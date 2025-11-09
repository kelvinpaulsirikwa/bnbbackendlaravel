@extends('websitepages.layouts.app')

@section('title', 'Gallery | Discover Our Motels')
@section('meta_description', 'Browse the bnbStay gallery showcasing stunning stays from our curated motel partners.')

@push('styles')
    <style>
        .gallery-hero {
            max-width: 980px;
            margin: 4rem auto 3rem;
            text-align: center;
            display: grid;
            gap: 1rem;
        }

        .gallery-hero h1 {
            margin: 0;
            font-size: clamp(2.3rem, 4vw, 3.1rem);
        }

        .gallery-hero p {
            margin: 0 auto;
            max-width: 620px;
            color: var(--text-muted);
            line-height: 1.75;
        }

        .gallery-grid {
            max-width: 1240px;
            margin: 0 auto;
            display: grid;
            gap: 1.5rem;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        }

        .gallery-item {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            background: #0f172a;
            box-shadow: 0 18px 35px rgba(13, 27, 60, 0.18);
        }

        .gallery-item img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            transition: transform 0.35s ease;
            display: block;
        }

        .gallery-item:hover img {
            transform: scale(1.05);
        }

        .gallery-item .gallery-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(15, 23, 42, 0) 30%, rgba(15, 23, 42, 0.75) 100%);
            display: flex;
            align-items: flex-end;
            padding: 1.25rem;
            color: #ffffff;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }

        .gallery-overlay strong {
            font-size: 1.05rem;
        }

        .gallery-pagination {
            max-width: 1240px;
            margin: 3rem auto 0;
            display: flex;
            justify-content: center;
        }

        .gallery-pagination nav {
            background: #ffffff;
            padding: 0.75rem 1.25rem;
            border-radius: 999px;
            box-shadow: 0 14px 28px rgba(19, 37, 74, 0.16);
        }

        .gallery-empty {
            max-width: 640px;
            margin: 4rem auto;
            text-align: center;
            background: #ffffff;
            padding: 3rem;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(16, 27, 57, 0.12);
        }
    </style>
@endpush

@section('content')
    <section class="gallery-hero">
        <span class="badge" style="justify-self: center;">Visual stories</span>
        <h1>Explore Our Gallery</h1>
        <p>Take a virtual tour through our stunning properties and facilities. Each photo represents the character, design, and hospitality of our curated motels.</p>
    </section>

    @if($images->count() > 0)
        <section class="gallery-grid">
            @foreach($images as $image)
                <article class="gallery-item">
                    <img src="{{ $image['url'] }}" alt="{{ $image['motel_name'] }}">
                    <div class="gallery-overlay">
                        <div>
                            <strong>{{ $image['motel_name'] }}</strong>
                            @if(!empty($image['created_at']))
                                <div style="font-size: 0.85rem; opacity: 0.8;">Captured {{ $image['created_at']->diffForHumans() }}</div>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
        </section>

        <div class="gallery-pagination">
            {{ $images->links() }}
        </div>
    @else
        <div class="gallery-empty">
            <h2 style="margin-bottom: 1rem;">Gallery coming soon</h2>
            <p style="color: var(--text-muted); line-height: 1.7;">We’re curating new visuals from our partner motels. Check back shortly to explore immersive photography from our collection.</p>
        </div>
    @endif
@endsection

