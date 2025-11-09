@extends('adminpages.layouts.app')

@section('content')
    <div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">
                            User Details
                        </h1>
                        <p class="text-muted mb-0">View user information</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('adminpages.users.edit', $user->id) }}" class="btn btn-warning btn-lg shadow-sm">
                            <i class="bx bx-edit"></i> Edit
                        </a>
                        <a href="{{ route('adminpages.users.index') }}" class="btn btn-outline-secondary btn-lg shadow-sm">
                            <i class="bx bx-arrow-back"></i> Back to Users
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details Card -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-info-circle me-2"></i>
                            User Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <!-- Profile Image -->
                            <div class="col-12 text-center mb-4">
                                @if($user->profileimage)
                                    <img src="{{ asset($user->profileimage) }}" alt="Profile" class="rounded-circle shadow" style="width: 120px; height: 120px; object-fit: cover;">
                                @else
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto shadow" style="width: 120px; height: 120px; font-size: 3rem;">
                                        {{ strtoupper(substr($user->username, 0, 1)) }}
                                    </div>
                                @endif
                            </div>

                            <!-- ID -->
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bx bx-hash text-primary fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 text-muted">ID</h6>
                                        <p class="mb-0 fw-semibold">#{{ $user->id }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Username -->
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bx bx-user text-primary fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 text-muted">Username</h6>
                                        <p class="mb-0 fw-semibold">{{ $user->username }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bx bx-envelope text-primary fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 text-muted">Email</h6>
                                        <p class="mb-0 fw-semibold">{{ $user->useremail }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bx bx-phone text-primary fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 text-muted">Phone</h6>
                                        <p class="mb-0 fw-semibold">{{ $user->telephone ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Role -->
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bx bx-shield text-primary fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 text-muted">Role</h6>
                                        @php
                                            $roleLabels = [
                                                'bnbadmin' => 'Admin',
                                                'bnbowner' => 'Owner',
                                                'bnbreceiptionist' => 'Receptionist',
                                                'bnbsecurity' => 'Security',
                                                'bnbchef' => 'Chef'
                                            ];
                                        @endphp
                                        <span class="badge bg-info fs-6">{{ $roleLabels[$user->role] ?? $user->role }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bx bx-check-circle text-primary fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 text-muted">Status</h6>
                                        <span class="badge {{ $user->status == 'active' ? 'bg-success' : 'bg-danger' }} fs-6">
                                            {{ ucfirst($user->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Created By -->
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bx bx-user-plus text-primary fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 text-muted">Created By</h6>
                                        <p class="mb-0 fw-semibold">{{ $user->createdby ? \App\Models\BnbUser::find($user->createdby)->username ?? 'User #' . $user->createdby : 'System' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Created At -->
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bx bx-calendar text-primary fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 text-muted">Created At</h6>
                                        <p class="mb-0 fw-semibold">{{ $user->created_at->format('M d, Y H:i A') }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Updated At -->
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="bx bx-time text-primary fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1 text-muted">Last Updated</h6>
                                        <p class="mb-0 fw-semibold">{{ $user->updated_at->format('M d, Y H:i A') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions Card -->
                <div class="card shadow-sm mt-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="card-title mb-0">
                            <i class="bx bx-cog me-2"></i>
                            Actions
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex gap-2">
                            <a href="{{ route('adminpages.users.edit', $user->id) }}" 
                               class="btn btn-warning">
                                <i class="bx bx-edit"></i> Edit User
                            </a>
                            <form action="{{ route('adminpages.users.destroy', $user->id) }}" 
                                  method="POST" class="d-inline" 
                                  onsubmit="return confirm('Are you sure you want to delete this user?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="bx bx-trash"></i> Delete User
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
