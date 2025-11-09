@extends('websitepages.layouts.app')

@section('title', 'About bnbStay | Our Story & Values')
@section('meta_description', 'Learn how bnbStay curates boutique stays, partners with local hosts, and delivers meaningful travel experiences.')

@push('styles')
    <style>
        .hero-about {
            background: linear-gradient(135deg, rgba(43, 112, 247, 0.12), rgba(31, 84, 187, 0.18));
            border-radius: 24px;
            padding: 4rem clamp(1.75rem, 5vw, 4rem);
            margin: 4rem auto 3rem;
            max-width: 1100px;
            display: grid;
            gap: 1.25rem;
            text-align: center;
        }

        .hero-about h1 {
            margin: 0;
            font-size: clamp(2.2rem, 4vw, 3rem);
            line-height: 1.2;
        }

        .hero-about p {
            margin: 0 auto;
            color: var(--text-muted);
            max-width: 700px;
            line-height: 1.7;
        }

        .grid-two {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2.5rem;
            max-width: 1100px;
            margin: 0 auto;
        }

        .story-card {
            background: var(--white);
            border-radius: 20px;
            padding: 2.25rem;
            box-shadow: 0 22px 45px rgba(21, 42, 79, 0.14);
            display: grid;
            gap: 1.1rem;
        }

        .story-card h3 {
            margin: 0;
            font-size: 1.35rem;
        }

        .timeline {
            max-width: 680px;
            margin: 4rem auto;
            display: grid;
            gap: 2rem;
        }

        .timeline-item {
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 1.25rem;
            align-items: start;
        }

        .timeline-bullet {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            background: rgba(43, 112, 247, 0.1);
            color: var(--primary);
            font-weight: 600;
        }

        .principles {
            max-width: 1100px;
            margin: 0 auto;
            display: grid;
            gap: 1.25rem;
        }

        .principles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
        }

        .principle {
            padding: 1.75rem;
            border-radius: 18px;
            background: var(--white);
            border: 1px solid rgba(43, 112, 247, 0.08);
            display: grid;
            gap: 0.75rem;
        }

        .team-card {
            border-radius: 18px;
            overflow: hidden;
            background: var(--white);
            box-shadow: 0 18px 35px rgba(25, 39, 78, 0.14);
        }

        .team-photo {
            height: 220px;
            background-size: cover;
            background-position: center;
        }

        .team-content {
            padding: 1.75rem;
            display: grid;
            gap: 0.6rem;
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            max-width: 1100px;
            margin: 3rem auto 0;
        }

        @media (max-width: 640px) {
            .timeline-item {
                grid-template-columns: 1fr;
            }

            .timeline-bullet {
                justify-self: start;
            }
        }
    </style>
@endpush

@section('content')
    <section class="hero-about shadow">
        <span class="badge" style="justify-self: center;">Our Story</span>
        <h1>bnbStay began with one spare guest room and a desire to host with heart.</h1>
        <p>
            What started as a single listing created by two hospitality geeks in 2012 has grown into a global collection
            of carefully curated stays. We believe travel is most meaningful when it’s personal, thoughtful, and rooted
            in the communities we visit.
        </p>
    </section>

    <section class="grid-two">
        <article class="story-card">
            <div class="badge" style="width: fit-content;">Our Mission</div>
            <h3>Curate restorative spaces that feel human, not corporate.</h3>
            <p style="margin: 0; color: var(--text-muted); line-height: 1.7;">
                Every stay is designed to help you slow down, connect, and feel at home—no matter where you are.
                We champion independent hosts, celebrate design with purpose, and deliver service that anticipates your needs.
            </p>
        </article>
        <article class="story-card">
            <div class="badge" style="width: fit-content;">What sets us apart</div>
            <h3>We co-create with local hosts & artisans.</h3>
            <p style="margin: 0; color: var(--text-muted); line-height: 1.7;">
                Our hosts are restaurateurs, designers, guides, and storytellers. Together we build experiences—from wild
                foraging in the Nordics to gallery tours in Marrakech—that reflect the soul of each destination.
            </p>
        </article>
    </section>

    <section class="timeline">
        <div class="timeline-item">
            <div class="timeline-bullet">2012</div>
            <div>
                <h3 style="margin: 0 0 0.2rem;">The guest room that started it all</h3>
                <p style="margin: 0; color: var(--text-muted); line-height: 1.7;">
                    Our founders, Lina and Mateo, offered their San Francisco loft to traveling creatives. Their guests became friends,
                    and together they crafted itineraries that sparked a bigger idea.
                </p>
            </div>
        </div>
        <div class="timeline-item">
            <div class="timeline-bullet">2016</div>
            <div>
                <h3 style="margin: 0 0 0.2rem;">Expanding into curated collections</h3>
                <p style="margin: 0; color: var(--text-muted); line-height: 1.7;">
                    We partnered with independent hosts across five countries, introducing the first bnbStay Collections:
                    Coastal Escapes, Urban Atelier, Mountain Retreats.
                </p>
            </div>
        </div>
        <div class="timeline-item">
            <div class="timeline-bullet">2020</div>
            <div>
                <h3 style="margin: 0 0 0.2rem;">Designing for wellbeing</h3>
                <p style="margin: 0; color: var(--text-muted); line-height: 1.7%;">
                    We launched wellness-led amenities—sound baths, in-room botanicals, meditation itineraries—to help guests recharge.
                    Remote stays thrived, and our virtual concierge expanded worldwide.
                </p>
            </div>
        </div>
        <div class="timeline-item">
            <div class="timeline-bullet">Today</div>
            <div>
                <h3 style="margin: 0 0 0.2rem;">A global community of curious travelers</h3>
                <p style="margin: 0; color: var(--text-muted); line-height: 1.7%;">
                    With over 480 curated listings in 65 destinations, we continue shaping journeys that feel bespoke, rooted, and deeply connected.
                </p>
            </div>
        </div>
    </section>

    <section class="principles">
        <div class="section-title" style="margin-bottom: 0.5rem;">Our guiding principles</div>
        <p class="section-subtitle" style="margin-bottom: 1.75rem;">
            The bnbStay framework keeps every stay intentional and meaningful—for guests, hosts, and communities.
        </p>
        <div class="principles-grid">
            <article class="principle shadow">
                <h4 style="margin: 0;">Intentional design</h4>
                <p style="margin: 0; color: var(--text-muted); line-height: 1.7;">
                    Spaces shaped by local architects, artists, and craftspeople for a sense of place.
                </p>
            </article>
            <article class="principle shadow">
                <h4 style="margin: 0;">Sustainable hospitality</h4>
                <p style="margin: 0; color: var(--text-muted); line-height: 1.7%;">
                    We prioritize low-impact materials, renewable energy, and partnerships with eco-minded hosts.
                </p>
            </article>
            <article class="principle shadow">
                <h4 style="margin: 0;">Community enrichment</h4>
                <p style="margin: 0; color: var(--text-muted); line-height: 1.7%;">
                    A portion of every stay reinvests in local initiatives—from youth arts to environmental projects.
                </p>
            </article>
            <article class="principle shadow">
                <h4 style="margin: 0;">Seamless care</h4>
                <p style="margin: 0; color: var(--text-muted); line-height: 1.7%;">
                    Dedicated concierges who know your preferences, and hosts equipped to deliver heartfelt service.
                </p>
            </article>
        </div>
    </section>

    <section class="team-grid">
        <article class="team-card">
            <div class="team-photo" style="background-image: url('https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&w=800&q=80');"></div>
            <div class="team-content">
                <strong>Lina Ortega</strong>
                <span style="color: var(--primary); font-weight: 500;">Co-founder & Chief Curator</span>
                <p style="margin: 0; color: var(--text-muted); line-height: 1.7;">
                    Design-led strategist focused on blending architecture, art, and storytelling into each stay.
                </p>
            </div>
        </article>
        <article class="team-card">
            <div class="team-photo" style="background-image: url('https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=800&q=80');"></div>
            <div class="team-content">
                <strong>Mateo Silva</strong>
                <span style="color: var(--primary); font-weight: 500;">Co-founder & Experiential Lead</span>
                <p style="margin: 0; color: var(--text-muted); line-height: 1.7%;">
                    Culinary explorer and hospitality guru who crafts immersive itineraries with local hosts.
                </p>
            </div>
        </article>
        <article class="team-card">
            <div class="team-photo" style="background-image: url('https://images.unsplash.com/photo-1544723795-3fb6469f5b39?auto=format&fit=crop&w=800&q=80');"></div>
            <div class="team-content">
                <strong>Shanice Cole</strong>
                <span style="color: var(--primary); font-weight: 500;">Head of Guest Experience</span>
                <p style="margin: 0; color: var(--text-muted); line-height: 1.7%;">
                    Ensures every traveler’s profile is heard, celebrated, and translated into bespoke experiences.
                </p>
            </div>
        </article>
    </section>
@endsection

