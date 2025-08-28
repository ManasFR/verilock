@extends('admin.layout.app')

@include('admin.navbar.header')

<div class="container mt-5">
    <h2>Generate Redeem Codes</h2>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form id="generate-form" method="POST" action="{{ route('redeem_codes.save') }}">
        @csrf

        <!-- Company Name -->
        <div class="form-group mt-3">
            <label for="company-name">Company Name</label>
            <input type="text" name="company_name" id="company-name" class="form-control" placeholder="Enter Company Name" required>
        </div>

        <!-- Quantity of Redeem Codes -->
        <div class="form-group mt-3">
            <label for="quantity">Number of Redeem Codes</label>
            <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
        </div>

        <!-- Generate Button -->
        <button type="button" id="generate-btn" class="btn btn-primary mt-3">Generate</button>
    </form>

    <!-- Display Generated Redeem Codes -->
    <div class="mt-4" id="redeem-output" style="display: none;">
        <h4>Generated Redeem Codes</h4>
        <ul id="redeem-list" class="list-group"></ul>

        <form id="save-form" method="POST" action="{{ route('redeem_codes.save') }}">
            @csrf
            <input type="hidden" name="company_name" id="company-name-hidden">
            <input type="hidden" name="redeem_codes" id="redeem-codes-hidden">

            <!-- Save Button -->
            <button type="submit" class="btn btn-success mt-3">Save Redeem Codes</button>
        </form>
    </div>
</div>

<script>
    document.getElementById('generate-btn').addEventListener('click', function () {
        const companyName = document.getElementById('company-name').value;
        const quantity = document.getElementById('quantity').value;

        if (!companyName || !quantity) {
            return alert('Please fill out all fields.');
        }

        // Generate Random Redeem Codes
        const redeemCodes = [];
        for (let i = 0; i < quantity; i++) {
            redeemCodes.push('REDEEM-Freeazio' + Math.random().toString(36).substr(2, 8).toUpperCase());
        }

        // Display Redeem Codes
        const redeemList = document.getElementById('redeem-list');
        redeemList.innerHTML = '';
        redeemCodes.forEach(code => {
            const li = document.createElement('li');
            li.className = 'list-group-item';
            li.textContent = code;
            redeemList.appendChild(li);
        });

        // Set Hidden Fields for Saving
        document.getElementById('company-name-hidden').value = companyName;
        document.getElementById('redeem-codes-hidden').value = redeemCodes.join(', ');

        document.getElementById('redeem-output').style.display = 'block';
    });
</script>
