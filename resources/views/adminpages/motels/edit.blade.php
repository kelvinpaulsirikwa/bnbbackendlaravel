@extends('adminpages.layouts.app')

@section('content')
    <div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">
                            Edit Motel
                        </h1>
                        <p class="text-muted mb-0">Update motel information</p>
                    </div>
                    <a href="{{ route('adminpages.motels.index') }}" class="btn btn-outline-secondary btn-lg shadow-sm">
                        <i class="bx bx-arrow-back"></i> Back to Motels
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
                            <i class="bx bx-edit me-2"></i>
                            Motel Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('adminpages.motels.update', $motel->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="row g-3">
                                <!-- Name Field -->
                                <div class="col-12">
                                    <label for="name" class="form-label">
                                        Motel Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', $motel->name) }}" 
                                           placeholder="Enter motel name"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Description Field -->
                                <div class="col-12">
                                    <label for="description" class="form-label">
                                        Description
                                    </label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" 
                                              name="description" 
                                              rows="3" 
                                              placeholder="Enter motel description">{{ old('description', $motel->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Owner Field -->
                                <div class="col-md-6">
                                    <label for="owner_id" class="form-label">
                                        Owner <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('owner_id') is-invalid @enderror" 
                                            id="owner_id" 
                                            name="owner_id" 
                                            required>
                                        <option value="">Select Owner</option>
                                        @foreach($owners as $owner)
                                            <option value="{{ $owner->id }}" {{ old('owner_id', $motel->owner_id) == $owner->id ? 'selected' : '' }}>
                                                {{ $owner->username }} ({{ $owner->useremail }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('owner_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Motel Type Field -->
                                <div class="col-md-6">
                                    <label for="motel_type_id" class="form-label">
                                        Motel Type
                                    </label>
                                    <select class="form-select @error('motel_type_id') is-invalid @enderror" 
                                            id="motel_type_id" 
                                            name="motel_type_id">
                                        <option value="">Select Motel Type</option>
                                        @foreach($motelTypes as $motelType)
                                            <option value="{{ $motelType->id }}" {{ old('motel_type_id', $motel->motel_type_id) == $motelType->id ? 'selected' : '' }}>
                                                {{ $motelType->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('motel_type_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Contact Phone Field -->
                                <div class="col-md-6">
                                    <label for="contact_phone" class="form-label">
                                        Contact Phone
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('contact_phone') is-invalid @enderror" 
                                           id="contact_phone" 
                                           name="contact_phone" 
                                           value="{{ old('contact_phone', $motel->contact_phone) }}" 
                                           placeholder="Enter contact phone">
                                    @error('contact_phone')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Contact Email Field -->
                                <div class="col-md-6">
                                    <label for="contact_email" class="form-label">
                                        Contact Email
                                    </label>
                                    <input type="email" 
                                           class="form-control @error('contact_email') is-invalid @enderror" 
                                           id="contact_email" 
                                           name="contact_email" 
                                           value="{{ old('contact_email', $motel->contact_email) }}" 
                                           placeholder="Enter contact email">
                                    @error('contact_email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Status Field -->
                                <div class="col-md-6">
                                    <label for="status" class="form-label">
                                        Status <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('status') is-invalid @enderror" 
                                            id="status" 
                                            name="status" 
                                            required>
                                        <option value="">Select Status</option>
                                        <option value="active" {{ old('status', $motel->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status', $motel->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        <option value="closed" {{ old('status', $motel->status) == 'closed' ? 'selected' : '' }}>Closed</option>
                                    </select>
                                    @error('status')
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
                                        <a href="{{ route('adminpages.motels.index') }}" 
                                           class="btn btn-outline-secondary">
                                            <i class="bx bx-x"></i> Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bx bx-save"></i> Update Motel
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
