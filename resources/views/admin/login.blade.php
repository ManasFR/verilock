@extends('admin.layout.app')

@section('content')
<div class="login-container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg" style="width: 100%; max-width: 400px;">
        <div class="card-body">
            <h3 class="text-center mb-4">VeriLock Login</h3>
            
            <!-- Form for login -->
            <form action="{{ route('admin.login') }}" method="POST">
                @csrf
                
                <!-- Email Input -->
                <div class="mb-3">
                    <input type="email" name="email" class="form-control" id="email" placeholder="Email" required>
                </div>

                <!-- Password Input -->
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>

            <!-- Forgot Password Link -->
            <p class="text-center mt-3">
                <a href="#">Forgot password?</a>
            </p>
        </div>
    </div>
</div>
@endsection
