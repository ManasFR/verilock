@extends('admin.layout.app')

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">VeriLock Admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('dashboard')}}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('admin.product-show')}}"><i class="fas fa-box"></i> Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('licenses.index')}}"><i class="fas fa-key"></i> Licenses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('apigenerate')}}"><i class="fas fa-toggle-on"></i> Generate Script</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('redeemcode')}}"><i class="fas fa-ticket-alt"></i> Redeem Codes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('admin.plans')}}"><i class="fas fa-ticket-alt"></i> Plans Management</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('user.management')}}"> <i class="fas fa-user-cog"></i> User Management</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('admin.profile.edit')}}"><i class="fas fa-user"></i> Profile</a>
                </li>
                <li class="nav-item">
                    <!-- Logout Button -->
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link" style="margin-top:8px; border: none; background: none; padding: 0;"><i class="fas fa-sign-out-alt"></i> Logout</button>
                    </form>
                </li>
                
            </ul>
        </div>
    </div>
</nav>
