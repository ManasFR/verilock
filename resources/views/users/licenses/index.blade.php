@extends('users.layout.app')

@include('users.navbar.header')

<div class="container mt-5">
    
    <h2>Licenses</h2>
<div class="text-end mb-4 d-flex justify-content-between">
    <input type="text" id="searchInput" class="form-control" placeholder="Search licenses..." style="width: 50%;">
    <a href="{{ route('user.licenses.create') }}" class="btn btn-primary" style="width: 20%"><i class="fas fa-key"></i> Create Licenses</a>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($licenses->isEmpty())
    <p>No licenses available.</p>
@else
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>License Codes</th>
                <th>License Limits</th>
                <th>License Expire</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="licenseTable">
            @foreach ($licenses as $license)
                <tr>
                    <td>{{ $license->id }}</td>
                    <td>{{ $license->product_name }}</td>
                    <td>
                        <ul id="license-codes-{{ $license->id }}">
                            @foreach (explode(',', $license->license_codes) as $index => $code)
                                @if ($index < 10)
                                    <li>{{ $code }}</li>
                                @endif
                            @endforeach
                        </ul>

                        <button id="view-more-{{ $license->id }}" class="btn btn-link view-more-btn" 
                                style="color:white; width:auto; text-decoration:none; border-radius:5%;">
                            <i class="fas fa-chevron-down"></i> View More
                        </button>
                        <button id="view-less-{{ $license->id }}" class="btn btn-link view-less-btn" 
                                style="display: none; color:white; width:auto; text-decoration:none; border-radius:5%;">
                            <i class="fas fa-chevron-up"></i> View Less
                        </button>

                        <ul id="all-license-codes-{{ $license->id }}" style="display: none;">
                            @foreach (explode(',', $license->license_codes) as $index => $code)
                                @if ($index >= 10)
                                    <li>{{ $code }}</li>
                                @endif
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        @if($license->license_use_limit == -1)
                            Unlimited Use
                        @else
                            {{ $license->license_use_limit }} (Limit)
                        @endif
                    </td>
                    <td>
                        @if(empty($license->license_expiration_date))
                            No Expire Date
                        @else
                            {{ \Carbon\Carbon::parse($license->license_expiration_date)->format('d M Y') }}
                        @endif
                    </td>
                    
                    <td>
                        <div class="d-flex align-items-center">
                            <a href="{{ route('user.licenses.edit', $license->id) }}" class="btn mx-2" style="background-color: #ffc107; color: #212529; flex-fill me-2; width:50%">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('user.licenses.destroy', $license->id) }}" method="POST" class="flex-fill">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn" style="background-color: #dc3545; color: white;" onclick="return confirm('Are you sure you want to delete this license?')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </td>                        
                </tr>
            @endforeach
        </tbody>            
    </table>
@endif

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.getElementById("searchInput");
        const licenseTable = document.getElementById("licenseTable");

        searchInput.addEventListener("keyup", function () {
            let filter = searchInput.value.toLowerCase();
            let rows = licenseTable.getElementsByTagName("tr");
            for (let i = 0; i < rows.length; i++) {
                let cells = rows[i].getElementsByTagName("td");
                let found = false;
                for (let j = 0; j < cells.length - 1; j++) {
                    if (cells[j].textContent.toLowerCase().includes(filter)) {
                        found = true;
                        break;
                    }
                }
                rows[i].style.display = found ? "" : "none";
            }
        });
    });
</script>
