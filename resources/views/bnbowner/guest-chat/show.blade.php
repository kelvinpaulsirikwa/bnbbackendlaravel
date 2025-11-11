@extends('layouts.owner')
    
@section('content')
<div class="container-fluid py-4">
<div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-4">
        <div>
            <h2 class="fw-bold mb-1"> All Guest Chats</h2>
            <a href="{{ route('bnbowner.chats.index') }}" class="btn btn-link px-0">
            <i class="bx bx-chevron-left"></i> Back to chats
        </a>        </div>
       
            <div class="card border-0 shadow-sm">
                <div class="card-body py-2 px-3">
                    <div class="small text-muted">Currently viewing</div>
                    <div class="fw-semibold">Chat</div>
                </div>
            </div>
       
    </div>
   
    </div>

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">{{ $chat->customer->username ?? 'Guest' }}</h3>
            <div class="text-muted">
                Motel: {{ $chat->motel->name ?? 'N/A' }}
                @if ($chat->booking)
                    • Booking {{ $chat->booking->check_in_date?->format('Y-m-d') ?? '-' }} → {{ $chat->booking->check_out_date?->format('Y-m-d') ?? '-' }}
                @endif
            </div>
            <div class="text-muted small">Chat status: <span class="badge {{ $chat->status === 'active' ? 'bg-success' : 'bg-secondary' }}">{{ strtoupper($chat->status) }}</span></div>
        </div>
        <div class="text-end">
            <div class="text-muted small">Created: {{ $chat->created_at?->format('M d, Y H:i') }}</div>
            <div class="text-muted small">Last updated: {{ $chat->updated_at?->diffForHumans() }}</div>
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

    @if (!$canSend && $sendRestriction)
        <div class="alert alert-warning" role="alert">
            {{ $sendRestriction }}
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body" style="max-height: 520px; overflow-y: auto;">
            @forelse ($messages as $message)
                @php
                    $isCustomer = $message->sender_type === 'customer';
                    $bubbleClasses = $isCustomer ? 'bg-light text-dark' : 'bg-success text-white';
                    $timestampClasses = $isCustomer ? 'text-muted' : 'text-white-50';
                    $senderName = $isCustomer
                        ? ($chat->customer->username ?? 'Guest')
                        : ($message->sender?->username ?? 'Staff');
                    if (!$isCustomer && $message->sender_id === auth()->id()) {
                        $senderName = 'You';
                    }
                @endphp
                <div class="d-flex {{ $isCustomer ? 'justify-content-start' : 'justify-content-end' }} mb-3">
                    <div class="p-3 rounded-4 shadow-sm {{ $bubbleClasses }}" style="max-width: 70%;">
                        <div class="small fw-semibold mb-2">{{ $senderName }}</div>
                        <div class="mb-2" style="white-space: pre-wrap;">{{ $message->message }}</div>
                        <div class="small {{ $timestampClasses }}">
                            {{ $message->created_at?->timezone(config('app.timezone'))->format('M d, Y • H:i') }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-muted py-4">
                    No messages yet. Start the conversation by sending a reply below.
                </div>
            @endforelse
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('bnbowner.chats.send', $chat->id) }}">
                @csrf
                <div class="mb-3">
                    <label for="message" class="form-label fw-semibold">Your reply</label>
                    <textarea name="message" id="message" class="form-control" rows="3" placeholder="Type your message here..." {{ $canSend ? '' : 'disabled' }}>{{ old('message') }}</textarea>
                    @error('message')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">Guests will see your response instantly inside the mobile app.</small>
                    <button type="submit" class="btn btn-primary" {{ $canSend ? '' : 'disabled' }}>
                        <i class="bx bx-send"></i> Send message
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

