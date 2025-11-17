<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'BnB Stay')</title>
        <meta name="description" content="@yield('meta_description', 'Discover welcoming stays and curated experiences with bnbStay.')">
        <link rel="icon" href="{{ asset('images/static_file/applogo.png') }}" type="image/png">
        <link rel="apple-touch-icon" href="{{ asset('images/static_file/applogo.png') }}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <style>
            :root {
                color-scheme: light only;
                --primary: #2b70f7;
                --primary-dark: #1f54bb;
                --accent: #ffb200;
                --text-dark: #1a1c21;
                --text-muted: #6b7280;
                --bg: #f3f5fb;
                --white: #ffffff;
            }

            * {
                box-sizing: border-box;
            }

            body {
                margin: 0;
                font-family: 'Poppins', sans-serif;
                color: var(--text-dark);
                background-color: var(--bg);
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }

            a {
                color: inherit;
                text-decoration: none;
            }

            .shadow {
                box-shadow: 0 20px 45px rgba(20, 41, 82, 0.12);
            }

            header {
                backdrop-filter: blur(12px);
                position: sticky;
                top: 0;
                z-index: 50;
                background: rgba(250, 245, 238, 0.94);
                border-bottom: 1px solid rgba(203, 213, 225, 0.35);
                box-shadow: 0 8px 18px rgba(15, 23, 42, 0.08);
            }

            .nav {
                display: flex;
                align-items: center;
                gap: 2rem;
                padding: 1.35rem 4vw 1.35rem 2vw;
                max-width: 1240px;
                margin: 0 auto;
            }

            .nav-brand {
                display: flex;
                align-items: center;
                gap: 0.6rem;
                font-weight: 700;
                font-size: 1.35rem;
                color: #b2560d;
                text-transform: capitalize;
            }

            .nav-brand-text {
                display: inline-flex;
                align-items: baseline;
                gap: 0;
            }

            .nav-brand .nav-brand-dotcom {
                color: var(--text-dark);
                font-weight: 600;
            }

            .nav-links {
                flex: 1;
                display: flex;
                gap: 1.5rem;
                font-size: 0.95rem;
                font-weight: 500;
                justify-content: center;
            }

            .nav-links a {
                color: rgba(15, 23, 42, 0.65);
                transition: color 0.2s ease, transform 0.2s ease;
            }

            .nav-links a:hover,
            .nav-links a:focus {
                color: var(--primary);
                transform: translateY(-2px);
            }

            .nav-cta {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 0.6rem 1.4rem;
                border-radius: 999px;
                background: #b2560d;
                color: #ffffff;
                font-weight: 600;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .nav-cta:hover {
                transform: translateY(-2px);
                box-shadow: 0 12px 24px rgba(178, 86, 13, 0.3);
            }

            main {
                flex: 1;
                padding: 0 4vw 4vw;
            }

            .cta-button {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                padding: 0.75rem 1.5rem;
                border-radius: 999px;
                background: linear-gradient(120deg, var(--primary), var(--primary-dark));
                color: #ffffff;
                font-weight: 600;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .cta-button:hover {
                transform: translateY(-3px);
                box-shadow: 0 14px 30px rgba(43, 112, 247, 0.35);
            }

            .section {
                max-width: 1240px;
                margin: 0 auto;
                padding: 4rem 0;
            }

            @media (max-width: 768px) {
                header {
                    position: static;
                }

                .nav {
                    flex-direction: column;
                    gap: 0.75rem;
                }

                .nav-links {
                    flex-wrap: wrap;
                    justify-content: center;
                }

                .nav-cta {
                    width: 100%;
                    justify-content: center;
                }

                main {
                    padding: 0 6vw 4vw;
                }
            }
        </style>
        @stack('styles')
    </head>
    <body>
        <header>
            <div class="nav">
                <a class="nav-brand" href="{{ route('website.home') }}">
                    <img src="{{ asset('images/static_file/applogo.png') }}" alt="bnbStay logo" width="36" height="36">
                    <span class="nav-brand-text">BnB<span class="nav-brand-dotcom">.com</span></span>
                </a>
                <nav class="nav-links">
                    <a href="{{ route('website.home') }}">Home</a>
                    <a href="{{ route('website.gallery') }}">Gallery</a>
                    <a href="{{ route('website.motels.index') }}">Motels</a>
                    <a href="{{ route('website.amenities') }}">Amenities</a>
                    <a href="{{ route('website.services') }}">Services</a>
                    <a href="{{ route('website.contact') }}">Contact</a>
                </nav>
                <a class="nav-cta" href="{{ route('website.motels.index') }}">Book Now</a>
            </div>
        </header>
        <main>
            @yield('content')
        </main>
        @include('websitepages.components.footer')
        @stack('scripts')
    </body>
</html>

