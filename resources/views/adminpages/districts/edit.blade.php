@extends('adminpages.layouts.app')

@section('content')
     
    <div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-dark">
                            Edit District
                        </h1>
                        <p class="text-muted mb-0">Update district information</p>
                    </div>
                    <a href="{{ route('adminpages.districts.index') }}" class="btn btn-outline-secondary">
                        Back to Districts
                    </a>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="card-title mb-0 text-dark">
                            District Information
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('adminpages.districts.update', $district) }}" id="districtForm">
                            @csrf
                            @method('PUT')
                            
                            <!-- Region Selection -->
                            <div class="mb-4">
                                <label for="regionid" class="form-label fw-semibold text-dark">
                                    Region
                                    <span class="text-danger">*</span>
                                </label>
                                <select name="regionid" 
                                        id="regionid"
                                        class="form-select @error('regionid') is-invalid @enderror" 
                                        required>
                                    <option value="">Select a region</option>
                                    @foreach($regions as $region)
                                        <option value="{{ $region->id }}" {{ old('regionid', $district->regionid) == $region->id ? 'selected' : '' }}>
                                            {{ $region->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('regionid')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-text text-muted">
                                    Select the region this district belongs to
                                </div>
                            </div>

                            <!-- District Name -->
                            <div class="mb-4">
                                <label for="name" class="form-label fw-semibold text-dark">
                                    District Name
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       name="name" 
                                       id="name"
                                       class="form-control @error('name') is-invalid @enderror" 
                                       placeholder="Enter district name"
                                       value="{{ old('name', $district->name) }}"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-text text-muted">
                                    Enter the name of the district
                                </div>
                            </div>

                            <!-- Created By -->
                            <div class="mb-4">
                                <label for="createdby" class="form-label fw-semibold text-dark">
                                    Created By
                                </label>
                                <input type="text" 
                                       name="createdby" 
                                       id="createdby"
                                       class="form-control @error('createdby') is-invalid @enderror" 
                                       placeholder="Enter creator name (optional)"
                                       value="{{ old('createdby', $district->createdby) }}">
                                @error('createdby')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-text text-muted">
                                    Optional: Name of the person creating this record
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                <a href="{{ route('adminpages.districts.index') }}" class="btn btn-outline-secondary">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    Update District
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Validation Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('districtForm');
            const nameInput = document.getElementById('name');
            const regionSelect = document.getElementById('regionid');
            
            // Real-time validation
            nameInput.addEventListener('input', function() {
                if (this.value.trim().length < 2) {
                    this.setCustomValidity('District name must be at least 2 characters long');
                } else {
                    this.setCustomValidity('');
                }
            });

            regionSelect.addEventListener('change', function() {
                if (this.value === '') {
                    this.setCustomValidity('Please select a region');
                } else {
                    this.setCustomValidity('');
                }
            });

            // Form submission validation
            form.addEventListener('submit', function(e) {
                if (nameInput.value.trim().length < 2) {
                    e.preventDefault();
                    nameInput.focus();
                    return false;
                }
                if (regionSelect.value === '') {
                    e.preventDefault();
                    regionSelect.focus();
                    return false;
                }
            });
        });
    </script>
    
 @endsection
