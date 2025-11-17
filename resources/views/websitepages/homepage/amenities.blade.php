@push('styles')
    <style>
        :root {
            --uas-primary: #6366f1;
            --uas-primary-dark: #4f46e5;
            --uas-secondary: #8b5cf6;
            --uas-text-dark: #1e293b;
            --uas-text-light: #64748b;
            --uas-text-muted: #94a3b8;
            --uas-bg-light: #f8fafc;
            --uas-bg-white: #ffffff;
            --uas-border: #e2e8f0;
            --uas-shadow-sm: 0 1px 3px rgba(15, 23, 42, 0.08);
            --uas-shadow-md: 0 4px 12px rgba(15, 23, 42, 0.1);
            --uas-shadow-hover: 0 8px 24px rgba(15, 23, 42, 0.12);
        }

        /* Main Container */
        .uas-amenities-section {
            max-width: 1400px;
            margin: 0 auto;
            padding: 5rem 2rem;
            background: var(--uas-bg-light);
        }

        /* Section Header */
        .uas-section-header {
            text-align: center;
            max-width: 800px;
            margin: 0 auto 4rem;
        }

        .uas-section-title {
            font-size: clamp(2rem, 4vw, 2.75rem);
            font-weight: 800;
            color: var(--uas-text-dark);
            margin: 0 0 1rem 0;
            letter-spacing: -0.025em;
            line-height: 1.2;
        }

        .uas-section-subtitle {
            font-size: clamp(1rem, 2vw, 1.125rem);
            color: var(--uas-text-light);
            line-height: 1.7;
            margin: 0;
        }

        /* Grid Layout - 4 columns */
        .uas-amenities-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        /* Card Design */
        .uas-amenity-card {
            background: var(--uas-bg-white);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--uas-shadow-sm);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            position: relative;
        }

        .uas-amenity-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--uas-shadow-hover);
        }

        /* Card Number Badge */
        .uas-card-number {
            position: absolute;
            top: 1.5rem;
            left: 1.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--uas-text-muted);
            background: var(--uas-bg-white);
            padding: 0.375rem 0.75rem;
            border-radius: 8px;
            z-index: 2;
            box-shadow: var(--uas-shadow-sm);
        }

        /* Image Container */
        .uas-image-container {
            width: 100%;
            height: 240px;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #f0f4ff, #e8eeff);
        }

        .uas-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .uas-amenity-card:hover .uas-image-container img {
            transform: scale(1.08);
        }

        /* Fallback Icon for no image */
        .uas-fallback-icon {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            color: var(--uas-primary);
            background: linear-gradient(135deg, #f0f4ff, #e8eeff);
        }

        /* Card Content */
        .uas-card-content {
            padding: 2rem 1.5rem;
        }

        .uas-amenity-name {
            font-size: 1.375rem;
            font-weight: 700;
            color: var(--uas-text-dark);
            margin: 0 0 0.75rem 0;
            letter-spacing: -0.02em;
            line-height: 1.3;
        }

        .uas-amenity-description {
            font-size: 0.9375rem;
            color: var(--uas-text-light);
            line-height: 1.6;
            margin: 0;
        }

        /* CTA Section */
        .uas-cta-section {
            text-align: center;
            padding-top: 2.5rem;
        }

        .uas-cta-button {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem 2.5rem;
            font-size: 1.0625rem;
            font-weight: 700;
            color: #ffffff;
            background: linear-gradient(135deg, var(--uas-primary), var(--uas-secondary));
            border: none;
            border-radius: 12px;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .uas-cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
        }

        .uas-cta-icon {
            width: 20px;
            height: 20px;
            transition: transform 0.3s ease;
        }

        .uas-cta-button:hover .uas-cta-icon {
            transform: translateX(4px);
        }

        /* Inline Link */
        .uas-inline-link {
            color: var(--uas-primary);
            text-decoration: none;
            font-weight: 700;
            border-bottom: 2px solid transparent;
            transition: border-color 0.3s ease;
        }

        .uas-inline-link:hover {
            border-bottom-color: var(--uas-primary);
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .uas-amenities-grid {
                grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
                gap: 1.75rem;
            }
        }

        @media (max-width: 768px) {
            .uas-amenities-section {
                padding: 4rem 1.5rem;
            }

            .uas-amenities-grid {
                grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
                gap: 1.5rem;
            }

            .uas-image-container {
                height: 200px;
            }

            .uas-card-content {
                padding: 1.5rem 1.25rem;
            }

            .uas-amenity-name {
                font-size: 1.25rem;
            }
        }

        @media (max-width: 640px) {
            .uas-amenities-section {
                padding: 3rem 1rem;
            }

            .uas-section-header {
                margin-bottom: 2.5rem;
            }

            .uas-amenities-grid {
                grid-template-columns: 1fr;
                gap: 1.25rem;
            }

            .uas-image-container {
                height: 180px;
            }

            .uas-card-number {
                top: 1rem;
                left: 1rem;
                font-size: 0.8125rem;
                padding: 0.25rem 0.625rem;
            }

            .uas-card-content {
                padding: 1.25rem 1rem;
            }

            .uas-amenity-name {
                font-size: 1.125rem;
            }

            .uas-amenity-description {
                font-size: 0.875rem;
            }

            .uas-cta-button {
                width: 100%;
                justify-content: center;
                padding: 0.875rem 2rem;
                font-size: 1rem;
            }
        }

        /* Dark Mode Support */
        @media (prefers-color-scheme: dark) {
            :root {
                --uas-text-dark: #f1f5f9;
                --uas-text-light: #cbd5e1;
                --uas-text-muted: #94a3b8;
                --uas-bg-light: #0f172a;
                --uas-bg-white: #1e293b;
                --uas-border: #334155;
                --uas-shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.3);
                --uas-shadow-md: 0 4px 12px rgba(0, 0, 0, 0.4);
                --uas-shadow-hover: 0 8px 24px rgba(0, 0, 0, 0.5);
            }

            .uas-fallback-icon {
                background: linear-gradient(135deg, #1e293b, #334155);
            }
        }

        /* Reduced Motion */
        @media (prefers-reduced-motion: reduce) {
            .uas-amenity-card,
            .uas-amenity-card:hover,
            .uas-image-container img,
            .uas-cta-button,
            .uas-cta-icon,
            .uas-inline-link {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        /* Print Styles */
        @media print {
            .uas-cta-section {
                display: none;
            }

            .uas-amenity-card {
                break-inside: avoid;
                box-shadow: none;
                border: 1px solid var(--uas-border);
            }
        }
    </style>
@endpush

<!-- Premium Amenities Section -->
@if(isset($featuredAmenities) && $featuredAmenities->isNotEmpty())
    <section class="uas-amenities-section" aria-labelledby="uas-amenities-title">
        <!-- Header -->

        <h2 id="uas-amenities-title" 
    style="text-align:center; font-size:2.2rem; font-weight:800; margin-bottom:12px; 
           color:#1e3a8a; letter-spacing:1px;">
    What We Offer
</h2>

<p style="text-align:center; font-size:1.1rem; line-height:1.7; 
          color:#475569; max-width:750px; margin:0 auto 25px; font-weight:500;">
    Signature comforts and thoughtful touches available across our curated selection of motels. 
    <a href="{{ route('website.amenities') }}" 
       style="color:#dc2626; font-weight:700; text-decoration:none; border-bottom:2px solid #dc2626;">
        View all amenities
    </a> 
    to discover more.
</p>

<br>
       
        
        <!-- Amenities Grid -->
        <div class="uas-amenities-grid" role="list">
            @foreach($featuredAmenities as $index => $amenity)
                <article class="uas-amenity-card" role="listitem">
                    <!-- Card Number Badge -->
                    <div class="uas-card-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
                    
                    <!-- Image Container -->
                    <div class="uas-image-container">
                        @if($amenity['icon_is_image'] ?? false)
                            <img src="{{ $amenity['icon'] }}" alt="{{ $amenity['name'] }}" loading="lazy">
                        @elseif(!empty($amenity['icon']) && !($amenity['icon_is_image'] ?? false))
                            <div class="uas-fallback-icon" aria-hidden="true">
                                <span>{{ $amenity['icon'] }}</span>
                            </div>
                        @else
                            <div class="uas-fallback-icon" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"/>
                                    <path d="m9 12 2 2 4-4"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Card Content -->
                    <div class="uas-card-content">
                        <h3 class="uas-amenity-name">{{ $amenity['name'] }}</h3>
                        @if(!empty($amenity['description']))
                            <p class="uas-amenity-description">{{ $amenity['description'] }}</p>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    </section>
@endif