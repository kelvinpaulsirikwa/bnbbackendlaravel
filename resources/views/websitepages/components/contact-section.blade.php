@php
    $info = $companyInfo ?? config('companyinfo');
    $mapEmbed = $info['map']['embed'] ?? 'https://www.google.com/maps?q=Dodoma%20Ilazo&t=&z=14&ie=UTF8&iwloc=&output=embed';
@endphp

@if(!empty($info))
    <section class="pcs-contact-wrapper">
        <style>
            :root {
                --pcs-primary: #0ea5e9;
                --pcs-primary-dark: #0284c7;
                --pcs-secondary: #8b5cf6;
                --pcs-accent: #06b6d4;
                --pcs-success: #10b981;
                --pcs-danger: #ef4444;
                --pcs-text-primary: #0f172a;
                --pcs-text-secondary: #475569;
                --pcs-text-muted: #64748b;
                --pcs-bg-main: #ffffff;
                --pcs-bg-section: #f8fafc;
                --pcs-border: #e2e8f0;
                --pcs-shadow-sm: 0 1px 3px rgba(15, 23, 42, 0.08);
                --pcs-shadow-md: 0 4px 16px rgba(15, 23, 42, 0.1);
                --pcs-shadow-lg: 0 20px 40px rgba(15, 23, 42, 0.12);
                --pcs-shadow-card: 0 8px 32px rgba(14, 165, 233, 0.12);
            }

            .pcs-contact-wrapper {
                background: #fefefe;
                padding: clamp(4rem, 8vw, 7rem) clamp(1.5rem, 5vw, 3rem);
                position: relative;
                overflow: hidden;
            }

            .pcs-container {
                max-width: 1300px;
                margin: 0 auto;
                display: grid;
                gap: clamp(3rem, 6vw, 5rem);
                position: relative;
                z-index: 1;
            }

            /* Header Section */
            .pcs-header {
                text-align: center;
                max-width: 800px;
                margin: 0 auto;
                display: grid;
                gap: 1.25rem;
            }

            .pcs-header-badge {
                display: inline-block;
                padding: 0.625rem 1.5rem;
                background: linear-gradient(135deg, rgba(14, 165, 233, 0.1), rgba(139, 92, 246, 0.1));
                color: var(--pcs-primary);
                font-size: 0.875rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.1em;
                border-radius: 50px;
                border: 1px solid rgba(14, 165, 233, 0.2);
                margin: 0 auto 0.5rem;
                width: fit-content;
            }

            .pcs-header h2 {
                margin: 0;
                font-size: clamp(2.25rem, 5vw, 3.25rem);
                font-weight: 900;
                color: var(--pcs-text-primary);
                letter-spacing: -0.03em;
                line-height: 1.1;
                background: linear-gradient(135deg, #0f172a 0%, #0ea5e9 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .pcs-header p {
                margin: 0;
                color: var(--pcs-text-secondary);
                font-size: clamp(1.0625rem, 2.5vw, 1.1875rem);
                line-height: 1.7;
                font-weight: 400;
            }

            /* Quick Contact Cards */
            .pcs-quick-cards {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: clamp(1.25rem, 3vw, 2rem);
            }

            .pcs-quick-card {
                background: var(--pcs-bg-main);
                border-radius: 20px;
                padding: 2rem 1.75rem;
                display: flex;
                gap: 1.25rem;
                align-items: flex-start;
                box-shadow: var(--pcs-shadow-card);
                border: 1px solid rgba(14, 165, 233, 0.1);
                transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                position: relative;
                overflow: hidden;
            }

            .pcs-quick-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 4px;
                height: 100%;
                background: linear-gradient(180deg, var(--pcs-primary), var(--pcs-secondary));
                transform: scaleY(0);
                transform-origin: top;
                transition: transform 0.4s ease;
            }

            .pcs-quick-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 16px 48px rgba(14, 165, 233, 0.2);
                border-color: var(--pcs-primary);
            }

            .pcs-quick-card:hover::before {
                transform: scaleY(1);
            }

            .pcs-card-icon {
                width: 56px;
                height: 56px;
                min-width: 56px;
                border-radius: 16px;
                background: linear-gradient(135deg, var(--pcs-primary), var(--pcs-accent));
                color: #ffffff;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.5rem;
                box-shadow: 0 8px 20px rgba(14, 165, 233, 0.3);
                transition: transform 0.3s ease;
            }

            .pcs-quick-card:hover .pcs-card-icon {
                transform: scale(1.1) rotate(5deg);
            }

            .pcs-card-content {
                flex: 1;
            }

            .pcs-card-content strong {
                display: block;
                font-size: 1.125rem;
                font-weight: 700;
                color: var(--pcs-text-primary);
                margin-bottom: 0.5rem;
                letter-spacing: -0.01em;
            }

            .pcs-card-content span {
                display: block;
                font-size: 0.9375rem;
                color: var(--pcs-text-secondary);
                line-height: 1.6;
                margin-bottom: 0.25rem;
            }

            /* Main Content Grid */
            .pcs-main-grid {
                display: grid;
                grid-template-columns: 1.2fr 1fr;
                gap: clamp(2rem, 4vw, 3rem);
                align-items: start;
            }

            /* Form Card */
            .pcs-form-card {
                background: var(--pcs-bg-main);
                border-radius: 28px;
                padding: clamp(2.5rem, 5vw, 3.5rem);
                box-shadow: var(--pcs-shadow-lg);
                border: 1px solid rgba(14, 165, 233, 0.1);
                display: grid;
                gap: 2rem;
            }

            .pcs-form-header h3 {
                margin: 0 0 0.75rem 0;
                font-size: clamp(1.75rem, 4vw, 2.25rem);
                font-weight: 800;
                color: var(--pcs-text-primary);
                letter-spacing: -0.02em;
            }

            .pcs-form-header .pcs-subtitle {
                margin: 0;
                color: var(--pcs-text-muted);
                font-size: 1rem;
                line-height: 1.65;
            }

            /* Success Alert */
            .pcs-alert-success {
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
            }

            .pcs-alert-success::before {
                content: '✓';
                width: 28px;
                height: 28px;
                background: var(--pcs-success);
                color: white;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 700;
                flex-shrink: 0;
            }

            /* Form Styling */
            .pcs-form-grid {
                display: grid;
                gap: 1.5rem;
            }

            .pcs-form-row {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
                gap: 1.25rem;
            }

            .pcs-form-group label {
                display: block;
                font-weight: 600;
                font-size: 0.9375rem;
                color: var(--pcs-text-primary);
                margin-bottom: 0.625rem;
                letter-spacing: -0.01em;
            }

            .pcs-form-group input,
            .pcs-form-group textarea {
                width: 100%;
                padding: 1rem 1.25rem;
                border-radius: 14px;
                border: 2px solid var(--pcs-border);
                font: inherit;
                font-size: 0.9375rem;
                transition: all 0.3s ease;
                background: var(--pcs-bg-main);
                color: var(--pcs-text-primary);
            }

            .pcs-form-group input:focus,
            .pcs-form-group textarea:focus {
                outline: none;
                border-color: var(--pcs-primary);
                box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
                transform: translateY(-1px);
            }

            .pcs-form-group textarea {
                min-height: 160px;
                resize: vertical;
                line-height: 1.6;
            }

            .pcs-error {
                color: var(--pcs-danger);
                font-size: 0.8125rem;
                font-weight: 500;
                margin-top: 0.5rem;
                display: flex;
                align-items: center;
                gap: 0.375rem;
            }

            .pcs-error::before {
                content: '⚠';
            }

            .pcs-submit-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 0.75rem;
                padding: 1.125rem 2.5rem;
                border-radius: 16px;
                border: none;
                background: linear-gradient(135deg, var(--pcs-primary), var(--pcs-accent));
                color: #ffffff;
                font-weight: 700;
                font-size: 1.0625rem;
                cursor: pointer;
                transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                box-shadow: 0 8px 24px rgba(14, 165, 233, 0.3);
                position: relative;
                overflow: hidden;
            }

            .pcs-submit-btn::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
                transition: left 0.6s ease;
            }

            .pcs-submit-btn:hover {
                transform: translateY(-3px) scale(1.02);
                box-shadow: 0 16px 40px rgba(14, 165, 233, 0.4);
            }

            .pcs-submit-btn:hover::before {
                left: 100%;
            }

            .pcs-submit-btn:active {
                transform: translateY(-1px) scale(0.98);
            }

            .pcs-submit-icon {
                width: 20px;
                height: 20px;
                transition: transform 0.3s ease;
            }

            .pcs-submit-btn:hover .pcs-submit-icon {
                transform: translateX(4px);
            }

            /* Map Card */
            .pcs-map-card {
                background: var(--pcs-bg-main);
                border-radius: 28px;
                overflow: hidden;
                box-shadow: var(--pcs-shadow-lg);
                border: 1px solid rgba(14, 165, 233, 0.1);
                display: grid;
                grid-template-rows: auto 1fr;
                height: 100%;
                min-height: 600px;
            }

            .pcs-map-header {
                padding: 2.5rem 2.5rem 1.5rem;
            }

            .pcs-map-header h3 {
                margin: 0 0 0.75rem 0;
                font-size: clamp(1.5rem, 3vw, 1.875rem);
                font-weight: 800;
                color: var(--pcs-text-primary);
                letter-spacing: -0.02em;
            }

            .pcs-map-header .pcs-subtitle {
                margin: 0;
                color: var(--pcs-text-muted);
                font-size: 0.9375rem;
                line-height: 1.65;
            }

            .pcs-map-container {
                position: relative;
                min-height: 480px;
                border-radius: 20px 20px 0 0;
                overflow: hidden;
            }

            .pcs-map-container iframe {
                position: absolute;
                inset: 0;
                width: 100%;
                height: 100%;
                border: 0;
                filter: grayscale(0.2) contrast(1.1);
                transition: filter 0.3s ease;
            }

            .pcs-map-container:hover iframe {
                filter: grayscale(0) contrast(1);
            }

            /* Responsive Design */
            @media (max-width: 1024px) {
                .pcs-main-grid {
                    grid-template-columns: 1fr;
                }

                .pcs-map-card {
                    min-height: 500px;
                }
            }

            @media (max-width: 768px) {
                .pcs-contact-wrapper {
                    padding: 3.5rem 1.5rem;
                }

                .pcs-quick-cards {
                    grid-template-columns: 1fr;
                }

                .pcs-quick-card {
                    padding: 1.75rem 1.5rem;
                }

                .pcs-form-card {
                    padding: 2rem 1.5rem;
                }

                .pcs-form-row {
                    grid-template-columns: 1fr;
                }

                .pcs-map-card {
                    min-height: 450px;
                }

                .pcs-map-container {
                    min-height: 350px;
                }
            }

            @media (max-width: 640px) {
                .pcs-header-badge {
                    font-size: 0.8125rem;
                    padding: 0.5rem 1.25rem;
                }

                .pcs-card-icon {
                    width: 48px;
                    height: 48px;
                    min-width: 48px;
                    font-size: 1.25rem;
                }

                .pcs-form-group input,
                .pcs-form-group textarea {
                    padding: 0.875rem 1rem;
                }

                .pcs-submit-btn {
                    width: 100%;
                    padding: 1rem 2rem;
                }

                .pcs-map-header {
                    padding: 2rem 1.75rem 1.25rem;
                }
            }

            /* Dark Mode Support */
            @media (prefers-color-scheme: dark) {
                :root {
                    --pcs-text-primary: #f1f5f9;
                    --pcs-text-secondary: #cbd5e1;
                    --pcs-text-muted: #94a3b8;
                    --pcs-bg-main: #1e293b;
                    --pcs-bg-section: #0f172a;
                    --pcs-border: #334155;
                }

                .pcs-contact-wrapper {
                    background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
                }

                .pcs-quick-card,
                .pcs-form-card,
                .pcs-map-card {
                    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
                }

                .pcs-form-group input,
                .pcs-form-group textarea {
                    background: #0f172a;
                }
            }

            /* Reduced Motion */
            @media (prefers-reduced-motion: reduce) {
                .pcs-quick-card,
                .pcs-card-icon,
                .pcs-submit-btn,
                .pcs-form-group input,
                .pcs-form-group textarea {
                    transition-duration: 0.01ms !important;
                }
            }

            /* Print Styles */
            @media print {
                .pcs-contact-wrapper::before,
                .pcs-contact-wrapper::after {
                    display: none;
                }

                .pcs-quick-card,
                .pcs-form-card,
                .pcs-map-card {
                    box-shadow: none;
                    border: 1px solid var(--pcs-border);
                }

                .pcs-submit-btn {
                    display: none;
                }
            }
        </style>

        <div class="pcs-container">
            <!-- Header Section -->
            <div class="pcs-header">
                <span class="pcs-header-badge">Get In Touch</span>
                <h2>{{ $info['hero']['title'] ?? 'If You Have Any Query, Feel Free To Contact Us' }}</h2>
                <p>{{ $info['hero']['subtitle'] ?? 'We would love to hear from you. Reach out for bookings, questions, or custom packages.' }}</p>
            </div>

            <!-- Quick Contact Cards -->
            @php
                $cards = $info['contact_cards'] ?? [];
            @endphp

            @if(!empty($cards))
                <div class="pcs-quick-cards">
                    @foreach($cards as $card)
                        <div class="pcs-quick-card">
                            <div class="pcs-card-icon">{!! $card['icon'] ?? '' !!}</div>
                            <div class="pcs-card-content">
                                <strong>{{ $card['label'] ?? '' }}</strong>
                                @foreach(($card['lines'] ?? []) as $line)
                                    <span>{{ $line }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Main Content Grid -->
            <div class="pcs-main-grid">
                <!-- Contact Form -->
                <div class="pcs-form-card">
                    <div class="pcs-form-header">
                        <h3>{{ $info['form']['title'] ?? 'Send Us A Message' }}</h3>
                        @if(!empty($info['form']['subtitle']))
                            <p class="pcs-subtitle">{{ $info['form']['subtitle'] }}</p>
                        @endif
                    </div>

                    @if(session('contact_status'))
                        <div class="pcs-alert-success">
                            {{ session('contact_status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('website.contact.store') }}">
                        @csrf
                        <div class="pcs-form-grid">
                            <div class="pcs-form-row">
                                <div class="pcs-form-group">
                                    <label for="pcs_name">{{ $info['form']['fields']['name'] ?? 'Your Name' }}</label>
                                    <input id="pcs_name" type="text" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="pcs-error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="pcs-form-group">
                                    <label for="pcs_email">{{ $info['form']['fields']['email'] ?? 'Your Email' }}</label>
                                    <input id="pcs_email" type="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="pcs-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="pcs-form-group">
                                <label for="pcs_phone">{{ $info['form']['fields']['phone'] ?? 'Phone Number' }}</label>
                                <input id="pcs_phone" type="text" name="phone" value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="pcs-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="pcs-form-group">
                                <label for="pcs_message">{{ $info['form']['fields']['message'] ?? 'Message' }}</label>
                                <textarea id="pcs_message" name="message" required>{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="pcs-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="pcs-submit-btn">
                            <span>{{ $info['form']['button'] ?? 'Send Message' }}</span>
                            <svg class="pcs-submit-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </button>
                    </form>
                </div>

                <!-- Map Card -->
                <div class="pcs-map-card">
                    <div class="pcs-map-header">
                        <h3>{{ $info['map']['title'] ?? 'Visit Our Office' }}</h3>
                        @if(!empty($info['map']['subtitle']))
                            <p class="pcs-subtitle">{{ $info['map']['subtitle'] }}</p>
                        @else
                            <p class="pcs-subtitle">{{ $info['map']['description'] ?? 'Find us in Dodoma - Ilazo. Drop by for an in-person chat.' }}</p>
                        @endif
                    </div>
                    <div class="pcs-map-container">
                        <iframe
                            src="{{ $mapEmbed }}"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif