    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #1a1a2e;
            --accent: #d4a574;
            --light: #f8f9fa;
            --dark: #0f0f1e;
            --text: #2d3748;
            --border: #e2e8f0;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--text);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Hero Section */
        .hero {
            position: relative;
            min-height: 100vh;
            padding: clamp(3rem, 6vw, 6rem);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: #0b1324;
            width: 100vw;
            margin-left: calc(50% - 50vw);
            margin-right: calc(50% - 50vw);
        }

        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(90deg, rgba(5, 9, 20, 0.95) 0%, rgba(8, 12, 25, 0.8) 45%, rgba(12, 18, 30, 0.55) 70%),
                url("{{ asset('images/static_file/welcomeimage.png') }}");
            background-size: cover;
            background-position: center;
            filter: saturate(110%);
            transform: scale(1.05);
            animation: heroZoom 24s ease-in-out infinite alternate;
            z-index: 0;
        }

        .hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 75% 20%, rgba(30, 64, 175, 0.45), transparent 45%);
            z-index: 0;
        }

        .hero-inner {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 100%;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: clamp(2rem, 5vw, 4rem);
            flex-wrap: wrap;
        }

        .hero-content {
            flex: 1 1 420px;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        @keyframes heroZoom {
            from { transform: scale(1.05); }
            to { transform: scale(1.15); }
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: rgba(212, 165, 116, 0.15);
            border: 1px solid rgba(212, 165, 116, 0.3);
            border-radius: 50px;
            color: var(--accent);
            font-size: 0.875rem;
            font-weight: 600;
            width: fit-content;
            margin-bottom: 2rem;
            letter-spacing: 0.5px;
        }

        .hero-title {
            font-size: clamp(2.5rem, 5vw, 4.5rem);
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            letter-spacing: -0.02em;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            line-height: 1.7;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 2.5rem;
            max-width: 500px;
        }

        .hero-actions {
            margin-top: 0.5rem;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .hero-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.85rem 1.75rem;
            border-radius: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
            border: 1px solid transparent;
        }

        .hero-btn.primary {
            background: #0b5ed7;
            color: #ffffff;
            box-shadow: 0 15px 40px rgba(11, 94, 215, 0.35);
        }

        .hero-btn.secondary {
            background: rgba(255, 255, 255, 0.95);
            color: #0b5ed7;
            border-color: rgba(255, 255, 255, 0.5);
        }

        .hero-btn:hover {
            transform: translateY(-3px);
        }

        .hero-floating {
            flex: 0 0 auto;
            width: clamp(320px, 28vw, 380px);
            height: clamp(420px, 34vw, 460px);
            position: relative;
        }

        .floating-card {
            position: absolute;
            background: #ffffff;
            border-radius: 28px;
            padding: 1.35rem 1.65rem;
            min-width: 240px;
            box-shadow: 0 25px 45px rgba(9, 12, 30, 0.2);
            border: 1px solid rgba(15, 23, 42, 0.06);
            display: flex;
            align-items: center;
            gap: 1.25rem;
            animation: float 6s ease-in-out infinite;
        }

        .hero-floating .floating-card + .floating-card {
            margin-top: 1rem;
        }

        .floating-card:nth-child(1) {
            top: 0;
            left: 0;
        }

        .floating-card:nth-child(2) {
            top: 150px;
            right: 0;
            animation-delay: 0.8s;
        }

        .floating-card:nth-child(3) {
            top: 320px;
            left: 0;
            animation-delay: 1.6s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
        }

        .metric-card {
            display: flex;
            flex-direction: column;
            gap: 0.15rem;
        }

        .metric-label {
            font-size: 0.75rem;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            margin-bottom: 0.35rem;
            font-weight: 700;
        }

        .metric-value {
            font-size: 2rem;
            font-weight: 800;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }

        .metric-helper {
            font-size: 0.95rem;
            color: #1e293b;
            font-weight: 600;
            opacity: 0.9;
        }

        .metric-icon {
            width: 56px;
            height: 56px;
            border-radius: 18px;
            background: rgba(59, 130, 246, 0.15);
            color: #2563eb;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.35rem;
            flex-shrink: 0;
        }

        .floating-card:nth-child(2) .metric-icon {
            background: rgba(99, 102, 241, 0.18);
            color: #4f46e5;
        }

        .floating-card:nth-child(3) .metric-icon {
            background: rgba(16, 185, 129, 0.18);
            color: #0f9f6e;
        }

        /* Stats Section */
        .stats {
            background: white;
            padding: 2rem 6rem;
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 2rem;
            box-shadow: 0 -10px 30px rgba(0, 0, 0, 0.05);
            position: relative;
            z-index: 10;
        }

        .stat-item {
            text-align: center;
            padding: 1rem;
            transition: transform 0.3s ease;
        }

        .stat-item:hover {
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--accent);
            line-height: 1;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .stat-desc {
            font-size: 0.75rem;
            color: #718096;
            margin-top: 0.25rem;
        }

        /* Featured Rooms */
        .rooms-section {
            padding: 6rem;
            background: linear-gradient(180deg, #fafbfc 0%, #ffffff 100%);
        }

        .section-header {
            text-align: center;
            max-width: 700px;
            margin: 0 auto 4rem;
        }

        .section-tag {
            display: inline-block;
            padding: 0.5rem 1.25rem;
            background: var(--primary);
            color: white;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            border-radius: 50px;
            margin-bottom: 1.5rem;
        }

        .section-title {
            font-size: clamp(2rem, 4vw, 3.5rem);
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 1rem;
            letter-spacing: -0.02em;
        }

        .section-desc {
            font-size: 1.125rem;
            color: #718096;
            line-height: 1.7;
        }

        /* Rooms Grid - Masonry Style */
        .rooms-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .room-card {
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
        }

        .room-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .room-image-wrapper {
            position: relative;
            height: 300px;
            overflow: hidden;
        }

        .room-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .room-card:hover .room-image {
            transform: scale(1.1);
        }

        .room-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 40%, rgba(0, 0, 0, 0.8) 100%);
            display: flex;
            align-items: flex-end;
            padding: 1.5rem;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .room-card:hover .room-overlay {
            opacity: 1;
        }

        .quick-view {
            padding: 0.75rem 1.5rem;
            background: white;
            color: var(--primary);
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.875rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .quick-view:hover {
            background: var(--accent);
            color: white;
        }

        .room-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.5rem 1rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 700;
            color: #d4a017;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .room-content {
            padding: 2rem;
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
            flex: 1;
        }

        .room-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            line-height: 1.3;
        }

        .room-desc {
            font-size: 0.95rem;
            color: #718096;
            line-height: 1.6;
            line-clamp: 2;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .amenities {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .amenity {
            padding: 0.5rem 1rem;
            background: #f7fafc;
            border-radius: 50px;
            font-size: 0.8rem;
            color: var(--text);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            transition: all 0.3s ease;
        }

        .amenity:hover {
            background: var(--primary);
            color: white;
        }

        .room-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1.5rem;
            border-top: 2px solid #f7fafc;
            margin-top: auto;
        }

        .price-box {
            display: flex;
            flex-direction: column;
        }

        .price-label {
            font-size: 0.7rem;
            color: #a0aec0;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        .price {
            font-size: 2rem;
            font-weight: 800;
            color: var(--primary);
            line-height: 1;
        }

        .price-period {
            font-size: 0.875rem;
            color: #718096;
        }

        .book-btn {
            padding: 0.875rem 1.75rem;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .book-btn:hover {
            background: var(--accent);
            transform: translateX(5px);
        }

        /* View All Section */
        .view-all {
            text-align: center;
        }

        .view-all-btn {
            display: inline-flex;
            align-items: center;
            gap: 1rem;
            padding: 1.25rem 3rem;
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
            border-radius: 50px;
            font-weight: 700;
            text-decoration: none;
            font-size: 1rem;
            letter-spacing: 0.5px;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .view-all-btn::before {
            content: '';
            position: absolute;
            inset: 0;
            background: var(--primary);
            transform: scaleX(0);
            transition: transform 0.4s ease;
            z-index: -1;
        }

        .view-all-btn:hover::before {
            transform: scaleX(1);
        }

        .view-all-btn:hover {
            color: white;
            border-color: var(--primary);
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .hero-inner {
                flex-direction: column;
                gap: 2.5rem;
            }

            .hero-floating {
                width: 100%;
                height: auto;
                display: flex;
                flex-direction: row;
                flex-wrap: wrap;
                gap: 1rem;
            }

            .hero-floating .floating-card {
                position: relative;
                top: auto;
                right: auto;
                bottom: auto;
                left: auto;
                transform: none;
                flex: 1 1 220px;
            }

            .stats {
                grid-template-columns: repeat(3, 1fr);
                padding: 2rem 3rem;
            }

            .rooms-section {
                padding: 4rem 3rem;
            }
        }

        @media (max-width: 768px) {
            .hero {
                padding: 3rem 1.5rem 4rem;
            }

            .hero-actions {
                flex-direction: column;
            }

            .hero-floating {
                flex-direction: column;
            }

            .stats {
                grid-template-columns: repeat(2, 1fr);
                padding: 2rem 1.5rem;
                gap: 1.5rem;
            }

            .rooms-section {
                padding: 3rem 1.5rem;
            }

            .rooms-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .room-image-wrapper {
                height: 250px;
            }

            .room-content {
                padding: 1.5rem;
            }

            .room-footer {
                flex-direction: column;
                align-items: stretch;
                gap: 1rem;
            }

            .book-btn {
                width: 100%;
                justify-content: center;
            }

            .hero-title {
                font-size: 2rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }
        }

        @media (max-width: 480px) {
            .stats {
                grid-template-columns: 1fr;
            }

            .stat-number {
                font-size: 2rem;
            }

            .section-title {
                font-size: 1.75rem;
            }

            .room-title {
                font-size: 1.25rem;
            }

            .price {
                font-size: 1.75rem;
            }
        }

        /* Icons */
        svg {
            flex-shrink: 0;
        }
    </style>
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-inner">
            <div class="hero-content">
                <span class="hero-badge">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                    {{ __('website.home.hero_badge') }}
                </span>
                <h1 class="hero-title">
                    {{ __('website.home.hero_title') }}
                </h1>
                <p class="hero-subtitle">
                    {{ __('website.home.hero_subtitle') }}
                </p>
                <div class="hero-actions">
                    <a href="#download-android" class="hero-btn primary">
                        <span>Download Android</span>
                    </a>
                    <a href="#download-ios" class="hero-btn secondary">
                        <span>Download iOS</span>
                    </a>
                </div>
            </div>
            <div class="hero-floating">
                <div class="floating-card">
                        <div class="metric-icon">
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 2a10 10 0 1 0 10 10A10.011 10.011 0 0 0 12 2Z"/>
                                <path d="M2 12h20"/>
                                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10Z"/>
                            </svg>
                        </div>
                        <div class="metric-card">
                            <span class="metric-label">Countries Reached</span>
                            <span class="metric-value">{{ $statistics['total_countries'] }}+</span>
                            <span class="metric-helper">Presence across our network</span>
                        </div>
                    </div>
                    <div class="floating-card">
                        <div class="metric-icon">
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                <circle cx="8.5" cy="7" r="3"/>
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                            </svg>
                        </div>
                        <div class="metric-card">
                            <span class="metric-label">Total Accommodation</span>
                            <span class="metric-value">{{ $statistics['total_motels'] }}+</span>
                            <span class="metric-helper">Verified stays in our catalog</span>
                        </div>
                    </div>
                    <div class="floating-card">
                        <div class="metric-icon">
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 6L9 17l-5-5"/>
                            </svg>
                        </div>
                        <div class="metric-card">
                            <span class="metric-label">Total Customers</span>
                            <span class="metric-value">{{ $statistics['total_customers'] }}+</span>
                            <span class="metric-helper">Guests hosted with care</span>
                        </div>
                    </div>
            </div>
        </div>
    </section>

  
 