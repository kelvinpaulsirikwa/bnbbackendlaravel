@extends('adminpages.layouts.app')

@section('content')
    <div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">
                            Contact Messages
                        </h1>
                        <p class="text-muted mb-0">Review enquiries sent from the website contact section.</p>
                    </div>
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
                <form method="GET" action="{{ route('adminpages.contact-messages.index') }}">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="searchInput" class="form-label">Search</label>
                            <input type="text" id="searchInput" class="form-control" name="search" placeholder="Search by name, email, phone, or message..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="statusFilter" class="form-label">Status</label>
                            <select id="statusFilter" class="form-select" name="status">
                                <option value="">All</option>
                                <option value="unread" @selected(request('status') === 'unread')>Unread</option>
                                <option value="read" @selected(request('status') === 'read')>Read</option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-outline-primary me-2">
                                <i class="bx bx-search"></i> Filter
                            </button>
                            <a href="{{ route('adminpages.contact-messages.index') }}" class="btn btn-outline-secondary">
                                <i class="bx bx-refresh"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="card-title mb-0">
                    <i class="bx bx-envelope me-2"></i>
                    Messages
                    <span class="badge bg-primary ms-2">{{ $messages->total() }} total</span>
                </h5>
            </div>
            <div class="card-body p-0">
                @if($messages->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Received</th>
                                    <th>Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($messages as $message)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold">{{ $message->name }}</div>
                                        </td>
                                        <td>
                                            <a href="mailto:{{ $message->email }}">{{ $message->email }}</a>
                                        </td>
                                        <td>
                                            {{ $message->phone ?: '—' }}
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ $message->created_at->format('M d, Y H:i') }}</span>
                                        </td>
                                        <td>
                                            @if($message->read_at)
                                                <span class="badge bg-success-subtle text-success">Read</span>
                                            @else
                                                <span class="badge bg-warning-subtle text-warning">Unread</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('adminpages.contact-messages.show', $message) }}" class="btn btn-sm btn-outline-info" title="View">
                                                    <i class="bx bx-show"></i>
                                                </a>
                                                <form action="{{ route('adminpages.contact-messages.destroy', $message) }}" method="POST" onsubmit="return confirm('Delete this message?');">
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
                            <i class="bx bx-envelope-open display-1 text-muted"></i>
                        </div>
                        <h5 class="text-muted">No messages yet</h5>
                        <p class="text-muted mb-0">Once guests reach out through the website, you will see their details here.</p>
                    </div>
                @endif
            </div>
            @if($messages->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Showing {{ $messages->firstItem() }} to {{ $messages->lastItem() }} of {{ $messages->total() }} results
                        </div>
                        <div>
                            {{ $messages->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

