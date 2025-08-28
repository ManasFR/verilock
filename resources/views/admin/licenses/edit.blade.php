@extends('users.layout.app')

@include('users.navbar.header')

<div class="container mt-5">
    <h2>Edit License</h2>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('admin.licenses.update', $license->id) }}" method="POST">
        @csrf
        @method('PUT')
    
        <div class="form-group">
            <label for="product">Select Product</label>
            <select name="product_id" id="product" class="form-control" required>
                <option value="">-- Select Product --</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}" {{ $license->product_id == $product->id ? 'selected' : '' }} data-name="{{ $product->product_name }}">
                        {{ $product->product_id }} - {{ $product->product_name }}
                    </option>
                @endforeach
            </select>
        </div>
    
        <!-- Add a hidden input for the product_name -->
        <input type="hidden" name="product_name" id="product_name" value="{{ $license->product_name }}" required>
    
        <div class="form-group mt-3">
            <label for="license-codes">License Codes</label>
            <input type="text" name="license_codes" id="license-codes" class="form-control" value="{{ $license->license_codes }}" required>
        </div>
    
        <div class="form-group mt-3">
            <label for="license-use-limit">License Use Limit</label>
            <input type="number" name="license_use_limit" id="license-use-limit" class="form-control" value="{{ $license->license_use_limit == -1 ? '' : $license->license_use_limit }}">
            <small class="text-muted">Leave empty for unlimited use (-1).</small>
        </div>
    
        <div class="form-group mt-3">
            <label for="license-expiration-date">License Expiration Date</label>
            <input type="date" name="license_expiration_date" id="license-expiration-date" class="form-control" value="{{ $license->license_expiration_date }}">
            <small class="text-muted">Leave empty for no expiration.</small>
        </div>
    
        <button type="submit" class="btn btn-success mt-3">Update License</button>
    </form>
</div>
