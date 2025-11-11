@extends('layouts.owner')

@section('title', 'Hotel Management')

@section('content')
<div class="container-fluid py-4" style="background-color: #f5f5f5; min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-50">
            
            <!-- Page Header -->
            <div class="mb-4 d-flex justify-content-between align-items-center">
    <h2 class="fw-bold mb-0">BnB Details Management</h2>

    @if($selectedMotel)
        <div class="card border-0 shadow-sm ms-3">
            <div class="card-body py-2 px-3">
                <div class="small text-muted">Currently viewing</div>
                <div class="fw-semibold">{{ $selectedMotel->name }}</div>
            </div>
        </div>
    @endif
</div>

            
        
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Statistics Cards -->
            @if($motel->details)
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="text-muted mb-2">Total Rooms</h6>
                            <h3 class="mb-0">{{ $motel->details->total_rooms }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="text-muted mb-2">Available Rooms</h6>
                            <h3 class="mb-0">{{ $motel->details->available_rooms }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="text-muted mb-2">Contact Phone</h6>
                            <p class="mb-0 fw-semibold">{{ $motel->details->contact_phone }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h6 class="text-muted mb-2">Status</h6>
                            <span class="badge bg-{{ $motel->details->status === 'active' ? 'success' : 'danger' }}">
                                {{ ucfirst($motel->details->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Main Content -->
            <div class="row g-4">
                
                <!-- Motel Information Form -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="fas fa-hotel me-2"></i>BnB Information</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('bnbowner.hotel-management.update-motel') }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <div class="mb-3">
                                    <label for="name" class="form-label">BnB Name</label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="{{ old('name', $motel->name) }}" required>
                                    @error('name')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description', $motel->description) }}</textarea>
                                    @error('description')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="front_image" class="form-label">Front Image</label>
                                    <input type="file" class="form-control" id="front_image" name="front_image" accept="image/*">
                                    @error('front_image')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                    @if($motel->front_image)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $motel->front_image) }}" 
                                                 alt="Current Image" 
                                                 class="img-thumbnail" 
                                                 style="max-height: 150px;">
                                        </div>
                                    @endif
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Update BnB
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Contact Information Form -->
                    <div class="card mt-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="fas fa-phone me-2"></i>Contact Information</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('bnbowner.hotel-management.update-details') }}">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="contact_phone" class="form-label">Contact Phone</label>
                                        <input type="text" class="form-control" id="contact_phone" name="contact_phone" 
                                               value="{{ old('contact_phone', $motel->details->contact_phone ?? '') }}" required>
                                        @error('contact_phone')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="contact_email" class="form-label">Contact Email</label>
                                        <input type="email" class="form-control" id="contact_email" name="contact_email" 
                                               value="{{ old('contact_email', $motel->details->contact_email ?? '') }}" required>
                                        @error('contact_email')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-1"></i>Update Contact
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Information -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Current Details</h5>
                        </div>
                        <div class="card-body">
                            
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3">Basic Information</h6>
                                <p class="mb-2"><strong>Name:</strong><br>{{ $motel->name }}</p>
                                <p class="mb-2"><strong>Address:</strong><br>{{ $motel->street_address }}</p>
                                @if($motel->district)
                                    <p class="mb-2"><strong>District:</strong><br>{{ $motel->district->name }}</p>
                                @endif
                                @if($motel->motelType)
                                    <p class="mb-2"><strong>Type:</strong><br>{{ $motel->motelType->name }}</p>
                                @endif
                            </div>

                            @if($motel->details)
                            <div>
                                <h6 class="fw-bold mb-3">Contact & Rooms</h6>
                                <p class="mb-2"><strong>Phone:</strong><br>{{ $motel->details->contact_phone }}</p>
                                <p class="mb-2"><strong>Email:</strong><br>{{ $motel->details->contact_email }}</p>
                                <p class="mb-2"><strong>Total Rooms:</strong> {{ $motel->details->total_rooms }}</p>
                                <p class="mb-2"><strong>Available:</strong> {{ $motel->details->available_rooms }}</p>
                                <p class="mb-0">
                                    <strong>Status:</strong><br>
                                    <span class="badge bg-{{ $motel->details->status === 'active' ? 'success' : 'danger' }}">
                                        {{ ucfirst($motel->details->status) }}
                                    </span>
                                </p>
                            </div>
                            @else
                                <p class="text-muted">No additional details available.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection