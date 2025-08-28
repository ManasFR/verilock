@extends('admin.layout.app')

@section('content')

@include('admin.navbar.header')
<div class="container">
    <h1>Create New Plan</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('plans.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Plan Name</label>
            <input type="text" name="name" id="name" 
                   class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="license_code" class="form-label">License Codes</label>
            <input type="text" name="license_code" id="license_code" 
                   class="form-control" placeholder="license1,license2,license3"
                   value="{{ old('license_code') }}" required>
            <small class="text-muted">Add multiple licenses separated by comma</small>
        </div>

        <div class="mb-3">
            <label for="product_limit" class="form-label">Product Limit</label>
            <input type="number" name="product_limit" id="product_limit" 
                   class="form-control" value="{{ old('product_limit') }}" required>
        </div>

        <div class="mb-3">
            <label for="license_limit" class="form-label">License Limit</label>
            <input type="number" name="license_limit" id="license_limit" 
                   class="form-control" value="{{ old('license_limit') }}" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price (optional)</label>
            <input type="number" step="0.01" name="price" id="price" 
                   class="form-control" value="{{ old('price') }}">
        </div>

        {{-- ✅ Limit Checkbox --}}
        <div class="mb-3 form-check">
            <input type="hidden" name="limit" value="0"> {{-- unchecked case --}}
            <input type="checkbox" name="limit" id="limit" value="1" 
                   class="form-check-input" {{ old('limit', 1) ? 'checked' : '' }}>
            <label for="limit" class="form-check-label">Enable Limit</label>
        </div>

        <button type="submit" class="btn btn-success">Save Plan</button>
        <br><br><br>
        <a href="{{ route('admin.plans') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
