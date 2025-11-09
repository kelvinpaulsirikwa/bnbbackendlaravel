@extends('adminpages.layouts.app')

@section('content')
     
    <div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">
                            Districts Management
                        </h1>
                        <p class="text-muted mb-0">Manage districts within regions and countries</p>
                    </div>
                    <a href="{{ route('adminpages.districts.create') }}" class="btn btn-primary btn-lg shadow-sm">
                        Add New District
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
                <form method="GET" action="{{ route('adminpages.districts.index') }}" id="filterForm">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="searchInput" class="form-label">Search</label>
                            <input type="text" class="form-control" id="searchInput" name="search" 
                                   placeholder="Search districts..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
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
                        <div class="col-md-3">
                            <label for="regionFilter" class="form-label">Filter by Region</label>
                            <select class="form-select" id="regionFilter" name="region_id" onchange="document.getElementById('filterForm').submit()">
                                <option value="">All Regions</option>
                                @foreach($regions as $region)
                                    <option value="{{ $region->id }}" {{ request('region_id') == $region->id ? 'selected' : '' }}>
                                        {{ $region->name }} ({{ $region->country->name }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2">Filter</button>
                            <a href="{{ route('adminpages.districts.index') }}" class="btn btn-outline-secondary">Clear</a>
                        </div>
                    </div>
                </form>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <span class="badge bg-primary fs-6">
                            Total: {{ $districts->total() }} districts
                        </span>
                        @if(request()->hasAny(['country_id', 'region_id', 'search']))
                            <span class="badge bg-info fs-6 ms-2">
                                Filtered results
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Districts Table Card -->
        <div class="card shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="card-title mb-0">
                    Districts List
                </h5>
            </div>
            <div class="card-body p-0">
                @if($districts->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="districtsTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 py-3 px-4">District Name</th>
                                    <th class="border-0 py-3 px-4">Region</th>
                                    <th class="border-0 py-3 px-4">Country</th>
                                    <th class="border-0 py-3 px-4">Created By</th>
                                    <th class="border-0 py-3 px-4">Created Date</th>
                                    <th class="border-0 py-3 px-4 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($districts as $district)
                                    <tr class="align-middle">
                                        <td class="px-4 py-3">
                                            <div>
                                                <h6 class="mb-0 fw-semibold">{{ $district->name }}</h6>
                                                <small class="text-muted">District</small>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="fw-medium">{{ $district->region->name ?? 'N/A' }}</span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="fw-medium text-primary">{{ $district->region->country->name ?? 'N/A' }}</span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-info">
                                                {{ $district->createdby ?? 'System' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="badge bg-light text-dark">
                                                {{ $district->created_at->format('M d, Y') }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('adminpages.districts.edit', $district) }}" 
                                                   class="btn btn-outline-primary btn-sm" 
                                                   title="Edit District">
                                                    Edit
                                                </a>
                                                <form action="{{ route('adminpages.districts.destroy', $district) }}" 
                                                      method="POST" 
                                                      class="d-inline" 
                                                      onsubmit="return confirm('Are you sure you want to delete this district? This action cannot be undone.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-outline-danger btn-sm" 
                                                            title="Delete District">
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
                                <span class="text-muted fs-1">📁</span>
                            </div>
                        </div>
                        <h5 class="text-muted">No Districts Found</h5>
                        <p class="text-muted">Get started by adding your first district.</p>
                        <a href="{{ route('adminpages.districts.create') }}" class="btn btn-primary">
                            Add First District
                        </a>
                    </div>
                @endif
            </div>
            
            @if($districts->hasPages())
                <div class="card-footer bg-white border-top">
                    <div class="d-flex flex-column align-items-center">
                        <div class="mb-3">
                            {{ $districts->appends(request()->query())->links('adminpages.layouts.partials.pagination') }}
                        </div>
                        <div class="text-center">
                            <small class="text-muted">
                                Showing {{ $districts->firstItem() }} to {{ $districts->lastItem() }} of {{ $districts->total() }} results
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
            const table = document.getElementById('districtsTable');
            
            if (table) {
                const rows = table.getElementsByTagName('tr');

                searchInput.addEventListener('keyup', function() {
                    const filter = this.value.toLowerCase();
                    
                    for (let i = 1; i < rows.length; i++) {
                        const districtName = rows[i].getElementsByTagName('td')[0]?.textContent.toLowerCase() || '';
                        const regionName = rows[i].getElementsByTagName('td')[1]?.textContent.toLowerCase() || '';
                        const countryName = rows[i].getElementsByTagName('td')[2]?.textContent.toLowerCase() || '';
                        const createdBy = rows[i].getElementsByTagName('td')[3]?.textContent.toLowerCase() || '';
                        
                        if (districtName.includes(filter) || regionName.includes(filter) || 
                            countryName.includes(filter) || createdBy.includes(filter)) {
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
