<?php
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
?>

<section class="hiw-section">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap');

        .hiw-section {
            --hiw-primary: #0f172a;
            --hiw-secondary: #475569;
            --hiw-accent: #0ea5e9;
            --hiw-accent-dark: #0284c7;
            --hiw-light: #ffffff;
            --hiw-border: #e2e8f0;
            
            padding: 3rem 3rem 4rem;
            background: #ffffff;
            font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            position: relative;
        }

        .hiw-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .hiw-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .hiw-label {
            display: inline-block;
            font-size: 0.9rem;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--hiw-accent);
            margin-bottom: 1.25rem;
        }

        .hiw-title {
            font-size: clamp(2.5rem, 5vw, 3.5rem);
            font-weight: 700;
            color: var(--hiw-primary);
            letter-spacing: -0.02em;
            line-height: 1.2;
            margin: 0 0 1.25rem;
        }

        .hiw-subtitle {
            font-size: 1.25rem;
            color: var(--hiw-secondary);
            line-height: 1.7;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Steps Container */
        .hiw-steps {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2.5rem;
            position: relative;
        }

        /* Connecting Line */
        .hiw-steps::before {
            content: '';
            position: absolute;
            top: 38px;
            left: calc(16.66% + 38px);
            right: calc(16.66% + 38px);
            height: 3px;
            background: var(--hiw-border);
            border-radius: 2px;
        }

        .hiw-steps::after {
            content: '';
            position: absolute;
            top: 38px;
            left: calc(16.66% + 38px);
            width: 33.33%;
            height: 3px;
            background: var(--hiw-accent);
            border-radius: 2px;
        }

        /* Step Item */
        .hiw-step {
            text-align: center;
            position: relative;
        }

        /* Step Number */
        .hiw-step-num {
            width: 76px;
            height: 76px;
            margin: 0 auto 2.5rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 700;
            position: relative;
            z-index: 2;
            transition: all 0.3s ease;
        }

        .hiw-step:nth-child(1) .hiw-step-num {
            background: var(--hiw-accent);
            color: #fff;
            box-shadow: 0 8px 24px rgba(14, 165, 233, 0.4);
        }

        .hiw-step:nth-child(2) .hiw-step-num,
        .hiw-step:nth-child(3) .hiw-step-num {
            background: #fff;
            color: var(--hiw-primary);
            border: 2px solid var(--hiw-border);
        }

        .hiw-step:hover .hiw-step-num {
            background: var(--hiw-accent);
            color: #fff;
            border-color: var(--hiw-accent);
            box-shadow: 0 8px 24px rgba(14, 165, 233, 0.4);
            transform: scale(1.08);
        }

        /* Step Card */
        .hiw-card {
            background: #fff;
            border-radius: 20px;
            padding: 2.75rem 2rem 3rem;
            border: 1px solid var(--hiw-border);
            transition: all 0.3s ease;
            height: 100%;
        }

        .hiw-step:hover .hiw-card {
            border-color: rgba(14, 165, 233, 0.3);
            box-shadow: 0 24px 48px rgba(15, 23, 42, 0.1);
            transform: translateY(-6px);
        }

        /* Icon */
        .hiw-icon {
            width: 72px;
            height: 72px;
            margin: 0 auto 2rem;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease;
        }

        .hiw-icon svg {
            width: 32px;
            height: 32px;
        }

        .hiw-step:nth-child(1) .hiw-icon {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        }
        .hiw-step:nth-child(1) .hiw-icon svg {
            color: #d97706;
        }

        .hiw-step:nth-child(2) .hiw-icon {
            background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
        }
        .hiw-step:nth-child(2) .hiw-icon svg {
            color: #0284c7;
        }

        .hiw-step:nth-child(3) .hiw-icon {
            background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
        }
        .hiw-step:nth-child(3) .hiw-icon svg {
            color: #16a34a;
        }

        .hiw-step:hover .hiw-icon {
            transform: scale(1.08);
        }

        /* Card Title */
        .hiw-card-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--hiw-primary);
            margin: 0 0 1rem;
            line-height: 1.4;
        }

        /* Card Description */
        .hiw-card-desc {
            font-size: 1.1rem;
            color: var(--hiw-secondary);
            line-height: 1.8;
            margin: 0;
        }

        /* Responsive */
        @media (max-width: 1100px) {
            .hiw-section {
                padding: 5rem 2rem;
            }

            .hiw-steps {
                gap: 2rem;
            }

            .hiw-card {
                padding: 2.25rem 1.5rem 2.5rem;
            }
        }

        @media (max-width: 900px) {
            .hiw-steps {
                grid-template-columns: 1fr;
                gap: 3rem;
                max-width: 500px;
                margin: 0 auto;
            }

            .hiw-steps::before,
            .hiw-steps::after {
                display: none;
            }

            .hiw-step-num {
                margin-bottom: 2rem;
            }

            .hiw-card {
                padding: 2.5rem 2rem;
            }
        }

        @media (max-width: 480px) {
            .hiw-section {
                padding: 4rem 1.25rem;
            }

            .hiw-header {
                margin-bottom: 3.5rem;
            }

            .hiw-title {
                font-size: 2rem;
            }

            .hiw-subtitle {
                font-size: 1.1rem;
            }

            .hiw-step-num {
                width: 64px;
                height: 64px;
                font-size: 1.25rem;
            }

            .hiw-icon {
                width: 64px;
                height: 64px;
            }

            .hiw-icon svg {
                width: 28px;
                height: 28px;
            }

            .hiw-card-title {
                font-size: 1.25rem;
            }

            .hiw-card-desc {
                font-size: 1rem;
            }
        }
    </style>

    <div class="hiw-container">
        <div class="hiw-header">
            <span class="hiw-label">Get Started</span>
            <h2 class="hiw-title"><?php echo e($stepsTitle); ?></h2>
            <p class="hiw-subtitle"><?php echo e($stepsSubtitle); ?></p>
        </div>

        <div class="hiw-steps">
            <!-- Step 1 -->
            <div class="hiw-step">
                <div class="hiw-step-num">1</div>
                <div class="hiw-card">
                    <div class="hiw-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
                        </svg>
                    </div>
                    <h3 class="hiw-card-title"><?php echo e($step1Title); ?></h3>
                    <p class="hiw-card-desc"><?php echo e($step1Desc); ?></p>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="hiw-step">
                <div class="hiw-step-num">2</div>
                <div class="hiw-card">
                    <div class="hiw-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/>
                        </svg>
                    </div>
                    <h3 class="hiw-card-title"><?php echo e($step2Title); ?></h3>
                    <p class="hiw-card-desc"><?php echo e($step2Desc); ?></p>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="hiw-step">
                <div class="hiw-step-num">3</div>
                <div class="hiw-card">
                    <div class="hiw-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                    </div>
                    <h3 class="hiw-card-title"><?php echo e($step3Title); ?></h3>
                    <p class="hiw-card-desc"><?php echo e($step3Desc); ?></p>
                </div>
            </div>
        </div>
    </div>
</section>
<?php /**PATH C:\Users\iuser\Desktop\PROJECTS\BNB PROJECT\bnbbackendlaravel\resources\views/websitepages/homepage/howitworks.blade.php ENDPATH**/ ?>