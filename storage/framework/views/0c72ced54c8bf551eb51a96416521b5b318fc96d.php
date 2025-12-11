<?php $__env->startPush('styles'); ?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap');

    .whyus-section {
        padding: 3rem 1rem 4rem;
        background: #ffffff;
        font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, sans-serif;
        position: relative;
    }

    .whyus-container {
        max-width: 1400px;
        margin: 0 auto;
    }

    .whyus-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .whyus-label {
        display: inline-block;
        font-size: 0.9rem;
        font-weight: 600;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: #0ea5e9;
        margin-bottom: 1.25rem;
    }

    .whyus-title {
        font-size: clamp(2.5rem, 5vw, 3.5rem);
        font-weight: 700;
        color: #0f172a;
        letter-spacing: -0.02em;
        line-height: 1.2;
        margin: 0 0 1.25rem;
    }

    .whyus-subtitle {
        font-size: 1.25rem;
        color: #475569;
        line-height: 1.7;
        max-width: 650px;
        margin: 0 auto;
    }

    .whyus-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
    }

    .whyus-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 2.5rem 2rem;
        border: 1px solid #e2e8f0;
        transition: all 0.3s ease;
        text-align: center;
    }

    .whyus-card:hover {
        border-color: rgba(14, 165, 233, 0.3);
        box-shadow: 0 20px 40px rgba(15, 23, 42, 0.08);
        transform: translateY(-6px);
    }

    .whyus-icon {
        width: 72px;
        height: 72px;
        margin: 0 auto 1.75rem;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.3s ease;
    }

    .whyus-icon svg {
        width: 32px;
        height: 32px;
    }

    .whyus-card:nth-child(1) .whyus-icon {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    }
    .whyus-card:nth-child(1) .whyus-icon svg {
        color: #2563eb;
    }

    .whyus-card:nth-child(2) .whyus-icon {
        background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
    }
    .whyus-card:nth-child(2) .whyus-icon svg {
        color: #16a34a;
    }

    .whyus-card:nth-child(3) .whyus-icon {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    }
    .whyus-card:nth-child(3) .whyus-icon svg {
        color: #d97706;
    }

    .whyus-card:hover .whyus-icon {
        transform: scale(1.08);
    }

    .whyus-card-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 1rem;
        line-height: 1.3;
    }

    .whyus-card-desc {
        font-size: 1.05rem;
        color: #475569;
        line-height: 1.7;
        margin: 0;
    }

    @media (max-width: 1024px) {
        .whyus-grid {
            gap: 1.5rem;
        }

        .whyus-card {
            padding: 2rem 1.5rem;
        }
    }

    @media (max-width: 768px) {
        .whyus-section {
            padding: 3rem 0.75rem;
        }

        .whyus-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
            max-width: 480px;
            margin: 0 auto;
        }
    }

    @media (max-width: 480px) {
        .whyus-title {
            font-size: 2rem;
        }

        .whyus-subtitle {
            font-size: 1.1rem;
        }

        .whyus-icon {
            width: 64px;
            height: 64px;
        }

        .whyus-icon svg {
            width: 28px;
            height: 28px;
        }

        .whyus-card-title {
            font-size: 1.25rem;
        }

        .whyus-card-desc {
            font-size: 1rem;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<section class="whyus-section">
    <div class="whyus-container">
        <div class="whyus-header">
            <span class="whyus-label">Why Choose Us</span>
            <h2 class="whyus-title">Why Booking With Us?</h2>
            <p class="whyus-subtitle">Discover a better way to find your next home. We combine local expertise, verified listings, and fast customer support to give you a seamless and secure property booking experience.</p>
        </div>

        <div class="whyus-grid">
            <!-- Card 1: Professional Agents -->
            <div class="whyus-card">
                <div class="whyus-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <h3 class="whyus-card-title">Professional Agents</h3>
                <p class="whyus-card-desc">Work with experienced, licensed agents who understand the local market and guide you at every step.</p>
            </div>

            <!-- Card 2: Verified Properties -->
            <div class="whyus-card">
                <div class="whyus-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                </div>
                <h3 class="whyus-card-title">Verified Properties Only</h3>
                <p class="whyus-card-desc">We list only verified and inspected properties, ensuring you avoid scams or misleading deals.</p>
            </div>

            <!-- Card 3: Transparent Pricing -->
            <div class="whyus-card">
                <div class="whyus-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="1" x2="12" y2="23"/>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                    </svg>
                </div>
                <h3 class="whyus-card-title">Transparent Pricing</h3>
                <p class="whyus-card-desc">No hidden costs. What you see is what you get — we show you all fees upfront so you can plan your budget.</p>
            </div>
        </div>
    </div>
</section>
<?php /**PATH C:\Users\iuser\Desktop\PROJECTS\BNB PROJECT\bnbbackendlaravel\resources\views/websitepages/homepage/whyus.blade.php ENDPATH**/ ?>