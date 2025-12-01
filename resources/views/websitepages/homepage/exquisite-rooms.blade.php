@php
    $motelsToShow = collect($spotlightMotels ?? [])->take(18);
@endphp
<!-- Featured Motels / Our Exquisite Rooms Section -->
@if($motelsToShow->isNotEmpty())
    <section class="exquisite-rooms-section">
        <div class="ers-container">
            <!-- Section Header -->
            <div class="ers-header" data-aos="fade-up">
                <span class="ers-label">Featured Stays</span>
                <h2 class="ers-title">{{ __('website.home_exquisite.title') }}</h2>
                <p class="ers-subtitle">{{ __('website.home_exquisite.subtitle') }}</p>
            </div>

            <!-- Motels Grid -->
            <div class="motels-grid">
                @foreach($motelsToShow as $index => $motel)
                    <x-motel-card :motel="$motel" data-aos="fade-up" :data-aos-delay="$index * 100" />
                @endforeach
            </div>
        </div>
    </section>
@endif

<style>
@import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap');

.exquisite-rooms-section {
    padding: 3rem 1rem 4rem;
    background: #ffffff;
    position: relative;
    overflow: hidden;
    width: 100vw;
    margin-left: calc(50% - 50vw);
    margin-right: calc(50% - 50vw);
    font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, sans-serif;
}

.ers-container {
    width: 100%;
    max-width: 100%;
    margin: 0 auto;
    padding: 0 1rem;
}

.ers-header {
    text-align: center;
    margin-bottom: 3rem;
}

.ers-label {
    display: inline-block;
    font-size: 0.9rem;
    font-weight: 600;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: #0ea5e9;
    margin-bottom: 1.25rem;
}

.ers-title {
    font-size: clamp(2.5rem, 5vw, 3.5rem);
    font-weight: 700;
    color: #0f172a;
    letter-spacing: -0.02em;
    line-height: 1.2;
    margin: 0 0 1.25rem;
}

.ers-subtitle {
    font-size: 1.25rem;
    color: #475569;
    line-height: 1.7;
    max-width: 600px;
    margin: 0 auto;
}

.motels-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 2.5rem;
}

@media (max-width: 1100px) {
    .exquisite-rooms-section {
        padding: 5rem 0.75rem;
    }

    .motels-grid {
        gap: 1.5rem;
    }
}

@media (max-width: 900px) {
    .motels-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .ers-header {
        margin-bottom: 3.5rem;
    }
}

@media (max-width: 768px) {
    .exquisite-rooms-section {
        padding: 4rem 0.5rem;
    }

    .ers-container {
        padding: 0 0.5rem;
    }

    .motels-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
}

@media (max-width: 480px) {
    .ers-title {
        font-size: 2rem;
    }

    .ers-subtitle {
        font-size: 1.1rem;
    }
}
</style>
