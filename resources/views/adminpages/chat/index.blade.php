@extends('adminpages.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Guest Chats</h2>
            <p class="text-muted mb-0">Monitor conversations across every motel and see who responded.</p>
        </div>
        <div class="card border-0 shadow-sm">
            <div class="card-body py-2 px-3">
                <div class="small text-muted">Total chats</div>
                <div class="fw-semibold">{{ number_format($chats->total()) }}</div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row gy-3 gx-3 align-items-end">
                <div class="col-md-3">
                    <label for="motel_id" class="form-label fw-semibold">Motel</label>
                    <select name="motel_id" id="motel_id" class="form-select">
                        <option value="">All motels</option>
                        @foreach ($availableMotels as $motel)
                            <option value="{{ $motel->id }}" {{ (string) $selectedMotelId === (string) $motel->id ? 'selected' : '' }}>
                                {{ $motel->name }}
                                @if ($motel->owner && $motel->owner->username)
                                    ({{ $motel->owner->username }})
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label fw-semibold">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">Any status</option>
                        <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="closed" {{ $status === 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="search" class="form-label fw-semibold">Guest search</label>
                    <input
                        type="text"
                        name="search"
                        id="search"
                        value="{{ $search }}"
                        class="form-control"
                        placeholder="Name or email"
                    >
                </div>
                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-search me-1"></i> Filter
                    </button>
                    <a href="{{ route('adminpages.chats.index') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Guest</th>
                            <th scope="col">Motel</th>
                            <th scope="col">Booking</th>
                            <th scope="col">Last message</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($chatViewModels as $chat)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $chat['customer']->username ?? 'Guest' }}</div>
                                    <div class="text-muted small">{{ $chat['customer']->useremail ?? 'No email' }}</div>
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $chat['motel']->name ?? 'Unknown motel' }}</div>
                                    @if ($chat['motel']->owner)
                                        <div class="text-muted small">Owner • {{ $chat['motel']->owner->username ?? 'N/A' }}</div>
                                    @endif
                                </td>
                                <td>
                                    @if ($chat['booking'])
                                        <div class="text-muted small">
                                            {{ $chat['booking']['check_in_date'] ?? '-' }} → {{ $chat['booking']['check_out_date'] ?? '-' }}
                                        </div>
                                        <span class="badge bg-light text-muted border">
                                            {{ strtoupper($chat['booking']['status'] ?? 'N/A') }}
                                        </span>
                                    @else
                                        <span class="text-muted small">No booking linked</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($chat['last_message'])
                                        <div class="small text-truncate" style="max-width: 320px;">
                                            {{ $chat['last_message']['sender_name'] ?? ($chat['last_message']['sender_type'] === 'customer' ? 'Guest' : 'Staff') }}:
                                            {{ $chat['last_message']['message'] }}
                                        </div>
                                        <div class="text-muted small">
                                            {{ optional($chat['last_message']['created_at'])->timezone(config('app.timezone'))->format('M d, Y • H:i') }}
                                        </div>
                                    @else
                                        <span class="text-muted small">No messages yet</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="text-muted small">
                                        {{ optional($chat['updated_at'])->timezone(config('app.timezone'))->diffForHumans() }}
                                    </div>
                                    <span class="badge {{ $chat['status'] === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ strtoupper($chat['status']) }}
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('adminpages.chats.show', $chat['id']) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bx bx-message-rounded-detail me-1"></i> View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    No conversations found for the selected filters.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($chats->hasPages())
            <div class="card-footer">
                {{ $chats->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endsection




