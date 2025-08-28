@extends('admin.layout.app')

@include('admin.navbar.header')

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="container mt-5">
    <h3 class="text-center mb-4">Plan Management</h3>
<br>
    <div class="d-flex justify-content-between mb-4">
        <h5>Plans List</h5>
        <input type="text" id="searchInput" class="form-control" placeholder="Search plans..." style="width: 50%;">
        <a href="{{route('admin.create.plans')}}" class="btn btn-success" style="width: 20%"><i class="fas fa-box"></i>  Create Plans</a>
    </div>