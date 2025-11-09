@extends('websitepages.layouts.app')

@section('title', 'Amenities | bnbStay Experiences')
@section('meta_description', 'Discover the amenities curated across bnbStay motels to elevate every stay.')

@push('styles')
    <style>
        .amenities-hero {
            max-width: 980px;
            margin: 4rem auto 3rem;
            text-align: center;
            display: grid;
            gap: 1rem;
        }

        .amenities-hero h1 {
            margin: 0;
            font-size: clamp(2.4rem, 4vw, 3.2rem);
        }

        .amenities-hero p {
            margin: 0 auto;
            max-width: 620px;
            color: var(--text-muted);
            line-height: 1.75;
        }

        .amenities-filters {
            max-width: 980px;
            margin: 0 auto 2rem;
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .amenities-grid {
            max-width: 1240px;
            margin: 0 auto;
            display: grid;
            gap: 1.5rem;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        }

        .amenity-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 1.75rem;
            box-shadow: 0 18px 34px rgba(20, 35, 62, 0.12);
            display: grid;
            gap: 1rem;
            text-align: center;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .amenity-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 22px 44px rgba(17, 32, 61, 0.18);
        }

        .amenity-icon {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            margin: 0 auto;
            display: grid;
            place-items: center;
            background: rgba(43, 112, 247, 0.1);
            color: var(--primary);
            font-size: 2rem;
            overflow: hidden;
        }

        .amenity-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .amenity-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .amenities-empty {
            max-width: 640px;
            margin: 4rem auto;
            background: #ffffff;
            border-radius: 24px;
            padding: 3rem;
            text-align: center;
            box-shadow: 0 20px 42px rgba(17, 31, 60, 0.12);
        }
    </style>
@endpush

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
    <section class="amenities-hero">
        <span class="badge" style="justify-self: center;">Signature comforts</span>
        <h1>World-Class Amenities</h1>
        <p>Indulge in premium facilities and thoughtful touches curated across our partner motels—crafted to make every stay effortless.</p>
    </section>

    @if($amenities->isNotEmpty())
        <section class="amenities-grid">
            @foreach($amenities as $amenity)
                @php
                    $icon = $amenity['icon'];
                    $treatAsImage = $icon && (filter_var($icon, FILTER_VALIDATE_URL) || Str::contains($icon, ['/','\\','.png','.jpg','.jpeg','.svg']));
                @endphp
                <article class="amenity-card">
                    <div class="amenity-icon">
                        @if($treatAsImage)
                            <img src="{{ $icon }}" alt="{{ $amenity['name'] }} icon">
                        @elseif(!empty($icon))
                            <span>{{ $icon }}</span>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="none" stroke="currentColor" stroke-width="1.6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 13h8m-4 4h4m-2 8a9 9 0 1 0-9-9 9 9 0 0 0 9 9Z"/>
                            </svg>
                        @endif
                    </div>
                    <div class="amenity-name">{{ $amenity['name'] }}</div>
                </article>
            @endforeach
        </section>
    @else
        <div class="amenities-empty">
            <h2 style="margin-bottom: 1rem;">Amenities coming soon</h2>
            <p style="color: var(--text-muted); line-height: 1.7;">
                We’re currently curating premium amenities across our network. Check back shortly to explore everything included with each stay.
            </p>
        </div>
    @endif
@endsection

