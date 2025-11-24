@php
    $propertyTypeCards = collect($propertyTypes ?? [])->take(6);
@endphp

@push('styles')
    <style>
        .property-types-smart {
            background: #ffffff;
            padding: clamp(3rem, 6vw, 5rem) clamp(1.5rem, 6vw, 4rem);
        }

        .pts-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 2.5rem;
        }

        .pts-headline {
            display: grid;
            grid-template-columns: minmax(0, 2fr) minmax(0, 1fr);
            gap: 2rem;
            align-items: center;
        }

        .pts-pretitle {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.5rem 1.25rem;
            background: rgba(37, 99, 235, 0.1);
            color: #2563eb;
            font-weight: 600;
            border-radius: 999px;
            font-size: 0.85rem;
            letter-spacing: 0.05em;
            width: fit-content;
            margin-bottom: 1rem;
        }

        .pts-title {
            font-size: clamp(2.2rem, 4vw, 3rem);
            font-weight: 800;
            color: #091226;
            letter-spacing: -0.02em;
            margin-bottom: 1rem;
        }

        .pts-description {
            font-size: 1.1rem;
            color: #334155;
            line-height: 1.7;
            max-width: 640px;
        }

        .pts-actions {
            justify-self: end;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .pts-action-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.9rem 1.75rem;
            border-radius: 999px;
            font-weight: 600;
            border: 1px solid rgba(15, 23, 42, 0.15);
            color: #0f172a;
            text-decoration: none;
            background: #ffffff;
            transition: all 0.3s ease;
            width: fit-content;
        }

        .pts-action-btn.primary {
            background: #0f62fe;
            color: #ffffff;
            border-color: #0f62fe;
            box-shadow: 0 15px 30px rgba(15, 98, 254, 0.25);
        }

        .pts-action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(15, 23, 42, 0.15);
        }

        .pts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
        }

        .pts-card {
            background: #f4f6fb;
            border-radius: 24px;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            box-shadow: 0 10px 28px rgba(9, 18, 38, 0.08);
            text-decoration: none;
            color: inherit;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(15, 23, 42, 0.12);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .pts-card.featured {
            grid-column: span 2;
            background: radial-gradient(circle at 15% 20%, rgba(46, 106, 174, 0.35), rgba(8, 15, 32, 0.9));
            color: #edf0ff;
            border: none;
            box-shadow: 0 20px 45px rgba(20, 24, 75, 0.25);
        }

        .pts-card::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.04), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .pts-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 60px rgba(15, 23, 42, 0.15);
        }

        .pts-card:hover::after {
            opacity: 1;
        }

        .pts-card-icon {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(15, 23, 42, 0.1);
            color: #0f172a;
            font-weight: 700;
            font-size: 1.3rem;
        }

        .pts-card.featured .pts-card-icon {
            background: rgba(255, 255, 255, 0.15);
            color: #ffffff;
        }

        .pts-card-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin: 0;
            color: #111827;
        }

        .pts-card-desc {
            font-size: 0.95rem;
            color: #334155;
            line-height: 1.6;
        }

        .pts-card-cta {
            font-size: 0.9rem;
            font-weight: 600;
            color: #2563eb;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .pts-card.featured .pts-card-cta {
            color: #e0e6ff;
        }

        .pts-card-cta svg {
            width: 16px;
            height: 16px;
        }

        @media (max-width: 960px) {
            .pts-headline {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .pts-pretitle,
            .pts-description,
            .pts-actions {
                margin-left: auto;
                margin-right: auto;
            }

            .pts-actions {
                justify-self: center;
                align-items: center;
            }

            .pts-card.featured {
                grid-column: span 1;
            }
        }

        @media (max-width: 540px) {
            .pts-card {
                padding: 1.5rem;
            }

            .pts-card-title {
                font-size: 1.15rem;
            }
        }
    </style>
@endpush

@if($propertyTypeCards->isNotEmpty())
    <section class="property-types-smart">
        <div class="pts-inner">
            <div class="pts-headline">
                <div>
                    <span class="pts-pretitle">
                        ✦ {{ __('website.home_property_types.badge') ?: 'BnB Category' }}
                    </span>
                    <h2 class="pts-title">{{ __('website.home_property_types.title') }}</h2>
                    <p class="pts-description">
                        {{ __('website.home_property_types.subtitle') ?: 'Discover a stay style that mirrors your mood—from boutique motels to design-led apartments and coastal resorts.' }}
                    </p>
                </div>
                <div class="pts-actions">
                    <a href="{{ route('website.motels.index') }}" class="pts-action-btn primary">
                        {{ __('website.home_property_types.browse_all') ?: 'Browse All Stays' }}
                    </a>
                    <a href="{{ route('website.contact') }}" class="pts-action-btn">
                        {{ __('website.home_property_types.contact') ?: 'Need a recommendation?' }}
                    </a>
                </div>
            </div>

            <div class="pts-grid">
                @foreach($propertyTypeCards as $propertyType)
                    @php
                        $initial = mb_strtoupper(mb_substr($propertyType['name'], 0, 1));
                        $isFeatured = $loop->first;
                    @endphp
                    <a class="pts-card {{ $isFeatured ? 'featured' : '' }}"
                       href="{{ route('website.motels.index', ['motel_type' => $propertyType['id']]) }}">
                        <div class="pts-card-icon">{{ $initial }}</div>
                        <h4 class="pts-card-title">{{ $propertyType['name'] }}</h4>
                        <p class="pts-card-desc">
                            {{ $propertyType['description'] ?? __('website.home_property_types.default_desc', ['name' => $propertyType['name']]) ?? 'Thoughtfully curated stays with signature amenities and host support.' }}
                        </p>
                        <span class="pts-card-cta">
                            {{ __('website.home_property_types.cta') }}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endif