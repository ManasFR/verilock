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
        <a href="{{ route('admin.create.plans') }}" class="btn btn-success" style="width: 20%">
            <i class="fas fa-box"></i> Create Plans
        </a>
    </div>

    @php
        use App\Models\AdminPlan;
        $plans = AdminPlan::all();
    @endphp

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Plan Name</th>
                <th>License Codes</th>
                <th>Product Limit</th>
                <th>License Limit</th>
                <th>Price</th>
                <th>Limit</th>
                <th>Created At</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($plans as $plan)
                <tr>
                    <td>{{ $plan->id }}</td>
                    <td>{{ $plan->name }}</td>
                    <td>
                        @if(is_array($plan->license_code))
                            {{ implode(',', $plan->license_code) }}
                        @else
                            {{ $plan->license_code }}
                        @endif
                    </td>
                    <td>{{ $plan->product_limit }}</td>
                    <td>{{ $plan->license_limit }}</td>
                    <td>{{ $plan->price ?? '-' }}</td>
                    <td>{{ $plan->limit ? 'Yes' : 'No' }}</td>
                    <td>{{ $plan->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('plans.edit', $plan->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No plans found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
