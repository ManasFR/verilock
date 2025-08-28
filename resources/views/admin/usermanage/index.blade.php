@extends('admin.layout.app')

@include('admin.navbar.header')



@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="container mt-5">
    <h3 class="text-center mb-4">User Management</h3>
<br>
    <div class="d-flex justify-content-between mb-4">
        <h5>User Management</h5>
        <a href="{{ route('admin.user.register') }}" class="btn btn-success" style="width: 20%"><i class="fas fa-box"></i>  Register Users</a>
    </div>
@if ($Redeemuser->isEmpty())
        <p class="text-center">No users found. Click "Register User" to add a new one.</p>
    @else
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th>Redeem Code</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($Redeemuser as $Redeemuser)
                    <tr>
                        <td>{{ $Redeemuser->id }}</td>
                        <td>{{ $Redeemuser->name }}</td>
                        <td>{{ $Redeemuser->email }}</td>
                        <td>{{ $Redeemuser->roles }}</td>
                        <td>{{ $Redeemuser->redeem_code }}</td>
                        <td>{{ $Redeemuser->created_at }}</td>
                        <td>{{ $Redeemuser->updated_at }}</td>
                        
                        <td>
                            <a href="{{ route('admin.usermanage.edit', $Redeemuser->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('admin.user.destroy', $Redeemuser->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this user?');" style="background: red"><i class="fas fa-trash"></i> Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif