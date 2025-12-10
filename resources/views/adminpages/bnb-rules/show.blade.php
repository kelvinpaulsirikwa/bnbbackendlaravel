@extends('adminpages.layouts.app')

@section('content')
     
    <div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">
                            BNB Rules Details
                        </h1>
                        <p class="text-muted mb-0">View detailed rules and policies</p>
                    </div>
                    <a href="{{ route('adminpages.bnb-rules.index') }}" class="btn btn-outline-secondary">
                        <i class="bx bx-arrow-back me-1"></i>Back to List
                    </a>
                </div>
            </div>
        </div>

        <!-- Rules Details Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="bx bx-hotel me-2"></i>
                    Hotel Information
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-2">
                            <strong>Hotel Name:</strong><br>
                            {{ $bnbRule->motel->name ?? 'N/A' }}
                        </p>
                        @if($bnbRule->motel && $bnbRule->motel->owner)
                            <p class="mb-2">
                                <strong>Owner:</strong><br>
                                {{ $bnbRule->motel->owner->username }} 
                                <small class="text-muted">({{ $bnbRule->motel->owner->useremail }})</small>
                            </p>
                        @endif
                        @if($bnbRule->postedBy)
                            <p class="mb-2">
                                <strong>Posted By:</strong><br>
                                <span class="badge bg-info">{{ $bnbRule->postedBy->username }}</span>
                                <small class="text-muted">({{ $bnbRule->postedBy->useremail }})</small>
                            </p>
                        @endif
                        @if($bnbRule->motel && $bnbRule->motel->street_address)
                            <p class="mb-2">
                                <strong>Address:</strong><br>
                                {{ $bnbRule->motel->street_address }}
                            </p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        @if($bnbRule->motel && $bnbRule->motel->details)
                            <p class="mb-2">
                                <strong>Contact Phone:</strong><br>
                                {{ $bnbRule->motel->details->contact_phone ?? 'N/A' }}
                            </p>
                            <p class="mb-2">
                                <strong>Contact Email:</strong><br>
                                {{ $bnbRule->motel->details->contact_email ?? 'N/A' }}
                            </p>
                            <p class="mb-0">
                                <strong>Status:</strong><br>
                                <span class="badge bg-{{ $bnbRule->motel->details->status === 'active' ? 'success' : 'danger' }}">
                                    {{ ucfirst($bnbRule->motel->details->status ?? 'N/A') }}
                                </span>
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Rules Content Card -->
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bx bx-list-check me-2"></i>
                    Rules and Policies
                </h5>
                <div>
                    <small class="text-muted">
                        Created: {{ $bnbRule->created_at->format('M d, Y h:i A') }} | 
                        Updated: {{ $bnbRule->updated_at->format('M d, Y h:i A') }}
                    </small>
                </div>
            </div>
            <div class="card-body">
                @if($bnbRule->rules)
                    <div class="rules-content" style="white-space: pre-wrap; line-height: 1.8; font-size: 15px;">
                        {{ $bnbRule->rules }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bx bx-info-circle fs-1 text-muted"></i>
                        <p class="text-muted mt-3 mb-0">No rules have been set for this hotel.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

