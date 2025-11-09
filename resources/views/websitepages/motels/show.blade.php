@extends('websitepages.layouts.app')

@section('title', $motel->name.' | bnbStay Motel')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($motel->description ?? 'Discover bespoke stays with bnbStay.'), 150))

@push('styles')
    <style>
        .motel-hero {
            position: relative;
            border-radius: 28px;
            overflow: hidden;
            max-width: 1240px;
            margin: 4rem auto 3rem;
            min-height: 420px;
            display: grid;
            align-items: end;
            color: #ffffff;
            box-shadow: 0 32px 60px rgba(10, 23, 55, 0.35);
        }

        .motel-hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(11, 17, 30, 0.1) 20%, rgba(11, 17, 30, 0.75) 100%);
        }

        .motel-hero img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .motel-hero-body {
            position: relative;
            padding: 2.5rem 3rem;
            display: grid;
            gap: 0.75rem;
        }

        .motel-hero-tags {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .motel-tag {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.35rem 0.85rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.12);
            font-size: 0.9rem;
            font-weight: 500;
        }

        .motel-hero h1 {
            margin: 0;
            font-size: clamp(2.4rem, 4vw, 3.1rem);
        }

        .motel-hero p {
            margin: 0;
            max-width: 580px;
            line-height: 1.7;
            color: rgba(255, 255, 255, 0.85);
        }

        .motel-overview {
            max-width: 1240px;
            margin: 0 auto 3rem;
            display: grid;
            gap: 2rem;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        }

        .motel-overview-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 1.8rem;
            box-shadow: 0 18px 36px rgba(19, 38, 74, 0.12);
            display: grid;
            gap: 0.8rem;
        }

        .motel-overview-card h3 {
            margin: 0;
            font-size: 1.2rem;
            color: var(--text-dark);
        }

        .motel-overview-list {
            display: grid;
            gap: 0.5rem;
            color: var(--text-muted);
        }

        .motel-overview-list span {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .motel-amenities {
            max-width: 1240px;
            margin: 0 auto 3rem;
        }

        .motel-amenities-grid {
            display: grid;
            gap: 1rem;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        }

        .motel-amenity-card {
            background: #ffffff;
            border-radius: 18px;
            padding: 1.5rem;
            box-shadow: 0 14px 28px rgba(22, 40, 74, 0.12);
            display: grid;
            gap: 0.6rem;
        }

        .motel-gallery {
            max-width: 1240px;
            margin: 0 auto 3rem;
        }

        .motel-gallery-grid {
            display: grid;
            gap: 1rem;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        }

        .motel-gallery-grid img {
            border-radius: 18px;
            width: 100%;
            height: 220px;
            object-fit: cover;
            box-shadow: 0 18px 32px rgba(19, 34, 66, 0.12);
        }

        .motel-rooms {
            max-width: 1240px;
            margin: 0 auto 4rem;
        }

        .motel-rooms-grid {
            display: grid;
            gap: 1.5rem;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        }

        .motel-room-card {
            background: #ffffff;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 22px 40px rgba(19, 37, 74, 0.14);
            display: flex;
            flex-direction: column;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .motel-room-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 28px 54px rgba(19, 37, 74, 0.18);
        }

        .motel-room-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .motel-room-body {
            padding: 1.7rem;
            display: grid;
            gap: 0.8rem;
            flex: 1;
        }

        .motel-room-title {
            margin: 0;
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .motel-room-items {
            display: grid;
            gap: 0.35rem;
            color: var(--text-dark);
        }

        .motel-room-items span::before {
            content: '•';
            margin-right: 0.45rem;
            color: var(--accent);
            font-size: 1.2rem;
            line-height: 1;
        }

        .motel-room-footer {
            padding: 0 1.7rem 1.7rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .motel-room-price {
            font-size: 1.2rem;
            font-weight: 700;
            color: #b2560d;
        }

        .motel-room-price span {
            font-size: 0.9rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .motel-room-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            padding: 0.65rem 1.3rem;
            border-radius: 999px;
            background: #b2560d;
            color: #ffffff;
            font-weight: 600;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .motel-room-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 27px rgba(178, 86, 13, 0.32);
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

@php use Illuminate\Support\Str; @endphp

@section('content')
    <section class="motel-hero">
        <img src="{{ $primaryImage }}" alt="{{ $motel->name }}">
        <div class="motel-hero-body">
            <div class="motel-hero-tags">
                @if($motel->motelType)
                    <span class="motel-tag">{{ $motel->motelType->name }}</span>
                @endif
                @if($location)
                    <span class="motel-tag">{{ $location }}</span>
                @endif
                @if($motel->rooms_count)
                    <span class="motel-tag">{{ $motel->rooms_count }} rooms</span>
                @endif
            </div>
            <h1>{{ $motel->name }}</h1>
            @if($motel->description)
                <p>{{ Str::limit(strip_tags($motel->description), 200) }}</p>
            @endif
        </div>
    </section>

    <section class="motel-overview">
        <article class="motel-overview-card">
            <h3>Contact & Status</h3>
            <div class="motel-overview-list">
                <span><strong>Phone:</strong> {{ optional($motel->details)->contact_phone ?? 'Not provided' }}</span>
                <span><strong>Email:</strong> {{ optional($motel->details)->contact_email ?? 'Not provided' }}</span>
                <span><strong>Status:</strong> {{ optional($motel->details)->status ?? 'Active' }}</span>
            </div>
        </article>
        <article class="motel-overview-card">
            <h3>Location</h3>
            <div class="motel-overview-list">
                <span>{{ $location ?: 'Location coming soon' }}</span>
                @if($motel->street_address)
                    <span>{{ $motel->street_address }}</span>
                @endif
            </div>
        </article>
        <article class="motel-overview-card">
            <h3>Coordinates</h3>
            <div class="motel-overview-list">
                <span>Latitude: {{ $motel->latitude ?? '—' }}</span>
                <span>Longitude: {{ $motel->longitude ?? '—' }}</span>
            </div>
        </article>
    </section>

    @if($amenities->isNotEmpty())
        <section class="motel-amenities">
            <h2 class="section-heading">Signature amenities</h2>
            <p class="section-subheading">Elevated comforts and services curated to make every stay unforgettable.</p>
            <div class="motel-amenities-grid">
                @foreach($amenities as $amenity)
                    <article class="motel-amenity-card">
                        <strong>{{ $amenity['name'] }}</strong>
                        @if(!empty($amenity['description']))
                            <p style="margin: 0; color: var(--text-muted); line-height: 1.6;">{{ $amenity['description'] }}</p>
                        @endif
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    @if($gallery->isNotEmpty())
        <section class="motel-gallery">
            <h2 class="section-heading">Gallery</h2>
            <p class="section-subheading">Step inside and explore highlights from {{ $motel->name }}.</p>
            <div class="motel-gallery-grid">
                @foreach($gallery as $image)
                    <img src="{{ $image }}" alt="{{ $motel->name }} gallery image">
                @endforeach
            </div>
        </section>
    @endif

    <section class="motel-rooms">
        <h2 class="section-heading">Available rooms</h2>
        <p class="section-subheading">Select a room to view detailed amenities, imagery, and curated in-room experiences.</p>
        @if($rooms->isNotEmpty())
            <div class="motel-rooms-grid">
                @foreach($rooms as $room)
                    <article class="motel-room-card">
                        <img src="{{ $room['image'] }}" alt="{{ $room['name'] }}">
                        <div class="motel-room-body">
                            <h3 class="motel-room-title">{{ $room['name'] }}</h3>
                            @if(!empty($room['description']))
                                <p style="margin: 0; color: var(--text-muted); line-height: 1.6;">{{ Str::limit($room['description'], 120) }}</p>
                            @endif
                            <div class="motel-room-items">
                                @forelse($room['items'] as $item)
                                    <span>{{ $item }}</span>
                                @empty
                                    <span>Premium linens & guest amenities</span>
                                @endforelse
                            </div>
                        </div>
                        <div class="motel-room-footer">
                            <div class="motel-room-price">
                                @if($room['price'])
                                    ${{ number_format($room['price'], 0) }} <span>/night</span>
                                @else
                                    <span style="color: var(--text-muted); font-weight:500;">Contact for rates</span>
                                @endif
                            </div>
                            <a class="motel-room-button" href="{{ route('website.rooms.show', [$motel->id, $room['id']]) }}">
                                View details
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="motels-empty">
                <h2 style="margin-bottom: 1rem;">Room details coming soon</h2>
                <p style="color: var(--text-muted); line-height: 1.7;">
                    This property is preparing to publish its room lineup. Check back shortly, or contact our concierge for tailored suggestions.
                </p>
            </div>
        @endif
    </section>
@endsection

