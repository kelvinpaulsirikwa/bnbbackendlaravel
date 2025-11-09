@extends('websitepages.layouts.app')

@section('title', 'Contact bnbStay | Plan Your Next Stay')
@section('meta_description', 'Reach the bnbStay team to plan your next stay, request retreat proposals, or explore partnership opportunities.')

@push('styles')
    <style>
        .contact-hero {
            max-width: 960px;
            margin: 4rem auto 3rem;
            display: grid;
            gap: 1.5rem;
            text-align: center;
        }

        .contact-hero h1 {
            margin: 0;
            font-size: clamp(2.3rem, 4vw, 3.2rem);
        }

        .contact-hero p {
            margin: 0 auto;
            max-width: 620px;
            color: var(--text-muted);
            line-height: 1.8;
        }

        .contact-highlights {
            max-width: 1080px;
            margin: 0 auto 3rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
        }

        .contact-highlight-card {
            background: #ffffff;
            border-radius: 18px;
            padding: 1.75rem;
            box-shadow: 0 16px 32px rgba(24, 42, 82, 0.12);
            display: grid;
            gap: 0.75rem;
        }

        .contact-highlight-card strong {
            font-size: 1.05rem;
            color: var(--text-dark);
        }

        .contact-highlight-card p {
            color: var(--text-muted);
            line-height: 1.6;
            margin: 0;
        }
    </style>
@endpush

@section('content')
    <section class="contact-hero">
        <span class="badge" style="justify-self: center;">Let’s connect</span>
        <h1>Tell us about your dream stay and we’ll make it effortless.</h1>
        <p>
            Share your ideas, timelines, or questions and our hospitality designers will reply within one business day.
            We can schedule a call, send curated stay recommendations, or outline partnership opportunities.
        </p>
    </section>

    <section class="contact-highlights">
        <article class="contact-highlight-card">
            <strong>Concierge guidance</strong>
            <p>Let us know about your celebration, corporate goals, or travel dreams—we will craft bespoke itineraries and connect you with the right hosts.</p>
        </article>
        <article class="contact-highlight-card">
            <strong>Partnership inquiries</strong>
            <p>Own a unique stay or brand experience? Share your story and our partnership team will coordinate a discovery call.</p>
        </article>
        <article class="contact-highlight-card">
            <strong>Press & media</strong>
            <p>We love collaborating with storytellers. Reach out for media stays, interviews, or campaign concepts tailored to your audience.</p>
        </article>
    </section>
@endsection

