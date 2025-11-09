@extends('websitepages.layouts.app')

@section('title', 'Services | bnbStay Hospitality Studio')
@section('meta_description', 'Explore bnbStay hospitality services: curated stays, experiential planning, corporate retreats, and host partnerships.')

@push('styles')
    <style>
        .hero-services {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2.5rem;
            align-items: center;
            margin: 4rem auto 3rem;
            max-width: 1100px;
        }

        .hero-services h1 {
            font-size: clamp(2.2rem, 4vw, 3rem);
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .hero-services p {
            color: var(--text-muted);
            margin-bottom: 2rem;
            line-height: 1.7;
        }

        .service-card {
            background: var(--white);
            border-radius: 18px;
            padding: 2rem;
            display: grid;
            gap: 1rem;
            box-shadow: 0 20px 40px rgba(26, 44, 87, 0.12);
        }

        .service-card h3 {
            margin: 0;
        }

        .service-card ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            gap: 0.6rem;
            color: var(--text-muted);
        }

        .service-card ul li::before {
            content: '•';
            color: var(--primary);
            font-weight: 700;
            margin-right: 0.4rem;
        }

        .tabs {
            display: grid;
            gap: 1.25rem;
            max-width: 1100px;
            margin: 0 auto;
        }

        .tabs-nav {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 0.75rem;
        }

        .tab-link {
            padding: 0.85rem 1rem;
            border-radius: 14px;
            border: 1px solid rgba(43, 112, 247, 0.2);
            text-align: center;
            font-weight: 500;
            color: var(--text-muted);
            background: rgba(255, 255, 255, 0.8);
        }

        .tab-link.active {
            background: linear-gradient(120deg, rgba(43, 112, 247, 0.12), rgba(31, 84, 187, 0.2));
            color: var(--primary);
            border-color: rgba(43, 112, 247, 0.45);
        }

        .tab-panel {
            background: var(--white);
            border-radius: 20px;
            padding: 2.5rem;
            display: grid;
            gap: 1.2rem;
            box-shadow: 0 18px 35px rgba(33, 52, 91, 0.14);
        }

        .experience-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
        }

        .experience-card {
            border-radius: 16px;
            padding: 1.6rem;
            background: rgba(43, 112, 247, 0.045);
            border: 1px solid rgba(43, 112, 247, 0.12);
            display: grid;
            gap: 0.75rem;
        }

        .cta-panel {
            margin: 4rem auto 0;
            max-width: 1100px;
            border-radius: 24px;
            background: linear-gradient(135deg, #2b70f7, #1f54bb);
            color: #ffffff;
            padding: clamp(2.5rem, 4vw, 4rem);
            display: grid;
            gap: 1.5rem;
        }

        .cta-panel p {
            margin: 0;
            font-size: 1.05rem;
            line-height: 1.8;
        }

        .cta-panel .cta-button {
            justify-self: start;
            background: #ffffff;
            color: var(--primary);
            box-shadow: none;
        }

        .cta-panel .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 30px rgba(255, 255, 255, 0.32);
        }
    </style>
@endpush

@section('content')
    <section class="hero-services">
        <div>
            <h1>Hospitality services tailored for modern travelers & discerning hosts.</h1>
            <p>
                Whether you’re planning a restorative escape, curating a company retreat, or launching your boutique stay,
                the bnbStay studio delivers strategy, style, and seamless execution.
            </p>
            <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                <a class="cta-button" href="{{ route('website.contact') }}">Connect with our team</a>
                <a class="cta-button" style="background: rgba(43, 112, 247, 0.1); color: var(--primary); box-shadow: none;" href="#collections">
                    Explore offerings
                </a>
            </div>
        </div>
        <div class="service-card">
            <h3>Bespoke stay blueprint</h3>
            <p style="margin: 0; color: var(--text-muted); line-height: 1.7;">
                We interview you (or your team) to understand your why—then design a stay around it with curated properties,
                concierge services, culinary programming, and meaningful experiences.
            </p>
            <ul>
                <li>Destination discovery & property scouting</li>
                <li>Itinerary craftsmanship & local partnerships</li>
                <li>Concierge & on-ground hospitality specialists</li>
            </ul>
        </div>
    </section>

    <section id="collections" class="tabs">
        <div class="tabs-nav">
            <span class="tab-link active">Signature Guests</span>
            <span class="tab-link">Corporate Retreats</span>
            <span class="tab-link">Brand Collaborations</span>
            <span class="tab-link">Host Partnerships</span>
        </div>
        <div class="tab-panel">
            <h2 style="margin: 0;">Signature guest services</h2>
            <p style="margin: 0; color: var(--text-muted); line-height: 1.7;">
                Ideal for couples, friends, and families seeking inspired escapes with concierge-level care.
                We coordinate every touchpoint so you can focus on the experience.
            </p>
            <div class="experience-grid">
                <article class="experience-card">
                    <strong>Stay selection</strong>
                    <span style="color: var(--text-muted); line-height: 1.6;">
                        Access to our private collection of design-led homes, villas, and boutique hotels worldwide.
                    </span>
                </article>
                <article class="experience-card">
                    <strong>Wellness programming</strong>
                    <span style="color: var(--text-muted); line-height: 1.6%;">
                        Breathwork, sound healing, forest bathing, and movement rituals hosted by vetted practitioners.
                    </span>
                </article>
                <article class="experience-card">
                    <strong>Culinary journeys</strong>
                    <span style="color: var(--text-muted); line-height: 1.6%;">
                        Private chefs, regional tasting menus, progressive dinners, and sommelier pairings.
                    </span>
                </article>
                <article class="experience-card">
                    <strong>Moments that matter</strong>
                    <span style="color: var(--text-muted); line-height: 1.6%;">
                        Proposal planning, milestone celebrations, and surprise experiences tailored to your story.
                    </span>
                </article>
            </div>
        </div>
        <div class="tab-panel">
            <h2 style="margin: 0;">Corporate retreats & leadership offsites</h2>
            <p style="margin: 0; color: var(--text-muted); line-height: 1.7;">
                Build connection, creativity, and culture. We translate your objectives into retreats that balance strategy with play.
            </p>
            <div class="experience-grid">
                <article class="experience-card">
                    <strong>Retreat design sprints</strong>
                    <span style="color: var(--text-muted); line-height: 1.6%;">
                        Collaborative workshops to align agenda goals, team dynamics, and retreat outcomes.
                    </span>
                </article>
                <article class="experience-card">
                    <strong>Experience production</strong>
                    <span style="color: var(--text-muted); line-height: 1.6%;">
                        Facilitation, AV, live chefs, and experiential activations handled end-to-end by our crew.
                    </span>
                </article>
                <article class="experience-card">
                    <strong>Wellbeing & team flow</strong>
                    <span style="color: var(--text-muted); line-height: 1.6%;">
                        Daily rituals, guided mindfulness, and energy management coaches for peak collaboration.
                    </span>
                </article>
                <article class="experience-card">
                    <strong>Impact-driven givebacks</strong>
                    <span style="color: var(--text-muted); line-height: 1.6%;">
                        Community projects and climate-positive initiatives aligned with your brand values.
                    </span>
                </article>
            </div>
        </div>
        <div class="tab-panel">
            <h2 style="margin: 0;">Brand collaborations & launches</h2>
            <p style="margin: 0; color: var(--text-muted); line-height: 1.7%;">
                Transform properties into immersive environments that tell your brand story and engage your audience.
            </p>
            <div class="experience-grid">
                <article class="experience-card">
                    <strong>Concept studios</strong>
                    <span style="color: var(--text-muted); line-height: 1.6%;">
                        Multi-sensory brand worlds crafted with production designers & creative directors.
                    </span>
                </article>
                <article class="experience-card">
                    <strong>Influencer residencies</strong>
                    <span style="color: var(--text-muted); line-height: 1.6%;">
                        Hosted stays for creators complete with curated content itineraries and production support.
                    </span>
                </article>
                <article class="experience-card">
                    <strong>Press preview stays</strong>
                    <span style="color: var(--text-muted); line-height: 1.6%;">
                        Bespoke guest journeys for media partners with white-glove hospitality teams.
                    </span>
                </article>
                <article class="experience-card">
                    <strong>Campaign storytelling</strong>
                    <span style="color: var(--text-muted); line-height: 1.6%;">
                        Documentary crews, stylists, and production managers to execute narrative-driven content.
                    </span>
                </article>
            </div>
        </div>
        <div class="tab-panel">
            <h2 style="margin: 0;">Host partnership program</h2>
            <p style="margin: 0; color: var(--text-muted); line-height: 1.7%;">
                Join our curated portfolio, scale your revenue, and deliver elevated hospitality with bnbStay’s guidance.
            </p>
            <div class="experience-grid">
                <article class="experience-card">
                    <strong>Design consultation</strong>
                    <span style="color: var(--text-muted); line-height: 1.6%;">
                        Visual storytelling, furnishing selection, and guest flow tailored to your unique space.
                    </span>
                </article>
                <article class="experience-card">
                    <strong>Revenue strategy</strong>
                    <span style="color: var(--text-muted); line-height: 1.6%;">
                        Dynamic pricing, predictive demand, and seasonal programming built on data insights.
                    </span>
                </article>
                <article class="experience-card">
                    <strong>Guest experience playbooks</strong>
                    <span style="color: var(--text-muted); line-height: 1.6%;">
                        Rituals, welcome kits, and service standards that turn guests into lifelong fans.
                    </span>
                </article>
                <article class="experience-card">
                    <strong>Marketing collateral</strong>
                    <span style="color: var(--text-muted); line-height: 1.6%;">
                        Professional photography, storytelling frameworks, and campaign amplification.
                    </span>
                </article>
            </div>
        </div>
    </section>

    <section class="cta-panel shadow">
        <div class="badge" style="background: rgba(255, 255, 255, 0.2); color: #ffffff;">Work with us</div>
        <h2 style="margin: 0;">Let’s design a hospitality experience that feels made for you.</h2>
        <p>
            Tell us about your vision and we’ll assemble the right hosts, experts, and storytellers to bring it to life—
            from intimate escapes to global launches.
        </p>
        <a class="cta-button" href="{{ route('website.contact') }}">Schedule a discovery call</a>
    </section>
@endsection

