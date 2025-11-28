@extends('websitepages.layouts.app')

@section('title', __('website.auth.register_page_title'))
@section('meta_description', __('website.auth.register_page_message'))

@push('styles')
<style>
    :root {
        --reg-primary: #2b70f7;
        --reg-primary-dark: #1a5fd6;
        --reg-accent: #b2560d;
        --reg-accent-light: #d4722f;
        --reg-success: #10b981;
        --reg-danger: #ef4444;
        --reg-warning: #f59e0b;
        --reg-text-primary: #0f172a;
        --reg-text-secondary: #475569;
        --reg-text-muted: #64748b;
        --reg-bg-main: #ffffff;
        --reg-bg-section: #f8fafc;
        --reg-border: #e2e8f0;
        --reg-shadow-sm: 0 2px 8px rgba(15, 23, 42, 0.06);
        --reg-shadow-md: 0 8px 24px rgba(15, 23, 42, 0.1);
        --reg-shadow-lg: 0 20px 50px rgba(15, 23, 42, 0.12);
        --reg-shadow-accent: 0 12px 32px rgba(178, 86, 13, 0.25);
    }

    /* Hero Section */
    .reg-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #0f172a 100%);
        padding: clamp(4rem, 10vw, 7rem) clamp(1.5rem, 5vw, 3rem);
        text-align: center;
        position: relative;
        overflow: hidden;
        border-radius: 0 0 40px 40px;
        margin-bottom: 3rem;
    }

    .reg-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: 
            radial-gradient(ellipse 80% 60% at 20% 20%, rgba(43, 112, 247, 0.15), transparent),
            radial-gradient(ellipse 60% 50% at 80% 80%, rgba(178, 86, 13, 0.12), transparent);
        pointer-events: none;
    }

    .reg-hero::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        opacity: 0.5;
    }

    .reg-hero-content {
        position: relative;
        z-index: 1;
        max-width: 800px;
        margin: 0 auto;
    }

    .reg-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.625rem 1.5rem;
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 50px;
        color: #f1f5f9;
        font-size: 0.875rem;
        font-weight: 600;
        letter-spacing: 0.05em;
        margin-bottom: 1.5rem;
    }

    .reg-hero-badge svg {
        width: 18px;
        height: 18px;
    }

    .reg-hero h1 {
        font-size: clamp(2.5rem, 6vw, 4rem);
        font-weight: 900;
        color: #ffffff;
        margin: 0 0 1.25rem;
        letter-spacing: -0.03em;
        line-height: 1.1;
    }

    .reg-hero h1 span {
        background: linear-gradient(135deg, var(--reg-accent-light), var(--reg-accent));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .reg-hero p {
        font-size: clamp(1.0625rem, 2.5vw, 1.25rem);
        color: #cbd5e1;
        margin: 0;
        line-height: 1.7;
        max-width: 600px;
        margin: 0 auto;
    }

    /* Important Notice Card */
    .reg-notice {
        max-width: 900px;
        margin: -2rem auto 2rem;
        padding: 0 clamp(1.5rem, 5vw, 3rem);
        position: relative;
        z-index: 2;
    }

    .reg-notice-card {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(217, 119, 6, 0.08));
        border: 2px solid rgba(245, 158, 11, 0.3);
        border-radius: 20px;
        padding: 1.75rem 2rem;
        display: flex;
        gap: 1.25rem;
        align-items: flex-start;
    }

    .reg-notice-icon {
        width: 52px;
        height: 52px;
        min-width: 52px;
        border-radius: 14px;
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        box-shadow: 0 8px 20px rgba(245, 158, 11, 0.3);
    }

    .reg-notice-content h3 {
        margin: 0 0 0.5rem;
        font-size: 1.125rem;
        font-weight: 700;
        color: #92400e;
    }

    .reg-notice-content p {
        margin: 0;
        font-size: 0.9375rem;
        color: #b45309;
        line-height: 1.6;
    }

    .reg-notice-content ul {
        margin: 0.75rem 0 0;
        padding-left: 1.25rem;
        color: #b45309;
        font-size: 0.9375rem;
        line-height: 1.8;
    }

    .reg-notice-content ul li {
        margin-bottom: 0.25rem;
    }

    /* Benefits Section */
    .reg-benefits {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 1.5rem;
        max-width: 1200px;
        margin: 0 auto 3rem;
        padding: 0 clamp(1.5rem, 5vw, 3rem);
    }

    .reg-benefit-card {
        background: var(--reg-bg-main);
        border-radius: 20px;
        padding: 2rem 1.75rem;
        display: flex;
        gap: 1.25rem;
        align-items: flex-start;
        box-shadow: var(--reg-shadow-md);
        border: 1px solid var(--reg-border);
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .reg-benefit-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--reg-shadow-lg);
        border-color: var(--reg-primary);
    }

    .reg-benefit-icon {
        width: 52px;
        height: 52px;
        min-width: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .reg-benefit-icon.primary {
        background: linear-gradient(135deg, var(--reg-primary), var(--reg-primary-dark));
        color: #fff;
        box-shadow: 0 8px 20px rgba(43, 112, 247, 0.3);
    }

    .reg-benefit-icon.accent {
        background: linear-gradient(135deg, var(--reg-accent-light), var(--reg-accent));
        color: #fff;
        box-shadow: var(--reg-shadow-accent);
    }

    .reg-benefit-icon.success {
        background: linear-gradient(135deg, #34d399, var(--reg-success));
        color: #fff;
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
    }

    .reg-benefit-content h3 {
        margin: 0 0 0.5rem;
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--reg-text-primary);
    }

    .reg-benefit-content p {
        margin: 0;
        font-size: 0.9375rem;
        color: var(--reg-text-secondary);
        line-height: 1.6;
    }

    /* Form Container */
    .reg-form-container {
        max-width: 700px;
        margin: 0 auto 4rem;
        padding: 0 clamp(1.5rem, 5vw, 3rem);
    }

    .reg-form-card {
        background: var(--reg-bg-main);
        border-radius: 28px;
        padding: clamp(2rem, 5vw, 3.5rem);
        box-shadow: var(--reg-shadow-lg);
        border: 1px solid var(--reg-border);
    }

    .reg-form-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }

    .reg-form-header h2 {
        margin: 0 0 0.75rem;
        font-size: clamp(1.75rem, 4vw, 2.25rem);
        font-weight: 800;
        color: var(--reg-text-primary);
        letter-spacing: -0.02em;
    }

    .reg-form-header p {
        margin: 0;
        color: var(--reg-text-muted);
        font-size: 1rem;
        line-height: 1.65;
    }

    /* Form Grid */
    .reg-form-grid {
        display: grid;
        gap: 1.5rem;
    }

    .reg-form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.25rem;
    }

    .reg-form-group {
        display: flex;
        flex-direction: column;
    }

    .reg-form-group.full-width {
        grid-column: 1 / -1;
    }

    .reg-form-group label {
        font-weight: 600;
        font-size: 0.9375rem;
        color: var(--reg-text-primary);
        margin-bottom: 0.625rem;
        display: flex;
        align-items: center;
        gap: 0.375rem;
    }

    .reg-form-group label .required {
        color: var(--reg-danger);
        font-weight: 700;
    }

    .reg-form-group label .optional {
        color: var(--reg-text-muted);
        font-size: 0.8125rem;
        font-weight: 400;
    }

    .reg-form-group input,
    .reg-form-group select,
    .reg-form-group textarea {
        width: 100%;
        padding: 1rem 1.25rem;
        border-radius: 14px;
        border: 2px solid var(--reg-border);
        font: inherit;
        font-size: 0.9375rem;
        transition: all 0.3s ease;
        background: var(--reg-bg-main);
        color: var(--reg-text-primary);
    }

    .reg-form-group input:focus,
    .reg-form-group select:focus,
    .reg-form-group textarea:focus {
        outline: none;
        border-color: var(--reg-primary);
        box-shadow: 0 0 0 4px rgba(43, 112, 247, 0.1);
        transform: translateY(-1px);
    }

    .reg-form-group input::placeholder,
    .reg-form-group textarea::placeholder {
        color: var(--reg-text-muted);
    }

    .reg-field-hint {
        margin-top: 0.5rem;
        font-size: 0.8125rem;
        color: var(--reg-text-muted);
        display: flex;
        align-items: center;
        gap: 0.375rem;
    }

    .reg-field-hint svg {
        width: 14px;
        height: 14px;
        flex-shrink: 0;
    }

    .reg-error {
        color: var(--reg-danger);
        font-size: 0.8125rem;
        font-weight: 500;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.375rem;
    }

    .reg-error::before {
        content: '⚠';
    }

    /* Password Requirements */
    .reg-password-reqs {
        background: var(--reg-bg-section);
        border-radius: 12px;
        padding: 1rem 1.25rem;
        margin-top: 0.75rem;
    }

    .reg-password-reqs p {
        margin: 0 0 0.5rem;
        font-size: 0.8125rem;
        font-weight: 600;
        color: var(--reg-text-secondary);
    }

    .reg-password-reqs ul {
        margin: 0;
        padding-left: 1.25rem;
        font-size: 0.8125rem;
        color: var(--reg-text-muted);
        line-height: 1.7;
    }

    /* Alert Messages */
    .reg-alert-success {
        padding: 1.125rem 1.5rem;
        border-radius: 16px;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(5, 150, 105, 0.08));
        border: 1px solid rgba(16, 185, 129, 0.2);
        color: #065f46;
        font-size: 0.9375rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 2rem;
    }

    .reg-alert-success::before {
        content: '✓';
        width: 28px;
        height: 28px;
        background: var(--reg-success);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        flex-shrink: 0;
    }

    .reg-alert-error {
        padding: 1.125rem 1.5rem;
        border-radius: 16px;
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(220, 38, 38, 0.08));
        border: 1px solid rgba(239, 68, 68, 0.2);
        color: #991b1b;
        font-size: 0.9375rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 2rem;
    }

    .reg-alert-error::before {
        content: '✕';
        width: 28px;
        height: 28px;
        background: var(--reg-danger);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        flex-shrink: 0;
    }

    /* Submit Section */
    .reg-submit-section {
        margin-top: 2rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1.25rem;
    }

    .reg-submit-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        padding: 1.125rem 3rem;
        border-radius: 16px;
        border: none;
        background: linear-gradient(135deg, var(--reg-accent-light), var(--reg-accent));
        color: #ffffff;
        font-weight: 700;
        font-size: 1.0625rem;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: var(--reg-shadow-accent);
        position: relative;
        overflow: hidden;
        width: 100%;
    }

    .reg-submit-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.25), transparent);
        transition: left 0.5s ease;
    }

    .reg-submit-btn:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 18px 45px rgba(178, 86, 13, 0.35);
    }

    .reg-submit-btn:hover::before {
        left: 100%;
    }

    .reg-submit-btn:active {
        transform: translateY(-1px) scale(0.98);
    }

    .reg-submit-btn svg {
        width: 20px;
        height: 20px;
        transition: transform 0.3s ease;
    }

    .reg-submit-btn:hover svg {
        transform: translateX(4px);
    }

    .reg-terms {
        text-align: center;
        font-size: 0.875rem;
        color: var(--reg-text-muted);
        max-width: 400px;
    }

    .reg-terms a {
        color: var(--reg-primary);
        font-weight: 600;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .reg-terms a:hover {
        color: var(--reg-primary-dark);
        text-decoration: underline;
    }

    /* Already have account */
    .reg-login-link {
        text-align: center;
        padding: 1.5rem;
        background: var(--reg-bg-section);
        border-radius: 16px;
        margin-top: 2rem;
    }

    .reg-login-link p {
        margin: 0;
        font-size: 0.9375rem;
        color: var(--reg-text-secondary);
    }

    .reg-login-link a {
        color: var(--reg-primary);
        font-weight: 700;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .reg-login-link a:hover {
        color: var(--reg-primary-dark);
        text-decoration: underline;
    }

    /* Pending Status Info */
    .reg-pending-info {
        background: linear-gradient(135deg, rgba(43, 112, 247, 0.08), rgba(26, 95, 214, 0.05));
        border: 1px solid rgba(43, 112, 247, 0.2);
        border-radius: 14px;
        padding: 1.25rem 1.5rem;
        margin-top: 1.5rem;
        display: flex;
        gap: 1rem;
        align-items: flex-start;
    }

    .reg-pending-info svg {
        width: 24px;
        height: 24px;
        min-width: 24px;
        color: var(--reg-primary);
    }

    .reg-pending-info p {
        margin: 0;
        font-size: 0.875rem;
        color: var(--reg-text-secondary);
        line-height: 1.6;
    }

    .reg-pending-info strong {
        color: var(--reg-primary);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .reg-hero {
            border-radius: 0 0 24px 24px;
            padding: 3rem 1.5rem 5rem;
        }

        .reg-notice-card {
            flex-direction: column;
            text-align: center;
            padding: 1.5rem;
        }

        .reg-notice-content ul {
            text-align: left;
        }

        .reg-benefits {
            grid-template-columns: 1fr;
        }

        .reg-benefit-card {
            padding: 1.5rem;
        }

        .reg-form-card {
            padding: 1.75rem;
        }

        .reg-form-row {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 480px) {
        .reg-hero h1 {
            font-size: 2rem;
        }

        .reg-form-group input {
            padding: 0.875rem 1rem;
        }
    }
</style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="reg-hero">
        <div class="reg-hero-content">
            <span class="reg-hero-badge">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                    <circle cx="8.5" cy="7" r="4"/>
                    <line x1="20" y1="8" x2="20" y2="14"/>
                    <line x1="23" y1="11" x2="17" y2="11"/>
                </svg>
                Motel Owner Registration
            </span>
            <h1>Register as <span>Motel Owner</span></h1>
            <p>Create your account to start managing your property on our platform. Join our network and reach thousands of travelers.</p>
        </div>
    </section>

    <!-- Important Notice -->
    <div class="reg-notice">
        <div class="reg-notice-card">
            <div class="reg-notice-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
            </div>
            <div class="reg-notice-content">
                <h3>Important: Make Sure You Have a Motel to Register</h3>
                <p>This registration is specifically for motel owners who want to list their property on our platform. Before proceeding, please ensure:</p>
                <ul>
                    <li>You own or manage a motel/hotel/guesthouse property</li>
                    <li>You have the authority to list this property online</li>
                    <li>You have valid contact information and property details ready</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Benefits Section -->
    <div class="reg-benefits">
        <div class="reg-benefit-card">
            <div class="reg-benefit-icon primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
                </svg>
            </div>
            <div class="reg-benefit-content">
                <h3>Reach More Guests</h3>
                <p>Connect with travelers from across the region seeking unique stays and memorable experiences.</p>
            </div>
        </div>
        <div class="reg-benefit-card">
            <div class="reg-benefit-icon accent">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="3" width="20" height="14" rx="2" ry="2"/>
                    <line x1="8" y1="21" x2="16" y2="21"/>
                    <line x1="12" y1="17" x2="12" y2="21"/>
                </svg>
            </div>
            <div class="reg-benefit-content">
                <h3>Easy Management</h3>
                <p>Our intuitive dashboard lets you manage bookings, rooms, and amenities with ease.</p>
            </div>
        </div>
        <div class="reg-benefit-card">
            <div class="reg-benefit-icon success">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" y1="1" x2="12" y2="23"/>
                    <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>
                </svg>
            </div>
            <div class="reg-benefit-content">
                <h3>Grow Revenue</h3>
                <p>Maximize your earnings with competitive visibility and professional property presentation.</p>
            </div>
        </div>
    </div>

    <!-- Registration Form -->
    <div class="reg-form-container">
        <div class="reg-form-card">
            <div class="reg-form-header">
                <h2>Create Your Account</h2>
                <p>Fill in your details below to register as a motel owner. Your account will be reviewed by our team.</p>
            </div>

            @if(session('register_success'))
                <div class="reg-alert-success">
                    {{ session('register_success') }}
                </div>
            @endif

            @if(session('register_error'))
                <div class="reg-alert-error">
                    {{ session('register_error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('website.auth.register.store') }}">
                @csrf

                <div class="reg-form-grid">
                    <!-- Full Name -->
                    <div class="reg-form-group">
                        <label for="username">
                            Full Name <span class="required">*</span>
                        </label>
                        <input type="text" id="username" name="username" value="{{ old('username') }}" placeholder="Enter your full name" required>
                        @error('username')
                            <div class="reg-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="reg-form-group">
                        <label for="useremail">
                            Email Address <span class="required">*</span>
                        </label>
                        <input type="email" id="useremail" name="useremail" value="{{ old('useremail') }}" placeholder="you@example.com" required>
                        <div class="reg-field-hint">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="M12 16v-4M12 8h.01"/>
                            </svg>
                            You'll use this email to log in
                        </div>
                        @error('useremail')
                            <div class="reg-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Phone Number -->
                    <div class="reg-form-group">
                        <label for="telephone">
                            Phone Number <span class="required">*</span>
                        </label>
                        <input type="tel" id="telephone" name="telephone" value="{{ old('telephone') }}" placeholder="+255 xxx xxx xxx" required>
                        @error('telephone')
                            <div class="reg-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="reg-form-group">
                        <label for="password">
                            Password <span class="required">*</span>
                        </label>
                        <input type="password" id="password" name="password" placeholder="Create a secure password" required>
                        @error('password')
                            <div class="reg-error">{{ $message }}</div>
                        @enderror
                        <div class="reg-password-reqs">
                            <p>Password requirements:</p>
                            <ul>
                                <li>At least 8 characters long</li>
                                <li>Include letters and numbers</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="reg-form-group">
                        <label for="password_confirmation">
                            Confirm Password <span class="required">*</span>
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Re-enter your password" required>
                        @error('password_confirmation')
                            <div class="reg-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Pending Account Info -->
                <div class="reg-pending-info">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12,6 12,12 16,14"/>
                    </svg>
                    <p>
                        <strong>Note:</strong> After registration, your account will be <strong>inactive</strong> until our team reviews and approves it. 
                        You will receive an email notification once your account is activated. This usually takes 24-48 hours.
                    </p>
                </div>

                <!-- Submit Section -->
                <div class="reg-submit-section">
                    <button type="submit" class="reg-submit-btn">
                        <span>Create Account</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12"/>
                            <polyline points="12,5 19,12 12,19"/>
                        </svg>
                    </button>
                    <p class="reg-terms">
                        By registering, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.
                    </p>
                </div>
            </form>

            <div class="reg-login-link">
                <p>Already have an account? <a href="{{ route('login') }}">Sign in to your dashboard</a></p>
            </div>
        </div>
    </div>
@endsection
