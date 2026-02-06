@extends('layouts.owner')

@section('title', 'View Room ' . $room->room_number)

@section('content')
<div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">View Room {{ $room->room_number }} - {{ $motel->name }}</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('bnbowner.room-management.edit', $room->id) }}" class="btn btn-primary me-2">
                        <i class="fas fa-edit"></i> Edit Room
                    </a>
                    <a href="{{ route('bnbowner.room-management.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Rooms
                    </a>
                </div>
            </div>

            {{-- Room info --}}
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-bed"></i> Room Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            @if($room->frontimage)
                                <img src="{{ asset('storage/' . $room->frontimage) }}" class="img-fluid rounded" alt="Room {{ $room->room_number }}">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 180px;">
                                    <i class="fas fa-bed fa-3x text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-9">
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <th width="140">Room Number</th>
                                    <td>{{ $room->room_number }}</td>
                                </tr>
                                <tr>
                                    <th>Room Type</th>
                                    <td>{{ $room->roomType->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Price per night</th>
                                    <td>${{ number_format($room->price_per_night, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge bg-{{ $room->status === 'free' ? 'success' : ($room->status === 'booked' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($room->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Created by</th>
                                    <td>{{ $room->creator ? $room->creator->username : '—' }}@if($room->creator) <span class="text-muted">({{ $room->creator->useremail }})</span>@endif</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Room items (read-only) --}}
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-box"></i> Room Items ({{ $room->items->count() }})</h5>
                </div>
                <div class="card-body">
                    @if($room->items->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Created by</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($room->items as $item)
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->description ?? '—' }}</td>
                                            <td>{{ $item->creator ? $item->creator->username : '—' }}@if($item->creator) <span class="text-muted small">({{ $item->creator->useremail }})</span>@endif</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted mb-0">No items in this room.</p>
                    @endif
                </div>
            </div>

            {{-- Room images (read-only, paginated) --}}
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-images"></i> Room Images ({{ $roomImages->total() }})</h5>
                </div>
                <div class="card-body">
                    @if($roomImages->count() > 0)
                        <div class="row g-3">
                            @foreach($roomImages as $image)
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="card h-100">
                                        <img src="{{ asset('storage/' . $image->imagepath) }}" class="card-img-top" alt="Room image" style="height: 180px; object-fit: cover;">
                                        <div class="card-body py-2">
                                            @if($image->description)
                                                <p class="card-text small text-muted mb-1">{{ $image->description }}</p>
                                            @endif
                                            <p class="card-text small mb-0"><strong>Created by:</strong> {{ $image->creator ? $image->creator->username : '—' }}@if($image->creator) <span class="text-muted">({{ $image->creator->useremail }})</span>@endif</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            {{ $roomImages->links() }}
                        </div>
                    @else
                        <p class="text-muted mb-0">No images for this room.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
