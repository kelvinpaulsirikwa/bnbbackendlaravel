@extends('websitepages.layouts.app')

@section('title', __('website.motel_gallery.meta_title', ['name' => $motel->name]))

@push('styles')
    <style>
        .motel-gallery-page {
            max-width: 1240px;
            margin: 4rem auto;
            padding: 0 1rem;
        }

        .motel-gallery-header {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin-bottom: 2rem;
        }

        .gallery-back {
            color: var(--accent);
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }

        .gallery-back:hover {
            text-decoration: underline;
        }

        .motel-gallery-header h1 {
            margin: 0;
            font-size: clamp(2rem, 3.2vw, 2.6rem);
        }

        .motel-gallery-grid {
            display: grid;
            gap: 1.25rem;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        }

        .motel-gallery-grid figure {
            margin: 0;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 18px 32px rgba(19, 34, 66, 0.12);
            background: #0c1830;
            min-height: 220px;
        }

        .motel-gallery-grid img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
        }

        .motel-gallery-empty {
            padding: 3rem;
            text-align: center;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 18px 32px rgba(19, 34, 66, 0.12);
            color: var(--text-muted);
        }
    </style>
@endpush

@section('content')
    <section class="motel-gallery-page">
        <div class="motel-gallery-header">
            <a href="{{ route('website.motels.show', $motel) }}" class="gallery-back">
                {{ __('website.motel_gallery.back', ['name' => $motel->name]) }}
            </a>
            <h1>{{ __('website.motel_gallery.title', ['name' => $motel->name]) }}</h1>
            <p style="margin: 0; color: var(--text-muted);">{{ __('website.motel_gallery.subtitle') }}</p>
        </div>

        @if($gallery->isNotEmpty())
            <div class="motel-gallery-grid">
                @foreach($gallery as $image)
                    <figure>
                        <img src="{{ $image }}" alt="{{ $motel->name }} photo">
                    </figure>
                @endforeach
            </div>
        @else
            <div class="motel-gallery-empty">
                {{ __('website.motel_gallery.empty') }}
            </div>
        @endif
    </section>
@endsection

