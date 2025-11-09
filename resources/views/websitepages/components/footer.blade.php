<footer class="site-footer">
    <style>
        .site-footer {
            background: #0f172a;
            color: rgba(255, 255, 255, 0.78);
            padding: 3.5rem 4vw 2.5rem;
        }

        .site-footer__intro {
            max-width: 1240px;
            margin: 0 auto 2.75rem;
            display: grid;
            gap: 0.75rem;
        }

        .site-footer__title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #ffffff;
            margin: 0;
        }

        .site-footer__grid {
            max-width: 1240px;
            margin: 0 auto;
            display: grid;
            gap: 2.5rem;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        }

        .site-footer__col {
            display: grid;
            gap: 0.75rem;
        }

        .site-footer__links {
            display: grid;
            gap: 0.5rem;
        }

        .site-footer__links a {
            color: rgba(255, 255, 255, 0.78);
            transition: color 0.2s ease, transform 0.2s ease;
            font-size: 0.95rem;
        }

        .site-footer__links a:hover {
            color: #ffffff;
            transform: translateX(2px);
        }

        .site-footer__text {
            color: rgba(255, 255, 255, 0.65);
            font-size: 0.95rem;
        }

        .site-footer__language {
            display: grid;
            gap: 0.35rem;
        }

        .site-footer__language a,
        .site-footer__language span {
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.65);
            transition: color 0.2s ease;
        }

        .site-footer__language a:hover {
            color: #ffffff;
        }

        .site-footer__language a.is-active {
            color: #ff8a0c;
            font-weight: 600;
        }

        .site-footer__social {
            display: flex;
            gap: 0.6rem;
            align-items: center;
        }

        .site-footer__social a {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.2s ease, background 0.2s ease;
            color: #ffffff;
        }

        .site-footer__social a:hover {
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.18);
        }

        .site-footer__bottom {
            margin-top: 2.75rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.12);
            text-align: center;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.6);
        }

        @media (max-width: 720px) {
            .site-footer {
                padding: 3rem 6vw 2.5rem;
            }
        }
    </style>

    <div class="site-footer__intro">
        <h2 class="site-footer__title">bnbStay hospitality collective</h2>
        <p class="site-footer__text">
            Explore curated stays, purposeful amenities, and experiences rooted in the places we love. Our network keeps growing across new regions and property styles.
        </p>
    </div>

    <div class="site-footer__grid">
        <div class="site-footer__col">
            <h3 class="site-footer__title">Motel types</h3>
            <div class="site-footer__links">
                @forelse(($footerMotelTypes ?? collect()) as $motelType)
                    <a href="{{ route('website.motels.index', ['motel_type' => $motelType->id]) }}">
                        {{ $motelType->name }}
                    </a>
                @empty
                    <span class="site-footer__text">Coming soon.</span>
                @endforelse
            </div>
        </div>
        <div class="site-footer__col">
            <h3 class="site-footer__title">Supported regions</h3>
            <div class="site-footer__links">
                @forelse(($footerRegions ?? collect()) as $region)
                    <a href="{{ route('website.motels.index', ['region' => $region->id]) }}">
                        {{ $region->name }}
                    </a>
                @empty
                    <span class="site-footer__text">No regions available yet.</span>
                @endforelse
            </div>
        </div>
        <div class="site-footer__col">
            <h3 class="site-footer__title">Supported countries</h3>
            <div class="site-footer__links">
                @forelse(($footerCountries ?? collect()) as $country)
                    <span class="site-footer__text">{{ $country }}</span>
                @empty
                    <span class="site-footer__text">No countries available yet.</span>
                @endforelse
            </div>
        </div>
        <div class="site-footer__col">
            <h3 class="site-footer__title">Room types</h3>
            <div class="site-footer__links">
                @forelse(($footerRoomTypes ?? collect()) as $roomType)
                    <span class="site-footer__text">{{ $roomType }}</span>
                @empty
                    <span class="site-footer__text">No room types available yet.</span>
                @endforelse
            </div>
        </div>
        <div class="site-footer__col">
            <h3 class="site-footer__title">Language</h3>
            <div class="site-footer__language">
                <a href="#" class="is-active">English</a>
                <a href="#">Kiswahili</a>
            </div>
        </div>
        <div class="site-footer__col">
            <h3 class="site-footer__title">Follow us</h3>
            <div class="site-footer__social">
                <a href="#" aria-label="Facebook">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M13 22v-8h3l1-3h-4V8a1 1 0 0 1 1-1h3V4h-3a4 4 0 0 0-4 4v3H8v3h2v8h3Z"/>
                    </svg>
                </a>
                <a href="#" aria-label="Twitter">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M22 5.92a7.53 7.53 0 0 1-2.12.58 3.69 3.69 0 0 0 1.64-2.02 7.42 7.42 0 0 1-2.36.93 3.7 3.7 0 0 0-6.3 3.38 10.5 10.5 0 0 1-7.64-3.88 3.68 3.68 0 0 0 1.14 4.93 3.66 3.66 0 0 1-1.67-.46v.05a3.7 3.7 0 0 0 2.97 3.63 3.72 3.72 0 0 1-1.66.06 3.7 3.7 0 0 0 3.46 2.57A7.42 7.42 0 0 1 2 18.09a10.46 10.46 0 0 0 5.65 1.66c6.79 0 10.5-5.63 10.5-10.5 0-.16 0-.31-.01-.47A7.46 7.46 0 0 0 22 5.92Z"/>
                    </svg>
                </a>
                <a href="#" aria-label="Instagram">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 7a5 5 0 1 0 5 5 5.006 5.006 0 0 0-5-5Zm0 8a3 3 0 1 1 3-3 3 3 0 0 1-3 3Zm5.5-8.9a1.17 1.17 0 1 0 1.17 1.17 1.17 1.17 0 0 0-1.17-1.17ZM21 7.5a5.5 5.5 0 0 0-5.5-5.5h-7A5.5 5.5 0 0 0 3 7.5v7A5.5 5.5 0 0 0 8.5 20h7A5.5 5.5 0 0 0 21 14.5Zm-2 7A3.5 3.5 0 0 1 15.5 18h-7A3.5 3.5 0 0 1 5 14.5v-7A3.5 3.5 0 0 1 8.5 4h7A3.5 3.5 0 0 1 19 7.5Z"/>
                    </svg>
                </a>
                <a href="#" aria-label="YouTube">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M21.6 7.2a2.75 2.75 0 0 0-1.93-1.95C18 5 12 5 12 5s-6 0-7.67.28A2.75 2.75 0 0 0 2.4 7.2 28.72 28.72 0 0 0 2 12a28.72 28.72 0 0 0 .4 4.8 2.75 2.75 0 0 0 1.93 1.95C6 19 12 19 12 19s6 0 7.67-.28a2.75 2.75 0 0 0 1.93-1.95A28.72 28.72 0 0 0 22 12a28.72 28.72 0 0 0-.4-4.8ZM10 15.25v-6.5L15.5 12Z"/>
                    </svg>
                </a>
                <a href="#" aria-label="LinkedIn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M5 3a2 2 0 1 1-2 2 2 2 0 0 1 2-2Zm1.5 6h-3A.5.5 0 0 0 3 9.5v11a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-11A.5.5 0 0 0 6.5 9Zm11.75-.12A3.75 3.75 0 0 0 15 9.86a4.86 4.86 0 0 0-1.31-.18A4.68 4.68 0 0 0 11 11.32v-1.82a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v11a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-6a2.38 2.38 0 0 1 .11-.77 1.82 1.82 0 0 1 1.74-1.23c1 0 1.55.73 1.55 1.91v6.09a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-6.86c0-3.3-1.76-4.83-3.75-4.83Z"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <div class="site-footer__bottom">
        &copy; {{ now()->year }} bnbStay. All rights reserved.
    </div>
</footer>

