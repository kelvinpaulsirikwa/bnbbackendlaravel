@extends('adminpages.layouts.app')

@section('content')
    <div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">
                            Amenity Details
                        </h1>
                        <p class="text-muted mb-0">View amenity information</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('adminpages.amenities.edit', $amenity->id) }}" class="btn btn-warning btn-lg shadow-sm">
                            <i class="bx bx-edit"></i> Edit
                        </a>
                        <a href="{{ route('adminpages.amenities.index') }}" class="btn btn-outline-secondary btn-lg shadow-sm">
                            <i class="bx bx-arrow-back"></i> Back to Amenities
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
                            Amenity Information
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
                                        <p class="mb-0 fw-semibold">#{{ $amenity->id }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Name -->
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bx bx-tag text-primary fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 text-muted">Name</h6>
                                        <p class="mb-0 fw-semibold">{{ $amenity->name }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Icon -->
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bx bx-image text-primary fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 text-muted">Icon</h6>
                                        @if($amenity->icon)
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $amenity->icon_url }}" alt="Amenity icon" class="img-thumbnail me-2" style="max-width: 50px; max-height: 50px;" onerror="this.onerror=null;this.src='{{ asset('images/noimage.png') }}';">
                                                <span class="fw-semibold">{{ basename($amenity->icon) }}</span>
                                            </div>
                                        @else
                                            <p class="mb-0 text-muted">No icon set</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Created By -->
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bx bx-user text-primary fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 text-muted">Created By</h6>
                                        <p class="mb-0 fw-semibold">{{ $amenity->createdby ? \App\Models\BnbUser::find($amenity->createdby)->username ?? 'User #' . $amenity->createdby : 'System' }}</p>
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
                                        <p class="mb-0 fw-semibold">{{ $amenity->created_at->format('M d, Y H:i A') }}</p>
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
                                        <p class="mb-0 fw-semibold">{{ $amenity->updated_at->format('M d, Y H:i A') }}</p>
                                    </div>
                                </div>
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
                            <a href="{{ route('adminpages.amenities.edit', $amenity->id) }}" 
                               class="btn btn-warning">
                                <i class="bx bx-edit"></i> Edit Amenity
                            </a>
                            <form action="{{ route('adminpages.amenities.destroy', $amenity->id) }}" 
                                  method="POST" class="d-inline" 
                                  onsubmit="return confirm('Are you sure you want to delete this amenity?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="bx bx-trash"></i> Delete Amenity
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
