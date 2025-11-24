@extends('websitepages.layouts.app')

@section('title', __('website.motel.meta_title', ['name' => $motel->name]))
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($motel->description ?? 'Discover bespoke stays with bnbStay.'), 150))

@push('styles')
    <style>
        /* ===== CSS Variables ===== */
        :root {
            --text-dark: #1a1a1a;
            --text-muted: #6b7280;
            --accent: #b2560d;
            --section-spacing-lg: clamp(2.5rem, 5vw, 4rem);
            --section-spacing-md: clamp(1.75rem, 4vw, 3rem);
            --section-spacing-sm: clamp(1rem, 3vw, 2rem);
        }

        /* ===== Hero Section ===== */
        .motel-hero {
            max-width: 1240px;
            margin: var(--section-spacing-lg) auto var(--section-spacing-md);
            padding: 0 1rem;
            display: grid;
            gap: var(--section-spacing-sm);
        }

        .motel-hero-heading {
            display: grid;
            gap: 0.75rem;
        }

        .motel-hero-heading h1 {
            margin: 0;
            font-size: clamp(2rem, 4vw, 3.1rem);
        }

        .motel-hero-heading p {
            margin: 0;
            max-width: 720px;
            line-height: 1.7;
            color: var(--text-muted);
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
            background: rgba(178, 86, 13, 0.1);
            color: var(--accent);
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* ===== Hero Gallery ===== */
        .motel-hero-gallery {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 0.5rem;
            height: 420px;
            position: relative;
        }

        .hero-main {
            grid-row: 1 / 3;
            border-radius: 12px;
            overflow: hidden;
            position: relative;
        }

        .hero-main img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .hero-secondary-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-template-rows: repeat(2, 1fr);
            gap: 0.5rem;
        }

        .hero-secondary-grid figure {
            position: relative;
            overflow: hidden;
            margin: 0;
            border-radius: 12px;
        }

        .hero-secondary-grid img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .hero-image--with-overlay::after {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.25);
            border-radius: 12px;
        }

        .hero-show-all {
            position: absolute;
            right: 0.75rem;
            bottom: 0.75rem;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.98);
            color: #1a1a1a;
            font-weight: 600;
            text-decoration: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            font-size: 0.9rem;
            transition: all 0.2s ease;
            z-index: 10;
            border: 1px solid rgba(0, 0, 0, 0.08);
        }

        .hero-show-all:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        }

        .hero-show-all svg {
            width: 18px;
            height: 18px;
        }

        .hero-image--empty {
            grid-column: 1 / -1;
            grid-row: 1 / -1;
            min-height: 420px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f3f4f6;
            border-radius: 12px;
        }

        /* ===== Overview Section ===== */
        .motel-overview {
            max-width: 1240px;
            margin: 0 auto var(--section-spacing-lg);
            padding: 0 1rem;
        }

        .motel-overview-grid {
            display: grid;
            gap: var(--section-spacing-sm);
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            align-items: start;
        }

        .motel-amenities-panel {
            background: #ffffff;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border: 1px solid #e5e7eb;
        }

        .motel-amenities-panel h3 {
            margin: 0;
            font-size: 1.35rem;
            color: var(--text-dark);
            font-weight: 700;
        }

        .motel-amenities-panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .motel-amenities-link {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--accent);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }

        .motel-amenities-link:hover {
            text-decoration: underline;
        }

        .motel-amenities-list {
            display: grid;
            gap: 0.85rem;
            margin-top: 1.25rem;
        }

        .motel-amenities-item {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .motel-amenities-item strong {
            font-size: 1rem;
        }

        .motel-amenity-link {
            color: inherit;
            text-decoration: none;
        }

        .motel-amenity-link:hover {
            color: var(--accent);
        }

        .motel-amenities-item p {
            margin: 0;
            color: var(--text-muted);
            line-height: 1.5;
            font-size: 0.9rem;
        }

        .motel-overview-stack {
            display: grid;
            gap: var(--section-spacing-sm);
        }

        .motel-overview-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 1.8rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            display: grid;
            gap: 0.8rem;
            border: 1px solid #e5e7eb;
        }

        .motel-overview-card h3 {
            margin: 0;
            font-size: 1.2rem;
            color: var(--text-dark);
            font-weight: 600;
        }

        .motel-overview-list {
            display: grid;
            gap: 0.5rem;
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        .motel-overview-list span {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* ===== Rooms Section ===== */
        .motel-rooms {
            max-width: 1240px;
            margin: 0 auto var(--section-spacing-lg);
            padding: 0 1rem;
        }

        .section-heading {
            font-size: clamp(1.75rem, 3vw, 2.3rem);
            margin-bottom: 0.75rem;
            text-align: center;
            color: var(--text-dark);
            font-weight: 700;
        }

        .section-subheading {
            color: var(--text-muted);
            text-align: center;
            margin-bottom: 2rem;
            line-height: 1.7;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .motel-rooms-grid {
            display: grid;
            gap: var(--section-spacing-sm);
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .motel-room-card {
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
            border: 1px solid #e5e7eb;
        }

        .motel-room-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        }

        .motel-room-card img {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }

        .motel-room-body {
            padding: 1.5rem;
            display: grid;
            gap: 0.9rem;
            flex: 1;
        }

        .motel-room-title {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .motel-room-items {
            display: grid;
            gap: 0.4rem;
            color: var(--text-dark);
            font-size: 0.9rem;
        }

        .motel-room-items span::before {
            content: '•';
            margin-right: 0.5rem;
            color: var(--accent);
            font-size: 1.2rem;
        }

        .motel-room-footer {
            padding: 0 1.5rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .motel-room-price {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--accent);
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
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            background: var(--accent);
            color: #ffffff;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .motel-room-button:hover {
            background: #8f4409;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(178, 86, 13, 0.3);
        }

        .motels-empty {
            text-align: center;
            padding: 3rem 1rem;
            background: #f9fafb;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
        }

        /* ===== Responsive Design ===== */
        @media (max-width: 1024px) {
            .motel-rooms-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 768px) {
            .motel-hero {
                margin: 2rem auto 2rem;
            }

            .motel-hero-gallery {
                grid-template-columns: 1fr;
                height: auto;
                gap: 0.5rem;
            }

            .hero-main {
                grid-row: auto;
                height: 300px;
            }

            .motel-room-footer {
                flex-direction: column;
                align-items: flex-start;
            }

            .motel-room-button {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .motel-hero,
            .motel-overview,
            .motel-rooms {
                padding: 0 0.75rem;
            }

            .hero-secondary-grid {
                grid-template-rows: repeat(2, 150px);
            }

            .hero-main {
                height: 250px;
            }

            .motel-rooms-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@php use Illuminate\Support\Str; @endphp

@section('content')
    @php
        $secondaryImages = $gallery->slice(1, 4);
        $remainingPhotos = max($gallery->count() - (1 + $secondaryImages->count()), 0);
    @endphp

    {{-- Hero Section --}}
    <section class="motel-hero">
        <div class="motel-hero-heading">
            <div class="motel-hero-tags">
                @if($motel->motelType)
                    <span class="motel-tag">{{ $motel->motelType->name }}</span>
                @endif
                @if($location)
                    <span class="motel-tag">{{ $location }}</span>
                @endif
                @if($motel->rooms_count)
                    <span class="motel-tag">{{ __('website.motel.rooms_count', ['count' => $motel->rooms_count]) }}</span>
                @endif
            </div>
            <h1>{{ $motel->name }}</h1>
            @if($motel->description)
                <p>{{ Str::limit(strip_tags($motel->description), 200) }}</p>
            @endif
        </div>

        <div class="motel-hero-gallery">
            <figure class="hero-main">
                <img src="{{ $primaryImage }}" alt="{{ $motel->name }} front view">
            </figure>
            @if($secondaryImages->isNotEmpty())
                <div class="hero-secondary-grid">
                    @foreach($secondaryImages as $image)
                        <figure class="{{ $loop->last ? 'hero-image--with-overlay' : '' }}">
                            <img src="{{ $image }}" alt="{{ $motel->name }} gallery preview">
                        </figure>
                    @endforeach
                </div>
                <a class="hero-show-all" href="{{ route('website.motels.gallery', $motel) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    {{ __('website.motel.show_all_photos') }}
                    @if($remainingPhotos > 0)
                        <span>({{ $gallery->count() }})</span>
                    @endif
                </a>
            @else
                <figure class="hero-image--empty">
                    <a class="hero-show-all" href="{{ route('website.motels.gallery', $motel) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ __('website.motel.show_all_photos') }}
                    </a>
                </figure>
            @endif
        </div>
    </section>

    {{-- Overview Section --}}
    <section class="motel-overview">
        <div class="motel-overview-grid">
            @if($amenities->isNotEmpty())
                <article class="motel-amenities-panel">
                    <div class="motel-amenities-panel-header">
                        <h3>{{ __('website.motel.amenities_title') }}</h3>
                        <a class="motel-amenities-link" href="{{ route('website.motels.amenities', $motel) }}">
                            {{ __('website.general.view_all') }}
                            <span style="font-weight:500; color: var(--text-muted);">({{ $amenities->count() }})</span>
                        </a>
                    </div>
                    <div class="motel-amenities-list">
                        @foreach($amenities as $amenity)
                            <div class="motel-amenities-item">
                                <strong>
                                    @if(!empty($amenity['amenity_id']))
                                        <a class="motel-amenity-link"
                                           href="{{ route('website.amenities.show', $amenity['amenity_id']) }}"
                                           aria-label="{{ __('website.motel.amenity_link_aria', ['name' => $amenity['name']]) }}">
                                            {{ $amenity['name'] }}
                                        </a>
                                    @else
                                        {{ $amenity['name'] }}
                                    @endif
                                </strong>
                                @if(!empty($amenity['description']))
                                    <p>{{ $amenity['description'] }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </article>
            @endif

            <div class="motel-overview-stack">
                <article class="motel-overview-card">
                    <h3>{{ __('website.motel.contact_status.title') }}</h3>
                    <div class="motel-overview-list">
                        <span><strong>{{ __('website.general.phone') }}</strong> {{ optional($motel->details)->contact_phone ?? __('website.general.not_provided') }}</span>
                        <span><strong>{{ __('website.general.email') }}</strong> {{ optional($motel->details)->contact_email ?? __('website.general.not_provided') }}</span>
                     </div>
                </article>
              
            </div>
        </div>
    </section>

    {{-- Rooms Section --}}
    <section class="motel-rooms">
        <h2 class="section-heading">{{ __('website.motel.rooms.title') }}</h2>
        <p class="section-subheading">{{ __('website.motel.rooms.subtitle') }}</p>
        @if($rooms->isNotEmpty())
            <div class="motel-rooms-grid">
                @foreach($rooms as $room)
                    <article class="motel-room-card">
                        <img src="{{ $room['image'] }}" alt="{{ $room['name'] }}">
                        <div class="motel-room-body">
                            <h3 class="motel-room-title">{{ $room['name'] }}</h3>
                            @if(!empty($room['description']))
                                <p style="margin: 0; color: var(--text-muted); line-height: 1.6; font-size: 0.9rem;">
                                    {{ Str::limit($room['description'], 120) }}
                                </p>
                            @endif
                            <div class="motel-room-items">
                                @forelse($room['items'] as $item)
                                    <span>{{ $item }}</span>
                                @empty
                                    <span>{{ __('website.motel.rooms.items_fallback') }}</span>
                                @endforelse
                            </div>
                        </div>
                        <div class="motel-room-footer">
                            <div class="motel-room-price">
                                @if($room['price'])
                                    ${{ number_format($room['price'], 0) }} <span>{{ __('website.general.per_night') }}</span>
                                @else
                                    <span style="color: var(--text-muted); font-weight:500;">{{ __('website.general.contact_for_rates') }}</span>
                                @endif
                            </div>
                            <a class="motel-room-button" href="{{ route('website.rooms.show', [$motel->id, $room['id']]) }}">
                                {{ __('website.general.view_details') }}
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="motels-empty">
                <h2 style="margin-bottom: 1rem;">{{ __('website.motel.rooms.empty_title') }}</h2>
                <p style="color: var(--text-muted); line-height: 1.7;">
                    {{ __('website.motel.rooms.empty_description') }}
                </p>
            </div>
        @endif
    </section>
@endsection