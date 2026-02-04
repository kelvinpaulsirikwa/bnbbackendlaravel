@extends('adminpages.layouts.app')

@section('content')
    <div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">
                            Edit User
                        </h1>
                        <p class="text-muted mb-0">Update user information</p>
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
                            <i class="bx bx-edit me-2"></i>
                            User Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('adminpages.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
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
                                           value="{{ old('username', $user->username) }}" 
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
                                           value="{{ old('useremail', $user->useremail) }}" 
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
                                        New Password
                                    </label>
                                    <input type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password" 
                                           placeholder="Enter new password (leave empty to keep current)">
                                    <div class="form-text">Leave empty to keep current password</div>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Confirm Password Field -->
                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label">
                                        Confirm New Password
                                    </label>
                                    <input type="password" 
                                           class="form-control" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           placeholder="Confirm new password">
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
                                           value="{{ old('telephone', $user->telephone) }}" 
                                           placeholder="Enter phone number">
                                    @error('telephone')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- User Type: Admin or Owner -->
                                <div class="col-md-6">
                                    <label class="form-label">
                                        User Type <span class="text-danger">*</span>
                                    </label>
                                    <div class="d-flex gap-4">
                                        <label class="form-check">
                                            <input class="form-check-input" type="radio" name="user_type" id="user_type_admin" value="admin" {{ old('user_type', $user->role === 'bnbadmin' ? 'admin' : 'owner') == 'admin' ? 'checked' : '' }} required>
                                            <span class="form-check-label">Admin</span>
                                        </label>
                                        <label class="form-check">
                                            <input class="form-check-input" type="radio" name="user_type" id="user_type_owner" value="owner" {{ old('user_type', $user->role === 'bnbadmin' ? 'admin' : 'owner') == 'owner' ? 'checked' : '' }}>
                                            <span class="form-check-label">Owner</span>
                                        </label>
                                    </div>
                                    @error('user_type')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Admin Permissions (when Admin is selected) -->
                                <div class="col-12" id="admin-permissions-wrap">
                                    <label class="form-label">Admin Permissions – choose which admin areas this user can access</label>
                                    <div class="border rounded p-3 bg-light">
                                        @foreach(config('admin_permissions', []) as $key => $label)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="admin_permissions[]" value="{{ $key }}" id="admin_perm_{{ $key }}" {{ in_array($key, old('admin_permissions', $user->admin_permissions ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="admin_perm_{{ $key }}">{{ $label }}</label>
                                            </div>
                                        @endforeach
                                    </div>
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
                                        <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="unactive" {{ old('status', $user->status) == 'unactive' ? 'selected' : '' }}>Inactive</option>
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
                                    
                                    @if($user->profileimage)
                                        <div class="mb-3">
                                            <label class="form-label">Current Image:</label>
                                            <div>
                                                <img src="{{ asset($user->profileimage) }}" alt="Current profile" class="img-thumbnail" style="max-width: 100px; max-height: 100px;">
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <input type="file" 
                                           class="form-control @error('profileimage') is-invalid @enderror" 
                                           id="profileimage" 
                                           name="profileimage" 
                                           accept="image/*">
                                    <div class="form-text">
                                        Upload a new profile image (JPEG, PNG, JPG, GIF, SVG - Max 2MB). Leave empty to keep current image.
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
                                            <i class="bx bx-save"></i> Update User
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
