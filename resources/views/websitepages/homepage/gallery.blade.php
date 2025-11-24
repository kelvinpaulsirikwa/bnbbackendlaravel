@php
    $galleryItems = collect($featuredGallery ?? [])->take(5);
@endphp

@push('styles')
    <style>
        /* Enhanced Gallery - Premium Masonry Layout */
        .hpg-gallery-wrapper {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            grid-template-rows: repeat(2, minmax(200px, 1fr));
            grid-template-areas:
                "primary secondary tertiary"
                "primary quaternary quinary";
            grid-auto-rows: minmax(200px, 1fr);
            gap: 2px;
            padding: 0;
        }

        .hpg-gallery-section {
            position: relative;
            background: var(--surface-dim);
            margin: 0 auto;
            width: 100%;
            padding: 1.25rem 0 0.25rem;
            overflow: hidden;
        }

        .hpg-gallery-section::before,
        .hpg-gallery-section::after {
            content: '';
            position: absolute;
            left: 5%;
            right: 5%;
            height: 10px;
            background: repeating-linear-gradient(
                120deg,
                rgba(99, 102, 241, 0.25),
                rgba(99, 102, 241, 0.25) 12px,
                rgba(14, 165, 233, 0.18) 12px,
                rgba(14, 165, 233, 0.18) 24px
            );
            opacity: 0.6;
            filter: blur(6px);
            z-index: 0;
        }

        .hpg-gallery-section::before,
        .hpg-gallery-section::after {
            display: none;
        }

        .hpg-gallery-card {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(15, 23, 42, 0.08);
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background: #f8fafc;
            min-height: 100%;
        }

        .hpg-gallery-card:nth-child(1) { grid-area: primary; }
        .hpg-gallery-card:nth-child(2) { grid-area: secondary; }
        .hpg-gallery-card:nth-child(3) { grid-area: tertiary; }
        .hpg-gallery-card:nth-child(4) { grid-area: quaternary; }
        .hpg-gallery-card:nth-child(5) { grid-area: quinary; }

        .hpg-gallery-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(168, 85, 247, 0.1));
            opacity: 0;
            transition: opacity 0.4s ease;
            z-index: 1;
        }

        .hpg-gallery-card:hover::before {
            opacity: 1;
        }

        .hpg-gallery-card--featured {
            grid-row: span 2;
            grid-column: span 1;
        }

        .hpg-gallery-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.16);
        }

        .hpg-gallery-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.7s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hpg-gallery-card:hover .hpg-gallery-image {
            transform: scale(1.08);
        }

        .hpg-gallery-content {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                180deg, 
                rgba(15, 23, 42, 0) 0%, 
                rgba(15, 23, 42, 0.4) 50%,
                rgba(15, 23, 42, 0.95) 100%
            );
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 1.75rem;
            color: #ffffff;
            opacity: 0;
            transition: opacity 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 2;
        }

        .hpg-gallery-card:hover .hpg-gallery-content {
            opacity: 1;
        }

        .hpg-gallery-title {
            font-size: 1.375rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            margin: 0;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
            transform: translateY(10px);
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hpg-gallery-card:hover .hpg-gallery-title {
            transform: translateY(0);
        }

        .hpg-gallery-actions {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 3.5rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(15, 23, 42, 0.08);
        }

        .hpg-gallery-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.625rem;
            padding: 0.875rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            color: var(--primary, #4f46e5);
            background: transparent;
            border: 2px solid currentColor;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
        }

        .hpg-gallery-btn:hover {
            background: var(--primary, #4f46e5);
            color: #ffffff;
            transform: translateX(4px);
            box-shadow: 0 8px 24px rgba(79, 70, 229, 0.25);
        }

        .hpg-gallery-btn-icon {
            width: 18px;
            height: 18px;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hpg-gallery-btn:hover .hpg-gallery-btn-icon {
            transform: translateX(4px);
        }

        .hpg-gallery-btn--header {
            flex-shrink: 0;
        }

        .hpg-gallery-inline-link {
            color: var(--primary, #4f46e5);
            text-decoration: none;
            font-weight: 600;
            position: relative;
            transition: color 0.3s ease;
        }

        .hpg-gallery-inline-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2px;
            background: currentColor;
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.3s ease;
        }

        .hpg-gallery-inline-link:hover {
            color: var(--primary-dark, #4338ca);
        }

        .hpg-gallery-inline-link:hover::after {
            transform: scaleX(1);
            transform-origin: left;
        }

        /* Enhanced Responsive Design */
        @media (max-width: 1024px) {
            .hpg-gallery-wrapper {
                grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
                grid-auto-rows: 240px;
                grid-template-rows: none;
                grid-template-areas: none;
                gap: 1rem;
            }

            .hpg-gallery-card:nth-child(-n+5) {
                grid-area: auto;
            }

            .hpg-gallery-card--featured {
                grid-row: span 2;
            }

            .hpg-gallery-title {
                font-size: 1.25rem;
            }

            .section-header {
                flex-direction: column;
                align-items: flex-start !important;
            }

            .hpg-gallery-btn--header {
                align-self: stretch;
                justify-content: center;
            }

            .hpg-gallery-inline-link {
                display: inline-block;
                margin-top: 0.25rem;
            }
        }

        @media (max-width: 768px) {
            .hpg-gallery-wrapper {
                grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
                grid-auto-rows: 220px;
                gap: 0.875rem;
            }

            .hpg-gallery-card--featured {
                grid-row: span 1;
                grid-column: span 2;
            }

            .hpg-gallery-content {
                padding: 1.25rem;
            }

            .hpg-gallery-title {
                font-size: 1.125rem;
            }

            .hpg-gallery-actions {
                margin-top: 2.5rem;
                padding-top: 1.5rem;
            }

            .hpg-gallery-btn {
                padding: 0.75rem 1.5rem;
                font-size: 0.9375rem;
            }
        }

        @media (max-width: 480px) {
            .hpg-gallery-wrapper {
                grid-template-columns: 1fr;
                grid-auto-rows: 280px;
                gap: 1rem;
            }

            .hpg-gallery-card--featured {
                grid-row: span 1;
                grid-column: span 1;
            }

            .hpg-gallery-card {
                border-radius: 16px;
            }

            .hpg-gallery-content {
                padding: 1rem;
            }

            .hpg-gallery-title {
                font-size: 1rem;
            }

            .hpg-gallery-btn {
                width: 100%;
                justify-content: center;
                padding: 1rem;
            }

            .hpg-gallery-actions {
                display: none;
            }
        }

        /* Loading State */
        .hpg-gallery-card[data-loading] {
            background: linear-gradient(
                90deg,
                #f0f0f0 25%,
                #e0e0e0 50%,
                #f0f0f0 75%
            );
            background-size: 200% 100%;
            animation: hpg-loading 1.5s ease-in-out infinite;
        }

        @keyframes hpg-loading {
            0% {
                background-position: 200% 0;
            }
            100% {
                background-position: -200% 0;
            }
        }
    </style>
@endpush

<!-- Premium Gallery Section -->
@if($galleryItems->isNotEmpty())
    <section class="hpg-gallery-section">
        <div class="section-header">
            <h2 class="section-title">{{ __('website.home_gallery.title') }}</h2>
            <p class="section-subtitle">
                {!! __('website.home_gallery.subtitle_html', [
                    'link' => '<a class="hpg-gallery-inline-link" href="'.route('website.gallery').'">'.__('website.home_gallery.link_text').'</a>'
                ]) !!}
            </p>
        </div>
        
        <div class="hpg-gallery-wrapper">
            @foreach($galleryItems as $index => $featured)
                @php
                    $cardClass = 'hpg-gallery-card';
                    if ($index === 0) {
                        $cardClass .= ' hpg-gallery-card--featured';
                    }
                    $hasMotel = !empty($featured['motel_id']);
                @endphp
                @if($hasMotel)
                    <a class="{{ $cardClass }}"
                       href="{{ route('website.motels.show', $featured['motel_id']) }}"
                       aria-label="{{ __('website.home_gallery.card_aria', ['name' => $featured['motel_name']]) }}">
                @else
                    <div class="{{ $cardClass }}">
                @endif
                    <img 
                        class="hpg-gallery-image" 
                        src="{{ $featured['url'] }}" 
                        alt="{{ $featured['motel_name'] }}"
                        loading="lazy"
                    >
                    <div class="hpg-gallery-content">
                        <h3 class="hpg-gallery-title">{{ $featured['motel_name'] }}</h3>
                    </div>
                @if($hasMotel)
                    </a>
                @else
                    </div>
                @endif
            @endforeach
        </div>
        
      
    </section>
@endif