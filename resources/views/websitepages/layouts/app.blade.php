<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', __('website.meta.default_title'))</title>
        <meta name="description" content="@yield('meta_description', __('website.meta.default_description'))">
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

            .nav-dropdown {
                position: relative;
            }

            .nav-dropdown-toggle {
                border: none;
                background: transparent;
                font: inherit;
                color: rgba(15, 23, 42, 0.65);
                display: inline-flex;
                align-items: center;
                gap: 0.35rem;
                cursor: pointer;
                padding: 0;
                transition: color 0.2s ease, transform 0.2s ease;
            }

            .nav-dropdown-toggle svg {
                width: 14px;
                height: 14px;
                stroke-width: 2;
            }

            .nav-dropdown:hover .nav-dropdown-toggle,
            .nav-dropdown:focus-within .nav-dropdown-toggle {
                color: var(--primary);
                transform: translateY(-2px);
            }

            .nav-dropdown-menu {
                position: absolute;
                top: calc(100% + 0.2rem);
                left: 0;
                min-width: 220px;
                background: #ffffff;
                border-radius: 16px;
                box-shadow: 0 18px 45px rgba(15, 23, 42, 0.18);
                padding: 0.75rem 0;
                display: flex;
                flex-direction: column;
                gap: 0;
                opacity: 0;
                visibility: hidden;
                transform: translateY(-8px);
                transition: opacity 0.2s ease, transform 0.2s ease;
                z-index: 20;
            }

            .nav-dropdown:hover .nav-dropdown-menu,
            .nav-dropdown:focus-within .nav-dropdown-menu {
                opacity: 1;
                visibility: visible;
                transform: translateY(0);
            }

            .nav-dropdown-menu a {
                padding: 0.65rem 1.25rem;
                text-decoration: none;
                color: rgba(15, 23, 42, 0.85);
                font-weight: 500;
                transition: background 0.2s ease, color 0.2s ease;
                display: block;
            }

            .nav-dropdown-menu a:hover,
            .nav-dropdown-menu a:focus {
                background: rgba(43, 112, 247, 0.08);
                color: #1a4fbb;
            }

            .nav-actions {
                display: flex;
                align-items: center;
                gap: 1rem;
            }

            .nav-language {
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                font-size: 0.85rem;
                font-weight: 600;
                color: rgba(15, 23, 42, 0.65);
            }

            .nav-language a {
                padding: 0.35rem 0.75rem;
                border-radius: 999px;
                border: 1px solid transparent;
                text-decoration: none;
                color: inherit;
                transition: color 0.2s ease, border-color 0.2s ease, background 0.2s ease;
            }

            .nav-language a:hover {
                color: var(--primary);
                border-color: rgba(43, 112, 247, 0.35);
            }

            .nav-language a.is-active {
                color: var(--primary);
                border-color: rgba(43, 112, 247, 0.5);
                background: rgba(43, 112, 247, 0.08);
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
                    gap: 1rem;
                }

                .nav-dropdown {
                    width: 100%;
                    text-align: center;
                }

                .nav-dropdown-menu {
                    position: static;
                    transform: none;
                    box-shadow: none;
                    background: rgba(255, 255, 255, 0.95);
                    border-radius: 14px;
                    margin-top: 0.75rem;
                }

                .nav-actions {
                    width: 100%;
                    justify-content: center;
                    flex-wrap: wrap;
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
            @php($currentLocale = app()->getLocale())
            @php($accommodationLabel = __('website.nav.accommodation_types'))
            @php($accommodationLabel = $accommodationLabel === 'website.nav.accommodation_types' ? 'Accommodation Types' : $accommodationLabel)
            <div class="nav">
                <a class="nav-brand" href="{{ route('website.home') }}">
                    <img src="{{ asset('images/static_file/applogo.png') }}" alt="bnbStay logo" width="36" height="36">
                    <span class="nav-brand-text">BnB<span class="nav-brand-dotcom">.com</span></span>
                </a>
                <nav class="nav-links">
                    <a href="{{ route('website.home') }}">{{ __('website.nav.home') }}</a>
                    <a href="{{ route('website.motels.index') }}">{{ __('website.nav.motels') }}</a>
                    @if(($navMotelTypes ?? collect())->count())
                        <div class="nav-dropdown">
                            <button class="nav-dropdown-toggle" type="button" aria-haspopup="true" aria-expanded="false">
                                {{ $accommodationLabel }}
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M6 9l6 6 6-6" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                            <div class="nav-dropdown-menu" role="menu">
                                @foreach($navMotelTypes as $type)
                                    <a role="menuitem" href="{{ route('website.motels.index', ['motel_type' => $type->id]) }}">
                                        {{ $type->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    @php($amenitiesLabel = __('website.nav.amenities'))
                    @if(($navAmenities ?? collect())->count())
                        <div class="nav-dropdown">
                            <button class="nav-dropdown-toggle" type="button" aria-haspopup="true" aria-expanded="false">
                                {{ $amenitiesLabel }}
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M6 9l6 6 6-6" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                            <div class="nav-dropdown-menu" role="menu">
                                <a role="menuitem" href="{{ route('website.amenities') }}">
                                    {{ __('website.nav.amenities_all') !== 'website.nav.amenities_all' ? __('website.nav.amenities_all') : __('website.nav.amenities') }}
                                </a>
                                @foreach($navAmenities as $amenity)
                                    <a role="menuitem" href="{{ route('website.amenities.show', $amenity->id) }}">
                                        {{ $amenity->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ route('website.amenities') }}">{{ $amenitiesLabel }}</a>
                    @endif
                    <a href="{{ route('website.gallery') }}">{{ __('website.nav.gallery') }}</a>

                    <a href="{{ route('website.contact') }}">{{ __('website.nav.contact') }}</a>
                </nav>
                <div class="nav-actions">
                    <a class="register-cta" href="{{ route('website.auth.register') }}"> {{ __('website.auth.register') }}
                    </a>
                    <a class="nav-cta" href="{{ route('login') }}"> {{ __('website.auth.login') }}
                    </a>
                </div>
            </div>
        </header>
        <main>
            @yield('content')
        </main>
        @include('websitepages.components.footer')
        @stack('scripts')
    </body>
</html>

