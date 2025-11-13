@extends('layouts.owner')

@section('title', 'Hotel Facilities')

@section('content')
<div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <div>
                    <h1 class="h2">Hotel Facilities</h1>
                    <p class="text-muted mb-0">Manage amenities and their images for <strong>{{ $motel->name }}</strong></p>
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
                <div class="col-lg-5">
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-plus-circle"></i> Add Amenity
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('bnbowner.hotel-facilities.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="amenities_id" class="form-label">Select Amenity</label>
                                    <select class="form-select" id="amenities_id" name="amenities_id" required>
                                        <option value="">Choose amenity</option>
                                        @foreach ($amenities as $amenity)
                                            <option value="{{ $amenity->id }}"
                                                {{ in_array($amenity->id, $assignedAmenityIds) ? 'disabled' : '' }}>
                                                {{ $amenity->name }}
                                                @if (in_array($amenity->id, $assignedAmenityIds))
                                                    (Already added)
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Only amenities not already assigned can be selected.</small>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description (optional)</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Describe how this amenity is offered"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Add Amenity
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-header bg-white">
                            <h5 class="mb-0 text-dark">
                                <i class="fas fa-concierge-bell text-primary"></i> Current Amenities
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            @if ($motel->amenities->isEmpty())
                                <div class="p-4 text-center text-muted">
                                    <i class="fas fa-info-circle me-2"></i>No amenities added yet. Use the form to add one.
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Amenity</th>
                                                <th>Description</th>
                                                <th>Added By</th>
                                                <th class="text-center">Images</th>
                                                <th class="text-end">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($motel->amenities as $motelAmenity)
                                                <tr>
                                                    <td>
                                                        <strong>{{ $motelAmenity->amenity->name ?? 'Unknown Amenity' }}</strong>
                                                    </td>
                                                    <td>{{ $motelAmenity->description ?? '—' }}</td>
                                                    <td>{{ $motelAmenity->postedBy->username ?? $motelAmenity->postedBy->useremail ?? 'Unknown' }}</td>
                                                    <td class="text-center">
                                                        <span class="badge bg-primary">
                                                            {{ $motelAmenity->images->count() }}
                                                        </span>
                                                    </td>
                                                    <td class="text-end">
                                                        <a href="{{ route('bnbowner.hotel-facilities.images', $motelAmenity->id) }}"
                                                           class="btn btn-sm btn-outline-primary me-2">
                                                            <i class="fas fa-images"></i> Manage Images
                                                        </a>
                                                        <form method="POST" action="{{ route('bnbowner.hotel-facilities.destroy', $motelAmenity->id) }}" class="d-inline" onsubmit="return confirm('Remove this amenity?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                <i class="fas fa-trash-alt"></i> Remove
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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

