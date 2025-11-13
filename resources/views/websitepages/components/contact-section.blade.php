@php
    $info = $companyInfo ?? config('companyinfo');
    $mapEmbed = $info['map']['embed'] ?? 'https://www.google.com/maps?q=Dodoma%20Ilazo&t=&z=14&ie=UTF8&iwloc=&output=embed';
@endphp

@if(!empty($info))
    <section class="contact-section">
        <style>
            .contact-section {
                background: #f6fbff;
                padding: clamp(3rem, 6vw, 5rem) 4vw;
            }

            .contact-container {
                max-width: 1240px;
                margin: 0 auto;
                display: grid;
                gap: clamp(2rem, 4vw, 3rem);
            }

            .contact-header {
                text-align: center;
                display: grid;
                gap: 0.75rem;
                max-width: 720px;
                margin: 0 auto;
            }

            .contact-header h2 {
                margin: 0;
                font-size: clamp(2rem, 4vw, 2.9rem);
                color: #052c65;
            }

            .contact-header p {
                margin: 0;
                color: #475569;
                font-size: 1rem;
                line-height: 1.7;
            }

            .contact-cards-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
                gap: clamp(1rem, 3vw, 1.75rem);
            }

            .contact-card {
                background: #ffffff;
                border-radius: 18px;
                padding: 1.4rem 1.6rem;
                display: flex;
                gap: 1rem;
                align-items: flex-start;
                box-shadow: 0 24px 45px -18px rgba(15, 71, 145, 0.25);
                border: 1px solid rgba(13, 148, 255, 0.08);
            }

            .contact-card-icon {
                width: 48px;
                height: 48px;
                border-radius: 14px;
                background: linear-gradient(135deg, #0d8bff, #0055ff);
                color: #ffffff;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                font-size: 1.2rem;
            }

            .contact-card strong {
                display: block;
                font-size: 1.1rem;
                color: #0f172a;
                margin-bottom: 0.35rem;
            }

            .contact-card span {
                display: block;
                font-size: 0.98rem;
                color: #475569;
                line-height: 1.5;
            }

            .contact-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
                gap: clamp(1.5rem, 4vw, 2.25rem);
                align-items: stretch;
            }

            .contact-form-card {
                background: #ffffff;
                border-radius: 24px;
                padding: clamp(2rem, 4vw, 3rem);
                box-shadow: 0 35px 60px -25px rgba(15, 71, 145, 0.25);
                display: grid;
                gap: 1.5rem;
            }

            .contact-form-card h3 {
                margin: 0;
                font-size: clamp(1.4rem, 3vw, 1.9rem);
                color: #0f172a;
            }

            .contact-form-card .subtitle {
                margin: -0.75rem 0 0;
                color: #64748b;
                font-size: 0.95rem;
                line-height: 1.6;
            }

            .contact-form-grid {
                display: grid;
                gap: 1rem;
            }

            .contact-form-grid .two-column {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
                gap: 1rem;
            }

            .contact-form-grid label {
                display: block;
                font-weight: 600;
                font-size: 0.95rem;
                color: #0f172a;
                margin-bottom: 0.4rem;
            }

            .contact-form-grid input,
            .contact-form-grid textarea {
                width: 100%;
                padding: 0.9rem 1rem;
                border-radius: 12px;
                border: 1px solid rgba(15, 23, 42, 0.12);
                font: inherit;
                transition: border-color 0.2s ease, box-shadow 0.2s ease;
                background: rgba(255, 255, 255, 0.98);
            }

            .contact-form-grid input:focus,
            .contact-form-grid textarea:focus {
                outline: none;
                border-color: #0d8bff;
                box-shadow: 0 0 0 3px rgba(13, 139, 255, 0.2);
            }

            .contact-form-grid textarea {
                min-height: 150px;
                resize: vertical;
            }

            .contact-submit {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
                padding: 0.95rem 1.75rem;
                border-radius: 14px;
                border: none;
                background: linear-gradient(135deg, #0d8bff, #0055ff);
                color: #ffffff;
                font-weight: 600;
                font-size: 1rem;
                cursor: pointer;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .contact-submit:hover {
                transform: translateY(-2px);
                box-shadow: 0 16px 32px rgba(13, 139, 255, 0.35);
            }

            .contact-alert {
                padding: 0.85rem 1rem;
                border-radius: 12px;
                background: rgba(16, 185, 129, 0.12);
                color: #065f46;
                font-size: 0.95rem;
            }

            .contact-error {
                color: #b91c1c;
                font-size: 0.85rem;
                margin-top: 0.3rem;
            }

            .contact-map-card {
                background: #ffffff;
                border-radius: 24px;
                overflow: hidden;
                box-shadow: 0 35px 60px -25px rgba(15, 71, 145, 0.25);
                display: grid;
                grid-template-rows: auto 1fr;
            }

            .contact-map-card h3 {
                margin: 0;
                padding: 1.75rem clamp(1.4rem, 4vw, 2.25rem) 0.35rem;
                font-size: clamp(1.3rem, 3vw, 1.75rem);
                color: #0f172a;
            }

            .contact-map-card .subtitle {
                margin: 0 0 1.5rem;
                padding: 0 clamp(1.4rem, 4vw, 2.25rem);
                color: #64748b;
                font-size: 0.95rem;
                line-height: 1.6;
            }

            .contact-map {
                position: relative;
                min-height: 360px;
            }

            .contact-map iframe {
                position: absolute;
                inset: 0;
                width: 100%;
                height: 100%;
                border: 0;
            }

            @media (max-width: 768px) {
                .contact-section {
                    padding: 3rem 6vw;
                }

                .contact-card {
                    padding: 1.25rem 1.4rem;
                }

                .contact-map-card {
                    grid-template-rows: auto auto;
                }
            }
        </style>

        <div class="contact-container">
            <div class="contact-header">
                <h2>{{ $info['hero']['title'] ?? 'If You Have Any Query, Feel Free To Contact Us' }}</h2>
                <p>{{ $info['hero']['subtitle'] ?? 'We would love to hear from you. Reach out for bookings, questions, or custom packages.' }}</p>
            </div>

            @php
                $cards = $info['contact_cards'] ?? [];
            @endphp

            @if(!empty($cards))
                <div class="contact-cards-grid">
                    @foreach($cards as $card)
                        <div class="contact-card">
                            <div class="contact-card-icon">{!! $card['icon'] ?? '' !!}</div>
                            <div>
                                <strong>{{ $card['label'] ?? '' }}</strong>
                                @foreach(($card['lines'] ?? []) as $line)
                                    <span>{{ $line }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="contact-grid">
                <div class="contact-form-card">
                    <div>
                        <h3>{{ $info['form']['title'] ?? 'Send Us A Message' }}</h3>
                        @if(!empty($info['form']['subtitle']))
                            <p class="subtitle">{{ $info['form']['subtitle'] }}</p>
                        @endif
                    </div>

                    @if(session('contact_status'))
                        <div class="contact-alert">
                            {{ session('contact_status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('website.contact.store') }}">
                        @csrf
                        <div class="contact-form-grid">
                            <div class="two-column">
                                <div>
                                    <label for="contact_name">{{ $info['form']['fields']['name'] ?? 'Your Name' }}</label>
                                    <input id="contact_name" type="text" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="contact-error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div>
                                    <label for="contact_email">{{ $info['form']['fields']['email'] ?? 'Your Email' }}</label>
                                    <input id="contact_email" type="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="contact-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="contact_phone">{{ $info['form']['fields']['phone'] ?? 'Phone Number' }}</label>
                                <input id="contact_phone" type="text" name="phone" value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="contact-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="contact_message">{{ $info['form']['fields']['message'] ?? 'Message' }}</label>
                                <textarea id="contact_message" name="message" required>{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="contact-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="contact-submit">
                            {{ $info['form']['button'] ?? 'Send Message' }}
                        </button>
                    </form>
                </div>

                <div class="contact-map-card">
                    <h3>{{ $info['map']['title'] ?? 'Visit Our Office' }}</h3>
                    @if(!empty($info['map']['subtitle']))
                        <p class="subtitle">{{ $info['map']['subtitle'] }}</p>
                    @else
                        <p class="subtitle">{{ $info['map']['description'] ?? 'Find us in Dodoma - Ilazo. Drop by for an in-person chat.' }}</p>
                    @endif
                    <div class="contact-map">
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

