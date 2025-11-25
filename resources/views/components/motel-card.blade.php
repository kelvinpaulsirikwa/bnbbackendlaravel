@props(['motel'])

@once
    @push('styles')
        <style>
            .motels-card {
                background: #ffffff;
                border-radius: 0;
                overflow: hidden;
                display: flex;
                flex-direction: column;
                transition: transform 0.3s ease;
                position: relative;
            }

            .motels-card:hover {
                transform: translateY(-4px);
            }

            .motels-image-wrapper {
                position: relative;
                overflow: hidden;
                width: 100%;
                padding-top: 75%;
                background: #f0f0f0;
            }

            .motels-image-wrapper img {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.4s ease;
            }

            .motels-card:hover .motels-image-wrapper img {
                transform: scale(1.05);
            }

            .motels-overlay-label {
                position: absolute;
                top: 1rem;
                left: 1rem;
                background: rgba(240, 240, 240, 0.95);
                color: #222222;
                padding: 0.65rem 1.35rem;
                font-size: 0.85rem;
                font-weight: 600;
                letter-spacing: 0.05em;
                text-transform: uppercase;
                z-index: 2;
                border-radius: 6px;
            }

            .motels-glass-overlay {
                position: absolute;
                inset: 0;
                display: grid;
                place-items: center;
                color: #ffffff;
                background: rgba(0, 0, 0, 0.18);
                padding: 2.5rem 1.5rem;
                transition: opacity 0.3s ease, visibility 0.3s ease;
                text-align: center;
                overflow-y: auto;
            }

            .motels-center-info {
                display: grid;
                gap: 0.85rem;
                justify-items: center;
                width: 100%;
                max-width: 100%;
            }

            .motels-center-info h3 {
                margin: 0;
                font-size: clamp(1.3rem, 2.6vw, 2rem);
                font-weight: 600;
                letter-spacing: 0.02em;
                word-break: break-word;
            }

            .motels-features-inline {
                display: flex;
                gap: 1.5rem;
                justify-content: center;
                flex-wrap: wrap;
                font-size: 0.95rem;
                letter-spacing: 0.02em;
                max-width: 100%;
                padding: 0;
                margin: 0;
            }

            .motels-features-inline li {
                list-style: none;
                position: relative;
                padding-left: 0.8rem;
                white-space: nowrap;
            }

            .motels-features-inline li::before {
                content: '•';
                position: absolute;
                left: 0;
                color: #ffffff;
            }

            .motels-card:hover .motels-glass-overlay {
                opacity: 0;
                visibility: hidden;
            }

            .motels-hover-content {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.65);
                color: #ffffff;
                padding: 2rem;
                display: flex;
                flex-direction: column;
                justify-content: center;
                opacity: 0;
                visibility: hidden;
                transition: opacity 0.3s ease, visibility 0.3s ease;
                z-index: 3;
                text-align: left;
                overflow-y: auto;
            }

            .motels-card:hover .motels-hover-content {
                opacity: 1;
                visibility: visible;
            }

            .motels-hover-description {
                margin: 0 0 1.5rem 0;
                color: #ffffff;
                line-height: 1.7;
                font-size: 0.95rem;
            }

            .motels-hover-button {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 0.9rem 2.4rem;
                background: transparent;
                color: #ffffff;
                border: 2px solid #ffffff;
                text-decoration: none;
                font-weight: 600;
                font-size: 1rem;
                transition: all 0.3s ease;
                align-self: flex-start;
                border-radius: 999px;
            }

            .motels-hover-button:hover {
                background: #ffffff;
                color: #000000;
            }

            /* Responsive adjustments for amenities */
            @media (max-width: 768px) {
                .motels-features-inline {
                    gap: 1rem;
                    font-size: 0.85rem;
                }
                
                .motels-glass-overlay {
                    padding: 1.5rem 1rem;
                }
            }
        </style>
    @endpush
@endonce

<article {{ $attributes->merge(['class' => 'motels-card']) }}>
    <div class="motels-image-wrapper">
        <img src="{{ $motel['image'] }}" alt="{{ $motel['name'] }}">

        @if(!empty($motel['location']))
            <div class="motels-overlay-label">{{ $motel['location'] }}</div>
        @endif

        <div class="motels-glass-overlay">
            <div class="motels-center-info">
                <h3>{{ $motel['name'] }}</h3>

                @if(!empty($motel['amenities']))
                    <ul class="motels-features-inline">
                        @foreach($motel['amenities'] as $amenity)
                            <li>{{ $amenity }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        <div class="motels-hover-content">
            <p class="motels-hover-description">{{ $motel['description'] }}</p>
            <a href="{{ route('website.motels.show', $motel['id']) }}" class="motels-hover-button">
                {{ __('website.general.view_details') }}
            </a>
        </div>
    </div>
</article>