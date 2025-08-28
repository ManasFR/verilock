@extends('users.layout.app')

@include('users.navbar.header')

<div class="container mt-5">
    <h2>Generate Licenses</h2>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form id="generate-form" method="POST">
        @csrf
        <div class="form-group">
            <label for="product">Select Product</label>
            <select name="product_id" id="product" class="form-control" required>
                <option value="">-- Select Product --</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ $product->product_id }} - {{ $product->product_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group mt-3">
            <label for="quantity">Number of Licenses</label>
            <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
            <button type="button" id="generate-btn" class="btn btn-primary mt-3">Generate</button>
        </div>

        <!-- License Use Limit Input -->
        <div class="form-group mt-3">
            <label for="license-use-limit">License Use Limit</label>
            <input type="number" name="license_use_limit" id="license-use-limit" class="form-control" placeholder="Enter use limit (e.g., 100)" min="1">
        </div>

        <!-- License Expiration Date Input -->
        <div class="form-group mt-3">
            <label for="license-expiration-date">License Expiration Date</label>
            <input type="date" name="license_expiration_date" id="license-expiration-date" class="form-control">
        </div>
    </form>

    <div class="mt-4" id="license-output" style="display: none;">
        <h4>Generated Licenses</h4>
        <ul id="license-list" class="list-group"></ul>

        <form id="save-form" action="{{ route('user.licenses.save') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" id="product-id-hidden">
            <input type="hidden" name="product_name" id="product-name-hidden">
            <input type="hidden" name="license_codes" id="license-codes-hidden">
            <input type="hidden" name="license_use_limit" id="license-use-limit-hidden">
            <input type="hidden" name="license_expiration_date" id="license-expiration-date-hidden">
            
            <!-- Save Button -->
            <button type="submit" class="btn btn-success mt-3">Save Licenses</button>
        </form>
    </div>
</div>

<script>
    document.getElementById('generate-btn').addEventListener('click', function () {
        const productId = document.getElementById('product').value;
        const quantity = document.getElementById('quantity').value;
        const licenseUseLimit = document.getElementById('license-use-limit').value;
        const licenseExpirationDate = document.getElementById('license-expiration-date').value;

        if (!productId || !quantity ) {
            return alert('Please fill out all fields.');
        }

        fetch("{{ route('user.licenses.generate') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({ product_id: productId, quantity: quantity }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const licenseList = document.getElementById('license-list');
                licenseList.innerHTML = '';
                data.licenses.forEach(code => {
                    const li = document.createElement('li');
                    li.className = 'list-group-item';
                    li.textContent = code;
                    licenseList.appendChild(li);
                });

                document.getElementById('product-id-hidden').value = data.product_id;
                document.getElementById('product-name-hidden').value = data.product_name;
                document.getElementById('license-codes-hidden').value = data.licenses.join(', ');

                // Set hidden fields for license_use_limit and license_expiration_date
                document.getElementById('license-use-limit-hidden').value = licenseUseLimit;
                document.getElementById('license-expiration-date-hidden').value = licenseExpirationDate;

                document.getElementById('license-output').style.display = 'block';
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>
