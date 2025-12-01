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
                --bg: #ffffff;
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
                background: rgba(255, 255, 255, 0.96);
                border-bottom: 1px solid rgba(203, 213, 225, 0.35);
                box-shadow: 0 4px 12px rgba(15, 23, 42, 0.06);
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

            .register-cta {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 0.6rem 1.4rem;
                border-radius: 999px;
                background: transparent;
                color: #b2560d;
                font-weight: 600;
                border: 2px solid #b2560d;
                transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease, color 0.2s ease;
            }

            .register-cta:hover {
                transform: translateY(-2px);
                background: #b2560d;
                color: #ffffff;
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

            /* Mobile Menu Button */
            .mobile-menu-btn {
                display: none;
                width: 44px;
                height: 44px;
                border: none;
                background: transparent;
                cursor: pointer;
                padding: 8px;
                border-radius: 8px;
                transition: background 0.2s ease;
            }

            .mobile-menu-btn:hover {
                background: rgba(0, 0, 0, 0.05);
            }

            .mobile-menu-btn svg {
                width: 28px;
                height: 28px;
                color: #0f172a;
            }

            /* Mobile Drawer Overlay */
            .mobile-drawer-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 998;
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            .mobile-drawer-overlay.active {
                display: block;
                opacity: 1;
            }

            /* Mobile Drawer */
            .mobile-drawer {
                position: fixed;
                top: 0;
                right: -320px;
                width: 300px;
                max-width: 85vw;
                height: 100vh;
                background: #ffffff;
                z-index: 999;
                display: flex;
                flex-direction: column;
                transition: right 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                box-shadow: -10px 0 40px rgba(0, 0, 0, 0.15);
            }

            .mobile-drawer.active {
                right: 0;
            }

            .mobile-drawer-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 1.25rem 1.5rem;
                border-bottom: 1px solid #e5e7eb;
                background: #f8fafc;
            }

            .mobile-drawer-brand {
                display: flex;
                align-items: center;
                gap: 0.6rem;
                text-decoration: none;
            }

            .mobile-drawer-brand img {
                width: 40px;
                height: 40px;
            }

            .mobile-drawer-brand-text {
                font-weight: 700;
                font-size: 1.1rem;
                color: #b2560d;
            }

            .mobile-drawer-brand-text span {
                color: #0f172a;
            }

            .mobile-drawer-close {
                width: 40px;
                height: 40px;
                border: none;
                background: transparent;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                transition: background 0.2s ease;
            }

            .mobile-drawer-close:hover {
                background: #f1f5f9;
            }

            .mobile-drawer-close svg {
                width: 24px;
                height: 24px;
                color: #64748b;
            }

            .mobile-drawer-nav {
                flex: 1;
                overflow-y: auto;
                padding: 1rem 0;
            }

            .mobile-nav-item {
                display: flex;
                align-items: center;
                gap: 1rem;
                padding: 1rem 1.5rem;
                text-decoration: none;
                color: #1e293b;
                font-weight: 500;
                font-size: 1rem;
                transition: all 0.2s ease;
                border-left: 3px solid transparent;
            }

            .mobile-nav-item:hover {
                background: #f8fafc;
                color: #2563eb;
                border-left-color: #2563eb;
            }

            .mobile-nav-item svg {
                width: 20px;
                height: 20px;
                color: #64748b;
                flex-shrink: 0;
            }

            .mobile-nav-item:hover svg {
                color: #2563eb;
            }

            /* Expandable Menu */
            .mobile-nav-expandable {
                border-bottom: 1px solid #f1f5f9;
            }

            .mobile-nav-toggle {
                display: flex;
                align-items: center;
                justify-content: space-between;
                width: 100%;
                padding: 1rem 1.5rem;
                background: transparent;
                border: none;
                cursor: pointer;
                color: #1e293b;
                font-weight: 500;
                font-size: 1rem;
                text-align: left;
                border-left: 3px solid transparent;
                transition: all 0.2s ease;
            }

            .mobile-nav-toggle:hover {
                background: #f8fafc;
                color: #2563eb;
                border-left-color: #2563eb;
            }

            .mobile-nav-toggle-left {
                display: flex;
                align-items: center;
                gap: 1rem;
            }

            .mobile-nav-toggle svg.icon {
                width: 20px;
                height: 20px;
                color: #64748b;
            }

            .mobile-nav-toggle:hover svg.icon {
                color: #2563eb;
            }

            .mobile-nav-toggle svg.chevron {
                width: 22px;
                height: 22px;
                color: #94a3b8;
                transition: transform 0.3s ease;
                background: #f1f5f9;
                border-radius: 50%;
                padding: 3px;
            }

            .mobile-nav-expandable.open .mobile-nav-toggle svg.chevron {
                transform: rotate(180deg);
                background: #dbeafe;
                color: #2563eb;
            }

            .mobile-nav-submenu {
                display: none;
                background: #f8fafc;
                padding: 0.5rem 0;
            }

            .mobile-nav-expandable.open .mobile-nav-submenu {
                display: block;
            }

            .mobile-nav-subitem {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                padding: 0.85rem 1.5rem 0.85rem 3.5rem;
                text-decoration: none;
                color: #475569;
                font-size: 0.95rem;
                transition: all 0.2s ease;
            }

            .mobile-nav-subitem:hover {
                background: #e0f2fe;
                color: #0369a1;
            }

            .mobile-nav-subitem::before {
                content: '';
                width: 6px;
                height: 6px;
                background: #2563eb;
                border-radius: 50%;
            }

            /* Mobile Drawer Footer */
            .mobile-drawer-footer {
                border-top: 1px solid #e5e7eb;
                padding: 1.5rem;
                background: #1e293b;
                color: #ffffff;
            }

            .mobile-footer-section {
                margin-bottom: 1.25rem;
            }

            .mobile-footer-section:last-child {
                margin-bottom: 0;
            }

            .mobile-footer-title {
                font-size: 0.75rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.1em;
                color: #94a3b8;
                margin-bottom: 0.75rem;
            }

            .mobile-social-links {
                display: flex;
                gap: 0.5rem;
            }

            .mobile-social-link {
                width: 38px;
                height: 38px;
                display: flex;
                align-items: center;
                justify-content: center;
                background: #334155;
                border-radius: 8px;
                color: #ffffff;
                text-decoration: none;
                transition: all 0.2s ease;
            }

            .mobile-social-link:hover {
                background: #2563eb;
                transform: translateY(-2px);
            }

            .mobile-social-link svg {
                width: 18px;
                height: 18px;
            }

            .mobile-lang-btns {
                display: flex;
                gap: 0.5rem;
            }

            .mobile-lang-btn {
                display: flex;
                align-items: center;
                gap: 0.4rem;
                padding: 0.6rem 1rem;
                background: #2563eb;
                color: #ffffff;
                border: none;
                border-radius: 50px;
                font-size: 0.85rem;
                font-weight: 600;
                cursor: pointer;
                text-decoration: none;
                transition: all 0.2s ease;
            }

            .mobile-lang-btn:hover {
                background: #1d4ed8;
            }

            .mobile-lang-btn.inactive {
                background: #475569;
            }

            @media (max-width: 900px) {
                .nav-links,
                .nav-actions {
                    display: none;
                }

                .mobile-menu-btn {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }

                .nav {
                    justify-content: space-between;
                }

                main {
                    padding: 0 4vw 4vw;
                }
            }

            @media (max-width: 480px) {
                main {
                    padding: 0 3vw 3vw;
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
                    @if(\Illuminate\Support\Facades\Auth::check())
                        <a class="nav-cta" href="{{ \Illuminate\Support\Facades\Auth::user()->role === 'bnbowner' ? route('bnbowner.motel-selection') : route('adminpages.dashboard') }}">
                           
                            Dashboard
                        </a>
                    @else
                        <a class="register-cta" href="{{ route('website.auth.register') }}">{{ __('website.auth.register') }}</a>
                        <a class="nav-cta" href="{{ route('login') }}">{{ __('website.auth.login') }}</a>
                    @endif
                </div>
                <!-- Mobile Menu Button -->
                <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Open Menu">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="3" y1="6" x2="21" y2="6"/>
                        <line x1="3" y1="12" x2="21" y2="12"/>
                        <line x1="3" y1="18" x2="21" y2="18"/>
                    </svg>
                </button>
            </div>
        </header>

        <!-- Mobile Drawer Overlay -->
        <div class="mobile-drawer-overlay" id="mobileOverlay"></div>

        <!-- Mobile Drawer -->
        <aside class="mobile-drawer" id="mobileDrawer">
            <div class="mobile-drawer-header">
                <a href="{{ route('website.home') }}" class="mobile-drawer-brand">
                    <img src="{{ asset('images/static_file/applogo.png') }}" alt="BnB Logo">
                    <span class="mobile-drawer-brand-text">BnB<span>.com</span></span>
                </a>
                <button class="mobile-drawer-close" id="mobileDrawerClose" aria-label="Close Menu">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"/>
                        <line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>

            <nav class="mobile-drawer-nav">
                <!-- Home -->
                <a href="{{ route('website.home') }}" class="mobile-nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                    {{ __('website.nav.home') }}
                </a>

                <!-- Motels -->
                <a href="{{ route('website.motels.index') }}" class="mobile-nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 21V5a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v16"/>
                        <path d="M1 21h22"/>
                        <path d="M9 7h1"/>
                        <path d="M9 11h1"/>
                        <path d="M14 7h1"/>
                        <path d="M14 11h1"/>
                    </svg>
                    {{ __('website.nav.motels') }}
                </a>

                <!-- Accommodation Types (Expandable) -->
                @if(($navMotelTypes ?? collect())->count())
                    <div class="mobile-nav-expandable">
                        <button class="mobile-nav-toggle" type="button">
                            <span class="mobile-nav-toggle-left">
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="3" width="7" height="7"/>
                                    <rect x="14" y="3" width="7" height="7"/>
                                    <rect x="14" y="14" width="7" height="7"/>
                                    <rect x="3" y="14" width="7" height="7"/>
                                </svg>
                                {{ $accommodationLabel }}
                            </span>
                            <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="6 9 12 15 18 9"/>
                            </svg>
                        </button>
                        <div class="mobile-nav-submenu">
                            @foreach($navMotelTypes as $type)
                                <a href="{{ route('website.motels.index', ['motel_type' => $type->id]) }}" class="mobile-nav-subitem">
                                    {{ $type->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Amenities (Expandable) -->
                @if(($navAmenities ?? collect())->count())
                    <div class="mobile-nav-expandable">
                        <button class="mobile-nav-toggle" type="button">
                            <span class="mobile-nav-toggle-left">
                                <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                    <polyline points="22 4 12 14.01 9 11.01"/>
                                </svg>
                                {{ $amenitiesLabel }}
                            </span>
                            <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="6 9 12 15 18 9"/>
                            </svg>
                        </button>
                        <div class="mobile-nav-submenu">
                            <a href="{{ route('website.amenities') }}" class="mobile-nav-subitem">All Amenities</a>
                            @foreach($navAmenities as $amenity)
                                <a href="{{ route('website.amenities.show', $amenity->id) }}" class="mobile-nav-subitem">
                                    {{ $amenity->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <a href="{{ route('website.amenities') }}" class="mobile-nav-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                        {{ $amenitiesLabel }}
                    </a>
                @endif

                <!-- Gallery -->
                <a href="{{ route('website.gallery') }}" class="mobile-nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                        <circle cx="8.5" cy="8.5" r="1.5"/>
                        <polyline points="21 15 16 10 5 21"/>
                    </svg>
                    {{ __('website.nav.gallery') }}
                </a>

                <!-- Contact -->
                <a href="{{ route('website.contact') }}" class="mobile-nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                    </svg>
                    {{ __('website.nav.contact') }}
                </a>

                <!-- Auth Links -->
                @if(\Illuminate\Support\Facades\Auth::check())
                    <a href="{{ \Illuminate\Support\Facades\Auth::user()->role === 'bnbowner' ? route('bnbowner.motel-selection') : route('adminpages.dashboard') }}" class="mobile-nav-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                            <path d="M3 9h18"/>
                            <path d="M9 21V9"/>
                        </svg>
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="mobile-nav-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                            <polyline points="10 17 15 12 10 7"/>
                            <line x1="15" y1="12" x2="3" y2="12"/>
                        </svg>
                        {{ __('website.auth.login') }}
                    </a>
                    <a href="{{ route('website.auth.register') }}" class="mobile-nav-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="8.5" cy="7" r="4"/>
                            <line x1="20" y1="8" x2="20" y2="14"/>
                            <line x1="23" y1="11" x2="17" y2="11"/>
                        </svg>
                        {{ __('website.auth.register') }}
                    </a>
                @endif
            </nav>

            <!-- Mobile Drawer Footer -->
            <div class="mobile-drawer-footer">
                <div class="mobile-footer-section">
                    <div class="mobile-footer-title">Follow Us</div>
                    <div class="mobile-social-links">
                        <a href="#" class="mobile-social-link" aria-label="Twitter/X">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                        <a href="#" class="mobile-social-link" aria-label="Facebook">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="mobile-social-link" aria-label="Instagram">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        </a>
                        <a href="#" class="mobile-social-link" aria-label="YouTube">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                    </div>
                </div>
                <div class="mobile-footer-section">
                    <div class="mobile-footer-title">Language</div>
                    <div class="mobile-lang-btns">
                        <a href="{{ route('website.language.switch', 'en') }}" class="mobile-lang-btn {{ app()->getLocale() === 'en' ? '' : 'inactive' }}">
                            🇺🇸 English
                        </a>
                        <a href="{{ route('website.language.switch', 'sw') }}" class="mobile-lang-btn {{ app()->getLocale() === 'sw' ? '' : 'inactive' }}">
                            🇹🇿 Kiswahili
                        </a>
                    </div>
                </div>
            </div>
        </aside>
        <main>
            @yield('content')
        </main>
        @include('websitepages.components.footer')
        
        <!-- Floating Action Button for Downloads -->
        <div class="fab-container">
            <div class="fab-options">
                <a href="#download-android" class="fab-option fab-android">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M17.523 2.326a.5.5 0 0 0-.727.054L15.022 4.5H8.978L7.204 2.38a.5.5 0 0 0-.727-.054.5.5 0 0 0-.054.727L8.022 5H6a3 3 0 0 0-3 3v9a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3V8a3 3 0 0 0-3-3h-2.022l1.599-1.947a.5.5 0 0 0-.054-.727zM8.5 10a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                    </svg>
                    <span>Download Android</span>
                </a>
                <a href="#download-ios" class="fab-option fab-ios">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M13 3.5c.73-.83 1.94-1.46 2.94-1.5.13 1.17-.34 2.35-1.04 3.19-.69.85-1.83 1.51-2.95 1.42-.15-1.15.41-2.35 1.05-3.11z"/>
                    </svg>
                    <span>Download iOS</span>
                </a>
            </div>
            <button class="fab-main" aria-label="Download App">
                <img class="fab-icon-logo" src="{{ asset('images/static_file/applogo.png') }}" alt="App Logo">
                <svg class="fab-icon-close" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        <style>
            .fab-container {
                position: fixed;
                bottom: 2rem;
                right: 2rem;
                z-index: 1000;
                display: flex;
                flex-direction: column;
                align-items: flex-end;
                gap: 0.75rem;
            }

            .fab-main {
                width: 72px;
                height: 72px;
                border-radius: 50%;
                background: linear-gradient(135deg, #b2560d 0%, #d97706 100%);
                border: none;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #ffffff;
                box-shadow: 0 8px 28px rgba(178, 86, 13, 0.45);
                animation: fabPulse 3s ease-in-out infinite;
            }

            .fab-main svg {
                width: 28px;
                height: 28px;
            }

            @keyframes fabPulse {
                0% {
                    transform: scale(1) rotate(0deg);
                    box-shadow: 0 8px 28px rgba(178, 86, 13, 0.45);
                }
                15% {
                    transform: scale(1.08) rotate(12deg);
                    box-shadow: 0 10px 32px rgba(178, 86, 13, 0.5);
                }
                30% {
                    transform: scale(1) rotate(0deg);
                    box-shadow: 0 8px 28px rgba(178, 86, 13, 0.45);
                }
                45% {
                    transform: scale(1.08) rotate(-12deg);
                    box-shadow: 0 10px 32px rgba(178, 86, 13, 0.5);
                }
                60% {
                    transform: scale(1) rotate(0deg);
                    box-shadow: 0 8px 28px rgba(178, 86, 13, 0.45);
                }
                75% {
                    transform: scale(1.05) rotate(6deg);
                    box-shadow: 0 9px 30px rgba(178, 86, 13, 0.48);
                }
                90% {
                    transform: scale(1.05) rotate(-6deg);
                    box-shadow: 0 9px 30px rgba(178, 86, 13, 0.48);
                }
                100% {
                    transform: scale(1) rotate(0deg);
                    box-shadow: 0 8px 28px rgba(178, 86, 13, 0.45);
                }
            }

            .fab-container:hover .fab-main,
            .fab-container.active .fab-main {
                animation: none;
                transform: rotate(180deg) scale(1.05);
                background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
                box-shadow: 0 10px 32px rgba(30, 41, 59, 0.5);
            }

            .fab-icon-logo {
                width: 42px;
                height: 42px;
                object-fit: contain;
                border-radius: 50%;
            }

            .fab-icon-close {
                display: none;
            }

            .fab-container:hover .fab-icon-logo,
            .fab-container.active .fab-icon-logo {
                display: none;
            }

            .fab-container:hover .fab-icon-close,
            .fab-container.active .fab-icon-close {
                display: block;
            }

            .fab-options {
                display: flex;
                flex-direction: column;
                gap: 0.6rem;
                opacity: 0;
                visibility: hidden;
                transform: translateY(20px) scale(0.8);
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .fab-container:hover .fab-options,
            .fab-container.active .fab-options {
                opacity: 1;
                visibility: visible;
                transform: translateY(0) scale(1);
            }

            .fab-option {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                padding: 1rem 1.5rem;
                border-radius: 50px;
                text-decoration: none;
                font-weight: 600;
                font-size: 0.95rem;
                white-space: nowrap;
                box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
                transition: all 0.2s ease;
            }

            .fab-android {
                background: #3ddc84;
                color: #ffffff;
            }

            .fab-android:hover {
                background: #2bc670;
                transform: translateX(-8px);
                box-shadow: 0 6px 20px rgba(61, 220, 132, 0.4);
            }

            .fab-ios {
                background: #000000;
                color: #ffffff;
            }

            .fab-ios:hover {
                background: #1a1a1a;
                transform: translateX(-8px);
                box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
            }

            @media (max-width: 768px) {
                .fab-container {
                    bottom: 1.5rem;
                    right: 1.5rem;
                }

                .fab-main {
                    width: 64px;
                    height: 64px;
                }

                .fab-main svg {
                    width: 26px;
                    height: 26px;
                }

                .fab-option {
                    padding: 0.85rem 1.25rem;
                    font-size: 0.9rem;
                }
            }
        </style>

        <script>
            // Toggle FAB on click for mobile
            document.querySelector('.fab-main')?.addEventListener('click', function() {
                document.querySelector('.fab-container').classList.toggle('active');
            });

            // Close FAB when clicking outside
            document.addEventListener('click', function(e) {
                const fabContainer = document.querySelector('.fab-container');
                if (fabContainer && !fabContainer.contains(e.target)) {
                    fabContainer.classList.remove('active');
                }
            });

            // Mobile Drawer Functionality
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const mobileDrawer = document.getElementById('mobileDrawer');
            const mobileOverlay = document.getElementById('mobileOverlay');
            const mobileDrawerClose = document.getElementById('mobileDrawerClose');

            function openMobileDrawer() {
                mobileDrawer.classList.add('active');
                mobileOverlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            function closeMobileDrawer() {
                mobileDrawer.classList.remove('active');
                mobileOverlay.classList.remove('active');
                document.body.style.overflow = '';
            }

            mobileMenuBtn?.addEventListener('click', openMobileDrawer);
            mobileDrawerClose?.addEventListener('click', closeMobileDrawer);
            mobileOverlay?.addEventListener('click', closeMobileDrawer);

            // Expandable Menu Toggle
            document.querySelectorAll('.mobile-nav-toggle').forEach(function(toggle) {
                toggle.addEventListener('click', function() {
                    const parent = this.closest('.mobile-nav-expandable');
                    parent.classList.toggle('open');
                });
            });

            // Close drawer on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && mobileDrawer.classList.contains('active')) {
                    closeMobileDrawer();
                }
            });
        </script>

        @stack('scripts')
    </body>
</html>


