@extends('layouts.owner')

@section('title', 'BnB Owner Dashboard - ' . $selectedMotel->name)

@section('content')
<div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
       

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">{{ $selectedMotel->name }} Dashboard</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="{{ route('bnbowner.switch-account') }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-exchange-alt"></i> Switch Motel
                        </a>
                    </div>
                </div>
            </div>

            <!-- Selected Motel Info -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-primary">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-hotel"></i> Current Motel: {{ $selectedMotel->name }}
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    @if($selectedMotel->front_image)
                                        <img src="{{ asset('storage/' . $selectedMotel->front_image) }}" 
                                             class="img-fluid rounded" 
                                             alt="{{ $selectedMotel->name }}">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                             style="height: 200px;">
                                            <i class="fas fa-hotel fa-4x text-muted"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-8">
                                    <h4 class="text-primary">{{ $selectedMotel->name }}</h4>
                                    <p class="text-muted">{{ $selectedMotel->description }}</p>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong><i class="fas fa-map-marker-alt"></i> Address:</strong><br>
                                            {{ $selectedMotel->street_address }}</p>
                                            
                                            @if($selectedMotel->district)
                                                <p><strong><i class="fas fa-city"></i> District:</strong><br>
                                                {{ $selectedMotel->district->name }}</p>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            @if($selectedMotel->motelType)
                                                <p><strong><i class="fas fa-tag"></i> Type:</strong><br>
                                                {{ $selectedMotel->motelType->name }}</p>
                                            @endif
                                            
                                            @if($selectedMotel->latitude && $selectedMotel->longitude)
                                                <p><strong><i class="fas fa-map"></i> Coordinates:</strong><br>
                                                {{ number_format($selectedMotel->latitude, 4) }}, {{ number_format($selectedMotel->longitude, 4) }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="card-title">{{ $allMotels->count() }}</h4>
                                    <p class="card-text">Total Motels</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-hotel fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="card-title">0</h4>
                                    <p class="card-text">Active Bookings</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-calendar-check fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-warning">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="card-title">0</h4>
                                    <p class="card-text">Total Rooms</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-bed fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-info">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="card-title">$0</h4>
                                    <p class="card-text">Total Revenue</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-dollar-sign fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Motel Amenities -->
            @if($selectedMotel->amenities && $selectedMotel->amenities->count() > 0)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-star"></i> Motel Amenities
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($selectedMotel->amenities as $amenity)
                                <div class="col-md-3 mb-2">
                                    <span class="badge bg-secondary me-1">
                                        <i class="fas fa-check"></i> {{ $amenity->amenity->name ?? 'Amenity' }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- All Motels Quick Access -->
            @if($allMotels->count() > 1)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-building"></i> All Your Motels
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($allMotels as $motel)
                                <div class="col-md-4 mb-3">
                                    <div class="card {{ $motel->id == $selectedMotel->id ? 'border-primary' : '' }}">
                                        <div class="card-body">
                                            <h6 class="card-title">
                                                {{ $motel->name }}
                                                @if($motel->id == $selectedMotel->id)
                                                    <span class="badge bg-primary">Current</span>
                                                @endif
                                            </h6>
                                            <p class="card-text small">{{ Str::limit($motel->description, 80) }}</p>
                                            @if($motel->id != $selectedMotel->id)
                                                <form method="POST" action="{{ route('bnbowner.select-motel') }}" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="motel_id" value="{{ $motel->id }}">
                                                    <button type="submit" class="btn btn-sm btn-outline-primary">Switch To</button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Recent Activity -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-clock"></i> Recent Activity - {{ $selectedMotel->name }}
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">No recent activity to display for this motel.</p>
                </div>
            </div>
        </main>
    </div>
</div>

<style>
.sidebar {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    z-index: 100;
    padding: 48px 0 0;
    box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
}

.sidebar-sticky {
    position: relative;
    top: 0;
    height: calc(100vh - 48px);
    padding-top: .5rem;
    overflow-x: hidden;
    overflow-y: auto;
}

.sidebar .nav-link {
    font-weight: 500;
    color: #333;
}

.sidebar .nav-link:hover {
    color: #007bff;
}

.sidebar .nav-link.active {
    color: #007bff;
}

.sidebar-heading {
    font-size: .75rem;
    text-transform: uppercase;
}

main {
    margin-left: 0;
}

@media (min-width: 768px) {
    main {
        margin-left: 16.66667%;
    }
}

@media (min-width: 992px) {
    main {
        margin-left: 16.66667%;
    }
}
</style>
@endsection
