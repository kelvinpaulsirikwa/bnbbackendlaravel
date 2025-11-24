@php
    $stepsTitle = __('website.home.steps.title');
    $stepsSubtitle = __('website.home.steps.subtitle');
    $step1Title = __('website.home.steps.step1.title');
    $step1Desc = __('website.home.steps.step1.desc');
    $step2Title = __('website.home.steps.step2.title');
    $step2Desc = __('website.home.steps.step2.desc');
    $step3Title = __('website.home.steps.step3.title');
    $step3Desc = __('website.home.steps.step3.desc');

    $defaults = [
        'website.home.steps.title' => 'How It Works',
        'website.home.steps.subtitle' => 'Three simple steps to plan your next stay with confidence.',
        'website.home.steps.step1.title' => 'Download & Sign in with Google',
        'website.home.steps.step1.desc' => 'Get the BnB app on Android or iOS, then sign in instantly with your Google account to sync preferences and reservations.',
        'website.home.steps.step2.title' => 'Choose, You Choose & Book',
        'website.home.steps.step2.desc' => 'Browse curated stays, compare amenities, and confirm the perfect space with just a few taps.',
        'website.home.steps.step3.title' => 'Enjoy the Stay',
        'website.home.steps.step3.desc' => 'Arrive relaxed knowing everything is ready. Enjoy seamless hospitality and support throughout your stay.',
    ];

    $stepsTitle = $stepsTitle === 'website.home.steps.title' ? $defaults['website.home.steps.title'] : $stepsTitle;
    $stepsSubtitle = $stepsSubtitle === 'website.home.steps.subtitle' ? $defaults['website.home.steps.subtitle'] : $stepsSubtitle;
    $step1Title = $step1Title === 'website.home.steps.step1.title' ? $defaults['website.home.steps.step1.title'] : $step1Title;
    $step1Desc = $step1Desc === 'website.home.steps.step1.desc' ? $defaults['website.home.steps.step1.desc'] : $step1Desc;
    $step2Title = $step2Title === 'website.home.steps.step2.title' ? $defaults['website.home.steps.step2.title'] : $step2Title;
    $step2Desc = $step2Desc === 'website.home.steps.step2.desc' ? $defaults['website.home.steps.step2.desc'] : $step2Desc;
    $step3Title = $step3Title === 'website.home.steps.step3.title' ? $defaults['website.home.steps.step3.title'] : $step3Title;
    $step3Desc = $step3Desc === 'website.home.steps.step3.desc' ? $defaults['website.home.steps.step3.desc'] : $step3Desc;
@endphp

<section class="steps-section">
    <style>
        .steps-section {
            padding: clamp(4rem, 8vw, 6rem) clamp(1.5rem, 6vw, 4rem);
            background: #f8fafc;
        }

        .steps-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
        }

        .steps-heading {
            font-size: clamp(2.25rem, 4vw, 3.25rem);
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.02em;
        }

        .steps-subtitle {
            margin: 1rem auto 3rem;
            max-width: 640px;
            color: #64748b;
            font-size: 1.1rem;
            line-height: 1.7;
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .step-card {
            background: #ffffff;
            border-radius: 32px;
            padding: 2.5rem 2rem;
            border: 1px solid rgba(15, 23, 42, 0.06);
            box-shadow: 0 25px 60px rgba(15, 23, 42, 0.08);
            position: relative;
            text-align: left;
            overflow: visible;
            transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
        }

        .step-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 40px 90px rgba(37, 99, 235, 0.15);
            border-color: rgba(37, 99, 235, 0.5);
        }

        .step-card.highlight,
        .step-card:hover {
            border-color: rgba(37, 99, 235, 0.5);
            box-shadow: 0 40px 90px rgba(37, 99, 235, 0.2);
        }

        .step-index {
            width: 60px;
            height: 60px;
            border-radius: 999px;
            background: linear-gradient(135deg, #2b70f7 0%, #1a5fd6 100%);
            color: #ffffff;
            font-weight: 700;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            top: -30px;
            right: 40px;
            box-shadow: 0 20px 40px rgba(43, 112, 247, 0.35);
        }

        .step-icon {
            width: 64px;
            height: 64px;
            border-radius: 18px;
            background: #eff6ff;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            font-size: 1.75rem;
            color: #2563eb;
        }

        .step-title {
            font-size: 1.45rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.75rem;
        }

        .step-desc {
            color: #475569;
            line-height: 1.7;
            font-size: 1rem;
        }

        @media (max-width: 640px) {
            .step-card {
                padding: 2rem;
            }

            .step-index {
                right: 20px;
            }
        }
    </style>

    <div class="steps-wrapper">
        <h2 class="steps-heading">{{ $stepsTitle }}</h2>
        <p class="steps-subtitle">
            {{ $stepsSubtitle }}
        </p>

        <div class="steps-grid">
            <div class="step-card">
                <div class="step-index">1</div>
                <div class="step-icon">⚡</div>
                <h3 class="step-title">{{ $step1Title }}</h3>
                <p class="step-desc">
                    {{ $step1Desc }}
                </p>
            </div>

            <div class="step-card">
                <div class="step-index">2</div>
                <div class="step-icon">🧭</div>
                <h3 class="step-title">{{ $step2Title }}</h3>
                <p class="step-desc">
                    {{ $step2Desc }}
                </p>
            </div>

            <div class="step-card highlight">
                <div class="step-index">3</div>
                <div class="step-icon">🎉</div>
                <h3 class="step-title">{{ $step3Title }}</h3>
                <p class="step-desc">
                    {{ $step3Desc }}
                </p>
            </div>
        </div>
    </div>
</section>

