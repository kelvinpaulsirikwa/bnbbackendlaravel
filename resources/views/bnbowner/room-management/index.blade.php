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
                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 80px;">Image</th>
                                        <th>Room #</th>
                                        <th>Type</th>
                                        <th>Price / night</th>
                                        <th>Status</th>
                                        <th class="text-end" style="width: 200px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rooms as $room)
                                        <tr>
                                            <td>
                                                @if($room->frontimage)
                                                    <img src="{{ asset('storage/' . $room->frontimage) }}" alt="" class="rounded" style="width: 56px; height: 56px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                                                        <i class="fas fa-bed text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td><strong>{{ $room->room_number }}</strong></td>
                                            <td>{{ $room->roomType->name ?? 'N/A' }}</td>
                                            <td>${{ number_format($room->price_per_night, 2) }}</td>
                                            <td>
                                                <span class="badge bg-{{ $room->status === 'free' ? 'success' : ($room->status === 'booked' ? 'warning' : 'secondary') }}">
                                                    {{ ucfirst($room->status) }}
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="{{ route('bnbowner.room-management.show', $room->id) }}" class="btn btn-outline-primary" title="View">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                    <a href="{{ route('bnbowner.room-management.edit', $room->id) }}" class="btn btn-outline-secondary" title="Edit">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <form method="POST" action="{{ route('bnbowner.room-management.destroy', $room->id) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this room?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger" title="Delete">
                                                            <i class="fas fa-trash"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
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
