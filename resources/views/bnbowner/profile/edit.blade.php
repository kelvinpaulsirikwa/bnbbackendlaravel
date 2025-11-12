@extends('layouts.owner')

@section('content')
@php
    $defaultAvatarPath = 'images/static_file/nodp.png';
    $avatar = asset($defaultAvatarPath);

    if (!empty($user->profileimage)) {
        $normalizedPath = ltrim(str_replace('storage/', '', $user->profileimage), '/');
        $avatar = asset('storage/' . $normalizedPath);
    }
@endphp

<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="mb-4">
                <h2 class="fw-semibold">Profile Management</h2>
                <p class="text-muted mb-0">Update your profile picture and password to keep your account secure.</p>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Profile Picture</h5>
                </div>
                <div class="card-body text-center">
                    <img src="{{ $avatar }}"
                         alt="Profile picture"
                         class="rounded-circle mb-3"
                         style="width: 120px; height: 120px; object-fit: cover;"
                         onerror="this.onerror=null;this.src='{{ asset($defaultAvatarPath) }}';">

                    @if (session('success_avatar'))
                        <div class="alert alert-success py-2">
                            {{ session('success_avatar') }}
                        </div>
                    @endif

                    <form action="{{ route('bnbowner.profile.update-avatar') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 text-start">
                            <label for="profile_image" class="form-label">Upload new picture</label>
                            <input
                                type="file"
                                name="profile_image"
                                id="profile_image"
                                class="form-control @error('profile_image') is-invalid @enderror"
                                accept="image/*"
                                required
                            >
                            @error('profile_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                <div class="form-text">Max size 2MB. Accepted formats: JPG, PNG, GIF.</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Update Picture</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8 d-flex flex-column gap-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Profile Details</h5>
                </div>
                <div class="card-body">
                    @if (session('success_profile'))
                        <div class="alert alert-success">
                            {{ session('success_profile') }}
                        </div>
                    @endif

                    <form action="{{ route('bnbowner.profile.update') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input
                                type="text"
                                name="username"
                                id="username"
                                class="form-control @error('username') is-invalid @enderror"
                                value="{{ old('username', $user->username) }}"
                                required
                            >
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="telephone" class="form-label">Telephone</label>
                            <input
                                type="text"
                                name="telephone"
                                id="telephone"
                                class="form-control @error('telephone') is-invalid @enderror"
                                value="{{ old('telephone', $user->telephone) }}"
                                placeholder="Enter phone number"
                            >
                            @error('telephone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Update Details</button>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Change Password</h5>
                </div>
                <div class="card-body">
                    @if (session('success_password'))
                        <div class="alert alert-success">
                            {{ session('success_password') }}
                        </div>
                    @endif

                    <form action="{{ route('bnbowner.profile.update-password') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input
                                type="password"
                                name="current_password"
                                id="current_password"
                                class="form-control @error('current_password') is-invalid @enderror"
                                required
                                autocomplete="current-password"
                            >
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">New Password</label>
                                    <input
                                        type="password"
                                        name="password"
                                        id="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        required
                                        autocomplete="new-password"
                                    >
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input
                                        type="password"
                                        name="password_confirmation"
                                        id="password_confirmation"
                                        class="form-control"
                                        required
                                        autocomplete="new-password"
                                    >
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


