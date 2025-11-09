@extends('websitepages.layouts.app')

@section('title', 'bnbStay | Curated Stays Crafted for Comfort')
@section('meta_description', 'Explore inspiring destinations, curated stays, and thoughtful hospitality with bnbStay—your partner for memorable getaways.')

@push('styles')
    <style>
        .hero-banner {
            position: relative;
            margin: 0 calc(-1 * 4vw);
            padding: clamp(6rem, 14vw, 8.5rem) 4vw;
            min-height: clamp(60vh, 70vw, 78vh);
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #ffffff;
            overflow: hidden;
            background: url('https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=1400&q=80') center/cover no-repeat;
        }

        .hero-banner::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(13, 23, 42, 0.25) 0%, rgba(13, 23, 42, 0.72) 100%);
        }

        .hero-banner__content {
            position: relative;
            max-width: 720px;
            display: grid;
            gap: 1.5rem;
        }

        .hero-banner__title {
            font-size: clamp(2.8rem, 6vw, 4.4rem);
            font-weight: 700;
            margin: 0;
            line-height: 1.1;
        }

        .hero-banner__subtitle {
            margin: 0 auto;
            max-width: 520px;
            line-height: 1.7;
            font-size: 1.1rem;
            color: #f1f5f9;
        }

        .hero-banner__cta {
            justify-self: center;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.85rem 1.9rem;
            border-radius: 999px;
            background: #b2560d;
            color: #ffffff;
            font-weight: 600;
            font-size: 1rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .hero-banner__cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 32px rgba(178, 86, 13, 0.35);
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.75rem;
        }

        .feature-card {
            background: var(--white);
            border-radius: 18px;
            padding: 1.75rem;
            display: grid;
            gap: 0.9rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .feature-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 18px 35px rgba(34, 67, 131, 0.16);
        }

        .feature-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: rgba(43, 112, 247, 0.08);
            display: grid;
            place-items: center;
            color: var(--primary);
        }

        .section-title {
            font-size: clamp(1.9rem, 3vw, 2.4rem);
            margin-bottom: 1rem;
        }

        .section-subtitle {
            color: var(--text-muted);
            margin-bottom: 2.5rem;
            max-width: 640px;
            line-height: 1.7;
        }

        .destinations {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 1.5rem;
        }

        .destination-card {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            color: #ffffff;
            min-height: 220px;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            background-size: cover;
            background-position: center;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .destination-card::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(15deg, rgba(8, 11, 19, 0.78), rgba(8, 11, 19, 0.2));
        }

        .destination-card > * {
            position: relative;
            z-index: 1;
        }

        .destination-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 18px 35px rgba(12, 27, 61, 0.25);
        }

        .testimonial-wrap {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .testimonial-card {
            background: var(--white);
            border-radius: 18px;
            padding: 2rem;
            display: grid;
            gap: 1.5rem;
            position: relative;
        }

        .testimonial-card::before {
            content: '“';
            font-size: 5rem;
            color: rgba(43, 112, 247, 0.1);
            position: absolute;
            top: -0.5rem;
            left: 1rem;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.35rem 0.8rem;
            border-radius: 999px;
            background: rgba(43, 112, 247, 0.1);
            color: var(--primary);
            font-size: 0.85rem;
            font-weight: 500;
        }

        .property-types {
            padding-top: 2rem;
        }

        .property-carousel {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
        }

        .property-card {
            background: var(--white);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 18px 32px rgba(20, 41, 82, 0.15);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .property-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 22px 40px rgba(18, 35, 68, 0.2);
        }

        .property-card img {
            width: 100%;
            height: 170px;
            object-fit: cover;
        }

        .property-card .property-body {
            padding: 1.25rem 1.5rem;
            display: grid;
            gap: 0.4rem;
        }

        .property-card h4 {
            margin: 0;
            font-size: 1.05rem;
        }

        .property-card span {
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .home-gallery {
            padding-top: 1rem;
        }

        .home-gallery-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.5fr) repeat(2, minmax(0, 0.85fr));
            grid-template-rows: repeat(2, 240px);
            gap: 1.1rem;
        }

        .home-gallery-item {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 16px 32px rgba(12, 27, 61, 0.18);
            background: #0f172a;
        }

        .home-gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
            display: block;
        }

        .home-gallery-item--hero {
            grid-row: 1 / span 2;
            height: 100%;
        }

        .home-gallery-item:not(.home-gallery-item--hero) {
            height: 240px;
        }

        .home-gallery-item:hover img {
            transform: scale(1.05);
        }

        .home-gallery-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(15, 23, 42, 0) 30%, rgba(15, 23, 42, 0.85) 100%);
            display: flex;
            align-items: flex-end;
            padding: 1.2rem;
            color: #ffffff;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .home-gallery-item:hover .home-gallery-overlay {
            opacity: 1;
        }

        .home-gallery-overlay strong {
            font-size: 1.05rem;
        }

        .home-gallery-footer {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
        }

        .ghost-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.8rem 1.6rem;
            border-radius: 999px;
            border: 1px solid rgba(43, 112, 247, 0.4);
            color: var(--primary);
            font-weight: 600;
            background: rgba(43, 112, 247, 0.08);
            transition: background 0.2s ease, color 0.2s ease, border-color 0.2s ease;
        }

        .ghost-button:hover {
            background: rgba(43, 112, 247, 0.15);
            border-color: rgba(43, 112, 247, 0.6);
        }

        .home-motels {
            padding-top: 1rem;
        }

        .home-motels-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .home-motel-card {
            background: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 24px 48px rgba(16, 32, 75, 0.15);
            display: flex;
            flex-direction: column;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .home-motel-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 30px 55px rgba(16, 32, 75, 0.18);
        }

        .home-motel-card img {
            width: 100%;
            height: 190px;
            object-fit: cover;
        }

        .home-motel-body {
            padding: 1.8rem;
            display: grid;
            gap: 0.85rem;
            flex: 1;
        }

        .home-motel-title {
            margin: 0;
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .home-motel-desc {
            margin: 0;
            color: var(--text-muted);
            line-height: 1.65;
        }

        .home-motel-features {
            display: grid;
            gap: 0.35rem;
            color: var(--text-dark);
            font-size: 0.95rem;
        }

        .home-motel-features span::before {
            content: '✔';
            margin-right: 0.5rem;
            color: var(--accent);
            font-weight: 600;
        }

        .home-motel-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.8rem 1.8rem;
        }

        .home-motel-price {
            font-size: 1.25rem;
            font-weight: 700;
            color: #b2560d;
        }

        .home-motel-price span {
            font-size: 0.9rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .home-motel-button {
            display: inline-flex; 
            align-items: center;
            justify-content: center;
            padding: 0.65rem 1.35rem;
            border-radius: 999px;
            background: #b2560d;
            color: #ffffff;
            font-weight: 600;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .home-motel-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 24px rgba(178, 86, 13, 0.35);
        }

        @media (max-width: 900px) {
            .home-gallery-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                grid-template-rows: repeat(3, 230px);
            }

            .home-gallery-item--hero {
                grid-column: 1 / -1;
                grid-row: 1 / span 2;
            }
        }

        .home-amenities {
            padding-top: 1rem;
        }

        .home-amenities-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1.25rem;
        }

        .home-amenity-card {
            background: #ffffff;
            border-radius: 18px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 16px 28px rgba(18, 28, 53, 0.12);
            display: grid;
            gap: 0.75rem;
        }

        .home-amenity-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin: 0 auto;
            display: grid;
            place-items: center;
            background: rgba(43, 112, 247, 0.1);
            color: var(--primary);
            font-size: 1.6rem;
            overflow: hidden;
        }

        .home-amenity-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .home-amenity-name {
            font-weight: 600;
            color: var(--text-dark);
            font-size: 1rem;
        }

        @media (max-width: 720px) {
            .hero-card {
                padding: 2rem;
            }

            .stats {
                flex-direction: column;
                gap: 1rem;
            }
        }

        @media (max-width: 600px) {
            .property-card img {
                height: 150px;
            }

            .home-gallery-grid {
                grid-template-columns: 1fr;
                grid-template-rows: none;
            }

            .home-gallery-item--hero,
            .home-gallery-item {
                height: 220px;
                grid-column: auto;
                grid-row: auto;
            }
        }
    </style>
@endpush

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
    <section class="hero-banner">
        <div class="hero-banner__content">
            <span class="badge" style="justify-self: center;">Curated boutique stays</span>
            <h1 class="hero-banner__title">Experience Luxury Beyond Imagination</h1>
            <p class="hero-banner__subtitle">
                Where elegance meets comfort in the heart of paradise. Discover thoughtfully hosted motels with unforgettable hospitality.
            </p>
            <a class="hero-banner__cta" href="{{ route('website.motels.index') }}">
                Explore Our Rooms
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </section>

    @if(isset($spotlightMotels) && $spotlightMotels->isNotEmpty())
        <section class="section home-motels">
            <div class="section-title" style="text-align: center;">Our Exquisite Rooms</div>
            <p class="section-subtitle" style="text-align: center; margin-left: auto; margin-right: auto;">
                Choose from carefully curated motels designed to deliver elevated hospitality, signature amenities, and bespoke service.
            </p>
            <div class="home-motels-grid">
                @foreach($spotlightMotels as $motel)
                    <article class="home-motel-card">
                        <img src="{{ $motel['image'] }}" alt="{{ $motel['name'] }}">
                        <div class="home-motel-body">
                            <h3 class="home-motel-title">{{ $motel['name'] }}</h3>
                            <p class="home-motel-desc">{{ $motel['description'] }}</p>
                            <div class="home-motel-features">
                                @forelse($motel['amenities'] as $label)
                                    <span>{{ $label }}</span>
                                @empty
                                    <span>Thoughtful concierge service</span>
                                @endforelse
                            </div>
                        </div>
                        <div class="home-motel-footer">
                            <div class="home-motel-price">
                                @if($motel['starting_price'])
                                    ${{ number_format($motel['starting_price'], 0) }} <span>/night</span>
                                @else
                                    <span style="color: var(--text-muted); font-weight:500;">Contact for rates</span>
                                @endif
                            </div>
                            <a class="home-motel-button" href="{{ route('website.motels.show', $motel['id']) }}">
                                View Details
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
            <div class="home-gallery-footer" style="margin-top: 2.5rem;">
                <a class="ghost-button" href="{{ route('website.motels.index') }}">
                    View all motels
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </section>
    @endif

    @if(isset($propertyTypes) && $propertyTypes->isNotEmpty())
        <section class="section property-types">
            <div class="section-title">Browse by property type</div>
            <p class="section-subtitle">
                Discover a stay style that mirrors your mood—from boutique motels to design-led apartments and coastal resorts.
            </p>
            <div class="property-carousel">
                @foreach($propertyTypes as $propertyType)
                    <article class="property-card">
                        <img src="{{ $propertyType['image'] }}" alt="{{ $propertyType['name'] }} stay">
                        <div class="property-body">
                            <h4>{{ $propertyType['name'] }}</h4>
                            <span>Thoughtfully hosted experiences curated for this property style.</span>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    @if(isset($featuredAmenities) && $featuredAmenities->isNotEmpty())
        <section class="section home-amenities">
            <div class="section-title" style="text-align: center;">World-class amenities</div>
            <p class="section-subtitle" style="text-align: center; margin-left: auto; margin-right: auto;">
                Signature comforts and thoughtful touches available across our curated selection of motels.
            </p>
            <div class="home-amenities-grid">
                @foreach($featuredAmenities as $amenity)
                    <article class="home-amenity-card">
                        <div class="home-amenity-icon">
                            @if($amenity['icon_is_image'] ?? false)
                                <img src="{{ $amenity['icon'] }}" alt="{{ $amenity['name'] }} icon">
                            @elseif(!empty($amenity['icon']))
                                <span>{{ $amenity['icon'] }}</span>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 13h8m-4 4h4m-2 8a9 9 0 1 0-9-9 9 9 0 0 0 9 9Z"/>
                                </svg>
                            @endif
                        </div>
                        <div class="home-amenity-name">{{ $amenity['name'] }}</div>
                    </article>
                @endforeach
            </div>
            <div class="home-gallery-footer" style="margin-top: 1.75rem;">
                <a class="ghost-button" href="{{ route('website.amenities') }}">
                    Explore all amenities
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </section>
    @endif

    @if(isset($featuredGallery) && $featuredGallery->isNotEmpty())
        <section class="section home-gallery">
            <div class="section-title" style="text-align: center;">Explore Our Gallery</div>
            <p class="section-subtitle" style="text-align: center; margin-left: auto; margin-right: auto;">
                A glimpse into a few of our favourite motels. Hover to reveal the stay, or explore the full gallery for more inspiration.
            </p>
            <div class="home-gallery-grid">
                @foreach($featuredGallery as $index => $featured)
                    @php
                        $itemClass = 'home-gallery-item';
                        if ($index === 0) {
                            $itemClass .= ' home-gallery-item--hero';
                        }
                    @endphp
                    <article class="{{ $itemClass }}">
                        <img src="{{ $featured['url'] }}" alt="{{ $featured['motel_name'] }}">
                        <div class="home-gallery-overlay">
                            <strong>{{ $featured['motel_name'] }}</strong>
                        </div>
                    </article>
                @endforeach
            </div>
            <div class="home-gallery-footer">
                <a class="ghost-button" href="{{ route('website.gallery') }}">
                    View full gallery
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </section>
    @endif

       <section class="section" style="padding-bottom: 5rem;">
        <div class="hero-card shadow" style="display: grid; gap: 1.5rem; text-align: center;">
            <h2 style="margin: 0;">Ready to co-create your next stay?</h2>
            <p style="margin: 0; color: var(--text-muted); line-height: 1.7;">
                Tell us what inspires you and we’ll design a stay around it—whether it’s food, art, wellness, or adventure.
            </p>
            <a class="cta-button" style="justify-self: center;" href="{{ route('website.contact') }}">
                Start planning with us
            </a>
        </div>
    </section>
@endsection

