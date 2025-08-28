@extends('users.layout.app')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo Login</title>
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
        <img src="https://freeazio.com/wp-content/uploads/2025/01/logo-white-300x300.png" style="height:190px; margin-top:-6rem;">
        <h2 style="font-weight:bold; color:white;">Welcome to Verilock</h2>
        <p style="color:white;">Login to your Verilock account and protect your work.</p>
    </div>

    <div class="container">
        @if(session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        <!-- Login Form -->
        <h2>Demo Login</h2>
        <form action="{{ route('user.login') }}" method="POST">
            @csrf
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required value="demo123@gmail.com">
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required value="demo123@gmail.com">
            </div>
            <button type="submit">Login</button>
        </form>

        <div class="link">
            <p><a href="{{ route('password.lost') }}">Forgot Password?</a></p>
        </div>
    </div>
</body>
</html>
