@extends('websitepages.layouts.app')

@section('title', __('website.motels.meta_title'))
@section('meta_description', __('website.motels.meta_description'))

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
            gap: 2rem;
            grid-template-columns: repeat(3, minmax(0, 1fr));
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
        @media (max-width: 1100px) {
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
        <span class="badge" style="justify-self: center;">{{ __('website.motels.hero_badge') }}</span>
        <h1>{{ __('website.motels.hero_title') }}</h1>
        <p>{{ __('website.motels.hero_subtitle') }}</p>
        @php
            $activeRegion = request('region') ? optional(($footerRegions ?? collect())->firstWhere('id', (int) request('region')))->name : null;
            $activeType = request('motel_type') ? optional(($footerMotelTypes ?? collect())->firstWhere('id', (int) request('motel_type')))->name : null;
        @endphp
        @if($activeRegion || $activeType)
            <div class="badge" style="justify-self: center; margin-top: 0.75rem; background: rgba(255,255,255,0.18); color: #ffffff;">
                {{ __('website.motels.filters.showing') }}
                @if($activeType)
                    {{ __('website.motels.filters.type', ['type' => $activeType]) }}
                @endif
                @if($activeRegion)
                    @if($activeType) · @endif
                    {{ __('website.motels.filters.region', ['region' => $activeRegion]) }}
                @endif
                <a href="{{ route('website.motels.index') }}" style="margin-left: 0.75rem; color: #ffb200;">{{ __('website.motels.filters.clear') }}</a>
            </div>
        @endif
    </section>

    @if($motels->count() > 0)
        <section class="motels-grid">
            @foreach($motels as $motel)
                <x-motel-card :motel="$motel" />
            @endforeach
        </section>

        <div class="motels-pagination">
            {{ $motels->onEachSide(1)->links('components.pagination.motels') }}
        </div>
    @else
        <div class="motels-empty">
            <h2 style="margin-bottom: 1rem;">{{ __('website.motels.empty_title') }}</h2>
            <p style="color: var(--text-muted); line-height: 1.7;">
                {{ __('website.motels.empty_description') }}
            </p>
        </div>
    @endif
@endsection

