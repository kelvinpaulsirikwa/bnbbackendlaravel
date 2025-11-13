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
                        <p class="text-muted mb-0">View motel information</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('adminpages.motels.edit', $motel->id) }}" class="btn btn-warning btn-lg shadow-sm">
                            <i class="bx bx-edit"></i> Edit
                        </a>
                        <a href="{{ route('adminpages.motels.index') }}" class="btn btn-outline-secondary btn-lg shadow-sm">
                            <i class="bx bx-arrow-back"></i> Back to Motels
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
                            Motel Information
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
                                        <p class="mb-0 fw-semibold">#{{ $motel->id }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Name -->
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bx bx-home text-primary fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 text-muted">Name</h6>
                                        <p class="mb-0 fw-semibold">{{ $motel->name }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="col-12">
                                <div class="d-flex align-items-start">
                                    <div class="flex-shrink-0">
                                        <i class="bx bx-text text-primary fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 text-muted">Description</h6>
                                        <p class="mb-0 fw-semibold">{{ $motel->description ?: 'No description provided' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Owner -->
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bx bx-user text-primary fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 text-muted">Owner</h6>
                                        <p class="mb-0 fw-semibold">{{ $motel->owner->username ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Motel Type -->
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bx bx-building text-primary fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 text-muted">Type</h6>
                                        <span class="badge bg-info fs-6">{{ $motel->motelType->name ?? 'No Type' }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bx bx-check-circle text-primary fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 text-muted">Status</h6>
                                        @php
                                            $statusColors = [
                                                'active' => 'bg-success',
                                                'inactive' => 'bg-warning',
                                                'closed' => 'bg-danger'
                                            ];
                                        @endphp
                                        <span class="badge {{ $statusColors[$motel->status] ?? 'bg-secondary' }} fs-6">
                                            {{ ucfirst($motel->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Phone -->
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bx bx-phone text-primary fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 text-muted">Contact Phone</h6>
                                        <p class="mb-0 fw-semibold">{{ $motel->contact_phone ?: 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Email -->
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bx bx-envelope text-primary fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 text-muted">Contact Email</h6>
                                        <p class="mb-0 fw-semibold">{{ $motel->contact_email ?: 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Created By -->
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bx bx-user-plus text-primary fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 text-muted">Created By</h6>
                                        <p class="mb-0 fw-semibold">{{ $motel->creator->username ?? 'System' }}</p>
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
                                        <p class="mb-0 fw-semibold">{{ $motel->created_at->format('M d, Y H:i A') }}</p>
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
                                        <p class="mb-0 fw-semibold">{{ $motel->updated_at->format('M d, Y H:i A') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Motel Details Card -->
                <div class="card shadow-sm mt-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-detail me-2"></i>
                            Motel Details
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <h6 class="text-muted">Address</h6>
                                <p class="fw-semibold">{{ $motel->street_address ?: 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted">District</h6>
                                <p class="fw-semibold">{{ optional($motel->district)->name ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted">Total Rooms</h6>
                                <p class="fw-semibold">{{ $motel->total_rooms ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted">Available Rooms</h6>
                                <p class="fw-semibold">{{ $motel->available_rooms ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

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
                            <a href="{{ route('adminpages.motels.edit', $motel->id) }}" 
                               class="btn btn-warning">
                                <i class="bx bx-edit"></i> Edit Motel
                            </a>
                            <form action="{{ route('adminpages.motels.update-status', $motel->id) }}"
                                  method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="{{ $motel->status === 'active' ? 'inactive' : 'active' }}">
                                <button type="submit" class="btn btn-danger">
                                    <i class="bx bx-power-off"></i> {{ $motel->status === 'active' ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
