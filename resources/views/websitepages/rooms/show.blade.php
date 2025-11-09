@extends('websitepages.layouts.app')

@section('title', ($room->roomType->name ?? 'Room').' | '.$motel->name)
@section('meta_description', \Illuminate\Support\Str::limit('Explore '.$motel->name.' - '.($room->roomType->name ?? 'Room').' with curated amenities and bespoke comforts.', 150))

@push('styles')
    <style>
        .room-hero {
            position: relative;
            border-radius: 28px;
            overflow: hidden;
            max-width: 1100px;
            margin: 4rem auto 3rem;
            min-height: 380px;
            display: grid;
            align-items: end;
            color: #ffffff;
            box-shadow: 0 28px 52px rgba(10, 23, 55, 0.32);
        }

        .room-hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(11, 17, 30, 0.1) 20%, rgba(11, 17, 30, 0.78) 100%);
        }

        .room-hero img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .room-hero-body {
            position: relative;
            padding: 2.3rem 2.8rem;
            display: grid;
            gap: 0.7rem;
        }

        .room-hero h1 {
            margin: 0;
            font-size: clamp(2.2rem, 4vw, 3rem);
        }

        .room-hero p {
            margin: 0;
            max-width: 540px;
            color: rgba(255, 255, 255, 0.85);
            line-height: 1.7;
        }

        .room-info {
            max-width: 1100px;
            margin: 0 auto 3rem;
            display: grid;
            gap: 2rem;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        }

        .room-info-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 1.8rem;
            box-shadow: 0 18px 36px rgba(19, 38, 74, 0.12);
            display: grid;
            gap: 0.7rem;
        }

        .room-info-card h3 {
            margin: 0;
            font-size: 1.15rem;
            color: var(--text-dark);
        }

        .room-info-list {
            display: grid;
            gap: 0.4rem;
            color: var(--text-muted);
        }

        .room-price {
            font-size: 1.4rem;
            font-weight: 700;
            color: #b2560d;
        }

        .room-price span {
            font-size: 0.9rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .room-gallery {
            max-width: 1100px;
            margin: 0 auto 3rem;
        }

        .room-gallery-grid {
            display: grid;
            gap: 1rem;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        }

        .room-gallery-grid img {
            border-radius: 18px;
            width: 100%;
            height: 220px;
            object-fit: cover;
            box-shadow: 0 18px 32px rgba(19, 34, 66, 0.12);
        }

        .room-items {
            max-width: 1100px;
            margin: 0 auto 4rem;
        }

        .room-items-grid {
            display: grid;
            gap: 1rem;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        }

        .room-item-card {
            background: #ffffff;
            border-radius: 18px;
            padding: 1.6rem;
            box-shadow: 0 16px 32px rgba(20, 38, 74, 0.12);
            display: grid;
            gap: 0.6rem;
        }

        .room-item-card strong {
            color: var(--text-dark);
        }

        .motels-empty {
            max-width: 640px;
            margin: 2.5rem auto 0;
            background: #ffffff;
            border-radius: 24px;
            padding: 3rem;
            text-align: center;
            box-shadow: 0 20px 42px rgba(17, 31, 60, 0.12);
        }

        .section-heading {
            font-size: clamp(1.9rem, 3vw, 2.3rem);
            margin-bottom: 0.75rem;
            text-align: center;
        }

        .section-subheading {
            color: var(--text-muted);
            text-align: center;
            margin-bottom: 2rem;
            line-height: 1.7;
        }
    </style>
@endpush

@section('content')
    <section class="room-hero">
        <img src="{{ $primaryImage }}" alt="{{ $room->roomType->name ?? 'Guest room' }}">
        <div class="room-hero-body">
            <span class="badge" style="width: fit-content;">{{ $motel->name }}</span>
            <h1>{{ $room->roomType->name ?? 'Guest Room' }}</h1>
            <p>
                Designed for restorative stays with curated amenities and thoughtful details. Enjoy personalised hospitality courtesy of {{ $motel->name }}.
            </p>
        </div>
    </section>

    <section class="room-info">
        <article class="room-info-card">
            <h3>Room overview</h3>
            <div class="room-info-list">
                <span><strong>Room number:</strong> {{ $room->room_number ?? '—' }}</span>
                <span><strong>Status:</strong> {{ $room->status ?? 'Available' }}</span>
                <span><strong>Type:</strong> {{ $room->roomType->name ?? 'Not specified' }}</span>
            </div>
        </article>
        <article class="room-info-card">
            <h3>Nightly rate</h3>
            <div class="room-price">
                @if($room->price_per_night)
                    ${{ number_format($room->price_per_night, 0) }} <span>/night</span>
                @else
                    <span style="color: var(--text-muted); font-weight:500;">Contact for rates</span>
                @endif
            </div>
            @if($room->office_price_per_night)
                <div style="color: var(--text-muted); font-size: 0.95rem;">
                    Office rate: ${{ number_format($room->office_price_per_night, 0) }} /night
                </div>
            @endif
        </article>
        <article class="room-info-card">
            <h3>Concierge support</h3>
            <div class="room-info-list">
                <span><strong>Phone:</strong> {{ optional($motel->details)->contact_phone ?? 'Not provided' }}</span>
                <span><strong>Email:</strong> {{ optional($motel->details)->contact_email ?? 'Not provided' }}</span>
            </div>
        </article>
    </section>

    @if($gallery->isNotEmpty())
        <section class="room-gallery">
            <h2 class="section-heading">Gallery</h2>
            <p class="section-subheading">A closer look at the space, ambience, and curated touches awaiting your stay.</p>
            <div class="room-gallery-grid">
                @foreach($gallery as $image)
                    <img src="{{ $image }}" alt="{{ $room->roomType->name ?? 'Room' }} image">
                @endforeach
            </div>
        </section>
    @endif

    <section class="room-items">
        <h2 class="section-heading">In-room amenities</h2>
        <p class="section-subheading">All the thoughtful details and inclusions crafted to elevate your time at {{ $motel->name }}.</p>
        @if($items->count())
            <div class="room-items-grid">
                @foreach($items as $item)
                    <article class="room-item-card">
                        <strong>{{ $item['name'] }}</strong>
                        @if(!empty($item['description']))
                            <p style="margin: 0; color: var(--text-muted); line-height: 1.6;">{{ $item['description'] }}</p>
                        @endif
                    </article>
                @endforeach
            </div>
        @else
            <div class="motels-empty">
                <h2 style="margin-bottom: 1rem;">Amenities coming soon</h2>
                <p style="color: var(--text-muted); line-height: 1.7;">
                    We’re finalising the in-room experience. Reach out to our concierge for bespoke recommendations and availability.
                </p>
            </div>
        @endif
    </section>
@endsection

