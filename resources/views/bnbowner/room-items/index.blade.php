@extends('layouts.owner')

@section('title', 'Room Items - Room ' . $room->room_number)

@section('content')
<div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Room Items - Room {{ $room->room_number }}</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('bnbowner.room-items.create', $room->id) }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Item
                    </a>
                    <a href="{{ route('bnbowner.room-management.index') }}" class="btn btn-outline-secondary ms-2">
                        <i class="fas fa-arrow-left"></i> Back to Rooms
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

            <!-- Room Info Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            @if($room->frontimage)
                                <img src="{{ asset('storage/' . $room->frontimage) }}" 
                                     class="img-fluid rounded" 
                                     alt="Room {{ $room->room_number }}">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                     style="height: 150px;">
                                    <i class="fas fa-bed fa-3x text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-9">
                            <h4>Room {{ $room->room_number }}</h4>
                            <p><strong>Type:</strong> {{ $room->roomType->name ?? 'N/A' }}</p>
                            <p><strong>Price:</strong> ${{ number_format($room->price_per_night, 2) }}/night</p>
                            <p><strong>Status:</strong> 
                                <span class="badge bg-{{ $room->status === 'active' ? 'success' : 'danger' }}">
                                    {{ ucfirst($room->status) }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            @if($items->count() > 0)
                <div class="row">
                    @foreach($items as $item)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $item->name }}</h5>
                                    <p class="card-text flex-grow-1">{{ $item->description }}</p>
                                    
                                    <div class="mt-auto">
                                        <div class="btn-group w-100" role="group">
                                            <a href="{{ route('bnbowner.room-items.edit', [$room->id, $item->id]) }}" 
                                               class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form method="POST" action="{{ route('bnbowner.room-items.destroy', [$room->id, $item->id]) }}" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this item?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-box fa-4x text-muted mb-3"></i>
                    <h4>No Items Found</h4>
                    <p class="text-muted">This room doesn't have any items added yet.</p>
                    <a href="{{ route('bnbowner.room-items.create', $room->id) }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add First Item
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
