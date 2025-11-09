@extends('adminpages.layouts.app')

@section('content')
     
    <div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">
                            Motel Details Management
                        </h1>
                        <p class="text-muted mb-0">Manage detailed information for motels</p>
                    </div>
                    <a href="{{ route('adminpages.motel-details.create') }}" class="btn btn-primary btn-lg shadow-sm">
                        Add New Motel Details
                    </a>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Search and Filter Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('adminpages.motel-details.index') }}" id="filterForm">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="searchInput" class="form-label">Search</label>
                            <input type="text" class="form-control" id="searchInput" name="search" 
                                   placeholder="Search motel details..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="districtFilter" class="form-label">Filter by District</label>
                            <select class="form-select" id="districtFilter" name="district_id" onchange="document.getElementById('filterForm').submit()">
                                <option value="">All Districts</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district->id }}" {{ request('district_id') == $district->id ? 'selected' : '' }}>
                                        {{ $district->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-outline-primary me-2">
                                <i class="bx bx-search"></i> Search
                            </button>
                            <a href="{{ route('adminpages.motel-details.index') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-refresh"></i> Clear
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Motel Details Table Card -->
        <div class="card shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="card-title mb-0">
                    <i class="bx bx-list-ul me-2"></i>
                    Motel Details List
                    <span class="badge bg-primary ms-2">{{ $motelDetails->total() }} Total</span>
                </h5>
            </div>
            <div class="card-body p-0">
                @if($motelDetails->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0">ID</th>
                                    <th class="border-0">Motel</th>
                                    <th class="border-0">Address</th>
                                    <th class="border-0">District</th>
                                    <th class="border-0">Rooms</th>
                                    <th class="border-0">Rate</th>
                                    <th class="border-0">Image</th>
                                    <th class="border-0 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($motelDetails as $detail)
                                    <tr>
                                        <td class="align-middle">
                                            <span class="badge bg-light text-dark">#{{ $detail->id }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <div class="fw-semibold">{{ $detail->motel->name }}</div>
                                            <small class="text-muted">{{ $detail->motel->owner->username ?? 'N/A' }}</small>
                                        </td>
                                        <td class="align-middle">
                                            <span class="text-muted">{{ Str::limit($detail->street_address, 30) ?: 'N/A' }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class="text-muted">{{ $detail->district->name ?? 'N/A' }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <div class="small">
                                                <div>Total: <strong>{{ $detail->total_rooms }}</strong></div>
                                                <div>Available: <strong>{{ $detail->available_rooms }}</strong></div>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <span class="fw-semibold text-success">${{ number_format($detail->rate, 2) }}</span>
                                        </td>
                                        <td class="align-middle">
                                            @if($detail->front_image)
                                                <img src="{{ asset($detail->front_image) }}" alt="Front image" class="img-thumbnail" style="max-width: 50px; max-height: 50px;">
                                            @else
                                                <span class="text-muted">No image</span>
                                            @endif
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('adminpages.motel-details.show', $detail->id) }}" 
                                                   class="btn btn-sm btn-outline-info" title="View">
                                                    <i class="bx bx-show"></i>
                                                </a>
                                                <a href="{{ route('adminpages.motel-details.edit', $detail->id) }}" 
                                                   class="btn btn-sm btn-outline-warning" title="Edit">
                                                    <i class="bx bx-edit"></i>
                                                </a>
                                                <form action="{{ route('adminpages.motel-details.destroy', $detail->id) }}" 
                                                      method="POST" class="d-inline" 
                                                      onsubmit="return confirm('Are you sure you want to delete this motel detail?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="bx bx-detail display-1 text-muted"></i>
                        </div>
                        <h5 class="text-muted">No motel details found</h5>
                        <p class="text-muted mb-4">Get started by creating your first motel details.</p>
                        <a href="{{ route('adminpages.motel-details.create') }}" class="btn btn-primary">
                            <i class="bx bx-plus"></i> Add New Motel Details
                        </a>
                    </div>
                @endif
            </div>
            
            @if($motelDetails->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Showing {{ $motelDetails->firstItem() }} to {{ $motelDetails->lastItem() }} 
                            of {{ $motelDetails->total() }} results
                        </div>
                        <div>
                            {{ $motelDetails->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
