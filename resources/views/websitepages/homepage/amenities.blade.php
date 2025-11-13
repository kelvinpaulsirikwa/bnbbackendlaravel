@push('styles')
    <style>
        /* Premium Amenities - Dynamic Grid */
        .hpa-amenities-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1.75rem;
            padding: 1rem 0;
        }

        .hpa-amenity-item {
            background: linear-gradient(135deg, #ffffff 0%, #fafbff 100%);
            border-radius: 24px;
            padding: 2.25rem 1.75rem;
            text-align: center;
            box-shadow: 0 4px 16px rgba(15, 23, 42, 0.06);
            border: 2px solid transparent;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.25rem;
            position: relative;
            overflow: hidden;
        }

        .hpa-amenity-item::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.08) 0%, transparent 70%);
            transform: scale(0);
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 0;
        }

        .hpa-amenity-item:hover::before {
            transform: scale(1);
        }

        .hpa-amenity-item:hover {
            transform: translateY(-12px) scale(1.02);
            box-shadow: 0 20px 48px rgba(99, 102, 241, 0.15);
            border-color: rgba(99, 102, 241, 0.3);
            background: linear-gradient(135deg, #ffffff 0%, #f0f4ff 100%);
        }

        .hpa-amenity-icon-wrapper {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: #ffffff;
            font-size: 2.25rem;
            box-shadow: 0 12px 28px rgba(99, 102, 241, 0.3);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            z-index: 1;
        }

        .hpa-amenity-item:hover .hpa-amenity-icon-wrapper {
            transform: rotate(360deg) scale(1.1);
            box-shadow: 0 16px 40px rgba(99, 102, 241, 0.4);
        }

        .hpa-amenity-icon-wrapper::after {
            content: '';
            position: absolute;
            inset: -8px;
            border-radius: 50%;
            border: 2px solid rgba(99, 102, 241, 0.2);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .hpa-amenity-item:hover .hpa-amenity-icon-wrapper::after {
            opacity: 1;
            animation: hpa-pulse 2s infinite;
        }

        @keyframes hpa-pulse {
            0%, 100% {
                transform: scale(1);
                opacity: 0.5;
            }
            50% {
                transform: scale(1.1);
                opacity: 0.8;
            }
        }

        .hpa-amenity-icon-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .hpa-amenity-icon-wrapper svg {
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hpa-amenity-item:hover .hpa-amenity-icon-wrapper svg {
            transform: scale(1.2);
        }

        .hpa-amenity-label {
            font-weight: 700;
            color: var(--text-dark, #1e293b);
            font-size: 1.0625rem;
            letter-spacing: -0.01em;
            position: relative;
            z-index: 1;
            transition: color 0.3s ease;
        }

        .hpa-amenity-item:hover .hpa-amenity-label {
            color: var(--primary, #4f46e5);
        }

        .hpa-amenities-cta {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 3.5rem;
            padding-top: 2.5rem;
            border-top: 2px solid rgba(99, 102, 241, 0.1);
        }

        .hpa-amenities-link {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem 2.5rem;
            font-size: 1.0625rem;
            font-weight: 700;
            color: #ffffff;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            border: none;
            border-radius: 16px;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            box-shadow: 0 8px 24px rgba(99, 102, 241, 0.3);
            position: relative;
            overflow: hidden;
        }

        .hpa-amenities-link::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .hpa-amenities-link:hover::before {
            opacity: 1;
        }

        .hpa-amenities-link:hover {
            transform: translateY(-4px) scale(1.05);
            box-shadow: 0 16px 40px rgba(99, 102, 241, 0.4);
        }

        .hpa-amenities-link-text {
            position: relative;
            z-index: 1;
        }

        .hpa-amenities-link-icon {
            width: 20px;
            height: 20px;
            position: relative;
            z-index: 1;
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hpa-amenities-link:hover .hpa-amenities-link-icon {
            transform: translateX(6px);
        }

        .hpa-amenities-inline-link {
            color: var(--primary, #6366f1);
            text-decoration: none;
            font-weight: 600;
            position: relative;
            transition: color 0.3s ease;
        }

        .hpa-amenities-inline-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.3s ease;
        }

        .hpa-amenities-inline-link:hover {
            color: var(--primary-dark, #4f46e5);
        }

        .hpa-amenities-inline-link:hover::after {
            transform: scaleX(1);
            transform-origin: left;
        }

        /* Staggered Animation on Load */
        .hpa-amenity-item {
            animation: hpa-fade-in 0.6s ease forwards;
            opacity: 0;
        }

        @keyframes hpa-fade-in {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hpa-amenity-item:nth-child(1) { animation-delay: 0.1s; }
        .hpa-amenity-item:nth-child(2) { animation-delay: 0.2s; }
        .hpa-amenity-item:nth-child(3) { animation-delay: 0.3s; }
        .hpa-amenity-item:nth-child(4) { animation-delay: 0.4s; }
        .hpa-amenity-item:nth-child(5) { animation-delay: 0.5s; }
        .hpa-amenity-item:nth-child(6) { animation-delay: 0.6s; }
        .hpa-amenity-item:nth-child(n+7) { animation-delay: 0.7s; }

        /* Enhanced Responsive Design */
        @media (max-width: 1200px) {
            .hpa-amenities-container {
                grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
                gap: 1.5rem;
            }

            .hpa-amenity-icon-wrapper {
                width: 80px;
                height: 80px;
                font-size: 2rem;
            }
        }

        @media (max-width: 768px) {
            .hpa-amenities-container {
                grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
                gap: 1.25rem;
            }

            .hpa-amenity-item {
                padding: 1.75rem 1.25rem;
                gap: 1rem;
            }

            .hpa-amenity-icon-wrapper {
                width: 70px;
                height: 70px;
                font-size: 1.75rem;
            }

            .hpa-amenity-label {
                font-size: 0.9375rem;
            }

            .hpa-amenities-cta {
                margin-top: 2.5rem;
                padding-top: 2rem;
            }

            .hpa-amenities-link {
                padding: 0.875rem 2rem;
                font-size: 1rem;
            }
        }

        @media (max-width: 480px) {
            .hpa-amenities-container {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }

            .hpa-amenity-item {
                padding: 1.5rem 1rem;
                border-radius: 20px;
            }

            .hpa-amenity-icon-wrapper {
                width: 64px;
                height: 64px;
                font-size: 1.5rem;
            }

            .hpa-amenity-label {
                font-size: 0.875rem;
            }

            .hpa-amenities-link {
                width: 100%;
                justify-content: center;
                padding: 1rem 1.5rem;
            }

            .hpa-amenities-cta {
                display: none;
            }
        }

        /* Accessibility */
        @media (prefers-reduced-motion: reduce) {
            .hpa-amenity-item,
            .hpa-amenity-icon-wrapper,
            .hpa-amenities-link {
                animation: none;
                transition: none;
            }
        }
    </style>
@endpush

<!-- Premium Amenities Section -->
@if(isset($featuredAmenities) && $featuredAmenities->isNotEmpty())
    <section class="section">
        <div class="section-header">
            <h2 class="section-title">World-Class Amenities</h2>
            <p class="section-subtitle">
                Signature comforts and thoughtful touches available across our curated selection of motels. 
                <a class="hpa-amenities-inline-link" href="{{ route('website.amenities') }}">View all amenities</a> 
                to discover more.
            </p>
        </div>
        
        <div class="hpa-amenities-container">
            @foreach($featuredAmenities as $amenity)
                <article class="hpa-amenity-item">
                    <div class="hpa-amenity-icon-wrapper">
                        @if($amenity['icon_is_image'] ?? false)
                            <img src="{{ $amenity['icon'] }}" alt="{{ $amenity['name'] }} icon">
                        @elseif(!empty($amenity['icon']))
                            <span>{{ $amenity['icon'] }}</span>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="16" cy="16" r="14"/>
                                <path d="m11 16 3 3 7-7"/>
                            </svg>
                        @endif
                    </div>
                    <div class="hpa-amenity-label">{{ $amenity['name'] }}</div>
                </article>
            @endforeach
        </div>
     
    </section>
@endif