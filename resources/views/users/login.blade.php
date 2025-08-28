@extends('users.layout.app')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register and Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 700px !important;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #3498db;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        .error {
            color: red;
            font-size: 14px;
        }
        .success {
            color: green;
            font-size: 14px;
        }
        .link {
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body style="background:#021414;">
    <div class="start-container" style="margin-top:5rem; padding:10px 20px; text-align:center;">
         <!-- <img src="https://freeazio.com/wp-content/uploads/2025/01/logo-white-300x300.png" style="height:190px; margin-top:-6rem;">
    <h2 style="font-weight:bold; color:white;">Welcome to Verilock</h2>
         <p style="color:white;">Register Yourself with verilock and protect your work.</p> -->
        </div>
        <div class="container">
            <!-- Display success or error message -->
            @if(session('error'))
                <div class="error">{{ session('error') }}</div>
            @endif
            @if(session('success'))
                <div class="success">{{ session('success') }}</div>
            @endif
        
            <!-- Register Form -->
            <h2 id="register-title">Register</h2>
            <form action="{{ route('user.register') }}" method="POST" id="register-form">
                @csrf
                <div class="form-group">
                    <input type="text" name="name" placeholder="Full Name" required value="{{ old('name') }}">
                </div>
                <div class="form-group">
                    <input type="email" name="email" placeholder="Email" required value="{{ old('email') }}">
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
                </div>
                <div class="form-group">
                    <input type="text" name="redeem_code" placeholder="Redeem Code" value="{{ old('redeem_code') }}" required>
                </div>
                <button type="submit">Register</button>
            </form>
        
            <div class="link">
                <p>Already have an account? <a href="#" id="show-login">Login here</a></p>
            </div>
        
            <!-- Login Form -->
            <h2 id="login-form-title" style="display: none;">Login</h2>
            <form action="{{ route('user.login') }}" method="POST" id="login-form" style="display: none;">
                @csrf
                <div class="form-group">
                    <input type="email" name="email" placeholder="Email" required value="{{ old('email') }}">
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit">Login</button>
            </form>
        
            <div class="link" id="register-link" style="display: none;">
                <p>Don't have an account? <a href="#" id="show-register">Register here</a></p>
                <p><a href="{{route('password.lost')}}" id="show-register">Forgot Password?</a></p>
            </div>
        </div>
        
        <script>
            document.getElementById('show-login').addEventListener('click', function() {
                document.getElementById('register-form').style.display = 'none';
                document.getElementById('register-title').style.display = 'none';
                document.getElementById('login-form').style.display = 'block';
                document.getElementById('login-form-title').style.display = 'block';
                document.getElementById('register-link').style.display = 'block';
                this.parentElement.style.display = 'none'; // Hide the "Already have an account" text
            });
        
            document.getElementById('show-register').addEventListener('click', function() {
                document.getElementById('register-form').style.display = 'block';
                document.getElementById('register-title').style.display = 'block';
                document.getElementById('login-form').style.display = 'none';
                document.getElementById('login-form-title').style.display = 'none';
                document.getElementById('show-login').parentElement.style.display = 'block';
                document.getElementById('register-link').style.display = 'none';
            });
        </script>
</body>
</html>
