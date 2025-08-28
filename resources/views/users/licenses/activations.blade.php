@extends('users.layout.app')
@include('users.navbar.header')
@section('content')


@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="container mt-5">
    <div class="row mt-4">
        <div class="col-md-12">
            <!-- License Table -->
            <div class="card-info shadow">
                <div class="card-header bg-primary text-white text-center" style="padding:10px; border-radius:10px;">
                    <h3>Licenses Activations</h3>
                    <a style="background:green; margin-bottom:1rem;" href="{{ route('user.export.licenses') }}" class="btn btn-light">Export Licenses</a>
                    
                    <input type="text" id="searchInput" placeholder="Search by Email or License Code" class="form-control">
                </div>
                <br>

                <div class="card-body">
                    @if ($licenseShow->isNotEmpty())
                    <table class="table table-bordered table-hover" id="licenseTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>User Email</th>
                                    <th>License Code</th>
                                    <th>Product ID</th>
                                    <th>Domain</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($licenseShow as $license)
                                    <tr>
                                        <td>{{ $license->id }}</td>
                                        <td>{{ $license->user_email }}</td>
                                        <td>{{ $license->user_license }}</td>
                                        <td>{{ $license->product->product_name ?? 'Unknown' }}</td>
                                        <td>{{ $license->domain }}</td>
                                        <td>
                                            <span class="badge {{ $license->active ? 'bg-success' : 'bg-danger' }} text-white">
                                                {{ $license->active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        
                                        <td>
                                            @if($license->active)
                                                <!-- Deactivate Button -->
                                                <form action="{{ route('deactivate.license') }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    <input type="hidden" name="license_id" value="{{ $license->id }}">
                                                    <button class="btn btn-danger btn-sm" type="submit" style="background: red"><i class="fas fa-times-circle"></i> Deactivate</button>
                                                </form>
                                            @else
                                                <!-- Activate Button -->
                                                <form action="{{ route('activate.license') }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    <input type="hidden" name="license_id" value="{{ $license->id }}">
                                                    <button class="btn btn-success btn-sm" type="submit" style="background: green"><i class="fas fa-check-circle"></i> Activate</button>
                                                </form>
                                            @endif
                                        </td>                                        
                                        
                                        <td>{{ $license->created_at->format('d M Y, h:i A') }}</td>
                                        <td>{{ $license->updated_at->format('d M Y, h:i A') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-center">No Licenses Found</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endsection
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const searchInput = document.getElementById("searchInput");
            const licenseTable = document.getElementById("licenseTable");
    
            // Search by User Email or License Code
            searchInput.addEventListener("keyup", function () {
                let filter = searchInput.value.toLowerCase();
                let rows = licenseTable.getElementsByTagName("tr");
    
                for (let i = 1; i < rows.length; i++) { // Start from 1 to skip table header
                    let emailCell = rows[i].getElementsByTagName("td")[1]; // User Email is in column index 1
                    let licenseCodeCell = rows[i].getElementsByTagName("td")[2]; // License Code is in column index 2
                    
                    if (emailCell && licenseCodeCell) {
                        let emailText = emailCell.textContent.toLowerCase();
                        let licenseCodeText = licenseCodeCell.textContent.toLowerCase();
                        
                        // Show row if it matches User Email or License Code
                        if (emailText.includes(filter) || licenseCodeText.includes(filter)) {
                            rows[i].style.display = "";
                        } else {
                            rows[i].style.display = "none";
                        }
                    }
                }
            });
        });
    </script>
    