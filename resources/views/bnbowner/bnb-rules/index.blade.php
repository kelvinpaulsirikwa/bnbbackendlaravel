@extends('layouts.owner')

@section('title', 'BNB Rules Management')

@section('content')
<div class="container-fluid py-4" style="background-color: #f5f5f5; min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            
            <!-- Page Header -->
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <h2 class="fw-bold mb-0">BNB Rules Management</h2>

                @if($motel)
                    <div class="card border-0 shadow-sm ms-3">
                        <div class="card-body py-2 px-3">
                            <div class="small text-muted">Currently viewing</div>
                            <div class="fw-semibold">{{ $motel->name }}</div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Rules Form Card -->
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-list-alt me-2"></i>Hotel Rules</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('bnbowner.bnb-rules.store') }}" id="rulesForm">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="rules" class="form-label">Rules and Policies</label>
                            <textarea class="form-control" id="rules" name="rules" rows="15" 
                                      placeholder="Enter your hotel rules, policies, and guidelines here. You can include information about check-in/check-out times, cancellation policies, pet policies, smoking policies, etc.">{{ old('rules', $bnbRule->rules ?? '') }}</textarea>
                            <div class="form-text">Write all the rules and policies for your BNB. This information will be visible to guests.</div>
                            @error('rules')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                @if($bnbRule && $bnbRule->id)
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i>Update Rules
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-plus me-1"></i>Create Rules
                                    </button>
                                @endif
                            </div>
                            <a href="{{ route('bnbowner.dashboard') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Help Card -->
            <div class="card mt-4 border-info">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Tips for Writing Rules</h6>
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li>Be clear and specific about your policies</li>
                        <li>Include check-in and check-out times</li>
                        <li>Mention cancellation and refund policies</li>
                        <li>Specify rules about pets, smoking, parties, etc.</li>
                        <li>Include any age restrictions or special requirements</li>
                        <li>Mention quiet hours or noise policies</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

