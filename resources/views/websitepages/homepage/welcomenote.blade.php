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

        /* Hero Section - Split Design */
        .hero {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 100vh;
            position: relative;
        }

        .hero-content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 4rem 6rem;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: white;
            position: relative;
            overflow: hidden;
        }

        .hero-content::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(212, 165, 116, 0.1) 0%, transparent 70%);
            border-radius: 50%;
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

        .hero-cta {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.6rem 1.4rem;
            border-radius: 999px;
            background: #b2560d;
            color: #ffffff;
            font-weight: 600;
            text-decoration: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .hero-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(178, 86, 13, 0.3);
        }

        .hero-image {
            position: relative;
            overflow: hidden;
        }

        .hero-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            animation: zoomIn 20s ease infinite alternate;
        }

        @keyframes zoomIn {
            from { transform: scale(1); }
            to { transform: scale(1.1); }
        }

        .hero-image::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(45deg, rgba(26, 26, 46, 0.3) 0%, transparent 100%);
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
            .hero {
                grid-template-columns: 1fr;
            }

            .hero-image {
                min-height: 50vh;
            }

            .stats {
                grid-template-columns: repeat(3, 1fr);
                padding: 2rem 3rem;
            }

            .rooms-section {
                padding: 4rem 3rem;
            }

            .hero-content {
                padding: 3rem 3rem;
            }
        }

        @media (max-width: 768px) {
            .hero-content {
                padding: 2rem 1.5rem;
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
        <div class="hero-content">
            <span class="hero-badge">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
                FBC Products
            </span>
            <h1 class="hero-title">Stay, Explore, Feel at Home</h1>
            <p class="hero-subtitle">
                Effortless bookings, curated motels, and warm hospitality— FBC products brings every getaway closer to perfect.
            </p>
            <a href="#rooms" class="hero-cta">
                Explore Our Rooms
              
            </a>
        </div>
        <div class="hero-image">
            <img src="{{ asset('images/static_file/welcomeimage.png') }}" alt="Luxury Hotel">
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="stats">
        <div class="stat-item">
            <div class="stat-number">{{ $statistics['total_countries'] }}</div>
            <div class="stat-label">Countries</div>
            <div class="stat-desc">Worldwide</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $statistics['total_regions'] }}</div>
            <div class="stat-label">Regions</div>
            <div class="stat-desc">Beautiful</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $statistics['total_districts'] }}</div>
            <div class="stat-label">Districts</div>
            <div class="stat-desc">Curated</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $statistics['total_motels'] }}</div>
            <div class="stat-label">Motels</div>
            <div class="stat-desc">Premium</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $statistics['total_customers'] }}</div>
            <div class="stat-label">Customers</div>
            <div class="stat-desc">Happy</div>
        </div>
    </section>

    <!-- Featured Rooms Section -->
 