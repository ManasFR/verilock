@extends('admin.layout.app')
@include('admin.navbar.header')
@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div class="container mt-5">
    <div class="row">
        <!-- Dashboard Card: Total Registered Products -->
        <div class="col-md-3 mb-4">
            <div class="card shadow text-center">
                <div class="card-header bg-primary text-white">
                    <h5><i class="fas fa-box"></i> Total Products</h5>
                </div>
                <div class="card-body">
                    <h3 class="card-title">{{ $productCount }}</h3>
                    <p class="card-text">Products currently registered.</p>
                </div>
            </div>
        </div>
        <!-- Dashboard Card: Total Licenses -->
        <div class="col-md-3 mb-4">
            <div class="card shadow text-center">
                <div class="card-header bg-warning text-black">
                    <h5><i class="fas fa-boxes"></i> Total Licenses</h5>
                </div>
                <div class="card-body">
                    <h3 class="card-title">{{ $licenseShow->count() }}</h3>
                    <p class="card-text">Licenses currently in use.</p>
                </div>
            </div>
        </div>
        <!-- Dashboard Card: Active Licenses -->
        <div class="col-md-3 mb-4">
            <div class="card shadow text-center">
                <div class="card-header bg-success text-white">
                    <h5><i class="fas fa-check-circle"></i> Active Licenses</h5>
                </div>
                <div class="card-body">
                    <h3 class="card-title">{{ $licenseShow->where('active', true)->count() }}</h3>
                    <p class="card-text">Active licenses currently in use.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card shadow text-center">
                <div class="card-header bg-danger text-white">
                    <h5><i class="fas fa-plug"></i> API Calls</h5>
                </div>
                <div class="card-body">
                    <h3 class="card-title">{{ $licenseShow->where('active', true)->count() }}</h3>
                    <p class="card-text">Users Call API</p>
                </div>
            </div>
        </div>
    </div>
    <div class="custom-wrapper mt-4">
        <!-- Professional Card Design for Pie and Bar Charts Side by Side -->
        <div class="custom-card shadow-sm">
            <div class="custom-card-header">
                <h4 class="mb-0">License Activation Overview</h4>
            </div>
            <div class="custom-card-body">
                <p class="text-muted">Total vs Active Licenses</p>

                <!-- Create a flex container to display pie chart and bar chart side by side -->
                <div class="row">
                    <!-- Left side: Pie chart -->
                    <div class="col-md-4">
                        <div style="width: 70%; margin: auto;">
                            <canvas id="licensePieChart"></canvas>
                        </div>
                        
                    </div>

                    <!-- Right side: Bar chart -->
                    <div class="col-md-6">
                        <div class="chart-container">
                            <canvas id="myChart" style="width:100%;max-width:600px"></canvas>
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
                            <script>
                                // Data from Laravel
                                var xValues = {!! json_encode($months) !!}; // Labels (January - December)
                                var yValues = {!! json_encode($licenseCounts) !!}; // License activations per month
                            
                                var barColors = ["#4CAF50", "#FF5733", "#36A2EB", "#FFC300", "#8E44AD", "#E74C3C", "#3498DB", "#2ECC71", "#F39C12", "#D35400", "#7D3C98", "#C0392B"];
                            
                                new Chart("myChart", {
                                    type: "bar",
                                    data: {
                                        labels: xValues,
                                        datasets: [{
                                            label: "License Activations",
                                            backgroundColor: barColors.slice(0, xValues.length),
                                            data: yValues
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        legend: { display: false },
                                        title: {
                                            display: true,
                                            text: "Total License Activations Per Month"
                                        },
                                        scales: {
                                            y: {
                                                beginAtZero: true
                                            }
                                        }
                                    }
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <!-- License Table -->
            <div class="card-info shadow">
                <div class="card-header bg-primary text-white text-center" style="padding:20px; border-radius:10px;">
                    <h3>Licenses Information</h3>
                    <a href="{{ route('admin.export.licenses') }}" style="background: green;" class="btn btn-success mb-3">Export Licenses</a>

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
                                        <td>{{ $license->product_id }}</td>
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
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data from Laravel variables
    const totalLicenses = {{ $licenseShow->count() }};
    const activeLicenses = {{ $licenseShow->where('active', true)->count() }};
    const inactiveLicenses = totalLicenses - activeLicenses;

    // Chart.js implementation
    const ctx = document.getElementById('licensePieChart').getContext('2d');
    const licensePieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Active Licenses', 'Inactive Licenses'],
            datasets: [{
                data: [activeLicenses, inactiveLicenses],
                backgroundColor: ['#4CAF50', '#F44336'], // Green for active, red for inactive
                hoverBackgroundColor: ['#45A049', '#E53935']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            const count = tooltipItem.raw;
                            const percentage = ((count / totalLicenses) * 100).toFixed(2);
                            return `${tooltipItem.label}: ${count} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
</script>
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
@endsection
