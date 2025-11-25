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
                <x-motel-card :motel="$motel" />
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

