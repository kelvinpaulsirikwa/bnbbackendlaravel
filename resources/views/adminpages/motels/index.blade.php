@extends('adminpages.layouts.app')

@section('content')
     
    <div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">
                            Motels Management
                        </h1>
                        <p class="text-muted mb-0">Manage motel properties</p>
                    </div>
                    <a href="{{ route('adminpages.motels.create') }}" class="btn btn-primary btn-lg shadow-sm">
                        Add New Motel
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
                <form method="GET" action="{{ route('adminpages.motels.index') }}" id="filterForm">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="searchInput" class="form-label">Search</label>
                            <input type="text" class="form-control" id="searchInput" name="search" 
                                   placeholder="Search motels..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="statusFilter" class="form-label">Filter by Status</label>
                            <select class="form-select" id="statusFilter" name="status" onchange="document.getElementById('filterForm').submit()">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="motelTypeFilter" class="form-label">Filter by Type</label>
                            <select class="form-select" id="motelTypeFilter" name="motel_type_id" onchange="document.getElementById('filterForm').submit()">
                                <option value="">All Types</option>
                                @foreach($motelTypes as $motelType)
                                    <option value="{{ $motelType->id }}" {{ request('motel_type_id') == $motelType->id ? 'selected' : '' }}>
                                        {{ $motelType->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-outline-primary me-2">
                                <i class="bx bx-search"></i> Search
                            </button>
                            <a href="{{ route('adminpages.motels.index') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-refresh"></i> Clear
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Motels Table Card -->
        <div class="card shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="card-title mb-0">
                    <i class="bx bx-list-ul me-2"></i>
                    Motels List
                    <span class="badge bg-primary ms-2">{{ $motels->total() }} Total</span>
                </h5>
            </div>
            <div class="card-body p-0">
                @if($motels->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0">ID</th>
                                    <th class="border-0">Name</th>
                                    <th class="border-0">Owner</th>
                                    <th class="border-0">Type</th>
                                    <th class="border-0">Status</th>
                                    <th class="border-0">Contact</th>
                                    <th class="border-0">Created</th>
                                    <th class="border-0 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($motels as $motel)
                                    <tr>
                                        <td class="align-middle">
                                            <span class="badge bg-light text-dark">#{{ $motel->id }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <div class="fw-semibold">{{ $motel->name }}</div>
                                            @if($motel->description)
                                                <small class="text-muted">{{ Str::limit($motel->description, 50) }}</small>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            <span class="text-muted">{{ $motel->owner->username ?? 'N/A' }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class="badge bg-info">{{ $motel->motelType->name ?? 'No Type' }}</span>
                                        </td>
                                        <td class="align-middle">
                                            @php
                                                $statusColors = [
                                                    'active' => 'bg-success',
                                                    'inactive' => 'bg-warning',
                                                    'closed' => 'bg-danger'
                                                ];
                                            @endphp
                                            <span class="badge {{ $statusColors[$motel->status] ?? 'bg-secondary' }}">
                                                {{ ucfirst($motel->status) }}
                                            </span>
                                        </td>
                                        <td class="align-middle">
                                            <div class="small">
                                                @if($motel->contact_phone)
                                                    <div><i class="bx bx-phone"></i> {{ $motel->contact_phone }}</div>
                                                @endif
                                                @if($motel->contact_email)
                                                    <div><i class="bx bx-envelope"></i> {{ $motel->contact_email }}</div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            <span class="text-muted">{{ $motel->created_at->format('M d, Y') }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('adminpages.motels.show', $motel->id) }}" 
                                                   class="btn btn-sm btn-outline-info" title="View">
                                                    <i class="bx bx-show"></i>
                                                </a>
                                                <a href="{{ route('adminpages.motels.edit', $motel->id) }}" 
                                                   class="btn btn-sm btn-outline-warning" title="Edit">
                                                    <i class="bx bx-edit"></i>
                                                </a>
                                                <form action="{{ route('adminpages.motels.destroy', $motel->id) }}" 
                                                      method="POST" class="d-inline" 
                                                      onsubmit="return confirm('Are you sure you want to delete this motel?')">
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
                            <i class="bx bx-home display-1 text-muted"></i>
                        </div>
                        <h5 class="text-muted">No motels found</h5>
                        <p class="text-muted mb-4">Get started by creating your first motel.</p>
                        <a href="{{ route('adminpages.motels.create') }}" class="btn btn-primary">
                            <i class="bx bx-plus"></i> Add New Motel
                        </a>
                    </div>
                @endif
            </div>
            
            @if($motels->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Showing {{ $motels->firstItem() }} to {{ $motels->lastItem() }} 
                            of {{ $motels->total() }} results
                        </div>
                        <div>
                            {{ $motels->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
