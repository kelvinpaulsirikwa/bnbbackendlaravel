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

                                <!-- User Type: Admin or Owner -->
                                <div class="col-md-6">
                                    <label class="form-label">
                                        User Type <span class="text-danger">*</span>
                                    </label>
                                    <div class="d-flex gap-4">
                                        <label class="form-check">
                                            <input class="form-check-input" type="radio" name="user_type" id="user_type_admin" value="admin" {{ old('user_type') == 'admin' ? 'checked' : '' }} required>
                                            <span class="form-check-label">Admin</span>
                                        </label>
                                        <label class="form-check">
                                            <input class="form-check-input" type="radio" name="user_type" id="user_type_owner" value="owner" {{ old('user_type') == 'owner' ? 'checked' : '' }}>
                                            <span class="form-check-label">Owner</span>
                                        </label>
                                    </div>
                                    @error('user_type')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Admin Permissions (shown only when Admin is selected) -->
                                <div class="col-12" id="admin-permissions-wrap" style="display: {{ old('user_type') === 'admin' ? 'block' : 'none' }};">
                                    <label class="form-label">Admin Permissions – choose which admin areas this user can access</label>
                                    <div class="border rounded p-3 bg-light">
                                        @foreach(config('admin_permissions', []) as $key => $label)
                                            <div class="form-check">
                                                <input class="form-check-input admin-permission-cb" type="checkbox" name="admin_permissions[]" value="{{ $key }}" id="admin_perm_{{ $key }}" {{ in_array($key, old('admin_permissions', [])) ? 'checked' : '' }}>
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

    <script>
        (function () {
            var wrap = document.getElementById('admin-permissions-wrap');
            var adminRadio = document.getElementById('user_type_admin');
            var ownerRadio = document.getElementById('user_type_owner');
            if (!wrap || !adminRadio || !ownerRadio) return;

            function togglePermissions() {
                if (adminRadio.checked) {
                    wrap.style.display = 'block';
                } else {
                    wrap.style.display = 'none';
                    document.querySelectorAll('.admin-permission-cb').forEach(function (cb) { cb.checked = false; });
                }
            }

            adminRadio.addEventListener('change', togglePermissions);
            ownerRadio.addEventListener('change', togglePermissions);
        })();
    </script>
@endsection
