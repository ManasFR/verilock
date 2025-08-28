@extends('admin.layout.app') <!-- Assuming you're using a layout -->
@include('admin.navbar.header')

@section('content')
<br>
    <div class="container">
        <h2>Edit User</h2>
        <br>
        <form action="{{ route('admin.usermanage.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Enter new password">
            </div>

            <button type="submit" class="btn btn-primary">Update User</button>
        </form>
    </div>
@endsection
