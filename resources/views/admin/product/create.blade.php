@extends('admin.layout.app')

@include('admin.navbar.header')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="container mt-5">
    <h3 class="text-center mb-4">Create Product</h3>
    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="product_id" class="form-label">Product ID (Auto-Generated)</label>
            <input type="text" class="form-control" id="product_id" name="product_id" value="{{ rand(1000, 9999) }}">
        </div>
        <div class="mb-3">
            <label for="product_name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Enter Product Name" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description (Optional)</label>
            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter Product Description"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
