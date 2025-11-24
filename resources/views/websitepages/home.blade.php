@extends('websitepages.layouts.app')

@section('title', __('website.home.meta_title'))
@section('meta_description', __('website.home.meta_description'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/homepage-exquisite-rooms.css') }}">
    <link rel="stylesheet" href="{{ asset('css/homepage-property-types.css') }}">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #2b70f7 0%, #1a5fd6 100%);
            --accent-gradient: linear-gradient(135deg, #b2560d 0%, #8a4209 100%);
            --surface: #ffffff;
            --surface-dim: #f8fafc;
            --border-light: rgba(148, 163, 184, 0.15);
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --primary: #2b70f7;
        }

        /* Section Headers */
        .section {
            padding: 2.5rem 0;
        }

        .section-header {
            text-align: center;
            max-width: 800px;
            margin: 0 auto 2rem;
        }

        .section-title {
            font-size: clamp(2.25rem, 4vw, 3.25rem);
            font-weight: 800;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, #0f172a 0%, #334155 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .section-subtitle {
            color: var(--text-muted);
            font-size: 1.15rem;
            line-height: 1.8;
            max-width: 640px;
            margin: 0 auto;
        }

        /* Buttons */
        .ghost-button {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem 2rem;
            border-radius: 50px;
            border: 2px solid var(--primary);
            color: var(--primary);
            font-weight: 600;
            background: transparent;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .ghost-button:hover {
            background: var(--primary);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(43, 112, 247, 0.25);
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            border-radius: 32px;
            padding: 5rem 3rem;
            text-align: center;
            color: #ffffff;
            position: relative;
            overflow: hidden;
            margin: 5rem 0;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top right, rgba(43, 112, 247, 0.15), transparent 50%),
                        radial-gradient(circle at bottom left, rgba(178, 86, 13, 0.15), transparent 50%);
        }

        .cta-section > * {
            position: relative;
            z-index: 1;
        }

        .cta-section h2 {
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 800;
            margin: 0 0 1.5rem;
            letter-spacing: -0.01em;
        }

        .cta-section p {
            font-size: 1.15rem;
            color: #cbd5e1;
            margin: 0 auto 2.5rem;
            max-width: 640px;
            line-height: 1.7;
        }

        .cta-button {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1.1rem 2.5rem;
            border-radius: 50px;
            background: var(--accent-gradient);
            color: #ffffff;
            font-weight: 700;
            font-size: 1rem;
            box-shadow: 0 8px 24px rgba(178, 86, 13, 0.4);
            transition: all 0.3s ease;
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 40px rgba(178, 86, 13, 0.5);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .cta-section {
                padding: 3rem 2rem;
            }

            .section {
                padding: 3rem 0;
            }
        }
    </style>
@endpush

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
    <!-- Hero Section -->
    @include('websitepages.homepage.welcomenote')

    <!-- How it Works -->
    @include('websitepages.homepage.howitworks')

    <!-- Featured Motels / Our Exquisite Rooms -->
    @include('websitepages.homepage.exquisite-rooms')

    <!-- Property Types / Browse by Property Type -->
    @include('websitepages.homepage.property-types')

    <!-- Amenities -->
    @include('websitepages.homepage.amenities')

    <!-- Gallery -->
    @include('websitepages.homepage.gallery')

   
@endsection