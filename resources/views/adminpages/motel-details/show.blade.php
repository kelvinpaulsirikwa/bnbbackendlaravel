@extends('adminpages.layouts.app')

@section('content')
    <div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">
                            Motel Details
                        </h1>
                        <p class="text-muted mb-0">View motel detailed information</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('adminpages.motel-details.edit', $motelDetail->id) }}" class="btn btn-warning btn-lg shadow-sm">
                            <i class="bx bx-edit"></i> Edit
                        </a>
                        <a href="{{ route('adminpages.motel-details.index') }}" class="btn btn-outline-secondary btn-lg shadow-sm">
                            <i class="bx bx-arrow-back"></i> Back to Motel Details
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details Card -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-info-circle me-2"></i>
                            Motel Details Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <!-- ID -->
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bx bx-hash text-primary fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 text-muted">ID</h6>
                                        <p class="mb-0 fw-semibold">#{{ $motelDetail->id }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Motel -->
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bx bx-home text-primary fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 text-muted">Motel</h6>
                                        <p class="mb-0 fw-semibold">{{ $motelDetail->motel->name }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Street Address -->
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bx bx-map text-primary fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 text-muted">Street Address</h6>
                                        <p class="mb-0 fw-semibold">{{ $motelDetail->street_address ?: 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- District -->
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bx bx-map-pin text-primary fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 text-muted">District</h6>
                                        <p class="mb-0 fw-semibold">{{ $motelDetail->district->name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Latitude -->
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bx bx-navigation text-primary fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 text-muted">Latitude</h6>
                                        <p class="mb-0 fw-semibold">{{ $motelDetail->latitude ?: 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Longitude -->
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bx bx-navigation text-primary fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 text-muted">Longitude</h6>
                                        <p class="mb-0 fw-semibold">{{ $motelDetail->longitude ?: 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Rooms -->
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bx bx-bed text-primary fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 text-muted">Total Rooms</h6>
                                        <p class="mb-0 fw-semibold">{{ $motelDetail->total_rooms }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Available Rooms -->
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bx bx-check-circle text-primary fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 text-muted">Available Rooms</h6>
                                        <p class="mb-0 fw-semibold">{{ $motelDetail->available_rooms }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Rate -->
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bx bx-dollar text-primary fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 text-muted">Rate (per night)</h6>
                                        <p class="mb-0 fw-semibold text-success">${{ number_format($motelDetail->rate, 2) }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Created At -->
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bx bx-calendar text-primary fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 text-muted">Created At</h6>
                                        <p class="mb-0 fw-semibold">{{ $motelDetail->created_at->format('M d, Y H:i A') }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Updated At -->
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bx bx-time text-primary fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 text-muted">Last Updated</h6>
                                        <p class="mb-0 fw-semibold">{{ $motelDetail->updated_at->format('M d, Y H:i A') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Front Image Card -->
                @if($motelDetail->front_image)
                    <div class="card shadow-sm mt-4">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="card-title mb-0">
                                <i class="bx bx-image me-2"></i>
                                Front Image
                            </h5>
                        </div>
                        <div class="card-body text-center">
                            <img src="{{ asset($motelDetail->front_image) }}" alt="Front image" class="img-fluid rounded shadow" style="max-height: 400px;">
                        </div>
                    </div>
                @endif

                <!-- Actions Card -->
                <div class="card shadow-sm mt-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-cog me-2"></i>
                            Actions
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-2">
                            <a href="{{ route('adminpages.motel-details.edit', $motelDetail->id) }}" 
                               class="btn btn-warning">
                                <i class="bx bx-edit"></i> Edit Motel Details
                            </a>
                            <a href="{{ route('adminpages.motels.show', $motelDetail->motel_id) }}" 
                               class="btn btn-info">
                                <i class="bx bx-home"></i> View Motel
                            </a>
                            <form action="{{ route('adminpages.motel-details.destroy', $motelDetail->id) }}" 
                                  method="POST" class="d-inline" 
                                  onsubmit="return confirm('Are you sure you want to delete this motel detail?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="bx bx-trash"></i> Delete Motel Details
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
