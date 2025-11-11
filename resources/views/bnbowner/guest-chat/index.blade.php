@extends('layouts.owner')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-4">
        <div>
            <h2 class="fw-bold mb-1">Guest Chats</h2>
            <p class="text-muted mb-0">Review conversations and respond to guests staying at your motels.</p>
        </div>
        @if($selectedMotel)
            <div class="card border-0 shadow-sm">
                <div class="card-body py-2 px-3">
                    <div class="small text-muted">Currently viewing</div>
                    <div class="fw-semibold">{{ $selectedMotel->name }}</div>
                </div>
            </div>
        @endif
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

    

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Guest</th>
                             <th scope="col">Booking</th>
                            <th scope="col">Last message</th>
                            <th scope="col">Updated</th>
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
                                    @if ($chat['booking'])
                                        <div class="text-muted small">
                                            {{ $chat['booking']['check_in_date'] ?? '-' }} → {{ $chat['booking']['check_out_date'] ?? '-' }}
                                        </div>
                                        <span class="badge bg-light text-muted border">{{ strtoupper($chat['booking']['status'] ?? 'N/A') }}</span>
                                    @else
                                        <span class="text-muted small">No booking linked</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($chat['last_message'])
                                        <div class="small text-truncate" style="max-width: 280px;">
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
                                    <a href="{{ route('bnbowner.chats.show', $chat['id']) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bx bx-message-rounded-detail me-1"></i> Open chat
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

