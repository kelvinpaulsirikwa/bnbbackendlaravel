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

            @if(session('reset_password'))
                <div class="alert alert-info">
                    <strong>New Password:</strong> {{ session('reset_password') }}
                    <p class="mb-0 small text-muted">Share this password securely with the staff member. They should change it after logging in.</p>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
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
                            <div class="d-flex justify-content-end mb-4">
                                <form method="POST" action="{{ route('bnbowner.staff-management.reset-password', $staff->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-sync-alt"></i> Reset Password
                                    </button>
                                </form>
                            </div>
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
                                            <label for="telephone" class="form-label">Phone Number</label>
                                            <input type="text" class="form-control" id="telephone" name="telephone" 
                                                   value="{{ old('telephone', $staff->telephone) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="motel_role_id" class="form-label">Role (from Role Management)</label>
                                            <select class="form-select" id="motel_role_id" name="motel_role_id">
                                                <option value="">— No role —</option>
                                                @foreach($motelRoles ?? [] as $r)
                                                    <option value="{{ $r->id }}" {{ old('motel_role_id', $staff->motel_role_id) == $r->id ? 'selected' : '' }}>{{ $r->name }}</option>
                                                @endforeach
                                            </select>
                                            @if(empty($motelRoles) || $motelRoles->isEmpty())
                                                <small class="text-muted">Create roles in <a href="{{ route('bnbowner.role-management.index') }}">Role Management</a> first.</small>
                                            @endif
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

                    @if(isset($ownedMotels) && $ownedMotels->isNotEmpty())
                    <div class="card mt-4 border-warning">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0">
                                <i class="fas fa-exchange-alt"></i> Transfer to another BNB
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-3">Move this staff member to one of your other properties. You will need to enter your account password to confirm.</p>
                            <form method="POST" action="{{ route('bnbowner.staff-management.transfer', $staff->id) }}" class="transfer-form">
                                @csrf
                                <div class="row align-items-end">
                                    <div class="col-md-4">
                                        <label for="target_motel_id" class="form-label">Transfer to BNB</label>
                                        <select class="form-select" id="target_motel_id" name="target_motel_id" required>
                                            <option value="">— Select a BNB —</option>
                                            @foreach($ownedMotels as $m)
                                                <option value="{{ $m->id }}">{{ $m->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="transfer_password" class="form-label">Your account password</label>
                                        <input type="password" class="form-control" id="transfer_password" name="password" required placeholder="Enter your login password" autocomplete="current-password">
                                    </div>
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-warning">
                                            <i class="fas fa-exchange-alt"></i> Transfer Staff
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @else
                    <div class="card mt-4 border-secondary">
                        <div class="card-body text-muted">
                            <i class="fas fa-info-circle"></i> Transfer to another BNB is available when you own more than one property.
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
