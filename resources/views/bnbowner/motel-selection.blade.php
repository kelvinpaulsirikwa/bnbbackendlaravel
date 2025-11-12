@extends('layouts.choose')

@section('title', 'Select Your Motel')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <!-- Header -->
            <div class="text-center mb-5">
                <h1 class="display-4 text-primary">
                    <i class="fas fa-hotel"></i> Welcome, {{ $user->username }}!
                </h1>
                <p class="lead text-muted">Select a your BnB to manage your business</p>
                <hr class="my-4">
            </div>

           

            <!-- Motels Grid -->
            @if($motels->count() > 0)
                <div class="row">
                    <div class="col-12">
                        <h3 class="text-center mb-4">
                            <i class="fas fa-building"></i> Your Motels ({{ $motels->count() }})
                        </h3>
                    </div>
                </div>
                
                <div class="row">
                    @foreach($motels as $motel)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100 shadow-sm motel-card" style="transition: transform 0.2s;">
                                @if($motel->front_image)
                                    <img src="{{ asset('storage/' . $motel->front_image) }}" 
                                         class="card-img-top" 
                                         alt="{{ $motel->name }}" 
                                         style="height: 250px; object-fit: cover;">
                                @else
                                    <div class="card-img-top bg-gradient-primary d-flex align-items-center justify-content-center" 
                                         style="height: 250px;">
                                        <i class="fas fa-hotel fa-4x text-white"></i>
                                    </div>
                                @endif
                                
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title text-primary">{{ $motel->name }}</h5>
                                    <p class="card-text flex-grow-1">{{ Str::limit($motel->description, 120) }}</p>
                                    
                                    <!-- Motel Details -->
                                    <div class="mb-3">
                                        <small class="text-muted">
                                            <i class="fas fa-map-marker-alt"></i> 
                                            {{ $motel->street_address }}<br>
                                            @if($motel->district)
                                                <i class="fas fa-city"></i> {{ $motel->district->name }}<br>
                                            @endif
                                            @if($motel->motelType)
                                                <i class="fas fa-tag"></i> {{ $motel->motelType->name }}<br>
                                            @endif
                                            @if($motel->latitude && $motel->longitude)
                                                <i class="fas fa-map"></i> 
                                                {{ number_format($motel->latitude, 4) }}, {{ number_format($motel->longitude, 4) }}
                                            @endif
                                        </small>
                                    </div>
                                    
                                    <!-- Action Button -->
                                    <form method="POST" action="{{ route('bnbowner.select-motel') }}" class="mt-auto">
                                        @csrf
                                        <input type="hidden" name="motel_id" value="{{ $motel->id }}">
                                        <button type="submit" class="btn btn-primary w-100 btn-lg">
                                            <i class="fas fa-tachometer-alt"></i> Manage This Motel
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- No Motels -->
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card border-warning">
                            <div class="card-body text-center">
                                <i class="fas fa-exclamation-triangle fa-4x text-warning mb-3"></i>
                                <h5 class="card-title">No Motels Found</h5>
                                <p class="card-text">You don't have any motels assigned to your account yet.</p>
                                <p class="card-text">Please contact the administrator to get motels assigned to your account.</p>
                                <a href="#" class="btn btn-warning">Contact Administrator</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Logout Button -->
            <div class="text-center mt-5">
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-lg">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.motel-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
}

.card {
    border: none;
    border-radius: 15px;
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
}

.btn-lg {
    border-radius: 10px;
    font-weight: 500;
}

.display-4 {
    font-weight: 300;
}

.lead {
    font-size: 1.25rem;
    font-weight: 300;
}
</style>
@endsection
