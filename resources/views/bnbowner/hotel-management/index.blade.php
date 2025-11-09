@extends('layouts.owner')

@section('title', 'Hotel Management')

@section('content')
<div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Hotel Management</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('bnbowner.dashboard') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
            </div>

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

            <!-- Motel Information Card -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-hotel"></i> Motel Information
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('bnbowner.hotel-management.update-motel') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Motel Name</label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="{{ old('name', $motel->name) }}" required>
                                    @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="front_image" class="form-label">Front Image</label>
                                    <input type="file" class="form-control" id="front_image" name="front_image" 
                                           accept="image/*">
                                    @error('front_image')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    @if($motel->front_image)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $motel->front_image) }}" 
                                                 alt="Current Image" 
                                                 style="max-width: 200px; max-height: 150px; object-fit: cover;"
                                                 class="img-thumbnail">
                                            <p class="text-muted small mt-1">Current image</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description', $motel->description) }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Motel Information
                        </button>
                    </form>
                </div>
            </div>

            <!-- Contact Information Card -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-phone"></i> Contact Information
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('bnbowner.hotel-management.update-details') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="contact_phone" class="form-label">Contact Phone</label>
                                    <input type="text" class="form-control" id="contact_phone" name="contact_phone" 
                                           value="{{ old('contact_phone', $motel->details->contact_phone ?? '') }}" required>
                                    @error('contact_phone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="contact_email" class="form-label">Contact Email</label>
                                    <input type="email" class="form-control" id="contact_email" name="contact_email" 
                                           value="{{ old('contact_email', $motel->details->contact_email ?? '') }}" required>
                                    @error('contact_email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Update Contact Information
                        </button>
                    </form>
                </div>
            </div>

            <!-- Current Motel Details -->
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle"></i> Current Motel Details
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Basic Information</h6>
                            <p><strong>Name:</strong> {{ $motel->name }}</p>
                            <p><strong>Description:</strong> {{ $motel->description }}</p>
                            <p><strong>Address:</strong> {{ $motel->street_address }}</p>
                            @if($motel->district)
                                <p><strong>District:</strong> {{ $motel->district->name }}</p>
                            @endif
                            @if($motel->motelType)
                                <p><strong>Type:</strong> {{ $motel->motelType->name }}</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h6>Contact Information</h6>
                            @if($motel->details)
                                <p><strong>Phone:</strong> {{ $motel->details->contact_phone }}</p>
                                <p><strong>Email:</strong> {{ $motel->details->contact_email }}</p>
                                <p><strong>Total Rooms:</strong> {{ $motel->details->total_rooms }}</p>
                                <p><strong>Available Rooms:</strong> {{ $motel->details->available_rooms }}</p>
                                <p><strong>Status:</strong> 
                                    <span class="badge bg-{{ $motel->details->status === 'active' ? 'success' : 'danger' }}">
                                        {{ ucfirst($motel->details->status) }}
                                    </span>
                                </p>
                            @else
                                <p class="text-muted">No contact information available. Please add contact details above.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
