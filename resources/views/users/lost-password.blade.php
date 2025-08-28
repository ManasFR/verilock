@extends('users.layout.app')
@include('users.navbar.lost-header')
@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif



<div class="container mt-5">
    <h1>Lost Password</h1>
    <form method="POST" action="{{ route('sendResetPassword') }}">
        @csrf
        <div class="form-group">
            <label for="email">Enter your email address:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Send Reset Password</button>
    </form>
</div>
@endsection
