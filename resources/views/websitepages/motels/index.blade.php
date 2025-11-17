@extends('websitepages.layouts.app')

@section('title', 'Motels | Discover Stays with bnbStay')
@section('meta_description', 'Browse the curated bnbStay collection of motels featuring premium amenities, thoughtful service, and memorable guest experiences.')

@push('styles')
    <style>
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.35rem 0.85rem;
            border-radius: 999px;
            background: rgba(43, 112, 247, 0.1);
            color: var(--primary);
            font-size: 0.9rem;
            font-weight: 600;
        }

        .motels-hero {
            max-width: 960px;
            margin: 4rem auto 3rem;
            text-align: center;
            display: grid;
            gap: 1rem;
        }

        .motels-hero h1 {
            margin: 0;
            font-size: clamp(2.4rem, 4vw, 3.2rem);
        }

        .motels-hero p {
            margin: 0 auto;
            max-width: 660px;
            color: var(--text-muted);
            line-height: 1.75;
        }

        .motels-grid {
            max-width: 1240px;
            margin: 0 auto;
            display: grid;
            gap: 1.5rem;
            grid-template-columns: repeat(6, minmax(0, 1fr));
        }

        .motels-card {
            background: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 24px 48px rgba(16, 36, 74, 0.14);
            display: flex;
            flex-direction: column;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .motels-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 30px 55px rgba(16, 36, 74, 0.18);
        }

        .motels-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .motels-body {
            padding: 1.9rem;
            display: grid;
            gap: 0.9rem;
            flex: 1;
        }

        .motels-title {
            margin: 0;
            font-size: 1.35rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .motels-type {
            margin: 0;
            font-size: 0.95rem;
            color: var(--primary);
            font-weight: 600;
            letter-spacing: 0.02em;
        }

        .motels-description {
            margin: 0;
            color: var(--text-muted);
            line-height: 1.65;
        }

        .motels-features {
            display: grid;
            gap: 0.35rem;
            font-size: 0.95rem;
            color: var(--text-dark);
        }

        .motels-features span::before {
            content: '✔';
            margin-right: 0.45rem;
            color: var(--accent);
            font-weight: 600;
        }

        .motels-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.9rem 1.9rem;
        }

        .motels-price {
            font-size: 1.25rem;
            font-weight: 700;
            color: #b2560d;
        }

        .motels-price span {
            font-size: 0.9rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .motels-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.7rem 1.4rem;
            border-radius: 999px;
            background: #b2560d;
            color: #ffffff;
            font-weight: 600;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .motels-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 27px rgba(178, 86, 13, 0.32);
        }

        .motels-pagination {
            max-width: 1240px;
            margin: 3rem auto 0;
            display: flex;
            justify-content: center;
        }

        .motels-pagination-inner {
            background: #ffffff;
            border-radius: 999px;
            box-shadow: 0 14px 28px rgba(19, 37, 74, 0.16);
            padding: 0.65rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 1.25rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .motels-pagination-summary {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .motels-pagination-list {
            list-style: none;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0;
            margin: 0;
        }

        .motels-pagination-list li {
            margin: 0;
        }

        .motels-page-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--text-dark);
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .motels-page-btn:hover {
            background: rgba(178, 86, 13, 0.12);
            color: #b2560d;
        }

        .motels-page-btn--disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        .motels-page-btn--active {
            background: #b2560d;
            color: #ffffff;
            box-shadow: 0 8px 16px rgba(178, 86, 13, 0.3);
        }

        .motels-empty {
            max-width: 640px;
            margin: 4rem auto;
            background: #ffffff;
            border-radius: 24px;
            padding: 3rem;
            text-align: center;
            box-shadow: 0 20px 42px rgba(17, 31, 60, 0.12);
        }
        @media (max-width: 1600px) {
            .motels-grid {
                grid-template-columns: repeat(5, minmax(0, 1fr));
            }
        }

        @media (max-width: 1400px) {
            .motels-grid {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }
        }

        @media (max-width: 1100px) {
            .motels-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 900px) {
            .motels-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 640px) {
            .motels-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')
    <section class="motels-hero">
        <span class="badge" style="justify-self: center;">Our stays</span>
        <h1>Our Exquisite Rooms</h1>
        <p>Choose from our carefully curated selection of motels and suites—each designed with signature amenities, tasteful interiors, and personalised service for memorable stays.</p>
        @php
            $activeRegion = request('region') ? optional(($footerRegions ?? collect())->firstWhere('id', (int) request('region')))->name : null;
            $activeType = request('motel_type') ? optional(($footerMotelTypes ?? collect())->firstWhere('id', (int) request('motel_type')))->name : null;
        @endphp
        @if($activeRegion || $activeType)
            <div class="badge" style="justify-self: center; margin-top: 0.75rem; background: rgba(255,255,255,0.18); color: #ffffff;">
                Showing
                @if($activeType)
                    {{ $activeType }} stays
                @endif
                @if($activeRegion)
                    @if($activeType) · @endif
                    Region: {{ $activeRegion }}
                @endif
                <a href="{{ route('website.motels.index') }}" style="margin-left: 0.75rem; color: #ffb200;">Clear</a>
            </div>
        @endif
    </section>

    @if($motels->count() > 0)
        <section class="motels-grid">
            @foreach($motels as $motel)
                <article class="motels-card">
                    <img src="{{ $motel['image'] }}" alt="{{ $motel['name'] }}">
                    <div class="motels-body">
                        @if(!empty($motel['type']))
                            <p class="motels-type">{{ $motel['type'] }}</p>
                        @endif
                        <h3 class="motels-title">{{ $motel['name'] }}</h3>
                        <p class="motels-description">{{ $motel['description'] }}</p>
                      
                    </div>
                    <div class="motels-footer">
                       
                        <a class="motels-button" href="{{ route('website.motels.show', $motel['id']) }}">
                            View Details
                        </a>
                    </div>
                </article>
            @endforeach
        </section>

        <div class="motels-pagination">
            {{ $motels->onEachSide(1)->links('components.pagination.motels') }}
        </div>
    @else
        <div class="motels-empty">
            <h2 style="margin-bottom: 1rem;">Motel listings coming soon</h2>
            <p style="color: var(--text-muted); line-height: 1.7;">
                We’re gathering new properties for the bnbStay collection. Check back shortly to explore our full roster of stays.
            </p>
        </div>
    @endif
@endsection

