@extends('layouts.owner')

@section('title', 'Hotel Images')

@section('content')
<div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <div>
                    <h1 class="h2">Hotel Images</h1>
                    <p class="text-muted mb-0">Manage gallery images for <strong>{{ $motel->name }}</strong></p>
                </div>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('bnbowner.hotel-management.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Hotel Management
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-upload"></i> Upload Image
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('bnbowner.hotel-images.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="image" class="form-label">Select Image</label>
                                    <input type="file"
                                           class="form-control"
                                           id="image"
                                           name="image"
                                           accept="image/*"
                                           required>
                                    <small class="text-muted">Supported formats: jpeg, png, jpg, gif. Max size 4MB.</small>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-save"></i> Upload
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0 text-dark">
                                <i class="fas fa-images text-primary"></i> Existing Images
                            </h5>
                        </div>
                        <div class="card-body">
                            @if ($images->isEmpty())
                                <div class="text-center text-muted py-5">
                                    <i class="fas fa-image fa-2x mb-3"></i>
                                    <p class="mb-0">No images uploaded yet. Use the form to add one.</p>
                                </div>
                            @else
                                <div class="row g-3">
                                    @foreach ($images as $image)
                                        <div class="col-md-6">
                                            <div class="card h-100 shadow-sm">
                                                <img src="{{ asset('storage/' . $image->filepath) }}"
                                                     class="card-img-top"
                                                     alt="Hotel image"
                                                     style="height: 180px; object-fit: cover;">
                                                <div class="card-body d-flex flex-column">
                                                    <p class="mb-1 text-muted small">
                                                        Uploaded by:
                                                        <strong>{{ $image->postedBy->username ?? $image->postedBy->useremail ?? 'Unknown' }}</strong>
                                                        <br>
                                                        <span class="text-muted">{{ optional($image->created_at)->format('d M Y, H:i') }}</span>
                                                    </p>
                                                    <form method="POST" action="{{ route('bnbowner.hotel-images.destroy', $image->id) }}" onsubmit="return confirm('Delete this image?');" class="mt-auto">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                                            <i class="fas fa-trash-alt"></i> Remove Image
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

