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
            background: linear-gradient(135deg, #1e293b 0%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .gallery-hero p {
            margin: 0 auto;
            max-width: 620px;
            color: var(--text-muted);
            line-height: 1.75;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1.25rem;
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            color: #ffffff;
            border-radius: 999px;
            font-size: 0.875rem;
            font-weight: 600;
            letter-spacing: 0.025em;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .gallery-grid {
            max-width: 1240px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: grid;
            gap: 1.5rem;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        }

        .gallery-item {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            background: #0f172a;
            box-shadow: 0 18px 35px rgba(13, 27, 60, 0.18);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .gallery-item:hover {
            transform: translateY(-8px);
            box-shadow: 0 24px 48px rgba(13, 27, 60, 0.28);
        }

        .gallery-item img {
            width: 100%;
            height: 280px;
            object-fit: cover;
            transition: transform 0.35s ease;
            display: block;
        }

        .gallery-item:hover img {
            transform: scale(1.08);
        }

        .gallery-item .gallery-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(15, 23, 42, 0) 30%, rgba(15, 23, 42, 0.9) 100%);
            display: flex;
            align-items: flex-end;
            padding: 1.5rem;
            color: #ffffff;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }

        .gallery-overlay strong {
            font-size: 1.125rem;
            font-weight: 600;
            display: block;
            margin-bottom: 0.25rem;
        }

        /* Custom Pagination Styles */
        .custom-pagination {
            max-width: 1240px;
            margin: 4rem auto 0;
            padding: 0 1.5rem;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.75rem;
        }

        .pagination-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 44px;
            height: 44px;
            padding: 0 1rem;
            background: #ffffff;
            color: #334155;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            transition: all 0.25s ease;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.08);
        }

        .pagination-btn:hover:not(.disabled):not(.active) {
            background: #f8fafc;
            border-color: #3b82f6;
            color: #3b82f6;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
        }

        .pagination-btn.active {
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            color: #ffffff;
            border-color: transparent;
            box-shadow: 0 4px 16px rgba(59, 130, 246, 0.4);
        }

        .pagination-btn.disabled {
            opacity: 0.4;
            cursor: not-allowed;
            background: #f1f5f9;
            border-color: #e2e8f0;
        }

        .pagination-btn.prev-next {
            padding: 0 1.25rem;
            font-weight: 700;
        }

        .pagination-dots {
            color: #94a3b8;
            padding: 0 0.5rem;
            font-weight: 600;
        }

        .pagination-info {
            margin-top: 1.5rem;
            text-align: center;
            color: #64748b;
            font-size: 0.9rem;
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

        @media (max-width: 768px) {
            .gallery-grid {
                grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
                gap: 1rem;
            }

            .gallery-item img {
                height: 220px;
            }

            .custom-pagination {
                flex-wrap: wrap;
                gap: 0.5rem;
            }

            .pagination-btn {
                min-width: 40px;
                height: 40px;
                font-size: 0.875rem;
            }
        }
    </style>
@endpush

@section('content')
    <section class="gallery-hero">
        <span class="badge">✨ Visual stories</span>
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
                                <div style="font-size: 0.85rem; opacity: 0.85;">Captured {{ $image['created_at']->diffForHumans() }}</div>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
        </section>

        <div class="custom-pagination">
            {{-- Previous Button --}}
            @if ($images->onFirstPage())
                <span class="pagination-btn prev-next disabled">← Previous</span>
            @else
                <a href="{{ $images->previousPageUrl() }}" class="pagination-btn prev-next">← Previous</a>
            @endif

            {{-- Page Numbers --}}
            @php
                $currentPage = $images->currentPage();
                $lastPage = $images->lastPage();
                $start = max(1, $currentPage - 2);
                $end = min($lastPage, $currentPage + 2);
            @endphp

            {{-- First Page --}}
            @if($start > 1)
                <a href="{{ $images->url(1) }}" class="pagination-btn">1</a>
                @if($start > 2)
                    <span class="pagination-dots">•••</span>
                @endif
            @endif

            {{-- Page Numbers Range --}}
            @for($page = $start; $page <= $end; $page++)
                @if($page == $currentPage)
                    <span class="pagination-btn active">{{ $page }}</span>
                @else
                    <a href="{{ $images->url($page) }}" class="pagination-btn">{{ $page }}</a>
                @endif
            @endfor

            {{-- Last Page --}}
            @if($end < $lastPage)
                @if($end < $lastPage - 1)
                    <span class="pagination-dots">•••</span>
                @endif
                <a href="{{ $images->url($lastPage) }}" class="pagination-btn">{{ $lastPage }}</a>
            @endif

            {{-- Next Button --}}
            @if ($images->hasMorePages())
                <a href="{{ $images->nextPageUrl() }}" class="pagination-btn prev-next">Next →</a>
            @else
                <span class="pagination-btn prev-next disabled">Next →</span>
            @endif
        </div>

        {{-- Pagination Info --}}
        <div class="pagination-info">
            Showing {{ $images->firstItem() }} to {{ $images->lastItem() }} of {{ $images->total() }} images
        </div>
    @else
        <div class="gallery-empty">
            <h2 style="margin-bottom: 1rem;">Gallery coming soon</h2>
            <p style="color: var(--text-muted); line-height: 1.7;">We're curating new visuals from our partner motels. Check back shortly to explore immersive photography from our collection.</p>
        </div>
    @endif
@endsection