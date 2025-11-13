@extends('websitepages.layouts.app')

@section('title', 'About bnbStay | Our Story & Values')
@section('meta_description', 'Learn how bnbStay curates boutique stays, partners with local hosts, and delivers meaningful travel experiences.')

@push('styles')
    <style>
        :root {
            --about-gradient: linear-gradient(135deg, rgba(43, 112, 247, 0.12), rgba(31, 84, 187, 0.18));
            --about-accent: #b4550f;
            --about-surface: #ffffff;
            --about-border: rgba(15, 23, 42, 0.08);
        }

        .about-container {
            display: grid;
            gap: 4rem;
        }

        .about-hero {
            background: var(--about-gradient);
            border-radius: 28px;
            padding: clamp(2.5rem, 6vw, 4.5rem);
            display: grid;
            gap: clamp(2rem, 4vw, 3rem);
            box-shadow: 0 30px 60px rgba(17, 24, 39, 0.12);
            overflow: hidden;
        }

        .about-hero-inner {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: clamp(2rem, 4vw, 3rem);
            align-items: center;
        }

        .about-hero-copy {
            display: grid;
            gap: 1.25rem;
        }

        .about-hero-copy h1 {
            margin: 0;
            font-size: clamp(2.4rem, 4.5vw, 3.4rem);
            line-height: 1.15;
        }

        .about-hero-copy p {
            margin: 0;
            color: var(--text-muted);
            line-height: 1.8;
            max-width: 600px;
        }

        .about-hero-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 1.25rem;
        }

        .about-stat {
            background: var(--about-surface);
            border-radius: 20px;
            padding: 1.75rem 1.5rem;
            display: grid;
            gap: 0.4rem;
            text-align: left;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.1);
        }

        .about-stat .value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary);
        }

        .about-stat .label {
            font-size: 0.95rem;
            color: var(--text-muted);
        }

        .about-stories {
            display: grid;
            gap: clamp(1.75rem, 3vw, 2.5rem);
            padding: 0 clamp(1.5rem, 5vw, 3rem);
        }

        .about-stories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .about-card {
            background: var(--about-surface);
            border-radius: 22px;
            padding: 2.25rem;
            box-shadow: 0 24px 50px rgba(15, 23, 42, 0.12);
            border: 1px solid var(--about-border);
            display: grid;
            gap: 1rem;
        }

        .about-card .card-heading {
            display: inline-flex;
            align-items: center;
            gap: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-size: 0.75rem;
            color: var(--primary);
        }

        .about-card p {
            margin: 0;
            color: var(--text-muted);
            line-height: 1.7;
        }

        .about-journey {
            display: grid;
            gap: 2rem;
        }

        .about-journey-header {
            display: grid;
            gap: 0.75rem;
            text-align: center;
            max-width: 680px;
            margin: 0 auto;
        }

        .about-journey-header h2 {
            margin: 0;
            font-size: clamp(2rem, 3vw, 2.6rem);
        }

        .about-journey-header p {
            margin: 0;
            color: var(--text-muted);
        }

        .about-timeline {
            position: relative;
            display: grid;
            gap: 1.5rem;
            padding-left: clamp(1rem, 4vw, 2.75rem);
        }

        .about-timeline::before {
            content: '';
            position: absolute;
            left: clamp(0.35rem, 1.5vw, 0.75rem);
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(180deg, rgba(43, 112, 247, 0.2), transparent);
        }

        .timeline-step {
            display: grid;
            gap: 0.75rem;
            padding: 1.75rem 1.75rem 1.75rem clamp(1.75rem, 4vw, 3rem);
            background: var(--about-surface);
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
            border: 1px solid var(--about-border);
            position: relative;
        }

        .timeline-step::before {
            content: attr(data-year);
            position: absolute;
            left: clamp(-1.1rem, -1vw, -0.9rem);
            top: 50%;
            transform: translate(-50%, -50%);
            min-width: 58px;
            height: 58px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            background: #ffffff;
            color: var(--primary);
            font-weight: 700;
            box-shadow: 0 10px 25px rgba(43, 112, 247, 0.18);
        }

        .timeline-step h3 {
            margin: 0;
            font-size: 1.35rem;
        }

        .timeline-step p {
            margin: 0;
            color: var(--text-muted);
            line-height: 1.75;
        }

        .about-values {
            background: #f5f7ff;
            border-radius: 28px;
            padding: clamp(2.5rem, 6vw, 4rem);
            display: grid;
            gap: 2rem;
        }

        .about-values-header {
            display: grid;
            gap: 0.75rem;
            text-align: center;
            max-width: 760px;
            margin: 0 auto;
        }

        .about-values-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
        }

        .about-value {
            background: var(--about-surface);
            border-radius: 20px;
            padding: 1.75rem;
            display: grid;
            gap: 0.75rem;
            border: 1px solid rgba(99, 102, 241, 0.12);
            box-shadow: 0 18px 32px rgba(15, 23, 42, 0.08);
        }

        .about-value h4 {
            margin: 0;
            font-size: 1.1rem;
        }

        .about-value p {
            margin: 0;
            font-size: 0.95rem;
            color: var(--text-muted);
            line-height: 1.7;
        }

        .about-team {
            display: grid;
            gap: 2.5rem;
        }

        .about-team-header {
            display: grid;
            gap: 0.75rem;
            text-align: center;
            max-width: 680px;
            margin: 0 auto;
        }

        .about-team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.75rem;
        }

        .about-team-card {
            background: var(--about-surface);
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 24px 50px rgba(15, 23, 42, 0.12);
            display: flex;
            flex-direction: column;
            min-height: 100%;
        }

        .about-team-photo {
            position: relative;
            aspect-ratio: 3/2;
            overflow: hidden;
            background: #e2e8f0;
        }

        .about-team-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .about-team-content {
            padding: 1.75rem;
            display: grid;
            gap: 0.5rem;
        }

        .about-team-role {
            color: var(--primary);
            font-weight: 600;
            font-size: 0.95rem;
        }

        .about-team-content p {
            margin: 0;
            color: var(--text-muted);
            line-height: 1.65;
        }

        @media (max-width: 768px) {
            .about-container {
                gap: 3rem;
            }

            .about-hero-stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .timeline-step::before {
                left: clamp(-1.25rem, -2vw, -1rem);
            }
        }

        @media (max-width: 640px) {
            .about-hero {
                border-radius: 22px;
            }

            .about-hero-stats {
                grid-template-columns: minmax(0, 1fr);
            }

            .about-timeline {
                padding-left: 0;
            }

            .about-timeline::before {
                display: none;
            }

            .timeline-step {
                padding: 1.5rem;
            }

            .timeline-step::before {
                position: static;
                transform: none;
                margin-bottom: 0.75rem;
                justify-self: flex-start;
            }
        }
    </style>
@endpush

@section('content')
    @php
        $headlineStats = [
            ['value' => '480+', 'label' => 'Boutique stays with soul'],
            ['value' => '65', 'label' => 'Destinations & districts'],
            ['value' => '1.2K', 'label' => 'Hosts & creative partners'],
            ['value' => '98%', 'label' => 'Guests who plan a return trip'],
        ];

        $pillars = [
            [
                'heading' => 'Mission',
                'title' => 'Curate restorative spaces that feel human.',
                'description' => 'Every stay is crafted around slow moments, purposeful design, and service that anticipates your needs before you arrive.',
            ],
            [
                'heading' => 'How we build',
                'title' => 'We co-create with local hosts & makers.',
                'description' => 'From indigenous artisans in Oaxaca to botanical designers in Bali, each experience is rooted in the people who call it home.',
            ],
            [
                'heading' => 'Promise',
                'title' => 'Travel that feels bespoke and grounded.',
                'description' => 'We pair handpicked properties with concierge support so you can focus on connection, not logistics.',
            ],
        ];

        $timeline = [
            [
                'year' => '2012',
                'title' => 'A guest room with a bigger vision',
                'description' => 'bnbStay began in a San Francisco loft shared with traveling designers. The joy of hosting sparked a community-first approach to hospitality.',
            ],
            [
                'year' => '2016',
                'title' => 'Collections take shape',
                'description' => 'We expanded across five countries and introduced curated Collections—Coastal Escapes, Urban Atelier, Mountain Retreats, and Wellness Havens.',
            ],
            [
                'year' => '2020',
                'title' => 'Designing for wellbeing',
                'description' => 'Amid global pause, we aligned with wellness practitioners to bring sound baths, slow dining, and digital detox itineraries into every stay.',
            ],
            [
                'year' => 'Today',
                'title' => 'A growing circle of curious travelers',
                'description' => 'With 480+ listings and new cultural residencies every quarter, we continue to champion travel that is intentional, local, and beautifully human.',
            ],
        ];

        $values = [
            [
                'title' => 'Intentional design',
                'copy' => 'Spaces are imagined with local architects, heritage artisans, and biophilic designers to feel rooted in place.',
            ],
            [
                'title' => 'Sustainable hospitality',
                'copy' => 'We invest in circular materials, renewable energy, and low-impact operations across our partner network.',
            ],
            [
                'title' => 'Community enrichment',
                'copy' => 'A portion of every booking funds micro-grants for cultural programs, youth arts, and conservation projects.',
            ],
            [
                'title' => 'Seamless care',
                'copy' => 'Dedicated concierges learn your rituals, plan immersive itineraries, and stay with you throughout the journey.',
            ],
        ];

        $team = [
            [
                'name' => 'Lina Ortega',
                'role' => 'Co-founder & Chief Curator',
                'bio' => 'Design-led strategist blending architecture, art, and storytelling into each stay experience.',
                'image' => 'https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&w=960&q=80',
            ],
            [
                'name' => 'Mateo Silva',
                'role' => 'Co-founder & Experiential Lead',
                'bio' => 'Culinary explorer and hospitality partner who co-designs resident chef programs with local hosts.',
                'image' => 'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=960&q=80',
            ],
            [
                'name' => 'Shanice Cole',
                'role' => 'Head of Guest Experience',
                'bio' => 'Leads our Rituals team to translate traveler preferences into unforgettable, heartfelt itineraries.',
                'image' => 'https://images.unsplash.com/photo-1544723795-3fb6469f5b39?auto=format&fit=crop&w=960&q=80',
            ],
            [
                'name' => 'Arjun Dhillon',
                'role' => 'Director of Host Partnerships',
                'bio' => 'Works across continents to mentor hosts, elevate service rituals, and keep stays feeling distinctly bnbStay.',
                'image' => 'https://images.unsplash.com/photo-1599566150163-29194dcaad36?auto=format&fit=crop&w=960&q=80',
            ],
        ];
    @endphp

    <div class="about-container">
        <section class="about-hero">
            <div class="about-hero-inner">
                <div class="about-hero-copy">
                    <span class="badge">Our Story</span>
                    <h1>bnbStay was born from one spare room and a commitment to heartfelt hosting.</h1>
                    <p>
                        The project started in 2012 when two hospitality enthusiasts opened their loft to designers passing
                        through San Francisco. That humble experience taught us that the best stays are a collaboration between
                        thoughtful hosts, inspired places, and travelers who crave more than a bed for the night.
                    </p>
                </div>
                <div class="about-hero-stats">
                    @foreach($headlineStats as $stat)
                        <div class="about-stat">
                            <span class="value">{{ $stat['value'] }}</span>
                            <span class="label">{{ $stat['label'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
    </section>

        <section class="about-stories">
            <div class="section-title" style="text-align: center; margin: 0 auto;">How we build the bnbStay experience</div>
            <p class="section-subtitle" style="text-align: center; max-width: 680px; margin: 0 auto;">
                Every stay is a collaboration. We pair purpose-led hosts with designers, wellness experts, and local guides to
                create journeys that feel intentional from the first welcome to the last goodbye.
            </p>

            <div class="about-stories-grid">
                @foreach($pillars as $pillar)
                    <article class="about-card">
                        <span class="card-heading">{{ $pillar['heading'] }}</span>
                        <h3 style="margin: 0;">{{ $pillar['title'] }}</h3>
                        <p>{{ $pillar['description'] }}</p>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="about-journey">
            <div class="about-journey-header">
                <span class="badge" style="justify-self: center;">Journey</span>
                <h2>The evolution of a people-first stay company</h2>
                <p>From a single guest room to a global network of handcrafted stays, here are the milestones that shaped the project.</p>
            </div>

            <div class="about-timeline">
                @foreach($timeline as $event)
                    <article class="timeline-step" data-year="{{ $event['year'] }}">
                        <h3>{{ $event['title'] }}</h3>
                        <p>{{ $event['description'] }}</p>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="about-values">
            <div class="about-values-header">
                <h2>Our guiding principles</h2>
                <p>These are the promises we make to every guest, host, and community we collaborate with on the bnbStay journey.</p>
            </div>

            <div class="about-values-grid">
                @foreach($values as $value)
                    <article class="about-value">
                        <h4>{{ $value['title'] }}</h4>
                        <p>{{ $value['copy'] }}</p>
                    </article>
                @endforeach
            </div>
        </section>

        <section class="about-team">
            <div class="about-team-header">
                <span class="badge" style="justify-self: center;">Team</span>
                <h2>Hosts, curators, and storytellers at your service</h2>
                <p>Meet the team that ensures every bnbStay experience feels naturally luxurious and full of heart.</p>
            </div>

            <div class="about-team-grid">
                @foreach($team as $member)
                    <article class="about-team-card">
                        <div class="about-team-photo">
                            <img src="{{ $member['image'] }}" alt="{{ $member['name'] }} portrait">
                        </div>
                        <div class="about-team-content">
                            <strong>{{ $member['name'] }}</strong>
                            <span class="about-team-role">{{ $member['role'] }}</span>
                            <p>{{ $member['bio'] }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    </div>
@endsection

