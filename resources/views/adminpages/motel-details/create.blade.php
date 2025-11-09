@extends('adminpages.layouts.app')

@section('content')
    <div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">
                            Create New Motel Details
                        </h1>
                        <p class="text-muted mb-0">Add detailed information for a motel</p>
                    </div>
                    <a href="{{ route('adminpages.motel-details.index') }}" class="btn btn-outline-secondary btn-lg shadow-sm">
                        <i class="bx bx-arrow-back"></i> Back to Motel Details
                    </a>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-plus-circle me-2"></i>
                            Motel Details Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('adminpages.motel-details.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="row g-3">
                                <!-- Motel Field -->
                                <div class="col-12">
                                    <label for="motel_id" class="form-label">
                                        Motel <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('motel_id') is-invalid @enderror" 
                                            id="motel_id" 
                                            name="motel_id" 
                                            required>
                                        <option value="">Select Motel</option>
                                        @foreach($motels as $motel)
                                            <option value="{{ $motel->id }}" {{ (old('motel_id') == $motel->id || request('motel_id') == $motel->id) ? 'selected' : '' }}>
                                                {{ $motel->name }} ({{ $motel->owner->username ?? 'N/A' }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('motel_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- District Field -->
                                <div class="col-md-6">
                                    <label for="district_id" class="form-label">
                                        District
                                    </label>
                                    <select class="form-select @error('district_id') is-invalid @enderror" 
                                            id="district_id" 
                                            name="district_id">
                                        <option value="">Select District</option>
                                        @foreach($districts as $district)
                                            <option value="{{ $district->id }}" {{ old('district_id') == $district->id ? 'selected' : '' }}>
                                                {{ $district->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('district_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Street Address Field -->
                                <div class="col-md-6">
                                    <label for="street_address" class="form-label">
                                        Street Address
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('street_address') is-invalid @enderror" 
                                           id="street_address" 
                                           name="street_address" 
                                           value="{{ old('street_address') }}" 
                                           placeholder="Enter street address">
                                    @error('street_address')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Latitude Field -->
                                <div class="col-md-6">
                                    <label for="latitude" class="form-label">
                                        Latitude
                                    </label>
                                    <input type="number" 
                                           step="any"
                                           class="form-control @error('latitude') is-invalid @enderror" 
                                           id="latitude" 
                                           name="latitude" 
                                           value="{{ old('latitude') }}" 
                                           placeholder="Enter latitude">
                                    @error('latitude')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Longitude Field -->
                                <div class="col-md-6">
                                    <label for="longitude" class="form-label">
                                        Longitude
                                    </label>
                                    <input type="number" 
                                           step="any"
                                           class="form-control @error('longitude') is-invalid @enderror" 
                                           id="longitude" 
                                           name="longitude" 
                                           value="{{ old('longitude') }}" 
                                           placeholder="Enter longitude">
                                    @error('longitude')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Front Image Field -->
                                <div class="col-md-6">
                                    <label for="front_image" class="form-label">
                                        Front Image
                                    </label>
                                    <input type="file" 
                                           class="form-control @error('front_image') is-invalid @enderror" 
                                           id="front_image" 
                                           name="front_image" 
                                           accept="image/*">
                                    <div class="form-text">
                                        Upload a front image (JPEG, PNG, JPG, GIF, SVG - Max 2MB)
                                    </div>
                                    @error('front_image')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Total Rooms Field -->
                                <div class="col-md-6">
                                    <label for="total_rooms" class="form-label">
                                        Total Rooms <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" 
                                           min="0"
                                           class="form-control @error('total_rooms') is-invalid @enderror" 
                                           id="total_rooms" 
                                           name="total_rooms" 
                                           value="{{ old('total_rooms') }}" 
                                           placeholder="Enter total rooms"
                                           required>
                                    @error('total_rooms')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Available Rooms Field -->
                                <div class="col-md-6">
                                    <label for="available_rooms" class="form-label">
                                        Available Rooms <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" 
                                           min="0"
                                           class="form-control @error('available_rooms') is-invalid @enderror" 
                                           id="available_rooms" 
                                           name="available_rooms" 
                                           value="{{ old('available_rooms') }}" 
                                           placeholder="Enter available rooms"
                                           required>
                                    @error('available_rooms')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Rate Field -->
                                <div class="col-md-6">
                                    <label for="rate" class="form-label">
                                        Rate (per night) <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" 
                                           step="0.01"
                                           min="0"
                                           class="form-control @error('rate') is-invalid @enderror" 
                                           id="rate" 
                                           name="rate" 
                                           value="{{ old('rate') }}" 
                                           placeholder="Enter rate per night"
                                           required>
                                    @error('rate')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('adminpages.motel-details.index') }}" 
                                           class="btn btn-outline-secondary">
                                            <i class="bx bx-x"></i> Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bx bx-save"></i> Create Motel Details
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
