@extends('websitepages.layouts.app')

@section('title', 'Booking Services | bnbStay Hospitality Studio')
@section('meta_description', 'Discover our comprehensive booking services: explore BNB types, room types, and locations across countries, regions, and districts.')

@push('styles')
    <style>
        :root {
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-secondary: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --gradient-accent: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --gradient-gold: linear-gradient(135deg, #f7971e 0%, #ffd200 100%);
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.04);
            --shadow-md: 0 8px 24px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 20px 60px rgba(0, 0, 0, 0.12);
            --shadow-glow: 0 8px 32px rgba(102, 126, 234, 0.35);
        }

        body {
            background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
            min-height: 100vh;
        }

        .services-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        /* Hero Section */
        .hero-services {
            text-align: center;
            margin: 5rem auto 4rem;
            animation: fadeInUp 0.8s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-services h1 {
            font-size: clamp(2.5rem, 4vw, 3.5rem);
            margin-bottom: 1.5rem;
            line-height: 1.2;
            font-weight: 800;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .hero-services p {
            color: #64748b;
            margin-bottom: 2rem;
            line-height: 1.8;
            font-size: 1.125rem;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Section Styles */
        .section {
            margin: 4rem 0;
            animation: fadeIn 1s ease backwards;
        }

        .section-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-header h2 {
            font-size: clamp(2rem, 3vw, 2.75rem);
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .section-header p {
            color: #64748b;
            font-size: 1.125rem;
            max-width: 700px;
            margin: 0 auto;
        }

        /* Grid Layouts */
        .bnb-types-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .room-types-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .location-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        /* Card Styles */
        .type-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--shadow-md);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            border: 2px solid transparent;
        }

        .type-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .type-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
            border-color: rgba(102, 126, 234, 0.2);
        }

        .type-card:hover::before {
            transform: scaleX(1);
        }

        .type-card h3 {
            margin: 0 0 0.75rem 0;
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .type-card h3::before {
            content: '🏨';
            font-size: 1.75rem;
        }

        .type-card p {
            margin: 0;
            color: #64748b;
            line-height: 1.7;
        }

        .room-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--shadow-md);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            border: 2px solid transparent;
        }

        .room-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-accent);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .room-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
            border-color: rgba(79, 172, 254, 0.2);
        }

        .room-card:hover::before {
            transform: scaleX(1);
        }

        .room-card h3 {
            margin: 0 0 0.75rem 0;
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .room-card h3::before {
            content: '🛏️';
            font-size: 1.75rem;
        }

        .room-card p {
            margin: 0;
            color: #64748b;
            line-height: 1.7;
            font-size: 0.95rem;
        }

        /* Location Card */
        .location-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: var(--shadow-md);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            border: 2px solid transparent;
        }

        .location-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-gold);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .location-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
            border-color: rgba(247, 151, 30, 0.2);
        }

        .location-card:hover::before {
            transform: scaleX(1);
        }

        .location-card h3 {
            margin: 0 0 1.5rem 0;
            font-size: 1.75rem;
            font-weight: 800;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f1f5f9;
        }

        .location-card h3::before {
            content: '🌍';
            font-size: 2rem;
        }

        .regions-list {
            margin-top: 1.5rem;
        }

        .region-item {
            margin-bottom: 1.25rem;
            padding-left: 1rem;
            border-left: 3px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .region-item:hover {
            border-left-color: #667eea;
            padding-left: 1.25rem;
        }

        .region-item h4 {
            margin: 0 0 0.75rem 0;
            font-size: 1.25rem;
            font-weight: 700;
            color: #334155;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .region-item h4::before {
            content: '📍';
            font-size: 1.25rem;
        }

        .districts-list {
            margin-top: 0.75rem;
            padding-left: 1.5rem;
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .district-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.375rem 0.875rem;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            color: #667eea;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 600;
            border: 1px solid rgba(102, 126, 234, 0.2);
            transition: all 0.3s ease;
        }

        .district-badge:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%);
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
        }

        /* CTA Panel */
        .cta-panel {
            margin: 5rem 0;
            border-radius: 32px;
            background: var(--gradient-primary);
            color: #ffffff;
            padding: clamp(3rem, 5vw, 5rem);
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-glow);
        }

        .cta-panel::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            filter: blur(60px);
        }

        .cta-panel::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            filter: blur(50px);
        }

        .cta-content {
            position: relative;
            z-index: 1;
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
        }

        .cta-panel .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.5rem;
            background: rgba(255, 255, 255, 0.2);
            color: #ffffff;
            border-radius: 999px;
            font-size: 0.875rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 1.5rem;
            backdrop-filter: blur(10px);
        }

        .cta-panel h2 {
            margin: 0 0 1.25rem 0;
            font-size: clamp(1.75rem, 3vw, 2.5rem);
            font-weight: 800;
            line-height: 1.3;
        }

        .cta-panel p {
            margin: 0 0 2rem 0;
            font-size: 1.125rem;
            line-height: 1.8;
            opacity: 0.95;
        }

        .cta-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem 2rem;
            background: #ffffff;
            color: #667eea;
            border-radius: 16px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
        }

        .cta-button:hover {
            transform: translateY(-4px) scale(1.05);
            box-shadow: 0 8px 32px rgba(255, 255, 255, 0.4);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #64748b;
        }

        .empty-state p {
            font-size: 1.125rem;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .bnb-types-grid,
            .room-types-grid,
            .location-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .hero-services {
                margin: 3rem auto 2.5rem;
            }

            .section {
                margin: 3rem 0;
            }

            .bnb-types-grid,
            .room-types-grid,
            .location-grid {
                grid-template-columns: 1fr;
            }

            .location-card {
                padding: 2rem;
            }

            .districts-list {
                padding-left: 1rem;
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
@endpush

@section('content')
    <div class="services-container">
        <!-- Hero Section -->
        <section class="hero-services">
            <h1>Booking Services</h1>
            <p>
                Discover our comprehensive booking platform featuring a wide selection of BNB types, room types, 
                and locations across multiple countries, regions, and districts. Find your perfect stay with ease.
            </p>
        </section>

        <!-- BNB Types Section -->
        <section class="section" style="animation-delay: 0.2s;">
            <div class="section-header">
                <h2>BNB Types</h2>
                <p>Explore our diverse collection of accommodation types, each offering unique experiences and amenities.</p>
            </div>
            <div class="bnb-types-grid">
                @forelse($bnbTypes as $bnbType)
                    <div class="type-card">
                        <h3>{{ $bnbType->name }}</h3>
                        <p>Experience exceptional hospitality with our {{ strtolower($bnbType->name) }} accommodations.</p>
                    </div>
                @empty
                    <div class="empty-state" style="grid-column: 1 / -1;">
                        <p>No BNB types available at the moment.</p>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- Room Types Section -->
        <section class="section" style="animation-delay: 0.4s;">
            <div class="section-header">
                <h2>Room Types</h2>
                <p>Choose from a variety of room types designed to suit every traveler's needs and preferences.</p>
            </div>
            <div class="room-types-grid">
                @forelse($roomTypes as $roomType)
                    <div class="room-card">
                        <h3>{{ $roomType->name }}</h3>
                        <p>{{ $roomType->description ?? 'Comfortable and well-appointed room designed for your relaxation and convenience.' }}</p>
                    </div>
                @empty
                    <div class="empty-state" style="grid-column: 1 / -1;">
                        <p>No room types available at the moment.</p>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- Locations Section -->
        <section class="section" style="animation-delay: 0.6s;">
            <div class="section-header">
                <h2>Our Locations</h2>
                <p>Browse our extensive network of properties organized by country, region, and district for easy navigation.</p>
            </div>
            <div class="location-grid">
                @forelse($countries as $country)
                    <div class="location-card">
                        <h3>{{ $country['name'] }}</h3>
                        <div class="regions-list">
                            @forelse($country['regions'] as $region)
                                <div class="region-item">
                                    <h4>{{ $region['name'] }}</h4>
                                    @if(count($region['districts']) > 0)
                                        <div class="districts-list">
                                            @foreach($region['districts'] as $district)
                                                <span class="district-badge">{{ $district['name'] }}</span>
                                            @endforeach
                                        </div>
                                    @else
                                        <p style="color: #94a3b8; font-size: 0.875rem; margin: 0;">No districts available</p>
                                    @endif
                                </div>
                            @empty
                                <p style="color: #94a3b8; font-size: 0.95rem;">No regions available in this country.</p>
                            @endforelse
                        </div>
                    </div>
                @empty
                    <div class="empty-state" style="grid-column: 1 / -1;">
                        <p>No locations available at the moment.</p>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- CTA Panel -->
        <section class="cta-panel">
            <div class="cta-content">
                <span class="badge">🔍 Start Your Search</span>
                <h2>Ready to book your perfect stay?</h2>
                <p>
                    Explore our wide selection of BNB types, room types, and locations. 
                    Find the perfect accommodation that matches your preferences and start your journey today.
                </p>
                <a class="cta-button" href="{{ route('website.motels.index') }}">
                    Browse Properties
                </a>
            </div>
        </section>
    </div>
@endsection
