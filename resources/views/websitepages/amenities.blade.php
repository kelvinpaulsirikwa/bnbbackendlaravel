@extends('websitepages.layouts.app')

@section('title', 'Amenities | bnbStay Experiences')
@section('meta_description', 'Discover the amenities curated across bnbStay motels to elevate every stay.')

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

        .amenities-hero {
            max-width: 1000px;
            margin: 5rem auto 4rem;
            text-align: center;
            display: grid;
            gap: 1.5rem;
            padding: 0 1.5rem;
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

        .amenities-hero h1 {
            margin: 0;
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 800;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
            line-height: 1.1;
        }

        .amenities-hero p {
            margin: 0 auto;
            max-width: 680px;
            color: #64748b;
            line-height: 1.8;
            font-size: 1.125rem;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.5rem;
            background: var(--gradient-gold);
            color: #ffffff;
            border-radius: 999px;
            font-size: 0.875rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            box-shadow: 0 8px 32px rgba(247, 151, 30, 0.4);
            animation: shimmer 3s ease-in-out infinite;
        }

        @keyframes shimmer {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 8px 32px rgba(247, 151, 30, 0.4);
            }
            50% {
                transform: scale(1.03);
                box-shadow: 0 8px 40px rgba(247, 151, 30, 0.6);
            }
        }

        .amenities-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .amenities-grid {
            display: grid;
            gap: 2rem;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            animation: fadeIn 1s ease 0.3s backwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .amenity-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 2.5rem 2rem;
            box-shadow: var(--shadow-md);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.25rem;
            text-align: center;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .amenity-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .amenity-card:hover::before {
            transform: scaleX(1);
        }

        .amenity-card:hover {
            transform: translateY(-12px) scale(1.02);
            box-shadow: var(--shadow-lg);
        }

        .amenity-icon {
            width: 96px;
            height: 96px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            color: #667eea;
            font-size: 2.5rem;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .amenity-icon::before {
            content: '';
            position: absolute;
            inset: -2px;
            background: var(--gradient-primary);
            border-radius: 50%;
            opacity: 0;
            transition: opacity 0.4s ease;
            z-index: -1;
        }

        .amenity-card:hover .amenity-icon {
            transform: scale(1.1) rotate(5deg);
            box-shadow: var(--shadow-glow);
        }

        .amenity-card:hover .amenity-icon::before {
            opacity: 0.2;
        }

        .amenity-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .amenity-icon svg {
            filter: drop-shadow(0 2px 4px rgba(102, 126, 234, 0.2));
        }

        .amenity-name {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e293b;
            letter-spacing: -0.01em;
            transition: color 0.3s ease;
        }

        .amenity-card:hover .amenity-name {
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .amenity-description {
            font-size: 0.9rem;
            color: #64748b;
            line-height: 1.6;
            opacity: 0;
            max-height: 0;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .amenity-card:hover .amenity-description {
            opacity: 1;
            max-height: 100px;
        }

        /* Category-based icon colors */
        .amenity-card[data-category="comfort"] .amenity-icon {
            background: linear-gradient(135deg, rgba(240, 147, 251, 0.1) 0%, rgba(245, 87, 108, 0.1) 100%);
            color: #f093fb;
        }

        .amenity-card[data-category="technology"] .amenity-icon {
            background: linear-gradient(135deg, rgba(79, 172, 254, 0.1) 0%, rgba(0, 242, 254, 0.1) 100%);
            color: #4facfe;
        }

        .amenity-card[data-category="luxury"] .amenity-icon {
            background: linear-gradient(135deg, rgba(247, 151, 30, 0.1) 0%, rgba(255, 210, 0, 0.1) 100%);
            color: #f7971e;
        }

        .amenities-empty {
            max-width: 680px;
            margin: 4rem auto;
            background: #ffffff;
            border-radius: 32px;
            padding: 4rem 3rem;
            text-align: center;
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
        }

        .amenities-empty::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
        }

        .amenities-empty h2 {
            margin-bottom: 1.25rem;
            font-size: 2rem;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
        }

        .amenities-empty p {
            color: #64748b;
            line-height: 1.8;
            font-size: 1.05rem;
        }

        /* Stats Banner */
        .amenities-stats {
            max-width: 1200px;
            margin: 0 auto 4rem;
            padding: 0 1.5rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            animation: fadeInUp 1s ease 0.5s backwards;
        }

        .stat-card {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
            padding: 2rem;
            border-radius: 20px;
            text-align: center;
            border: 2px solid rgba(102, 126, 234, 0.1);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            border-color: rgba(102, 126, 234, 0.3);
            box-shadow: var(--shadow-md);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: block;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #64748b;
            font-size: 0.95rem;
            font-weight: 600;
        }

        /* Floating decoration elements */
        .amenities-container::before,
        .amenities-container::after {
            content: '';
            position: fixed;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.15;
            pointer-events: none;
            z-index: -1;
        }

        .amenities-container::before {
            top: -100px;
            left: -100px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            animation: float 20s ease-in-out infinite;
        }

        .amenities-container::after {
            bottom: -100px;
            right: -100px;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            animation: float 25s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) scale(1);
            }
            50% {
                transform: translate(30px, -30px) scale(1.1);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .amenities-hero {
                margin: 3rem auto 2.5rem;
            }

            .amenities-grid {
                grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
                gap: 1.25rem;
            }

            .amenity-card {
                padding: 2rem 1.5rem;
            }

            .amenity-icon {
                width: 80px;
                height: 80px;
                font-size: 2rem;
            }

            .amenities-stats {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                gap: 1rem;
            }

            .stat-card {
                padding: 1.5rem;
            }

            .stat-number {
                font-size: 2rem;
            }
        }
    </style>
@endpush

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
    <section class="amenities-hero">
        <span class="badge">⭐ Signature Comforts</span>
        <h1>World-Class Amenities</h1>
        <p>Indulge in premium facilities and thoughtful touches curated across our partner motels—crafted to make every stay effortless and extraordinary.</p>
    </section>

    <div class="amenities-container">
        @if($amenities->isNotEmpty())
            {{-- Stats Section --}}
            <div class="amenities-stats">
                <div class="stat-card">
                    <span class="stat-number">{{ $amenities->count() }}+</span>
                    <span class="stat-label">Premium Amenities</span>
                </div>
                <div class="stat-card">
                    <span class="stat-number">100%</span>
                    <span class="stat-label">Quality Assured</span>
                </div>
                <div class="stat-card">
                    <span class="stat-number">24/7</span>
                    <span class="stat-label">Available Services</span>
                </div>
            </div>

            <section class="amenities-grid">
                @foreach($amenities as $amenity)
                    @php
                        $icon = $amenity['icon'];
                        $treatAsImage = $icon && (filter_var($icon, FILTER_VALIDATE_URL) || Str::contains($icon, ['/','\\','.png','.jpg','.jpeg','.svg']));
                        
                        // Assign category based on amenity name for demo purposes
                        $category = 'comfort';
                        if(Str::contains(strtolower($amenity['name']), ['wifi', 'tv', 'smart', 'tech'])) {
                            $category = 'technology';
                        } elseif(Str::contains(strtolower($amenity['name']), ['spa', 'pool', 'vip', 'premium', 'suite'])) {
                            $category = 'luxury';
                        }
                    @endphp
                    <article class="amenity-card" data-category="{{ $category }}">
                        <div class="amenity-icon">
                            @if($treatAsImage)
                                <img src="{{ $icon }}" alt="{{ $amenity['name'] }} icon">
                            @elseif(!empty($icon))
                                <span>{{ $icon }}</span>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            @endif
                        </div>
                        <div class="amenity-name">{{ $amenity['name'] }}</div>
                        <div class="amenity-description">
                            Available at select properties for your comfort and convenience
                        </div>
                    </article>
                @endforeach
            </section>
        @else
            <div class="amenities-empty">
                <h2>✨ Amenities Coming Soon</h2>
                <p>
                    We're currently curating premium amenities across our network. Check back shortly to explore everything included with each stay.
                </p>
            </div>
        @endif
    </div>
@endsection