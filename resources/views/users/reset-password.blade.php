@extends('users.layout.app')

@section('content')

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </ul>
</div>
@endif

<div class="container mt-5">
    <h1>Reset Password</h1>
    <h3>Please reset your password from below fields</h3>
    @php
        // Assuming you have the user ID from the URL or session
        $userId = request()->query('user_id');
        $user = \App\Models\User::find($userId); // Query the user based on the user ID
    @endphp
    @if($user)
        <p>User Email: {{ $user->email }}</p>
        <form method="POST" action="{{ route('password.update', ['user_id' => $user->id]) }}">
            @csrf
            <input type="hidden" name="email" value="{{ $user->email }}">
            <div class="form-group">
                <label for="password">Enter new password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm new password:</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Password</button>
        </form>
    @else
        <p>User not found.</p>
    @endif
</div>

@endsection
