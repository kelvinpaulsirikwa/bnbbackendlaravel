@extends('adminpages.layouts.app')

@section('content')
    <div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">Terms of Service</h1>
                        <p class="text-muted mb-0">Manage system terms of service</p>
                    </div>
                    <a href="{{ route('adminpages.terms-of-service.create') }}" class="btn btn-primary btn-lg shadow-sm">
                        <i class="bx bx-plus"></i> Add New
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('adminpages.terms-of-service.index') }}">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="search" class="form-label">Search</label>
                            <input type="text" class="form-control" id="search" name="search"
                                   placeholder="Search by title or content..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-6 d-flex align-items-end">
                            <button type="submit" class="btn btn-outline-primary me-2">
                                <i class="bx bx-search"></i> Search
                            </button>
                            <a href="{{ route('adminpages.terms-of-service.index') }}" class="btn btn-outline-secondary">Clear</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="card-title mb-0">
                    <i class="bx bx-list-ul me-2"></i>
                    Terms of Service List
                    <span class="badge bg-primary ms-2">{{ $terms->total() }} Total</span>
                </h5>
            </div>
            <div class="card-body p-0">
                @if($terms->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Content Preview</th>
                                    <th>Created By</th>
                                    <th>Active</th>
                                    <th>Updated</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($terms as $term)
                                    <tr>
                                        <td class="align-middle"><span class="badge bg-light text-dark">#{{ $term->id }}</span></td>
                                        <td class="align-middle fw-semibold">{{ $term->title }}</td>
                                        <td class="align-middle text-muted">{{ Str::limit(strip_tags($term->content), 80) }}</td>
                                        <td class="align-middle">
                                            @if($term->creator)
                                                <span class="text-muted">{{ $term->creator->username }}</span>
                                                @if($term->creator->useremail)
                                                    <br><small class="text-muted">{{ $term->creator->useremail }}</small>
                                                @endif
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            @if($term->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="align-middle text-muted small">{{ $term->updated_at->format('M d, Y') }}</td>
                                        <td class="align-middle text-center">
                                            <div class="btn-group">
                                                <a href="{{ route('adminpages.terms-of-service.show', $term->id) }}" class="btn btn-sm btn-outline-info" title="View"><i class="bx bx-show"></i></a>
                                                <a href="{{ route('adminpages.terms-of-service.edit', $term->id) }}" class="btn btn-sm btn-outline-warning" title="Edit"><i class="bx bx-edit"></i></a>
                                                <form action="{{ route('adminpages.terms-of-service.destroy', $term->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this Terms of Service?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="bx bx-trash"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($terms->hasPages())
                        <div class="card-footer bg-white border-0 py-3">
                            {{ $terms->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <i class="bx bx-file fs-1 text-muted"></i>
                        <p class="text-muted mt-3 mb-0">No terms of service yet.</p>
                        <a href="{{ route('adminpages.terms-of-service.create') }}" class="btn btn-primary mt-2"><i class="bx bx-plus"></i> Add Terms of Service</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
