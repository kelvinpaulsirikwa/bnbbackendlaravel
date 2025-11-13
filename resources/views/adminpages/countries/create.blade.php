@extends('adminpages.layouts.app')

@section('content')
     
    <div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-dark">
                            New Country
                        </h1>
                        <p class="text-muted mb-0">to your system</p>
                    </div>
                    <a href="{{ route('adminpages.countries.index') }}" class="btn btn-outline-secondary">
                        Back to Countries
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
                            <i class="fas fa-flag me-2 text-primary"></i>
                            Country Information
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('adminpages.countries.store') }}" id="countryForm">
                            @csrf
                            
                            <!-- Country Name -->
                            <div class="mb-4">
                                <label for="name" class="form-label fw-semibold text-dark">
                                    <i class="fas fa-flag me-2 text-primary"></i>Country Name
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       name="name" 
                                       id="name"
                                       class="form-control @error('name') is-invalid @enderror" 
                                       placeholder="Enter country name"
                                       value="{{ old('name') }}"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                                <div class="form-text text-muted">
                                    <i class="fas fa-info-circle me-1"></i>Enter the official name of the country
                                </div>
                            </div>

                            <!-- Created By -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-dark">
                                    <i class="fas fa-user me-2 text-primary"></i>Created By
                                </label>
                                <input type="text"
                                       class="form-control"
                                       value="{{ optional($user)->username ?? optional($user)->useremail ?? optional($user)->name ?? 'System' }}"
                                       readonly>
                                <div class="form-text text-muted">
                                    <i class="fas fa-info-circle me-1"></i>This value is captured automatically from your account.
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                <a href="{{ route('adminpages.countries.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Create Country
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
            const form = document.getElementById('countryForm');
            const nameInput = document.getElementById('name');
            
            // Real-time validation
            nameInput.addEventListener('input', function() {
                if (this.value.trim().length < 2) {
                    this.setCustomValidity('Country name must be at least 2 characters long');
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
            });
        });
    </script>
    
 @endsection