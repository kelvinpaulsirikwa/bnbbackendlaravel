@extends('websitepages.layouts.app')

@section('title', __('website.gallery.meta_title'))
@section('meta_description', __('website.gallery.meta_description'))

@push('styles')
    <style>
        :root {
            --primary: #3b82f6;
            --primary-dark: #2563eb;
            --secondary: #8b5cf6;
            --dark: #0f172a;
            --dark-light: #1e293b;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-400: #94a3b8;
            --gray-600: #475569;
            --gray-700: #334155;
            --text-muted: #64748b;
        }

        body {
            background: #ffffff;
            min-height: 100vh;
        }

        .gallery-hero {
            max-width: 1000px;
            margin: 5rem auto 4rem;
            text-align: center;
            padding: 0 2rem;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.625rem;
            padding: 0.625rem 1.5rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: #ffffff;
            border-radius: 999px;
            font-size: 0.875rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            box-shadow: 0 8px 24px rgba(59, 130, 246, 0.25);
            margin-bottom: 1.5rem;
            animation: fadeInDown 0.6s ease;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .gallery-hero h1 {
            margin: 0 0 1.25rem 0;
            font-size: clamp(2.5rem, 5vw, 3.75rem);
            font-weight: 800;
            background: linear-gradient(135deg, var(--dark) 0%, var(--primary) 50%, var(--secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.2;
            animation: fadeInUp 0.6s ease 0.1s both;
        }

        .gallery-hero p {
            margin: 0 auto;
            max-width: 660px;
            color: var(--text-muted);
            font-size: 1.125rem;
            line-height: 1.8;
            animation: fadeInUp 0.6s ease 0.2s both;
        }

        .gallery-grid {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem 4rem;
            display: grid;
            gap: 2rem;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        }

        .gallery-item {
            position: relative;
            border-radius: 24px;
            overflow: hidden;
            background: #ffffff;
            box-shadow: 0 4px 20px rgba(15, 23, 42, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: default;
            animation: fadeInUp 0.5s ease both;
        }

        .gallery-item.has-link {
            cursor: pointer;
        }

        .gallery-item-link-wrapper {
            display: block;
            color: inherit;
            text-decoration: none;
            height: 100%;
        }

        .gallery-item:nth-child(1) { animation-delay: 0.05s; }
        .gallery-item:nth-child(2) { animation-delay: 0.1s; }
        .gallery-item:nth-child(3) { animation-delay: 0.15s; }
        .gallery-item:nth-child(4) { animation-delay: 0.2s; }
        .gallery-item:nth-child(5) { animation-delay: 0.25s; }
        .gallery-item:nth-child(6) { animation-delay: 0.3s; }

        .gallery-item:hover {
            transform: translateY(-12px) scale(1.02);
            box-shadow: 0 24px 60px rgba(59, 130, 246, 0.2);
        }

        .gallery-item::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 24px;
            padding: 2px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .gallery-item:hover::before {
            opacity: 1;
        }

        .gallery-item img {
            width: 100%;
            height: 320px;
            object-fit: cover;
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            display: block;
        }

        .gallery-item:hover img {
            transform: scale(1.1);
        }

        .gallery-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(15, 23, 42, 0) 20%, rgba(15, 23, 42, 0.85) 80%, rgba(15, 23, 42, 0.95) 100%);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 2rem;
            color: #ffffff;
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }

        .gallery-overlay strong {
            font-size: 1.25rem;
            font-weight: 700;
            display: block;
            margin-bottom: 0.5rem;
            letter-spacing: -0.5px;
        }

        .gallery-overlay div[style*="font-size"] {
            font-size: 0.9rem !important;
            opacity: 0.9 !important;
            font-weight: 500;
        }

        .custom-pagination {
            max-width: 1400px;
            margin: 3rem auto 0;
            padding: 0 2rem;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.875rem;
            flex-wrap: wrap;
        }

        .pagination-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 48px;
            height: 48px;
            padding: 0 1.125rem;
            background: #ffffff;
            color: var(--gray-700);
            border: 2px solid var(--gray-200);
            border-radius: 14px;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.06);
            position: relative;
            overflow: hidden;
        }

        .pagination-btn::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .pagination-btn:hover:not(.disabled):not(.active) {
            background: var(--gray-50);
            border-color: var(--primary);
            color: var(--primary);
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(59, 130, 246, 0.25);
        }

        .pagination-btn.active {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: #ffffff;
            border-color: transparent;
            box-shadow: 0 8px 24px rgba(59, 130, 246, 0.4);
            transform: scale(1.1);
        }

        .pagination-btn.active::before {
            opacity: 1;
        }

        .pagination-btn.disabled {
            opacity: 0.35;
            cursor: not-allowed;
            background: var(--gray-100);
            border-color: var(--gray-200);
            color: var(--gray-400);
        }

        .pagination-btn.prev-next {
            padding: 0 1.5rem;
            font-weight: 700;
            min-width: auto;
        }

        .pagination-dots {
            color: var(--gray-400);
            padding: 0 0.5rem;
            font-weight: 700;
            font-size: 1.125rem;
        }

        .pagination-info {
            margin-top: 2rem;
            text-align: center;
            color: var(--text-muted);
            font-size: 0.95rem;
            font-weight: 500;
            padding-bottom: 2rem;
        }

        .gallery-empty {
            max-width: 680px;
            margin: 5rem auto;
            text-align: center;
            background: #ffffff;
            padding: 4rem 3rem;
            border-radius: 32px;
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.12);
            border: 1px solid var(--gray-200);
            animation: fadeInUp 0.6s ease;
        }

        .gallery-empty h2 {
            margin-bottom: 1.25rem;
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark);
        }

        .gallery-empty p {
            color: var(--text-muted);
            line-height: 1.8;
            font-size: 1.05rem;
        }

        @media (max-width: 1024px) {
            .gallery-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 1.5rem;
            }

            .gallery-item img {
                height: 280px;
            }
        }

        @media (max-width: 768px) {
            .gallery-hero {
                margin: 3rem auto 3rem;
                padding: 0 1.5rem;
            }

            .gallery-hero h1 {
                font-size: 2.25rem;
            }

            .gallery-hero p {
                font-size: 1rem;
            }

            .gallery-grid {
                grid-template-columns: 1fr;
                gap: 1.25rem;
                padding: 0 1.5rem 3rem;
            }

            .gallery-item {
                border-radius: 20px;
            }

            .gallery-item img {
                height: 240px;
            }

            .gallery-overlay {
                padding: 1.5rem;
            }

            .custom-pagination {
                gap: 0.625rem;
                padding: 0 1.5rem;
            }

            .pagination-btn {
                min-width: 44px;
                height: 44px;
                font-size: 0.875rem;
                border-radius: 12px;
            }

            .pagination-btn.prev-next {
                padding: 0 1.25rem;
            }

            .gallery-empty {
                margin: 3rem auto;
                padding: 3rem 2rem;
                border-radius: 24px;
            }

            .gallery-empty h2 {
                font-size: 1.75rem;
            }
        }

        @media (max-width: 480px) {
            .badge {
                font-size: 0.8125rem;
                padding: 0.5rem 1.25rem;
            }

            .gallery-hero h1 {
                font-size: 1.875rem;
            }

            .pagination-btn {
                min-width: 40px;
                height: 40px;
                padding: 0 0.875rem;
            }

            .pagination-info {
                font-size: 0.875rem;
            }
        }
    </style>
@endpush

@section('content')
    <section class="gallery-hero">
        <span class="badge">{{ __('website.gallery.badge') }}</span>
        <h1>{{ __('website.gallery.title') }}</h1>
        <p>{{ __('website.gallery.subtitle') }}</p>
    </section>

    @if($images->count() > 0)
        <section class="gallery-grid">
            @foreach($images as $image)
                @php
                    $motelLink = !empty($image['motel_id']) ? route('website.motels.show', $image['motel_id']) : null;
                @endphp
                <article class="gallery-item {{ $motelLink ? 'has-link' : '' }}">
                    @if($motelLink)
                        <a href="{{ $motelLink }}"
                           class="gallery-item-link-wrapper"
                           aria-label="{{ __('website.gallery.card_aria', ['name' => $image['motel_name']]) }}">
                    @else
                        <div class="gallery-item-link-wrapper">
                    @endif
                            <img src="{{ $image['url'] }}" alt="{{ $image['motel_name'] }}" loading="lazy">
                            <div class="gallery-overlay">
                                <div>
                                    <strong>{{ $image['motel_name'] }}</strong>
                                    @if(!empty($image['created_at']))
                                        <div style="font-size: 0.85rem; opacity: 0.85;">{{ __('website.gallery.captured', ['time' => $image['created_at']->diffForHumans()]) }}</div>
                                    @endif
                                </div>
                            </div>
                    @if($motelLink)
                        </a>
                    @else
                        </div>
                    @endif
                </article>
            @endforeach
        </section>

        <div class="custom-pagination">
            {{-- Previous Button --}}
            @if ($images->onFirstPage())
                <span class="pagination-btn prev-next disabled">{{ __('website.pagination.previous') }}</span>
            @else
                <a href="{{ $images->previousPageUrl() }}" class="pagination-btn prev-next">{{ __('website.pagination.previous') }}</a>
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
                <a href="{{ $images->nextPageUrl() }}" class="pagination-btn prev-next">{{ __('website.pagination.next') }}</a>
            @else
                <span class="pagination-btn prev-next disabled">{{ __('website.pagination.next') }}</span>
            @endif
        </div>

        {{-- Pagination Info --}}
        <div class="pagination-info">
            {{ __('website.gallery.pagination_info', ['from' => $images->firstItem(), 'to' => $images->lastItem(), 'total' => $images->total()]) }}
        </div>
    @else
        <div class="gallery-empty">
            <h2>{{ __('website.gallery.empty_title') }}</h2>
            <p>{{ __('website.gallery.empty_description') }}</p>
        </div>
    @endif
@endsection