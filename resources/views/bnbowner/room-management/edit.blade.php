@extends('layouts.owner')

@section('title', 'Edit Room')

@section('content')
<div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Edit Room {{ $room->room_number }} - {{ $motel->name }}</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('bnbowner.room-management.show', $room->id) }}" class="btn btn-outline-primary me-2">
                        <i class="fas fa-eye"></i> View Room
                    </a>
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

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Room information form --}}
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-edit"></i> Room Information</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('bnbowner.room-management.update', $room->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="room_number" class="form-label">Room Number</label>
                                    <input type="text" class="form-control" id="room_number" name="room_number" value="{{ old('room_number', $room->room_number) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="room_type_id" class="form-label">Room Type</label>
                                    <select class="form-select" id="room_type_id" name="room_type_id" required>
                                        <option value="">Select Room Type</option>
                                        @foreach($roomTypes as $roomType)
                                            <option value="{{ $roomType->id }}" {{ old('room_type_id', $room->room_type_id) == $roomType->id ? 'selected' : '' }}>{{ $roomType->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="price_per_night" class="form-label">Price Per Night ($)</label>
                                    <input type="number" class="form-control" id="price_per_night" name="price_per_night" value="{{ old('price_per_night', $room->price_per_night) }}" step="0.01" min="0" required>
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
                                    <input type="file" class="form-control" id="frontimage" name="frontimage" accept="image/*">
                                    @if($room->frontimage)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $room->frontimage) }}" alt="Current" style="max-width: 120px; max-height: 90px; object-fit: cover;" class="img-thumbnail">
                                            <p class="text-muted small mt-1 mb-0">Current image</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('bnbowner.room-management.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Room</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Room items: add & edit --}}
            <div class="card mb-4">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-box"></i> Room Items ({{ $room->items->count() }})</h5>
                    <a href="{{ route('bnbowner.room-items.create', $room->id) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Add Item
                    </a>
                </div>
                <div class="card-body p-0">
                    @if($room->items->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th class="text-end" style="width: 140px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($room->items as $item)
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->description ?? '—' }}</td>
                                            <td class="text-end">
                                                <a href="{{ route('bnbowner.room-items.edit', [$room->id, $item->id]) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                                <form method="POST" action="{{ route('bnbowner.room-items.destroy', [$room->id, $item->id]) }}" class="d-inline" onsubmit="return confirm('Delete this item?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted mb-0 p-3">No items yet. <a href="{{ route('bnbowner.room-items.create', $room->id) }}">Add item</a></p>
                    @endif
                </div>
            </div>

            {{-- Room images: add & edit --}}
            <div class="card mb-4">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-images"></i> Room Images ({{ $room->images->count() }})</h5>
                    <a href="{{ route('bnbowner.room-images.create', $room->id) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Upload Image
                    </a>
                </div>
                <div class="card-body">
                    @if($room->images->count() > 0)
                        <div class="row g-3">
                            @foreach($room->images as $image)
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="card h-100">
                                        <img src="{{ asset('storage/' . $image->imagepath) }}" class="card-img-top" alt="" style="height: 160px; object-fit: cover;">
                                        <div class="card-body py-2">
                                            @if($image->description)
                                                <p class="card-text small text-muted mb-2">{{ Str::limit($image->description, 40) }}</p>
                                            @endif
                                            <div class="btn-group btn-group-sm w-100">
                                                <a href="{{ route('bnbowner.room-images.edit', [$room->id, $image->id]) }}" class="btn btn-outline-primary">Edit</a>
                                                <form method="POST" action="{{ route('bnbowner.room-images.destroy', [$room->id, $image->id]) }}" class="d-inline" onsubmit="return confirm('Delete this image?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">No images yet. <a href="{{ route('bnbowner.room-images.create', $room->id) }}">Upload image</a></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
