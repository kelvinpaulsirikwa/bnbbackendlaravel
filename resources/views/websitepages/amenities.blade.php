@extends('websitepages.layouts.app')

@section('title', __('website.amenities.meta_title'))
@section('meta_description', __('website.amenities.meta_description'))

@push('styles')
    <style>
        :root {
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-secondary: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --gradient-accent: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --gradient-gold: linear-gradient(135deg, #f7971e 0%, #ffd200 100%);
            --gradient-emerald: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.04);
            --shadow-md: 0 8px 24px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 24px 64px rgba(0, 0, 0, 0.14);
            --shadow-glow: 0 12px 40px rgba(102, 126, 234, 0.4);
            --dark: #0f172a;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #ffffff;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated background orbs */
        body::before,
        body::after {
            content: '';
            position: fixed;
            border-radius: 50%;
            filter: blur(120px);
            opacity: 0.12;
            pointer-events: none;
            z-index: 0;
            animation: float 25s ease-in-out infinite;
        }

        body::before {
            width: 600px;
            height: 600px;
            top: -200px;
            right: -200px;
            background: radial-gradient(circle, #667eea 0%, #764ba2 100%);
            animation-delay: -5s;
        }

        body::after {
            width: 500px;
            height: 500px;
            bottom: -150px;
            left: -150px;
            background: radial-gradient(circle, #f093fb 0%, #f5576c 100%);
        }

        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) scale(1);
            }
            33% {
                transform: translate(50px, -50px) scale(1.1);
            }
            66% {
                transform: translate(-30px, 40px) scale(0.95);
            }
        }

        .amenities-hero {
            position: relative;
            max-width: 1100px;
            margin: 6rem auto 5rem;
            text-align: center;
            display: grid;
            gap: 1.75rem;
            padding: 0 2rem;
            animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.625rem;
            padding: 0.75rem 1.75rem;
            background: var(--gradient-gold);
            color: #ffffff;
            border-radius: 999px;
            font-size: 0.875rem;
            font-weight: 700;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            box-shadow: 0 12px 40px rgba(247, 151, 30, 0.35);
            animation: shimmer 3s ease-in-out infinite;
            position: relative;
            overflow: hidden;
        }

        .badge::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            animation: shine 3s ease-in-out infinite;
        }

        @keyframes shimmer {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 12px 40px rgba(247, 151, 30, 0.35);
            }
            50% {
                transform: scale(1.05);
                box-shadow: 0 16px 48px rgba(247, 151, 30, 0.5);
            }
        }

        @keyframes shine {
            0% { left: -100%; }
            50%, 100% { left: 100%; }
        }

        .amenities-hero h1 {
            margin: 0;
            font-size: clamp(2.75rem, 6vw, 4.5rem);
            font-weight: 900;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 40%, #f093fb 70%, #f5576c 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.03em;
            line-height: 1.1;
            background-size: 200% 200%;
            animation: gradientShift 8s ease infinite;
        }

        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .amenities-hero p {
            margin: 0 auto;
            max-width: 720px;
            color: var(--text-secondary);
            line-height: 1.9;
            font-size: 1.15rem;
            font-weight: 400;
        }

        .amenities-container {
            position: relative;
            max-width: 1500px;
            margin: 0 auto;
            padding: 0 2rem;
            z-index: 1;
        }

        /* Stats Section */
        .amenities-stats {
            max-width: 1300px;
            margin: 0 auto 5rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 2rem;
            animation: fadeInUp 1s cubic-bezier(0.4, 0, 0.2, 1) 0.3s backwards;
        }

        .stat-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.7) 100%);
            backdrop-filter: blur(20px);
            padding: 2.5rem 2rem;
            border-radius: 24px;
            text-align: center;
            border: 2px solid rgba(102, 126, 234, 0.15);
            box-shadow: 0 8px 32px rgba(102, 126, 234, 0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: var(--gradient-primary);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .stat-card:hover {
            transform: translateY(-8px) scale(1.02);
            border-color: rgba(102, 126, 234, 0.4);
            box-shadow: 0 16px 48px rgba(102, 126, 234, 0.2);
        }

        .stat-card:hover::before {
            opacity: 0.05;
        }

        .stat-number {
            position: relative;
            z-index: 1;
            font-size: 3rem;
            font-weight: 900;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: block;
            margin-bottom: 0.75rem;
            letter-spacing: -0.02em;
        }

        .stat-label {
            position: relative;
            z-index: 1;
            color: var(--text-secondary);
            font-size: 1rem;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        /* Amenities Grid */
        .amenities-grid {
            display: grid;
            gap: 2.5rem;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            animation: fadeIn 1s cubic-bezier(0.4, 0, 0.2, 1) 0.5s backwards;
            padding-bottom: 4rem;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .amenity-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.85) 100%);
            backdrop-filter: blur(20px);
            border-radius: 28px;
            padding: 3rem 2rem;
            box-shadow: 0 8px 32px rgba(15, 23, 42, 0.08);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.5rem;
            text-align: center;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            cursor: pointer;
            border: 2px solid transparent;
            text-decoration: none;
            color: inherit;
        }

        .amenity-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: var(--gradient-primary);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .amenity-card::after {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 50% 0%, rgba(102, 126, 234, 0.08), transparent 70%);
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        .amenity-card:hover {
            transform: translateY(-16px) scale(1.03);
            box-shadow: 0 24px 64px rgba(102, 126, 234, 0.2);
            border-color: rgba(102, 126, 234, 0.3);
        }

        .amenity-card:hover::before {
            transform: scaleX(1);
        }

        .amenity-card:hover::after {
            opacity: 1;
        }

        /* Staggered animation for cards */
        .amenity-card:nth-child(1) { animation: slideInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) 0.1s backwards; }
        .amenity-card:nth-child(2) { animation: slideInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) 0.15s backwards; }
        .amenity-card:nth-child(3) { animation: slideInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) 0.2s backwards; }
        .amenity-card:nth-child(4) { animation: slideInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) 0.25s backwards; }
        .amenity-card:nth-child(5) { animation: slideInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) 0.3s backwards; }
        .amenity-card:nth-child(6) { animation: slideInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) 0.35s backwards; }
        .amenity-card:nth-child(n+7) { animation: slideInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) 0.4s backwards; }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .amenity-icon {
            position: relative;
            width: 108px;
            height: 108px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.12) 0%, rgba(118, 75, 162, 0.12) 100%);
            color: #667eea;
            font-size: 3rem;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1;
        }

        .amenity-icon::before {
            content: '';
            position: absolute;
            inset: -3px;
            background: var(--gradient-primary);
            border-radius: 50%;
            opacity: 0;
            transition: opacity 0.5s ease;
            z-index: -1;
        }

        .amenity-card:hover .amenity-icon {
            transform: scale(1.15) rotate(8deg);
            box-shadow: 0 16px 48px rgba(102, 126, 234, 0.35);
        }

        .amenity-card:hover .amenity-icon::before {
            opacity: 0.25;
        }

        .amenity-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .amenity-icon svg {
            filter: drop-shadow(0 4px 8px rgba(102, 126, 234, 0.25));
        }

        .amenity-name {
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -0.02em;
            transition: all 0.4s ease;
            position: relative;
            z-index: 1;
        }

        .amenity-card:hover .amenity-name {
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            transform: scale(1.05);
        }

        .amenity-description {
            font-size: 0.95rem;
            color: var(--text-secondary);
            line-height: 1.7;
            opacity: 0;
            max-height: 0;
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            z-index: 1;
            font-weight: 500;
        }

        .amenity-card:hover .amenity-description {
            opacity: 1;
            max-height: 120px;
        }

        /* Category-based colors */
        .amenity-card[data-category="comfort"] .amenity-icon {
            background: linear-gradient(135deg, rgba(240, 147, 251, 0.12) 0%, rgba(245, 87, 108, 0.12) 100%);
            color: #f093fb;
        }

        .amenity-card[data-category="comfort"]:hover .amenity-icon::before {
            background: var(--gradient-secondary);
        }

        .amenity-card[data-category="comfort"]:hover .amenity-name {
            background: var(--gradient-secondary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .amenity-card[data-category="technology"] .amenity-icon {
            background: linear-gradient(135deg, rgba(79, 172, 254, 0.12) 0%, rgba(0, 242, 254, 0.12) 100%);
            color: #4facfe;
        }

        .amenity-card[data-category="technology"]:hover .amenity-icon::before {
            background: var(--gradient-accent);
        }

        .amenity-card[data-category="technology"]:hover .amenity-name {
            background: var(--gradient-accent);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .amenity-card[data-category="luxury"] .amenity-icon {
            background: linear-gradient(135deg, rgba(247, 151, 30, 0.12) 0%, rgba(255, 210, 0, 0.12) 100%);
            color: #f7971e;
        }

        .amenity-card[data-category="luxury"]:hover .amenity-icon::before {
            background: var(--gradient-gold);
        }

        .amenity-card[data-category="luxury"]:hover .amenity-name {
            background: var(--gradient-gold);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Empty State */
        .amenities-empty {
            max-width: 720px;
            margin: 5rem auto;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.85) 100%);
            backdrop-filter: blur(20px);
            border-radius: 36px;
            padding: 5rem 3.5rem;
            text-align: center;
            box-shadow: 0 24px 64px rgba(102, 126, 234, 0.15);
            position: relative;
            overflow: hidden;
            border: 2px solid rgba(102, 126, 234, 0.15);
        }

        .amenities-empty::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: var(--gradient-primary);
        }

        .amenities-empty h2 {
            margin-bottom: 1.5rem;
            font-size: 2.5rem;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 900;
            letter-spacing: -0.02em;
        }

        .amenities-empty p {
            color: var(--text-secondary);
            line-height: 1.9;
            font-size: 1.125rem;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .amenities-grid {
                grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
                gap: 2rem;
            }
        }

        @media (max-width: 768px) {
            body::before,
            body::after {
                width: 400px;
                height: 400px;
            }

            .amenities-hero {
                margin: 4rem auto 3.5rem;
                padding: 0 1.5rem;
                gap: 1.5rem;
            }

            .amenities-hero h1 {
                font-size: 2.5rem;
            }

            .amenities-hero p {
                font-size: 1.05rem;
            }

            .amenities-container {
                padding: 0 1.5rem;
            }

            .amenities-stats {
                grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
                gap: 1.5rem;
                margin-bottom: 4rem;
            }

            .stat-card {
                padding: 2rem 1.5rem;
                border-radius: 20px;
            }

            .stat-number {
                font-size: 2.5rem;
            }

            .stat-label {
                font-size: 0.9rem;
            }

            .amenities-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
                padding-bottom: 3rem;
            }

            .amenity-card {
                padding: 2.5rem 2rem;
                border-radius: 24px;
            }

            .amenity-icon {
                width: 96px;
                height: 96px;
                font-size: 2.5rem;
            }

            .amenity-name {
                font-size: 1.25rem;
            }

            .amenities-empty {
                margin: 4rem auto;
                padding: 4rem 2.5rem;
                border-radius: 28px;
            }

            .amenities-empty h2 {
                font-size: 2rem;
            }

            .amenities-empty p {
                font-size: 1.05rem;
            }
        }

        @media (max-width: 480px) {
            .amenities-hero {
                margin: 3rem auto 3rem;
            }

            .badge {
                font-size: 0.8125rem;
                padding: 0.625rem 1.5rem;
            }

            .amenities-hero h1 {
                font-size: 2rem;
            }

            .amenities-stats {
                grid-template-columns: 1fr;
            }

            .amenity-card {
                padding: 2rem 1.5rem;
            }

            .amenities-empty {
                padding: 3rem 2rem;
            }
        }
    </style>
@endpush

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
    

    <div class="amenities-container">
        @if($amenities->isNotEmpty())
            <br>
            <br>

            <section class="amenities-grid">
                @foreach($amenities as $amenity)
                    @php
                        $icon = $amenity['icon'];
                        $treatAsImage = $icon && (filter_var($icon, FILTER_VALIDATE_URL) || Str::contains($icon, ['/','\\','.png','.jpg','.jpeg','.svg']));
                        
                        $category = 'comfort';
                        if(Str::contains(strtolower($amenity['name']), ['wifi', 'tv', 'smart', 'tech'])) {
                            $category = 'technology';
                        } elseif(Str::contains(strtolower($amenity['name']), ['spa', 'pool', 'vip', 'premium', 'suite'])) {
                            $category = 'luxury';
                        }
                    @endphp
                    <a class="amenity-card"
                       data-category="{{ $category }}"
                       href="{{ route('website.amenities.show', $amenity['id']) }}"
                       aria-label="{{ __('website.amenities.card_aria', ['name' => $amenity['name']]) }}">
                        <div class="amenity-icon">
                            @if($treatAsImage)
                                <img src="{{ $icon }}" alt="{{ $amenity['name'] }} icon">
                            @elseif(!empty($icon))
                                <span>{{ $icon }}</span>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="54" height="54" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            @endif
                        </div>
                        <div class="amenity-name">{{ $amenity['name'] }}</div>
                        <div class="amenity-description">
                            {{ __('website.amenities.card_helper') }}
                        </div>
                    </a>
                @endforeach
            </section>
        @else
            <div class="amenities-empty">
                <h2>{{ __('website.amenities.empty_title') }}</h2>
                <p>
                    {{ __('website.amenities.empty_description') }}
                </p>
            </div>
        @endif
    </div>
@endsection