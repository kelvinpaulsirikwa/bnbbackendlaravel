@extends('adminpages.layouts.app')

@section('content')
    <div class="container-fluid py-4" style="background-color: white; min-height: 100vh;">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h3 mb-0 text-gray-800">Message from {{ $message->name }}</h1>
                        <p class="text-muted mb-0">Received on {{ $message->created_at->format('M d, Y \\a\\t H:i') }}</p>
                    </div>
                    <div>
                        <a href="{{ route('adminpages.contact-messages.index') }}" class="btn btn-outline-secondary me-2">
                            <i class="bx bx-arrow-back"></i> Back to messages
                        </a>
                        <form action="{{ route('adminpages.contact-messages.destroy', $message) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this message?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="bx bx-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Contact details</h5>
                        <div class="d-flex align-items-start mb-3">
                            <div class="me-3">
                                <i class="bx bx-user-circle fs-3 text-primary"></i>
                            </div>
                            <div>
                                <div class="fw-semibold">{{ $message->name }}</div>
                                <div class="text-muted small">Guest</div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="text-muted small">Email</div>
                            <a href="mailto:{{ $message->email }}" class="fw-semibold">{{ $message->email }}</a>
                        </div>
                        <div class="mb-3">
                            <div class="text-muted small">Phone</div>
                            <div class="fw-semibold">{{ $message->phone ?: 'Not provided' }}</div>
                        </div>
                        <div>
                            <div class="text-muted small">Status</div>
                            @if($message->read_at)
                                <span class="badge bg-success-subtle text-success">Read</span>
                                <div class="text-muted small mt-1">Read on {{ $message->read_at->format('M d, Y H:i') }}</div>
                            @else
                                <span class="badge bg-warning-subtle text-warning">Unread</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Message</h5>
                        <div class="bg-light rounded-3 p-3" style="min-height: 240px;">
                            <p class="mb-0" style="white-space: pre-line;">{{ $message->message }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

