@extends('websitepages.layouts.app')

@section('title', __('website.room.meta_title', ['room' => $room->roomType->name ?? __('website.room.generic_name'), 'motel' => $motel->name]))
@section('meta_description', \Illuminate\Support\Str::limit(__('website.room.meta_description', ['room' => $room->roomType->name ?? __('website.room.generic_name'), 'motel' => $motel->name]), 150))

@push('styles')
    <style>
        .room-hero {
            position: relative;
            border-radius: 28px;
            overflow: hidden;
            max-width: 1100px;
            margin: 4rem auto 3rem;
            min-height: 380px;
            display: grid;
            align-items: end;
            color: #ffffff;
            box-shadow: 0 28px 52px rgba(10, 23, 55, 0.32);
        }

        .room-hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.3) 0%, rgba(15, 23, 42, 0.6) 50%, rgba(15, 23, 42, 0.92) 100%);
            z-index: 1;
        }

        .room-hero img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 0;
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        }

        .room-hero-body {
            position: relative;
            z-index: 2;
            padding: 2.5rem 3rem;
            display: grid;
            gap: 0.75rem;
        }

        .room-hero h1 {
            margin: 0;
            font-size: clamp(2.2rem, 4vw, 3rem);
            font-weight: 700;
            text-shadow: 0 2px 12px rgba(0, 0, 0, 0.4);
        }

        .room-hero p {
            margin: 0;
            max-width: 540px;
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.7;
            text-shadow: 0 1px 8px rgba(0, 0, 0, 0.3);
        }

        .room-hero .badge {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #ffffff;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .room-info {
            max-width: 1100px;
            margin: 0 auto 3rem;
            display: grid;
            gap: 2rem;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        }

        .room-info-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 1.8rem;
            box-shadow: 0 18px 36px rgba(19, 38, 74, 0.12);
            display: grid;
            gap: 0.7rem;
        }

        .room-info-card h3 {
            margin: 0;
            font-size: 1.15rem;
            color: var(--text-dark);
        }

        .room-info-list {
            display: grid;
            gap: 0.4rem;
            color: var(--text-muted);
        }

        .room-price {
            font-size: 1.4rem;
            font-weight: 700;
            color: #b2560d;
        }

        .room-price span {
            font-size: 0.9rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .room-gallery {
            max-width: 1100px;
            margin: 0 auto 3rem;
        }

        .room-gallery-grid {
            display: grid;
            gap: 1rem;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        }

        .room-gallery-grid img {
            border-radius: 18px;
            width: 100%;
            height: 220px;
            object-fit: cover;
            box-shadow: 0 18px 32px rgba(19, 34, 66, 0.12);
        }

        .room-items {
            max-width: 1100px;
            margin: 0 auto 4rem;
        }

        .room-items-grid {
            display: grid;
            gap: 1rem;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        }

        .room-item-card {
            background: #ffffff;
            border-radius: 18px;
            padding: 1.6rem;
            box-shadow: 0 16px 32px rgba(20, 38, 74, 0.12);
            display: grid;
            gap: 0.6rem;
        }

        .room-item-card strong {
            color: var(--text-dark);
        }

        .motels-empty {
            max-width: 640px;
            margin: 2.5rem auto 0;
            background: #ffffff;
            border-radius: 24px;
            padding: 3rem;
            text-align: center;
            box-shadow: 0 20px 42px rgba(17, 31, 60, 0.12);
        }

        .section-heading {
            font-size: clamp(1.9rem, 3vw, 2.3rem);
            margin-bottom: 0.75rem;
            text-align: center;
        }

        .section-subheading {
            color: var(--text-muted);
            text-align: center;
            margin-bottom: 2rem;
            line-height: 1.7;
        }
    </style>
@endpush

@section('content')
    <section class="room-hero">
        <img src="{{ $primaryImage ?: asset('images/static_file/applogo.png') }}" 
             alt="{{ $room->roomType->name ?? 'Guest room' }}"
             onerror="this.onerror=null; this.src='{{ asset('images/static_file/applogo.png') }}'">
        <div class="room-hero-body">
            <span class="badge" style="width: fit-content;">{{ $motel->name }}</span>
            <h1>{{ $room->roomType->name ?? __('website.room.generic_name') }}</h1>
            <p>
                {{ __('website.room.hero_subtitle', ['motel' => $motel->name]) }}
            </p>
        </div>
    </section>

    <section class="room-info">
        <article class="room-info-card">
            <h3>{{ __('website.room.info.overview_title') }}</h3>
            <div class="room-info-list">
                <span><strong>{{ __('website.room.info.room_number') }}</strong> {{ $room->room_number ?? '—' }}</span>
                <span><strong>{{ __('website.room.info.status') }}</strong> {{ $room->status ?? __('website.room.info.status_available') }}</span>
                <span><strong>{{ __('website.room.info.type') }}</strong> {{ $room->roomType->name ?? __('website.room.info.type_unknown') }}</span>
            </div>
        </article>
        <article class="room-info-card">
            <h3>{{ __('website.room.info.rate_title') }}</h3>
            <div class="room-price">
                @if($room->price_per_night)
                    ${{ number_format($room->price_per_night, 0) }} <span>{{ __('website.general.per_night') }}</span>
                @else
                    <span style="color: var(--text-muted); font-weight:500;">{{ __('website.general.contact_for_rates') }}</span>
                @endif
            </div>
            @if($room->office_price_per_night)
                <div style="color: var(--text-muted); font-size: 0.95rem;">
                    {{ __('website.room.info.office_rate', ['price' => '$'.number_format($room->office_price_per_night, 0)]) }} {{ __('website.general.per_night') }}
                </div>
            @endif
        </article>
        <article class="room-info-card">
            <h3>{{ __('website.room.info.concierge_title') }}</h3>
            <div class="room-info-list">
                <span><strong>{{ __('website.general.phone') }}</strong> {{ optional($motel->details)->contact_phone ?? __('website.general.not_provided') }}</span>
                <span><strong>{{ __('website.general.email') }}</strong> {{ optional($motel->details)->contact_email ?? __('website.general.not_provided') }}</span>
            </div>
        </article>
    </section>

    @if($gallery->isNotEmpty())
        <section class="room-gallery">
            <h2 class="section-heading">{{ __('website.room.gallery.title') }}</h2>
            <p class="section-subheading">{{ __('website.room.gallery.subtitle') }}</p>
            <div class="room-gallery-grid">
                @foreach($gallery as $image)
                    <img src="{{ $image }}" alt="{{ ($room->roomType->name ?? __('website.room.generic_name')).' image' }}">
                @endforeach
            </div>
        </section>
    @endif

    <section class="room-items">
        <h2 class="section-heading">{{ __('website.room.items.title') }}</h2>
        <p class="section-subheading">{{ __('website.room.items.subtitle', ['motel' => $motel->name]) }}</p>
        @if($items->count())
            <div class="room-items-grid">
                @foreach($items as $item)
                    <article class="room-item-card">
                        <strong>{{ $item['name'] }}</strong>
                        @if(!empty($item['description']))
                            <p style="margin: 0; color: var(--text-muted); line-height: 1.6;">{{ $item['description'] }}</p>
                        @endif
                    </article>
                @endforeach
            </div>
        @else
            <div class="motels-empty">
                <h2 style="margin-bottom: 1rem;">{{ __('website.room.items.empty_title') }}</h2>
                <p style="color: var(--text-muted); line-height: 1.7;">
                    {{ __('website.room.items.empty_description') }}
                </p>
            </div>
        @endif
    </section>
@endsection

