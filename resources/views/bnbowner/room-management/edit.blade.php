@extends('layouts.owner')

@section('title', 'Edit Room')

@section('content')
<div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Edit Room {{ $room->room_number }} - {{ $motel->name }}</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('bnbowner.room-management.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Rooms
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

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-edit"></i> Room Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('bnbowner.room-management.update', $room->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="room_number" class="form-label">Room Number</label>
                                            <input type="text" class="form-control" id="room_number" name="room_number" 
                                                   value="{{ old('room_number', $room->room_number) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="room_type_id" class="form-label">Room Type</label>
                                            <select class="form-select" id="room_type_id" name="room_type_id" required>
                                                <option value="">Select Room Type</option>
                                                @foreach($roomTypes as $roomType)
                                                    <option value="{{ $roomType->id }}" 
                                                            {{ old('room_type_id', $room->room_type_id) == $roomType->id ? 'selected' : '' }}>
                                                        {{ $roomType->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="price_per_night" class="form-label">Price Per Night ($)</label>
                                            <input type="number" class="form-control" id="price_per_night" name="price_per_night" 
                                                   value="{{ old('price_per_night', $room->price_per_night) }}" step="0.01" min="0" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-select" id="status" name="status" required>
                                                <option value="free" {{ old('status', $room->status) == 'free' ? 'selected' : '' }}>Free</option>
                                                <option value="booked" {{ old('status', $room->status) == 'booked' ? 'selected' : '' }}>Booked</option>
                                                <option value="maintainace" {{ old('status', $room->status) == 'maintainace' ? 'selected' : '' }}>Maintenance</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="frontimage" class="form-label">Room Image</label>
                                            <input type="file" class="form-control" id="frontimage" name="frontimage" 
                                                   accept="image/*">
                                            @if($room->frontimage)
                                                <div class="mt-2">
                                                    <img src="{{ asset('storage/' . $room->frontimage) }}" 
                                                         alt="Current Image" 
                                                         style="max-width: 200px; max-height: 150px; object-fit: cover;"
                                                         class="img-thumbnail">
                                                    <p class="text-muted small mt-1">Current image</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{ route('bnbowner.room-management.index') }}" class="btn btn-secondary me-md-2">
                                        Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update Room
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
