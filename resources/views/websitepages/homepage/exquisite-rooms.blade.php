@php
    $motelsToShow = collect($spotlightMotels ?? [])->take(9);
@endphp
<!-- Featured Motels / Our Exquisite Rooms Section -->
 <br>
@if($motelsToShow->isNotEmpty())
    <section class="exquisite-rooms-section">
        <div class="container">
            <!-- Section Header -->
            <div class="section-header" data-aos="fade-up">
                 <h2 class="section-title">{{ __('website.home_exquisite.title') }}</h2>
                <p class="section-subtitle">
                    {{ __('website.home_exquisite.subtitle') }}
                 </p>
            </div>
            <br>

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
.exquisite-rooms-section {
    padding: 10px 0;
    background: linear-gradient(180deg, #fafafa 0%, #ffffff 100%);
    position: relative;
    overflow: hidden;
    width: 100vw;
    margin-left: calc(50% - 50vw);
    margin-right: calc(50% - 50vw);
}

.exquisite-rooms-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, #e5e5e5 50%, transparent);
}

.container {
    width: 100%;
    max-width: none;
    margin: 0;
    padding: 0 30px;
}

.section-header {
    text-align: center;
    max-width: 720px;
    margin: 0 auto 40px;
}

.section-title {
    font-size: clamp(32px, 5vw, 48px);
    font-weight: 700;
    color: #1a1a1a;
    margin: 0 0 16px;
    letter-spacing: -0.02em;
    line-height: 1.2;
}

.section-subtitle {
    font-size: 18px;
    line-height: 1.7;
    color: #666666;
    margin: 0;
}

.motels-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 20px;
}

@media (max-width: 900px) {
    .motels-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 768px) {
    .exquisite-rooms-section {
        padding: 45px 0;
    }

    .section-header {
        margin-bottom: 32px;
    }

    .motels-grid {
        grid-template-columns: 1fr;
        gap: 24px;
    }
}

@media (max-width: 480px) {
    .container {
        padding: 0 20px;
    }

    .section-subtitle {
        font-size: 16px;
    }
}
</style>