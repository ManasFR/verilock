@extends('admin.layout.app')
@include('admin.navbar.header')
@section('content')

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<!-- users/user-update/profile.blade.php -->

<div class="text-center mt-5">
<h1>Update Profile</h1>
<p>Please update your email and password below.</p>
</div>

<div class="container">
<form action="{{ route('profile.update') }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" id="name" value="{{ old('name', $name) }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email', $email) }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">New Password</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="Leave blank if not changing">
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirm Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Leave blank if not changing">
    </div>

    <button type="submit" class="btn btn-primary">Update Profile</button>
</form>
</div>

@endsection
