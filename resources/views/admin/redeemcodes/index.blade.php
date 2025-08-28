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
    <h3 class="text-center mb-4">Redeem Codes Management</h3>

    <div class="d-flex justify-content-between mb-4">
        <h5>Redeem Codes</h5>
        <a href="{{ route('redeemcreate') }}" class="btn btn-success" style="width: 20%"><i class="fas fa-tag"></i> Create Redeem Codes</a>
    </div>

    <!-- Bootstrap Pills -->
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        @foreach($redeemCodes as $index => $code)
            <li class="nav-item" role="presentation">
                <button 
                    class="nav-link {{ $index === 0 ? 'active' : '' }}" 
                    id="pills-{{ $code->id }}-tab" 
                    data-bs-toggle="pill" 
                    data-bs-target="#pills-{{ $code->id }}" 
                    type="button" 
                    role="tab" 
                    aria-controls="pills-{{ $code->id }}" 
                    aria-selected="{{ $index === 0 ? 'true' : 'false' }}">
                    {{ $code->company_name }}
                </button>
            </li>
        @endforeach
    </ul>

    <div class="tab-content" id="pills-tabContent">
        @foreach($redeemCodes as $index => $code)
            <div 
                class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}" 
                id="pills-{{ $code->id }}" 
                role="tabpanel" 
                aria-labelledby="pills-{{ $code->id }}-tab">
                <h5 class="mt-3">Redeem Codes for {{ $code->company_name }}</h5>
                <ul class="list-group">
                    @foreach(explode(',', $code->redeem_codes) as $redeemCode)
                        <li class="list-group-item">{{ $redeemCode }}</li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>

<br>
    <h5 style="font-size:15px; padding: 5px; background:royalblue; color:white; display:inline-block; border-radius:5px;">Used Redeem Codes</h5>
    <div class="row mt-4 d-flex justify-content-center">
        @php $count = 1; @endphp
        @foreach($userCodes->sortByDesc('created_at') as $usercode)
            @php
                $redeemCode = $redeemCodes->first(function ($redeem) use ($usercode) {
                    return str_contains($redeem->redeem_codes, $usercode->redeem_code);
                });
    
                $companyName = $redeemCode ? $redeemCode->company_name : 'Unknown Company';
            @endphp
            <p>
                <strong>{{ $count }}.</strong>  
                <strong>{{ $usercode->name }}</strong> registered in <strong>Verilock</strong> using redeem code  
                <strong>{{ $usercode->redeem_code }}</strong> from <strong>{{ $companyName }}</strong> on  
                <strong>{{ $usercode->created_at->format('d M Y, h:i A') }}</strong>.
            </p>
            @php $count++; @endphp
        @endforeach
    </div>

</div>
@endsection
