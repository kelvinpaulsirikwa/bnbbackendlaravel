@extends('adminpages.layouts.app')

@section('content')
     
    <div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">
                            Amenities Management
                        </h1>
                        <p class="text-muted mb-0">Manage amenities for properties</p>
                    </div>
                    <a href="{{ route('adminpages.amenities.create') }}" class="btn btn-primary btn-lg shadow-sm">
                        Add New Amenity
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
                <form method="GET" action="{{ route('adminpages.amenities.index') }}" id="filterForm">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="searchInput" class="form-label">Search</label>
                            <input type="text" class="form-control" id="searchInput" name="search" 
                                   placeholder="Search amenities..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-6 d-flex align-items-end">
                            <button type="submit" class="btn btn-outline-primary me-2">
                                <i class="bx bx-search"></i> Search
                            </button>
                            <a href="{{ route('adminpages.amenities.index') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-refresh"></i> Clear
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Amenities Table Card -->
        <div class="card shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="card-title mb-0">
                    <i class="bx bx-list-ul me-2"></i>
                    Amenities List
                    <span class="badge bg-primary ms-2">{{ $amenities->total() }} Total</span>
                </h5>
            </div>
            <div class="card-body p-0">
                @if($amenities->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0">ID</th>
                                    <th class="border-0">Name</th>
                                    <th class="border-0">Icon</th>
                                    <th class="border-0">Created By</th>
                                    <th class="border-0">Created At</th>
                                    <th class="border-0 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($amenities as $amenity)
                                    <tr>
                                        <td class="align-middle">
                                            <span class="badge bg-light text-dark">#{{ $amenity->id }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex align-items-center">
                                                <div class="fw-semibold">{{ $amenity->name }}</div>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            @if($amenity->icon)
                                                <img src="{{ asset($amenity->icon) }}" alt="Amenity icon" class="img-thumbnail" style="max-width: 40px; max-height: 40px;">
                                            @else
                                                <span class="text-muted">No icon</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            <span class="text-muted">{{ $amenity->createdby ? \App\Models\BnbUser::find($amenity->createdby)->username ?? 'User #' . $amenity->createdby : 'System' }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <span class="text-muted">{{ $amenity->created_at->format('M d, Y') }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('adminpages.amenities.show', $amenity->id) }}" 
                                                   class="btn btn-sm btn-outline-info" title="View">
                                                    <i class="bx bx-show"></i>
                                                </a>
                                                <a href="{{ route('adminpages.amenities.edit', $amenity->id) }}" 
                                                   class="btn btn-sm btn-outline-warning" title="Edit">
                                                    <i class="bx bx-edit"></i>
                                                </a>
                                                <form action="{{ route('adminpages.amenities.destroy', $amenity->id) }}" 
                                                      method="POST" class="d-inline" 
                                                      onsubmit="return confirm('Are you sure you want to delete this amenity?')">
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
                            <i class="bx bx-package display-1 text-muted"></i>
                        </div>
                        <h5 class="text-muted">No amenities found</h5>
                        <p class="text-muted mb-4">Get started by creating your first amenity.</p>
                        <a href="{{ route('adminpages.amenities.create') }}" class="btn btn-primary">
                            <i class="bx bx-plus"></i> Add New Amenity
                        </a>
                    </div>
                @endif
            </div>
            
            @if($amenities->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Showing {{ $amenities->firstItem() }} to {{ $amenities->lastItem() }} 
                            of {{ $amenities->total() }} results
                        </div>
                        <div>
                            {{ $amenities->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
