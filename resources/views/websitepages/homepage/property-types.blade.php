@push('styles')
    <style>
        /* Premium Property Types - Horizontal Scroll Carousel */
        .property-types-section {
            background: var(--surface-dim);
            padding: 40px clamp(24px, 6vw, 48px);
        }

        .property-types-section .section-header {
            margin-bottom: 32px;
        }

        .property-types-section .section-title {
            margin-bottom: 8px;
        }

        .property-types-section .section-subtitle {
            max-width: 680px;
            margin: 0 auto;
        }

        .hppt-carousel-wrapper {
            position: relative;
            margin: 0;
            padding: 1rem 0;
        }

        .hppt-carousel-container {
            display: flex;
            gap: 1.5rem;
            overflow-x: auto;
            scroll-behavior: smooth;
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            padding: 0 0 1rem;
            scroll-padding: 0 2rem;
        }

        .hppt-carousel-container::-webkit-scrollbar {
            display: none;
        }

        .hppt-property-card {
            flex: 0 0 auto;
            width: clamp(200px, calc((100vw - 160px) / 5), 260px);
            scroll-snap-align: start;
            background: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(15, 23, 42, 0.08);
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            position: relative;
            display: flex;
            flex-direction: column;
            text-decoration: none;
            color: inherit;
        }

        .hppt-property-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 0%, rgba(15, 23, 42, 0.02) 100%);
            opacity: 0;
            transition: opacity 0.4s ease;
            z-index: 1;
            pointer-events: none;
        }

        .hppt-property-card:hover::before {
            opacity: 1;
        }

        .hppt-property-card:hover {
            transform: translateY(-12px) scale(1.02);
            box-shadow: 0 24px 56px rgba(15, 23, 42, 0.16);
        }

        .hppt-property-image-wrapper {
            position: relative;
            width: 100%;
            height: 180px;
            overflow: hidden;
            background: linear-gradient(135deg, rgba(43, 112, 247, 0.12) 0%, rgba(178, 86, 13, 0.12) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hppt-property-initial {
            font-size: 3rem;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.03em;
        }

        .hppt-property-content {
            padding: 1.75rem;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            background: #ffffff;
            position: relative;
            z-index: 2;
            flex: 1;
        }

        .hppt-property-title {
            font-size: 1.375rem;
            font-weight: 700;
            color: var(--text-dark, #1e293b);
            margin: 0;
            letter-spacing: -0.02em;
            transition: color 0.3s ease;
        }

        .hppt-property-card:hover .hppt-property-title {
            color: var(--primary, #6366f1);
        }

        .hppt-property-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 0.75rem;
            margin-top: 0.5rem;
            border-top: 1px solid rgba(15, 23, 42, 0.06);
        }

        .hppt-property-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--primary, #6366f1);
            transition: gap 0.3s ease;
        }

        .hppt-property-card:hover .hppt-property-link {
            gap: 0.75rem;
        }

        .hppt-property-link-icon {
            width: 16px;
            height: 16px;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hppt-property-card:hover .hppt-property-link-icon {
            transform: translateX(4px);
        }

        /* Scroll Navigation Buttons - Positioned on Sides */
        .hppt-nav-buttons {
            position: absolute;
            top: 50%;
            left: 4vw;
            right: 4vw;
            transform: translateY(-50%);
            display: flex;
            justify-content: space-between;
            pointer-events: none;
            z-index: 10;
        }

        .hppt-nav-btn {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(99, 102, 241, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.12);
            pointer-events: auto;
        }

        .hppt-nav-btn:hover {
            background: var(--primary, #6366f1);
            border-color: var(--primary, #6366f1);
            transform: scale(1.15);
            box-shadow: 0 12px 32px rgba(99, 102, 241, 0.35);
        }

        .hppt-nav-btn:hover svg {
            color: #ffffff;
        }

        .hppt-nav-btn svg {
            width: 22px;
            height: 22px;
            color: var(--primary, #6366f1);
            transition: color 0.3s ease;
        }

        .hppt-nav-btn:disabled {
            opacity: 0.3;
            cursor: not-allowed;
            pointer-events: none;
        }

        /* Scroll Indicators */
        .hppt-scroll-indicator {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 1.5rem;
        }

        .hppt-scroll-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: rgba(99, 102, 241, 0.2);
            transition: all 0.3s ease;
        }

        .hppt-scroll-dot.active {
            background: var(--primary, #6366f1);
            width: 24px;
            border-radius: 4px;
        }

        /* Enhanced Responsive Design */
        @media (max-width: 1024px) {
            .hppt-property-card {
                width: clamp(200px, calc((100vw - 180px) / 4), 240px);
            }

            .hppt-property-image-wrapper {
                height: 160px;
            }

            .hppt-property-title {
                font-size: 1.25rem;
            }

            .hppt-carousel-container {
                padding: 0 2vw 1rem 2vw;
            }

            .hppt-nav-buttons {
                left: 2vw;
                right: 2vw;
            }
        }

        @media (max-width: 768px) {
            .hppt-carousel-wrapper {
                margin: 0;
            }

            .hppt-carousel-container {
                gap: 1rem;
                padding: 0 1rem 0.5rem 1rem;
            }

            .hppt-property-card {
                width: clamp(220px, calc((100vw - 140px) / 2), 260px);
            }

            .hppt-property-image-wrapper {
                height: 150px;
            }

            .hppt-property-content {
                padding: 1.5rem;
            }

            .hppt-property-title {
                font-size: 1.125rem;
            }

            .hppt-property-description {
                font-size: 0.875rem;
            }

            .hppt-nav-buttons {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .hppt-property-card {
                width: 220px;
            }

            .hppt-property-image-wrapper {
                height: 140px;
            }

            .hppt-property-content {
                padding: 1.25rem;
                gap: 0.5rem;
            }

            .hppt-property-title {
                font-size: 1rem;
            }

            .hppt-property-description {
                font-size: 0.8125rem;
            }

            .hppt-property-badge {
                font-size: 0.6875rem;
                padding: 0.375rem 0.75rem;
            }
        }

        /* Smooth Animations */
        .hppt-property-card {
            animation: hppt-slide-in 0.6s ease forwards;
            opacity: 0;
        }

        @keyframes hppt-slide-in {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .hppt-property-card:nth-child(1) { animation-delay: 0.1s; }
        .hppt-property-card:nth-child(2) { animation-delay: 0.2s; }
        .hppt-property-card:nth-child(3) { animation-delay: 0.3s; }
        .hppt-property-card:nth-child(4) { animation-delay: 0.4s; }
        .hppt-property-card:nth-child(n+5) { animation-delay: 0.5s; }

        /* Accessibility */
        @media (prefers-reduced-motion: reduce) {
            .hppt-property-card,
            .hppt-property-image {
                animation: none;
                transition: none;
            }
        }
    </style>
@endpush

<!-- Premium Property Types Section -->
@if(isset($propertyTypes) && $propertyTypes->isNotEmpty())
    <section class="section property-types-section">
        <div class="section-header">
            <h2 class="section-title">BnB Category</h2>
            <p class="section-subtitle">
                Discover a stay style that mirrors your mood—from boutique motels to design-led apartments and coastal resorts.
            </p>
        </div>
        
        <div class="hppt-carousel-wrapper">
            <!-- Navigation Buttons - Side Positioned -->
            <div class="hppt-nav-buttons">
                <button class="hppt-nav-btn" id="hpptPrevBtn" aria-label="Previous property types">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button class="hppt-nav-btn" id="hpptNextBtn" aria-label="Next property types">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>

            <div class="hppt-carousel-container" id="hpptCarousel">
                @foreach($propertyTypes as $index => $propertyType)
                    @php
                        $initial = mb_strtoupper(mb_substr($propertyType['name'], 0, 1));
                    @endphp
                    <a class="hppt-property-card"
                       href="{{ route('website.motels.index', ['motel_type' => $propertyType['id']]) }}"
                       aria-label="Explore {{ $propertyType['name'] }} stays">
                        <div class="hppt-property-image-wrapper">
                            <span class="hppt-property-initial">{{ $initial }}</span>
                        </div>
                        <div class="hppt-property-content">
                            <h4 class="hppt-property-title">{{ $propertyType['name'] }}</h4>
                            <div class="hppt-property-footer">
                                <span class="hppt-property-link">
                                    Explore stays
                                    <svg
                                        class="hppt-property-link-icon"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2.5"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M13 7l5 5m0 0l-5 5m5-5H6"
                                        />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="hppt-scroll-indicator" id="hpptScrollIndicator"></div>
    </section>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const carousel = document.getElementById('hpptCarousel');
                const prevBtn = document.getElementById('hpptPrevBtn');
                const nextBtn = document.getElementById('hpptNextBtn');
                const indicator = document.getElementById('hpptScrollIndicator');
                
                if (!carousel) return;

                const cards = carousel.querySelectorAll('.hppt-property-card');
                const cardCount = cards.length;
                
                // Create scroll indicators
                for (let i = 0; i < cardCount; i++) {
                    const dot = document.createElement('div');
                    dot.className = 'hppt-scroll-dot';
                    if (i === 0) dot.classList.add('active');
                    indicator.appendChild(dot);
                }

                const dots = indicator.querySelectorAll('.hppt-scroll-dot');

                // Update active indicator
                function updateIndicator() {
                    const scrollLeft = carousel.scrollLeft;
                    const cardWidth = cards[0].offsetWidth + 24; // card width + gap
                    const activeIndex = Math.round(scrollLeft / cardWidth);
                    
                    dots.forEach((dot, index) => {
                        dot.classList.toggle('active', index === activeIndex);
                    });
                }

                // Navigation
                prevBtn.addEventListener('click', () => {
                    carousel.scrollBy({ left: -360, behavior: 'smooth' });
                });

                nextBtn.addEventListener('click', () => {
                    carousel.scrollBy({ left: 360, behavior: 'smooth' });
                });

                carousel.addEventListener('scroll', updateIndicator);
            });
        </script>
    @endpush
@endif