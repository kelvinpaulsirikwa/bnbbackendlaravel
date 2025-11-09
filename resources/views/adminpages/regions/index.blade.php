@extends('adminpages.layouts.app')

@section('content')
     
    <div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">
                            Regions Management
                        </h1>
                        <p class="text-muted mb-0">Manage regions within countries</p>
                    </div>
                    <a href="{{ route('adminpages.regions.create') }}" class="btn btn-primary btn-lg shadow-sm">
                        Add New Region
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
                <form method="GET" action="{{ route('adminpages.regions.index') }}" id="filterForm">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="searchInput" class="form-label">Search</label>
                            <input type="text" class="form-control" id="searchInput" name="search" 
                                   placeholder="Search regions..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="countryFilter" class="form-label">Filter by Country</label>
                            <select class="form-select" id="countryFilter" name="country_id" onchange="document.getElementById('filterForm').submit()">
                                <option value="">All Countries</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}" {{ request('country_id') == $country->id ? 'selected' : '' }}>
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2">Filter</button>
                            <a href="{{ route('adminpages.regions.index') }}" class="btn btn-outline-secondary">Clear</a>
                        </div>
                    </div>
                </form>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <span class="badge bg-primary fs-6">
                            Total: {{ $regions->total() }} regions
                        </span>
                        @if(request()->hasAny(['country_id', 'search']))
                            <span class="badge bg-info fs-6 ms-2">
                                Filtered results
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Regions Table Card -->
        <div class="card shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="card-title mb-0">
                    Regions List
                </h5>
            </div>
            <div class="card-body p-0">
                @if($regions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="regionsTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 py-3 px-4">Region Name</th>
                                    <th class="border-0 py-3 px-4">Country</th>
                                    <th class="border-0 py-3 px-4">Created By</th>
                                    <th class="border-0 py-3 px-4">Created Date</th>
                                    <th class="border-0 py-3 px-4 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($regions as $region)
                                    <tr class="align-middle">
                                        <td class="px-4 py-3">
                                            <div>
                                                <h6 class="mb-0 fw-semibold">{{ $region->name }}</h6>
                                                <small class="text-muted">Region</small>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="fw-medium text-primary">{{ $region->country->name ?? 'N/A' }}</span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-info">
                                                {{ $region->createdby ?? 'System' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-light text-dark">
                                                {{ $region->created_at->format('M d, Y') }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('adminpages.regions.edit', $region) }}" 
                                                   class="btn btn-outline-primary btn-sm" 
                                                   title="Edit Region">
                                                    Edit
                                                </a>
                                                <form action="{{ route('adminpages.regions.destroy', $region) }}" 
                                                      method="POST" 
                                                      class="d-inline" 
                                                      onsubmit="return confirm('Are you sure you want to delete this region? This action cannot be undone.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-outline-danger btn-sm" 
                                                            title="Delete Region">
                                                        Delete
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
                        <div class="mb-4">
                            <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                <span class="text-muted fs-1">🗺️</span>
                            </div>
                        </div>
                        <h5 class="text-muted">No Regions Found</h5>
                        <p class="text-muted">Get started by adding your first region.</p>
                        <a href="{{ route('adminpages.regions.create') }}" class="btn btn-primary">
                            Add First Region
                        </a>
                    </div>
                @endif
            </div>
            
            @if($regions->hasPages())
                <div class="card-footer bg-white border-top">
                    <div class="d-flex flex-column align-items-center">
                        <div class="mb-3">
                            {{ $regions->appends(request()->query())->links('adminpages.layouts.partials.pagination') }}
                        </div>
                        <div class="text-center">
                            <small class="text-muted">
                                Showing {{ $regions->firstItem() }} to {{ $regions->lastItem() }} of {{ $regions->total() }} results
                            </small>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Enhanced Search Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const table = document.getElementById('regionsTable');
            
            if (table) {
                const rows = table.getElementsByTagName('tr');

                searchInput.addEventListener('keyup', function() {
                    const filter = this.value.toLowerCase();
                    
                    for (let i = 1; i < rows.length; i++) {
                        const regionName = rows[i].getElementsByTagName('td')[0]?.textContent.toLowerCase() || '';
                        const countryName = rows[i].getElementsByTagName('td')[1]?.textContent.toLowerCase() || '';
                        const createdBy = rows[i].getElementsByTagName('td')[2]?.textContent.toLowerCase() || '';
                        
                        if (regionName.includes(filter) || countryName.includes(filter) || createdBy.includes(filter)) {
                            rows[i].style.display = '';
                        } else {
                            rows[i].style.display = 'none';
                        }
                    }
                });
            }
        });
    </script>
    
 @endsection
