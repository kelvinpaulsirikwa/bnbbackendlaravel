@extends('adminpages.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-3">
        <a href="{{ route('adminpages.chats.index') }}" class="btn btn-link px-0">
            <i class="bx bx-chevron-left"></i> Back to guest chats
        </a>
    </div>

    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">{{ $chat->customer->username ?? 'Guest' }}</h3>
            <div class="text-muted">
                Motel: {{ $chat->motel->name ?? 'N/A' }}
                @if ($chat->motel && $chat->motel->owner)
                    • Owner: {{ $chat->motel->owner->username ?? 'N/A' }}
                @endif
                @if ($chat->booking)
                    • Booking {{ $chat->booking->check_in_date?->format('Y-m-d') ?? '-' }} → {{ $chat->booking->check_out_date?->format('Y-m-d') ?? '-' }}
                @endif
            </div>
            <div class="text-muted small">
                Chat status:
                <span class="badge {{ $chat->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                    {{ strtoupper($chat->status) }}
                </span>
            </div>
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

    <div class="card mb-4">
        <div class="card-body" style="max-height: 520px; overflow-y: auto;">
            @forelse ($messages as $message)
                @php
                    $isCustomer = $message->sender_type === 'customer';
                    $bubbleClasses = $isCustomer ? 'bg-light text-dark' : 'bg-primary text-white';
                    $timestampClasses = $isCustomer ? 'text-muted' : 'text-white-50';
                    $senderName = $isCustomer
                        ? ($chat->customer->username ?? 'Guest')
                        : ($message->sender?->username ?? 'Staff');
                @endphp
                <div class="d-flex {{ $isCustomer ? 'justify-content-start' : 'justify-content-end' }} mb-3">
                    <div class="p-3 rounded-4 shadow-sm {{ $bubbleClasses }}" style="max-width: 70%;">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="small fw-semibold">{{ $senderName }}</div>
                            <span class="badge bg-light text-muted border">
                                {{ strtoupper($message->sender_type === 'customer' ? 'Guest' : 'Staff') }}
                            </span>
                        </div>
                        <div class="mb-2" style="white-space: pre-wrap;">{{ $message->message }}</div>
                        <div class="small {{ $timestampClasses }}">
                            {{ $message->created_at?->timezone(config('app.timezone'))->format('M d, Y • H:i') }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-muted py-4">
                    No messages yet. Use the composer below to start the conversation.
                </div>
            @endforelse
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('adminpages.chats.send', $chat->id) }}">
                @csrf
                <div class="mb-3">
                    <label for="message" class="form-label fw-semibold">Send a message</label>
                    <textarea
                        name="message"
                        id="message"
                        class="form-control"
                        rows="3"
                        placeholder="Type your reply..."
                    >{{ old('message') }}</textarea>
                    @error('message')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">Messages appear instantly in the guest mobile app.</small>
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-send"></i> Send message
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection



