@php
    $info = $companyInfo ?? config('companyinfo');
@endphp

@if(!empty($info))
    <section class="contact-section">
        <style>
            .contact-section {
                background: #fff8eb;
                padding: 4rem 4vw;
            }

            .contact-wrapper {
                max-width: 1240px;
                margin: 0 auto;
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: 2rem;
                align-items: start;
            }

            .contact-details {
                display: grid;
                gap: 1.25rem;
            }

            .contact-details h2 {
                margin: 0;
                font-size: clamp(2rem, 4vw, 2.8rem);
                color: var(--text-dark, #1a1c21);
            }

            .contact-details p {
                margin: 0;
                color: #3f3f46;
                line-height: 1.7;
            }

            .contact-card {
                background: #fce9d5;
                border-radius: 16px;
                padding: 1.1rem 1.25rem;
                display: flex;
                gap: 1rem;
                align-items: flex-start;
            }

            .contact-card-icon {
                width: 44px;
                height: 44px;
                border-radius: 12px;
                background: #c76a15;
                color: #ffffff;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }

            .contact-card strong {
                display: block;
                font-size: 1.05rem;
                color: #111827;
            }

            .contact-card span {
                font-size: 0.95rem;
                color: #374151;
                display: block;
            }

            .contact-form-card {
                background: #ffffff;
                border-radius: 22px;
                box-shadow: 0 20px 45px rgba(0, 0, 0, 0.08);
                padding: clamp(2rem, 4vw, 3rem);
                display: grid;
                gap: 1.25rem;
            }

            .contact-form-card h3 {
                margin: 0;
                font-size: clamp(1.4rem, 3vw, 1.8rem);
                color: #1f2937;
            }

            .contact-form-grid {
                display: grid;
                gap: 1rem;
            }

            .contact-form-grid .two-column {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
                gap: 1rem;
            }

            .contact-form-grid label {
                display: block;
                font-weight: 600;
                font-size: 0.95rem;
                color: #1f2937;
                margin-bottom: 0.4rem;
            }

            .contact-form-grid input,
            .contact-form-grid textarea {
                width: 100%;
                padding: 0.85rem 1rem;
                border-radius: 12px;
                border: 1px solid rgba(17, 24, 39, 0.12);
                font: inherit;
                transition: border-color 0.2s ease, box-shadow 0.2s ease;
                background: rgba(255, 255, 255, 0.95);
            }

            .contact-form-grid input:focus,
            .contact-form-grid textarea:focus {
                outline: none;
                border-color: #c76a15;
                box-shadow: 0 0 0 3px rgba(199, 106, 21, 0.2);
            }

            .contact-form-grid textarea {
                min-height: 140px;
                resize: vertical;
            }

            .contact-submit {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
                padding: 0.85rem 1.5rem;
                border-radius: 14px;
                border: none;
                background: #b4550f;
                color: #ffffff;
                font-weight: 600;
                font-size: 1rem;
                cursor: pointer;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .contact-submit:hover {
                transform: translateY(-2px);
                box-shadow: 0 12px 25px rgba(180, 85, 15, 0.3);
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

            @media (max-width: 768px) {
                .contact-section {
                    padding: 3rem 6vw;
                }
            }
        </style>

        <div class="contact-wrapper">
            <div class="contact-details">
                <h2>{{ $info['hero']['title'] ?? 'Get In Touch' }}</h2>
                <p>{{ $info['hero']['subtitle'] ?? 'We would love to hear from you.' }}</p>

                @foreach(($info['contact_cards'] ?? []) as $card)
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

            <div class="contact-form-card">
                <h3>{{ $info['form']['title'] ?? 'Send Us a Message' }}</h3>

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
                                <label for="contact_name">{{ $info['form']['fields']['name'] ?? 'Full Name' }}</label>
                                <input id="contact_name" type="text" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="contact-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="contact_email">{{ $info['form']['fields']['email'] ?? 'Email Address' }}</label>
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
        </div>
    </section>
@endif

