@extends('admin.layout.app')
@include('admin.navbar.header')

<div class="container">
    <h3 class="text-center">Register New User</h3>
    <form action="{{ route('admin.register') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Enter full name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="Enter email address" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required>
        </div>
        <button type="submit" class="btn btn-custom w-100">Register User</button>
    </form>
</div>