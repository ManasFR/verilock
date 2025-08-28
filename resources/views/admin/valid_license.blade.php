@extends('admin.layout.app')


<div class="container mt-5">
    <h2>Validate License</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if (isset($validLicense))
        <div class="alert alert-info">
            <strong>Existing License Details:</strong><br>
            <p><strong>Email:</strong> {{ $validLicense->user_email }}</p>
            <p><strong>Product:</strong> {{ $validLicense->product->product_name ?? 'N/A' }}</p>
            <p><strong>License Code:</strong> {{ $validLicense->user_license }}</p>
            <p><strong>Domain:</strong> {{ $validLicense->domain }}</p>
            <p><strong>Status:</strong> {{ $validLicense->active ? 'Active' : 'Inactive' }}</p>
        </div>
    @endif

    <form action="{{ route('licenses.validate') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="user_email">Email Address</label>
            <input type="email" name="user_email" id="user_email" class="form-control" 
                   value="{{ $validLicense->user_email ?? old('user_email') }}" required>
        </div>

        <div class="form-group mt-3">
            <label for="product_name">Product Name</label>
            <input type="text" name="product_name" id="product_name" class="form-control" 
                   value="{{ $validLicense->product->product_name ?? old('product_name') }}" required>
        </div>

        <div class="form-group mt-3">
            <label for="user_license">License Code</label>
            <input type="text" name="user_license" id="user_license" class="form-control" 
                   value="{{ $validLicense->user_license ?? old('user_license') }}" required>
        </div>

        <input type="hidden" name="domain" value="{{ $validLicense->domain ?? $_SERVER['HTTP_HOST'] }}">

        <button type="submit" class="btn btn-primary mt-3">Validate License</button>
    </form>
    <div class="domain-container">
        <h1 class="mb-4">Licenses for Domain: {{ $currentDomain }}</h1>
        
            @if($validLicenses->isEmpty())
                <div class="alert alert-warning">
                    No licenses found for this domain ({{ $currentDomain }}).
                </div>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>License Code</th>
                            <th>Domain</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($validLicenses as $license)
                            <tr>
                                <td>{{ $license->user_license }}</td>
                                <td>{{ $license->domain }}</td>
                                <td>
                                    @if($license->active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    @if($license->active)
                                        <form action="{{ route('deactivate.license') }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            <input type="hidden" name="license_id" value="{{ $license->id }}">
                                            <button class="btn btn-danger btn-sm" type="submit">Deactivate</button>
                                        </form>
                                    @else
                                        <button class="btn btn-secondary btn-sm" disabled>Already Inactive</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
</div>
