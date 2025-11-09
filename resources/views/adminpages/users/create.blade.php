@extends('adminpages.layouts.app')

@section('content')
    <div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">
                            Create New User
                        </h1>
                        <p class="text-muted mb-0">Add a new user to the BNB system</p>
                    </div>
                    <a href="{{ route('adminpages.users.index') }}" class="btn btn-outline-secondary btn-lg shadow-sm">
                        <i class="bx bx-arrow-back"></i> Back to Users
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
                            User Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('adminpages.users.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="row g-3">
                                <!-- Username Field -->
                                <div class="col-md-6">
                                    <label for="username" class="form-label">
                                        Username <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('username') is-invalid @enderror" 
                                           id="username" 
                                           name="username" 
                                           value="{{ old('username') }}" 
                                           placeholder="Enter username"
                                           required>
                                    @error('username')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Email Field -->
                                <div class="col-md-6">
                                    <label for="useremail" class="form-label">
                                        Email Address <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" 
                                           class="form-control @error('useremail') is-invalid @enderror" 
                                           id="useremail" 
                                           name="useremail" 
                                           value="{{ old('useremail') }}" 
                                           placeholder="Enter email address"
                                           required>
                                    @error('useremail')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Password Field -->
                                <div class="col-md-6">
                                    <label for="password" class="form-label">
                                        Password <span class="text-danger">*</span>
                                    </label>
                                    <input type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password" 
                                           placeholder="Enter password (min 6 characters)"
                                           required>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Confirm Password Field -->
                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label">
                                        Confirm Password <span class="text-danger">*</span>
                                    </label>
                                    <input type="password" 
                                           class="form-control" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           placeholder="Confirm password"
                                           required>
                                </div>

                                <!-- Phone Field -->
                                <div class="col-md-6">
                                    <label for="telephone" class="form-label">
                                        Phone Number
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('telephone') is-invalid @enderror" 
                                           id="telephone" 
                                           name="telephone" 
                                           value="{{ old('telephone') }}" 
                                           placeholder="Enter phone number">
                                    @error('telephone')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Role Field -->
                                <div class="col-md-6">
                                    <label for="role" class="form-label">
                                        Role <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('role') is-invalid @enderror" 
                                            id="role" 
                                            name="role" 
                                            required>
                                        <option value="">Select Role</option>
                                        <option value="bnbadmin" {{ old('role') == 'bnbadmin' ? 'selected' : '' }}>Admin</option>
                                        <option value="bnbowner" {{ old('role') == 'bnbowner' ? 'selected' : '' }}>Owner</option>
                                        <option value="bnbreceiptionist" {{ old('role') == 'bnbreceiptionist' ? 'selected' : '' }}>Receptionist</option>
                                        <option value="bnbsecurity" {{ old('role') == 'bnbsecurity' ? 'selected' : '' }}>Security</option>
                                        <option value="bnbchef" {{ old('role') == 'bnbchef' ? 'selected' : '' }}>Chef</option>
                                    </select>
                                    @error('role')
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
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="unactive" {{ old('status') == 'unactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Profile Image Field -->
                                <div class="col-md-6">
                                    <label for="profileimage" class="form-label">
                                        Profile Image
                                    </label>
                                    <input type="file" 
                                           class="form-control @error('profileimage') is-invalid @enderror" 
                                           id="profileimage" 
                                           name="profileimage" 
                                           accept="image/*">
                                    <div class="form-text">
                                        Upload a profile image (JPEG, PNG, JPG, GIF, SVG - Max 2MB)
                                    </div>
                                    @error('profileimage')
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
                                        <a href="{{ route('adminpages.users.index') }}" 
                                           class="btn btn-outline-secondary">
                                            <i class="bx bx-x"></i> Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bx bx-save"></i> Create User
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
