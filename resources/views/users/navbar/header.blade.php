@extends('users.layout.app')

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{route('userdashboard')}}">VeriLock User</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('userdashboard')}}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('user-product-show')}}"><i class="fas fa-box"></i> Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('user.licenses.index')}}"><i class="fas fa-key"></i> Licenses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('license.activations')}}"> <i class="fas fa-toggle-on"></i> Activations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('user.apigenerate')}}"> <i class="fas fa-code"></i> API Generate</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" target="_blank" href="https://freeazio.com/how-to-setup-verilock/"> <i class="fas fa-question-circle"></i> Documentation</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('profile.edit')}}"> <i class="fas fa-user"></i> Profile</a>
                </li>
                <li class="nav-item">
                    <form action="{{ route('user.destroy') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link" style="margin-top:8px; border: none; background: none; padding: 0;"> <i class="fas fa-sign-out-alt"></i> Logout</button>
                    </form>
                </li>
                
            </ul>
        </div>
    </div>
</nav>
