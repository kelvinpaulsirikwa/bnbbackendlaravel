@extends('layouts.owner')

@section('title', 'Room Management')

@section('content')
<div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Room Management - {{ $motel->name }}</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('bnbowner.room-management.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Room
                    </a>
                    <a href="{{ route('bnbowner.dashboard') }}" class="btn btn-sm btn-outline-secondary ms-2">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
            </div>

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

            @if($rooms->count() > 0)
                <div class="row">
                    @foreach($rooms as $room)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100">
                                @if($room->frontimage)
                                    <img src="{{ asset('storage/' . $room->frontimage) }}" 
                                         class="card-img-top" 
                                         alt="{{ $room->room_number }}" 
                                         style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                         style="height: 200px;">
                                        <i class="fas fa-bed fa-3x text-muted"></i>
                                    </div>
                                @endif
                                
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">Room {{ $room->room_number }}</h5>
                                    <p class="card-text">
                                        <strong>Type:</strong> {{ $room->roomType->name ?? 'N/A' }}<br>
                                        <strong>Price:</strong> ${{ number_format($room->price_per_night, 2) }}/night<br>
                                        <strong>Status:</strong> 
                                        <span class="badge bg-{{ $room->status === 'active' ? 'success' : 'danger' }}">
                                            {{ ucfirst($room->status) }}
                                        </span>
                                    </p>
                                    
                                    <div class="mt-auto">
                                        <div class="btn-group w-100" role="group">
                                            <a href="{{ route('bnbowner.room-management.edit', $room->id) }}" 
                                               class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="{{ route('bnbowner.room-items.index', $room->id) }}" 
                                               class="btn btn-outline-info btn-sm">
                                                <i class="fas fa-box"></i> Items
                                            </a>
                                            <a href="{{ route('bnbowner.room-images.index', $room->id) }}" 
                                               class="btn btn-outline-secondary btn-sm">
                                                <i class="fas fa-images"></i> Images
                                            </a>
                                        </div>
                                        
                                        <form method="POST" action="{{ route('bnbowner.room-management.destroy', $room->id) }}" 
                                              class="mt-2" 
                                              onsubmit="return confirm('Are you sure you want to delete this room?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-bed fa-4x text-muted mb-3"></i>
                    <h4>No Rooms Found</h4>
                    <p class="text-muted">You haven't added any rooms to this motel yet.</p>
                    <a href="{{ route('bnbowner.room-management.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Your First Room
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
