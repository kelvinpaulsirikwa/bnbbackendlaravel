@extends('websitepages.layouts.app')

@section('title', __('website.amenity.meta_title', ['name' => $amenity['name']]))
@section('meta_description', __('website.amenity.meta_description', ['name' => $amenity['name']]))

@push('styles')
    <style>
        .amenity-hero {
            max-width: 1100px;
            margin: 4rem auto 3rem;
            padding: 0 1.5rem;
            display: grid;
            gap: 1.5rem;
        }

        .amenity-hero-back {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            width: fit-content;
            padding: 0.6rem 1.2rem;
            border-radius: 999px;
            border: 1px solid #e2e8f0;
            text-decoration: none;
            font-weight: 600;
            color: #0f172a;
            transition: all 0.2s ease;
        }

        .amenity-hero-back:hover {
            border-color: #6366f1;
            color: #6366f1;
            transform: translateX(-4px);
        }

        .amenity-hero-card {
            background: #ffffff;
            border-radius: 28px;
            padding: 2.5rem;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.12);
            display: grid;
            grid-template-columns: minmax(0, 120px) 1fr;
            gap: 2rem;
            align-items: center;
        }

        .amenity-hero-icon {
            width: 120px;
            height: 120px;
            border-radius: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.15), rgba(139, 92, 246, 0.15));
            font-size: 3rem;
            color: #6366f1;
            overflow: hidden;
        }

        .amenity-hero-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .amenity-hero-content h1 {
            margin: 0;
            font-size: clamp(2rem, 4vw, 3rem);
            color: #0f172a;
        }

        .amenity-hero-content p {
            margin: 0.5rem 0 0;
            color: #475569;
            line-height: 1.7;
        }

        .amenity-motels-grid {
            max-width: 1240px;
            margin: 0 auto;
            padding: 0 1.5rem 3rem;
            display: grid;
            gap: 1.75rem;
            grid-template-columns: repeat(auto-fit, minmax(290px, 1fr));
        }

        .amenity-motel-card {
            background: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 24px 48px rgba(15, 23, 42, 0.12);
            display: flex;
            flex-direction: column;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .amenity-motel-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 30px 60px rgba(15, 23, 42, 0.16);
        }

        .amenity-motel-card img {
            width: 100%;
            height: 210px;
            object-fit: cover;
        }

        .amenity-motel-body {
            padding: 1.75rem;
            display: grid;
            gap: 0.8rem;
            flex: 1;
        }

        .amenity-motel-type {
            margin: 0;
            font-size: 0.9rem;
            color: #6366f1;
            font-weight: 600;
            letter-spacing: 0.04em;
        }

        .amenity-motel-title {
            margin: 0;
            font-size: 1.4rem;
            color: #0f172a;
            font-weight: 700;
        }

        .amenity-motel-description {
            margin: 0;
            color: #475569;
            line-height: 1.6;
        }

        .amenity-motel-amenities {
            display: grid;
            gap: 0.35rem;
            font-size: 0.95rem;
            color: #0f172a;
        }

        .amenity-motel-amenities span::before {
            content: '✔';
            margin-right: 0.45rem;
            color: #b2560d;
            font-weight: 600;
        }

        .amenity-motel-footer {
            padding: 0 1.75rem 1.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .amenity-motel-price {
            font-weight: 700;
            color: #b2560d;
            font-size: 1.15rem;
        }

        .amenity-motel-price span {
            font-size: 0.9rem;
            color: #94a3b8;
            font-weight: 500;
        }

        .amenity-motel-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            padding: 0.65rem 1.4rem;
            border-radius: 999px;
            background: #0f172a;
            color: #ffffff;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .amenity-motel-button:hover {
            background: #6366f1;
            box-shadow: 0 12px 24px rgba(99, 102, 241, 0.35);
        }

        .amenity-pagination {
            max-width: 1240px;
            margin: 0 auto 4rem;
            padding: 0 1.5rem;
            display: flex;
            justify-content: center;
        }

        .amenity-empty {
            max-width: 720px;
            margin: 4rem auto;
            padding: 4rem 3rem;
            text-align: center;
            background: #ffffff;
            border-radius: 32px;
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.12);
        }

        .amenity-empty h2 {
            margin-bottom: 1rem;
            color: #0f172a;
        }

        .amenity-empty p {
            margin: 0;
            color: #475569;
            line-height: 1.7;
        }

        @media (max-width: 768px) {
            .amenity-hero-card {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .amenity-hero-icon {
                margin: 0 auto;
            }

            .amenity-motel-footer {
                flex-direction: column;
                gap: 0.75rem;
            }
        }
    </style>
@endpush

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
    <section class="amenity-hero">
        <a class="amenity-hero-back" href="{{ route('website.amenities') }}">
            {{ __('website.amenity.back') }}
        </a>
        <div class="amenity-hero-card">
            <div class="amenity-hero-icon">
                @if($amenity['icon_is_image'] ?? false)
                    <img src="{{ $amenity['icon'] }}" alt="{{ $amenity['name'] }} icon">
                @elseif(!empty($amenity['icon']))
                    <span>{{ $amenity['icon'] }}</span>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="m9 12 2 2 4-4"/>
                    </svg>
                @endif
            </div>
            <div class="amenity-hero-content">
                <h1>{{ $amenity['name'] }}</h1>
                <p>{{ __('website.amenity.hero_description', ['amenity' => Str::lower($amenity['name'] ?? __('website.amenity.generic_name'))]) }}</p>
            </div>
        </div>
    </section>

    @if($motels->count())
        <section class="amenity-motels-grid">
            @foreach($motels as $motel)
                <article class="amenity-motel-card">
                    <img src="{{ $motel['image'] }}" alt="{{ $motel['name'] }}">
                    <div class="amenity-motel-body">
                        @if(!empty($motel['type']))
                            <p class="amenity-motel-type">{{ $motel['type'] }}</p>
                        @endif
                        <h3 class="amenity-motel-title">{{ $motel['name'] }}</h3>
                        <p class="amenity-motel-description">{{ $motel['description'] }}</p>
                        <div class="amenity-motel-amenities">
                            @forelse($motel['amenities'] as $highlight)
                                <span>{{ $highlight }}</span>
                            @empty
                                <span>{{ __('website.amenity.concierge_available') }}</span>
                            @endforelse
                        </div>
                    </div>
                    <div class="amenity-motel-footer">
                        <div class="amenity-motel-price">
                            @if($motel['starting_price'])
                                ${{ number_format($motel['starting_price'], 0) }} <span>{{ __('website.general.per_night') }}</span>
                            @else
                                <span style="color: #94a3b8; font-weight:500;">{{ __('website.general.contact_for_rates') }}</span>
                            @endif
                        </div>
                        <a class="amenity-motel-button" href="{{ route('website.motels.show', $motel['id']) }}">
                            {{ __('website.amenity.view_motel') }}
                        </a>
                    </div>
                </article>
            @endforeach
        </section>

        <div class="amenity-pagination">
            {{ $motels->links() }}
        </div>
    @else
        <div class="amenity-empty">
            <h2>{{ __('website.amenity.empty_title') }}</h2>
            <p>{{ __('website.amenity.empty_description', ['amenity' => Str::lower($amenity['name'] ?? __('website.amenity.generic_name'))]) }}</p>
        </div>
    @endif
@endsection

