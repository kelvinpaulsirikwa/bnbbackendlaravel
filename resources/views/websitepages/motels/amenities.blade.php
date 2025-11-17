@extends('websitepages.layouts.app')

@section('title', $motel->name.' Amenities | bnbStay Motel')
@section('meta_description', 'Explore every experience and service offered at '.$motel->name.' with imagery and highlights.')

@push('styles')
    <style>
        :root {
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --accent: #b2560d;
            --accent-light: #d97706;
            --bg-soft: #f8fafc;
        }

        * {
            transition: all 0.3s ease;
        }

        body {
            background: #f8fafc;
        }

        .amenities-hero {
            max-width: 1400px;
            margin: 3rem auto 3rem;
            padding: 0 2rem;
        }

        .amenities-back {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.7rem 1.4rem;
            border-radius: 50px;
            background: white;
            border: 2px solid #e5e7eb;
            text-decoration: none;
            color: var(--text-dark);
            font-weight: 600;
            margin-bottom: 2rem;
            font-size: 0.95rem;
        }

        .amenities-back:hover {
            border-color: var(--accent);
            color: var(--accent);
            transform: translateX(-5px);
        }

        .hero-content {
            max-width: 900px;
        }

        .amenities-hero h1 {
            margin: 0 0 1rem;
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 900;
            color: var(--text-dark);
            letter-spacing: -0.04em;
            line-height: 1.1;
        }

        .amenities-hero p {
            margin: 0;
            color: var(--text-muted);
            line-height: 1.7;
            font-size: 1.15rem;
            max-width: 700px;
        }

        .amenities-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem 5rem;
        }

        .amenities-masonry {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
            gap: 2rem;
            align-items: start;
        }

        .amenity-item {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(0, 0, 0, 0.04);
            display: flex;
            flex-direction: column;
            break-inside: avoid;
            position: relative;
        }

        .amenity-item:hover {
            box-shadow: 0 12px 40px rgba(178, 86, 13, 0.15);
            transform: translateY(-5px);
        }

        .amenity-images {
            position: relative;
            display: grid;
            gap: 0.4rem;
            padding: 0.4rem;
            background: #f1f5f9;
        }

        .main-image-wrapper {
            position: relative;
            width: 100%;
            height: 320px;
            border-radius: 16px;
            overflow: hidden;
            cursor: pointer;
            isolation: isolate;
        }

        .main-image-wrapper::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(0deg, rgba(0,0,0,0.4) 0%, transparent 50%);
            opacity: 0;
            z-index: 1;
            transition: opacity 0.4s ease;
        }

        .main-image-wrapper:hover::before {
            opacity: 1;
        }

        .main-image-wrapper::after {
            content: '🔍 View';
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%) translateY(20px);
            background: white;
            padding: 0.6rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--text-dark);
            opacity: 0;
            z-index: 2;
            transition: all 0.4s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .main-image-wrapper:hover::after {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }

        .main-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.6s ease;
        }

        .main-image-wrapper:hover .main-image {
            transform: scale(1.08);
        }

        .image-gallery-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.4rem;
        }

        .gallery-thumb {
            position: relative;
            height: 90px;
            border-radius: 12px;
            overflow: hidden;
            cursor: pointer;
            background: #e5e7eb;
        }

        .gallery-thumb::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(178, 86, 13, 0.3);
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 1;
        }

        .gallery-thumb:hover::before {
            opacity: 1;
        }

        .gallery-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.4s ease;
        }

        .gallery-thumb:hover img {
            transform: scale(1.15);
        }

        .gallery-more {
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent-light) 100%);
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
            cursor: pointer;
            position: relative;
        }

        .gallery-more:hover {
            background: linear-gradient(135deg, var(--accent-light) 0%, var(--accent) 100%);
        }

        .amenity-content {
            padding: 1.8rem;
        }

        .amenity-header {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .amenity-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: linear-gradient(135deg, rgba(178, 86, 13, 0.1) 0%, rgba(217, 119, 6, 0.1) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .amenity-title {
            flex: 1;
        }

        .amenity-title h3 {
            margin: 0 0 0.3rem;
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--text-dark);
            letter-spacing: -0.02em;
            line-height: 1.3;
        }

        .amenity-title-link {
            color: inherit;
            text-decoration: none;
        }

        .amenity-title-link:hover {
            color: var(--accent);
        }

        .amenity-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            background: rgba(178, 86, 13, 0.08);
            color: var(--accent);
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .amenity-description {
            color: var(--text-muted);
            line-height: 1.7;
            font-size: 0.98rem;
            margin: 0;
        }

        .amenity-footer {
            padding: 0 1.8rem 1.8rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-top: 1px solid #f1f5f9;
            padding-top: 1.2rem;
            margin-top: 0.5rem;
        }

        .image-count {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-muted);
            font-size: 0.9rem;
            font-weight: 500;
        }

        .view-all-btn {
            padding: 0.5rem 1.2rem;
            background: var(--text-dark);
            color: white;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
        }

        .view-all-btn:hover {
            background: var(--accent);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(178, 86, 13, 0.3);
        }

        /* Lightbox Modal */
        .lightbox-modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.96);
            z-index: 9999;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            animation: fadeIn 0.3s ease;
        }

        .lightbox-modal.active {
            display: flex;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .lightbox-content {
            position: relative;
            max-width: 95vw;
            max-height: 90vh;
            animation: slideUp 0.4s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .lightbox-image {
            max-width: 100%;
            max-height: 90vh;
            width: auto;
            height: auto;
            border-radius: 12px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
            display: block;
        }

        .lightbox-close {
            position: absolute;
            top: -60px;
            right: 0;
            background: white;
            border: none;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1.8rem;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 300;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .lightbox-close:hover {
            background: var(--accent);
            color: white;
            transform: rotate(90deg);
        }

        .lightbox-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: white;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1.5rem;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .lightbox-nav:hover {
            background: var(--accent);
            color: white;
        }

        .lightbox-nav.prev {
            left: -70px;
        }

        .lightbox-nav.next {
            right: -70px;
        }

        .lightbox-info {
            position: absolute;
            bottom: -55px;
            left: 0;
            right: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .lightbox-title {
            background: white;
            padding: 0.7rem 1.5rem;
            border-radius: 50px;
            color: var(--text-dark);
            font-weight: 600;
            font-size: 0.95rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .lightbox-counter {
            background: white;
            padding: 0.7rem 1.5rem;
            border-radius: 50px;
            color: var(--text-dark);
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .amenities-pagination {
            max-width: 1400px;
            margin: 3rem auto 4rem;
            padding: 0 2rem;
            display: flex;
            justify-content: center;
        }

        .amenities-empty {
            max-width: 700px;
            margin: 5rem auto;
            padding: 4rem 3rem;
            text-align: center;
            background: white;
            border-radius: 24px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        }

        .amenities-empty::before {
            content: '🏨';
            display: block;
            font-size: 4rem;
            margin-bottom: 1.5rem;
        }

        .amenities-empty h2 {
            margin-bottom: 1rem;
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .amenities-empty p {
            margin: 0;
            color: var(--text-muted);
            line-height: 1.8;
            font-size: 1.05rem;
        }

        @media (max-width: 1024px) {
            .amenities-masonry {
                grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
                gap: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .amenities-hero {
                margin: 2rem auto;
                padding: 0 1.5rem;
            }

            .amenities-hero h1 {
                font-size: 2.2rem;
            }

            .amenities-container {
                padding: 0 1.5rem 3rem;
            }

            .amenities-masonry {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .main-image-wrapper {
                height: 240px;
            }

            .gallery-thumb {
                height: 70px;
            }

            .lightbox-nav.prev {
                left: 10px;
            }

            .lightbox-nav.next {
                right: 10px;
            }

            .lightbox-close {
                top: 10px;
                right: 10px;
            }

            .lightbox-info {
                position: static;
                margin-top: 1rem;
                flex-direction: column;
                gap: 0.5rem;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
@endpush

@section('content')
    <section class="amenities-hero">
        <a href="{{ route('website.motels.show', $motel) }}" class="amenities-back">
            ← Back to {{ $motel->name }}
        </a>
        <div class="hero-content">
            <h1>Amenities & Experiences</h1>
            <p>Discover every curated service and thoughtful detail at {{ $motel->name }}. Click any image to explore the full gallery.</p>
        </div>
    </section>

    @if($amenities->count())
        <section class="amenities-container">
            <div class="amenities-masonry">
                @foreach($amenities as $amenity)
                    @php
                        $amenityIndex = $loop->index;
                        $imageCollection = collect($amenity['images']);
                        $thumbImages = $imageCollection->slice(1, 3)->values();
                        $extraCount = max($imageCollection->count() - (1 + $thumbImages->count()), 0);
                        $amenityDetailUrl = !empty($amenity['amenity_id'])
                            ? route('website.amenities.show', $amenity['amenity_id'])
                            : null;
                    @endphp
                    <article class="amenity-item" data-amenity-id="{{ $amenityIndex }}">
                        <div class="amenity-images">
                            <div class="main-image-wrapper js-open-lightbox"
                                 data-amenity="{{ $amenityIndex }}"
                                 data-image="0">
                                <img class="main-image" src="{{ $amenity['primary_image'] }}" alt="{{ $amenity['name'] }}">
                            </div>
                            
                            @if($imageCollection->count() > 1)
                                <div class="image-gallery-grid">
                                    @foreach($thumbImages as $thumbIndex => $thumb)
                                        @php
                                            $isLastThumb = $loop->last && $extraCount > 0;
                                            $imagePosition = $thumbIndex + 1;
                                        @endphp
                                        <div class="gallery-thumb {{ $isLastThumb ? 'gallery-more' : '' }} js-open-lightbox"
                                             data-amenity="{{ $amenityIndex }}"
                                             data-image="{{ $imagePosition }}">
                                            @if($isLastThumb)
                                                +{{ $extraCount }}
                                            @else
                                                <img src="{{ $thumb['url'] }}" alt="{{ $amenity['name'] }}">
                                            @endif
                                        </div>
                                    @endforeach

                                    @if($thumbImages->isEmpty())
                                        <div class="gallery-thumb js-open-lightbox"
                                             data-amenity="{{ $amenityIndex }}"
                                             data-image="1">
                                            <img src="{{ $amenity['primary_image'] }}" alt="{{ $amenity['name'] }}">
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="amenity-content">
                            <div class="amenity-header">
                                <div class="amenity-icon">✦</div>
                                <div class="amenity-title">
                                    <h3>
                                        @if($amenityDetailUrl)
                                            <a class="amenity-title-link"
                                               href="{{ $amenityDetailUrl }}"
                                               aria-label="View motels that feature {{ $amenity['name'] }}">
                                                {{ $amenity['name'] }}
                                            </a>
                                        @else
                                            {{ $amenity['name'] }}
                                        @endif
                                    </h3>
                                    <span class="amenity-badge">Featured</span>
                                </div>
                            </div>
                            <p class="amenity-description">
                                @if(!empty($amenity['description']))
                                    {{ $amenity['description'] }}
                                @else
                                    Experience this premium amenity designed for your comfort and convenience.
                                @endif
                            </p>
                        </div>

                        <div class="amenity-footer">
                            <div class="image-count">
                                📸 {{ $imageCollection->count() }} {{ $imageCollection->count() === 1 ? 'photo' : 'photos' }}
                            </div>
                            <button class="view-all-btn js-open-lightbox"
                                    type="button"
                                    data-amenity="{{ $amenityIndex }}"
                                    data-image="0">
                                View Gallery
                            </button>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>

        <div class="amenities-pagination">
            {{ $amenities->withQueryString()->links() }}
        </div>

        @php
            $lightboxPayload = $amenities->map(function ($amenity) {
                return [
                    'name' => $amenity['name'],
                    'images' => $amenity['images'],
                ];
            })->values()->toJson();
        @endphp

        <!-- Lightbox Modal -->
        <div class="lightbox-modal" id="lightbox" onclick="if(event.target === this) closeLightbox()">
            <div class="lightbox-content">
                <button class="lightbox-close" onclick="closeLightbox()">×</button>
                <button class="lightbox-nav prev" onclick="navigateLightbox(-1)">‹</button>
                <img class="lightbox-image" id="lightboxImage" src="" alt="">
                <button class="lightbox-nav next" onclick="navigateLightbox(1)">›</button>
                <div class="lightbox-info">
                    <div class="lightbox-title" id="lightboxTitle"></div>
                    <div class="lightbox-counter" id="lightboxCounter"></div>
                </div>
            </div>
        </div>

        <script>
            const amenitiesData = <?php echo $lightboxPayload; ?>;

            let currentAmenityIndex = 0;
            let currentImageIndex = 0;

            function openLightbox(amenityIndex, imageIndex) {
                currentAmenityIndex = amenityIndex;
                currentImageIndex = imageIndex;
                updateLightbox();
                document.getElementById('lightbox').classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            function closeLightbox() {
                document.getElementById('lightbox').classList.remove('active');
                document.body.style.overflow = '';
            }

            function navigateLightbox(direction) {
                const amenity = amenitiesData[currentAmenityIndex];
                currentImageIndex += direction;
                
                if (currentImageIndex < 0) {
                    currentImageIndex = amenity.images.length - 1;
                } else if (currentImageIndex >= amenity.images.length) {
                    currentImageIndex = 0;
                }
                
                updateLightbox();
            }

            function updateLightbox() {
                const amenity = amenitiesData[currentAmenityIndex];
                const image = amenity.images[currentImageIndex];
                
                document.getElementById('lightboxImage').src = image.url;
                document.getElementById('lightboxTitle').textContent = amenity.name;
                document.getElementById('lightboxCounter').textContent = `${currentImageIndex + 1} / ${amenity.images.length}`;
            }

            document.addEventListener('keydown', function(e) {
                const lightbox = document.getElementById('lightbox');
                if (!lightbox.classList.contains('active')) return;
                
                if (e.key === 'Escape') {
                    closeLightbox();
                } else if (e.key === 'ArrowLeft') {
                    navigateLightbox(-1);
                } else if (e.key === 'ArrowRight') {
                    navigateLightbox(1);
                }
            });

            document.querySelectorAll('.js-open-lightbox').forEach((trigger) => {
                trigger.addEventListener('click', () => {
                    const amenityIndex = Number(trigger.dataset.amenity ?? 0);
                    const imageIndex = Number(trigger.dataset.image ?? 0);
                    openLightbox(amenityIndex, imageIndex);
                });
            });
        </script>
    @else
        <div class="amenities-empty">
            <h2>Amenities Coming Soon</h2>
            <p>We're curating beautiful imagery and details for each amenity. Check back soon!</p>
        </div>
    @endif
@endsection