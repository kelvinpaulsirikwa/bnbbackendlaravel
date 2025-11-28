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
                <p class="lead text-muted">Select a BnB to manage or add a new property</p>
                <hr class="my-4">
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Motels Grid -->
            <div class="row">
                <div class="col-12">
                    <h3 class="text-center mb-4">
                        <i class="fas fa-building"></i> Your Motels ({{ $motels->count() }})
                    </h3>
                </div>
            </div>
            
            <div class="row">
                <!-- Add New Motel Card -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <a href="{{ route('bnbowner.motel.create') }}" class="text-decoration-none">
                        <div class="card h-100 shadow-sm add-motel-card" style="transition: transform 0.2s; border: 2px dashed #6c757d;">
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                 style="height: 250px;">
                                <div class="text-center">
                                    <i class="fas fa-plus-circle fa-5x text-primary mb-3"></i>
                                    <h4 class="text-primary mb-0">Add New Motel</h4>
                                </div>
                            </div>
                            
                            <div class="card-body d-flex flex-column text-center">
                                <h5 class="card-title text-secondary">Register a New Property</h5>
                                <p class="card-text text-muted flex-grow-1">
                                    Click here to add a new motel or hotel to your account. Fill in the details and submit for approval.
                                </p>
                                
                                <div class="mt-auto">
                                    <span class="btn btn-outline-primary w-100 btn-lg">
                                        <i class="fas fa-plus"></i> Add New Motel
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Existing Motels -->
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
                            
                            <!-- Status Badge -->
                            @if($motel->status)
                                <div class="position-absolute" style="top: 15px; right: 15px;">
                                    @if($motel->status === 'active')
                                        <span class="badge bg-success"><i class="fas fa-check-circle"></i> Active</span>
                                    @elseif($motel->status === 'inactive')
                                        <span class="badge bg-warning text-dark"><i class="fas fa-clock"></i> Pending Approval</span>
                                    @else
                                        <span class="badge bg-secondary"><i class="fas fa-times-circle"></i> Closed</span>
                                    @endif
                                </div>
                            @endif
                            
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-primary">{{ $motel->name }}</h5>
                                <p class="card-text flex-grow-1">{{ Str::limit($motel->description, 120) }}</p>
                                
                                <!-- Motel Details -->
                                <div class="mb-3">
                                    <small class="text-muted">
                                        <i class="fas fa-map-marker-alt"></i> 
                                        {{ $motel->street_address ?? 'No address' }}<br>
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
                                @if($motel->status === 'active')
                                    <form method="POST" action="{{ route('bnbowner.select-motel') }}" class="mt-auto">
                                        @csrf
                                        <input type="hidden" name="motel_id" value="{{ $motel->id }}">
                                        <button type="submit" class="btn btn-primary w-100 btn-lg">
                                            <i class="fas fa-tachometer-alt"></i> Manage This Motel
                                        </button>
                                    </form>
                                @else
                                    <div class="mt-auto">
                                        <button class="btn btn-secondary w-100 btn-lg" disabled>
                                            <i class="fas fa-hourglass-half"></i> Awaiting Approval
                                        </button>
                                        <small class="text-muted d-block text-center mt-2">
                                            This motel is pending admin approval
                                        </small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($motels->count() === 0)
                <!-- No Motels Info -->
                <div class="row justify-content-center mt-3">
                    <div class="col-md-8">
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle fa-2x mb-2"></i>
                            <h5>No Motels Yet</h5>
                            <p class="mb-0">You haven't added any motels to your account yet. Click the "Add New Motel" card above to register your first property!</p>
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

.add-motel-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,123,255,0.2) !important;
    border-color: #007bff !important;
}

.add-motel-card:hover .fa-plus-circle {
    transform: scale(1.1);
    transition: transform 0.3s ease;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
}

.card {
    border: none;
    border-radius: 15px;
    overflow: hidden;
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

.badge {
    font-size: 0.85rem;
    padding: 0.5em 0.8em;
    border-radius: 8px;
}
</style>
@endsection
