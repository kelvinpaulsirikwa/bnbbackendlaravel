@extends('adminpages.layouts.app')

@section('content')
<div class="container-fluid py-4" style="background-color: #f8f9fa; min-height: 100vh;">
    <!-- Breadcrumb & Header -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2">
                    <li class="breadcrumb-item"><a href="{{ route('adminpages.motels.index') }}">Motels</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('adminpages.motels.show', $motel->id) }}">{{ $motel->name }}</a></li>
                    <li class="breadcrumb-item active">Room {{ $room->room_number }}</li>
                </ol>
            </nav>
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h1 class="h3 mb-1">Room {{ $room->room_number }}</h1>
                    <p class="text-muted mb-0">View-only — room details, items, images & bookings</p>
                </div>
                <a href="{{ route('adminpages.motels.show', $motel->id) }}" class="btn btn-outline-secondary">
                    <i class="bx bx-arrow-back me-1"></i> Back to motel
                </a>
            </div>
        </div>
    </div>

    <!-- Room summary card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0"><i class="bx bx-bed me-2"></i>Room information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3 col-6">
                            <span class="text-muted small d-block">Room number</span>
                            <span class="fw-semibold">{{ $room->room_number }}</span>
                        </div>
                        <div class="col-md-3 col-6">
                            <span class="text-muted small d-block">Type</span>
                            <span class="fw-semibold">{{ $room->roomType->name ?? '—' }}</span>
                        </div>
                        <div class="col-md-3 col-6">
                            <span class="text-muted small d-block">Price per night</span>
                            <span class="fw-semibold">{{ $room->price_per_night ? number_format($room->price_per_night) . ' ' . (config('app.currency', 'USD')) : '—' }}</span>
                        </div>
                        <div class="col-md-3 col-6">
                            <span class="text-muted small d-block">Status</span>
                            @php
                                $statusClass = ($room->status ?? ($room->is_active ? 'active' : 'inactive')) === 'active' ? 'bg-success' : 'bg-warning text-dark';
                            @endphp
                            <span class="badge {{ $statusClass }}">{{ ucfirst($room->status ?? ($room->is_active ? 'Active' : 'Inactive')) }}</span>
                        </div>
                        @if($room->description)
                            <div class="col-12 pt-2 border-top">
                                <span class="text-muted small d-block">Description</span>
                                <p class="mb-0 fw-semibold">{{ $room->description }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Room items (paginated) -->
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h5 class="mb-0"><i class="bx bx-list-ul me-2"></i>Room items</h5>
                    <span class="badge bg-primary">{{ $roomItems->total() }} total</span>
                </div>
                <div class="card-body p-0">
                    @if($roomItems->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($roomItems as $item)
                                        <tr>
                                            <td class="fw-semibold">{{ $item->name }}</td>
                                            <td class="text-muted">{{ $item->description ?: '—' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="p-3 border-top">
                            {{ $roomItems->withQueryString()->links() }}
                        </div>
                    @else
                        <div class="p-4 text-center text-muted">
                            <i class="bx bx-package fa-3x mb-2"></i>
                            <p class="mb-0">No items for this room.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Room images (paginated) -->
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h5 class="mb-0"><i class="bx bx-images me-2"></i>Room images</h5>
                    <span class="badge bg-primary">{{ $roomImages->total() }} total</span>
                </div>
                <div class="card-body">
                    @if($roomImages->count() > 0)
                        <div class="row g-3">
                            @foreach($roomImages as $img)
                                <div class="col-6 col-md-4 col-lg-3">
                                    <div class="border rounded overflow-hidden bg-light text-center p-2">
                                        @php
                                            $imgSrc = $img->imagepath ? (str_starts_with($img->imagepath, 'http') ? $img->imagepath : asset('storage/' . ltrim($img->imagepath, '/'))) : asset('images/static_file/nodp.png');
                                        @endphp
                                        <img src="{{ $imgSrc }}" alt="Room image" class="img-fluid rounded" style="max-height: 160px; object-fit: cover; width: 100%;" onerror="this.src='{{ asset('images/static_file/nodp.png') }}'">
                                        @if($img->description)
                                            <p class="small text-muted mb-0 mt-1">{{ Str::limit($img->description, 40) }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-3 pt-3 border-top">
                            {{ $roomImages->withQueryString()->links() }}
                        </div>
                    @else
                        <div class="p-4 text-center text-muted">
                            <i class="bx bx-image fa-3x mb-2"></i>
                            <p class="mb-0">No images for this room.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Bookings (paginated) -->
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h5 class="mb-0"><i class="bx bx-calendar-check me-2"></i>Bookings (recent)</h5>
                    <span class="badge bg-primary">{{ $bookings->total() }} total</span>
                </div>
                <div class="card-body p-0">
                    @if($bookings->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Guest</th>
                                        <th>Check-in</th>
                                        <th>Check-out</th>
                                        <th>Nights</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $booking)
                                        <tr>
                                            <td>
                                                <span class="fw-semibold">{{ $booking->customer->username ?? $booking->customer->useremail ?? 'N/A' }}</span>
                                                @if($booking->contact_number)
                                                    <br><small class="text-muted">{{ $booking->contact_number }}</small>
                                                @endif
                                            </td>
                                            <td>{{ $booking->check_in_date->format('M d, Y') }}</td>
                                            <td>{{ $booking->check_out_date->format('M d, Y') }}</td>
                                            <td>{{ $booking->number_of_nights ?? '—' }}</td>
                                            <td>{{ $booking->total_amount ? number_format($booking->total_amount, 0) . ' ' . (config('app.currency', 'USD')) : '—' }}</td>
                                            <td><span class="badge bg-secondary">{{ ucfirst($booking->status ?? '—') }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="p-3 border-top">
                            {{ $bookings->withQueryString()->links() }}
                        </div>
                    @else
                        <div class="p-4 text-center text-muted">
                            <i class="bx bx-calendar-x fa-3x mb-2"></i>
                            <p class="mb-0">No bookings for this room yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
