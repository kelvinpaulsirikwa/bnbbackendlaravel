@extends('adminpages.layouts.app')

@section('content')
    <div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">
                            Room Type Details
                        </h1>
                        <p class="text-muted mb-0">View room type information</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('adminpages.room-types.edit', $roomType->id) }}" class="btn btn-warning btn-lg shadow-sm">
                            <i class="bx bx-edit"></i> Edit
                        </a>
                        <a href="{{ route('adminpages.room-types.index') }}" class="btn btn-outline-secondary btn-lg shadow-sm">
                            <i class="bx bx-arrow-back"></i> Back to Room Types
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
                            Room Type Information
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
                                        <p class="mb-0 fw-semibold">#{{ $roomType->id }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Name -->
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bx bx-bed text-primary fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 text-muted">Name</h6>
                                        <p class="mb-0 fw-semibold">{{ $roomType->name }}</p>
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
                                        <p class="mb-0 fw-semibold">{{ $roomType->description ?: 'No description provided' }}</p>
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
                                        <p class="mb-0 fw-semibold">{{ $roomType->createdby ? \App\Models\BnbUser::find($roomType->createdby)->username ?? 'User #' . $roomType->createdby : 'System' }}</p>
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
                                        <p class="mb-0 fw-semibold">{{ $roomType->created_at->format('M d, Y H:i A') }}</p>
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
                                        <p class="mb-0 fw-semibold">{{ $roomType->updated_at->format('M d, Y H:i A') }}</p>
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
                            <a href="{{ route('adminpages.room-types.edit', $roomType->id) }}" 
                               class="btn btn-warning">
                                <i class="bx bx-edit"></i> Edit Room Type
                            </a>
                            <form action="{{ route('adminpages.room-types.destroy', $roomType->id) }}" 
                                  method="POST" class="d-inline" 
                                  onsubmit="return confirm('Are you sure you want to delete this room type?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="bx bx-trash"></i> Delete Room Type
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
