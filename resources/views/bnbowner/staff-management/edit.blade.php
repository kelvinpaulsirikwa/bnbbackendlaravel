@extends('layouts.owner')

@section('title', 'Edit Staff Member')

@section('content')
<div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Edit Staff Member - {{ $staff->username }}</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('bnbowner.staff-management.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Staff
                    </a>
                </div>
            </div>

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-user-edit"></i> Staff Member Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('bnbowner.staff-management.update', $staff->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Full Name</label>
                                            <input type="text" class="form-control" id="username" name="username" 
                                                   value="{{ old('username', $staff->username) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="useremail" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="useremail" name="useremail" 
                                                   value="{{ old('useremail', $staff->useremail) }}" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="password" class="form-label">New Password (Optional)</label>
                                            <input type="password" class="form-control" id="password" name="password" 
                                                   placeholder="Leave blank to keep current password">
                                            <small class="text-muted">Leave blank to keep current password</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                            <input type="password" class="form-control" id="password_confirmation" 
                                                   name="password_confirmation">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="telephone" class="form-label">Phone Number</label>
                                            <input type="text" class="form-control" id="telephone" name="telephone" 
                                                   value="{{ old('telephone', $staff->telephone) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="role" class="form-label">Role</label>
                                            <select class="form-select" id="role" name="role" required>
                                                <option value="">Select Role</option>
                                                <option value="bnbreceiptionist" {{ old('role', $staff->role) == 'bnbreceiptionist' ? 'selected' : '' }}>
                                                    Receptionist
                                                </option>
                                                <option value="bnbsecurity" {{ old('role', $staff->role) == 'bnbsecurity' ? 'selected' : '' }}>
                                                    Security
                                                </option>
                                                <option value="bnbchef" {{ old('role', $staff->role) == 'bnbchef' ? 'selected' : '' }}>
                                                    Chef
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="profileimage" class="form-label">Profile Image</label>
                                    <input type="file" class="form-control" id="profileimage" name="profileimage" 
                                           accept="image/*">
                                    @if($staff->profileimage)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $staff->profileimage) }}" 
                                                 alt="Current Image" 
                                                 style="max-width: 100px; max-height: 100px; object-fit: cover;"
                                                 class="img-thumbnail rounded-circle">
                                            <p class="text-muted small mt-1">Current image</p>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{ route('bnbowner.staff-management.index') }}" class="btn btn-secondary me-md-2">
                                        Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update Staff Member
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
