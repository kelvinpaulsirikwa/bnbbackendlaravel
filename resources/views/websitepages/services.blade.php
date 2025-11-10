@extends('websitepages.layouts.app')

@section('title', 'Services | bnbStay Hospitality Studio')
@section('meta_description', 'Explore bnbStay hospitality services: curated stays, experiential planning, corporate retreats, and host partnerships.')

@push('styles')
    <style>
        :root {
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-secondary: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --gradient-accent: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --gradient-gold: linear-gradient(135deg, #f7971e 0%, #ffd200 100%);
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.04);
            --shadow-md: 0 8px 24px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 20px 60px rgba(0, 0, 0, 0.12);
            --shadow-glow: 0 8px 32px rgba(102, 126, 234, 0.35);
        }

        body {
            background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
            min-height: 100vh;
        }

        .services-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        /* Hero Section */
        .hero-services {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
            margin: 5rem auto 4rem;
            animation: fadeInUp 0.8s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-content h1 {
            font-size: clamp(2.5rem, 4vw, 3.5rem);
            margin-bottom: 1.5rem;
            line-height: 1.2;
            font-weight: 800;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.02em;
        }

        .hero-content p {
            color: #64748b;
            margin-bottom: 2rem;
            line-height: 1.8;
            font-size: 1.125rem;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .cta-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem 2rem;
            background: var(--gradient-primary);
            color: #ffffff;
            border-radius: 16px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: var(--shadow-glow);
        }

        .cta-button:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 12px 40px rgba(102, 126, 234, 0.5);
        }

        .cta-button.secondary {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
            box-shadow: none;
        }

        .cta-button.secondary:hover {
            background: rgba(102, 126, 234, 0.15);
            box-shadow: var(--shadow-md);
        }

        .service-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
            animation: fadeIn 1s ease 0.3s backwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
        }

        .service-card h3 {
            margin: 0 0 1rem 0;
            font-size: 1.75rem;
            font-weight: 700;
            color: #1e293b;
        }

        .service-card > p {
            margin: 0 0 1.5rem 0;
            color: #64748b;
            line-height: 1.8;
        }

        .service-card ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            gap: 0.875rem;
        }

        .service-card ul li {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            color: #475569;
            line-height: 1.6;
        }

        .service-card ul li::before {
            content: '✓';
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 24px;
            height: 24px;
            border-radius: 50%;
            background: var(--gradient-primary);
            color: #ffffff;
            font-weight: 700;
            font-size: 0.875rem;
        }

        /* Tabs Section */
        .tabs {
            margin: 4rem 0;
            animation: fadeIn 1s ease 0.5s backwards;
        }

        .tabs-nav {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            overflow-x: auto;
            padding-bottom: 0.5rem;
            scrollbar-width: thin;
        }

        .tabs-nav::-webkit-scrollbar {
            height: 4px;
        }

        .tabs-nav::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 999px;
        }

        .tabs-nav::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 999px;
        }

        .tab-link {
            padding: 1rem 1.75rem;
            border-radius: 16px;
            border: 2px solid #e2e8f0;
            text-align: center;
            font-weight: 700;
            color: #64748b;
            background: #ffffff;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            white-space: nowrap;
            flex-shrink: 0;
        }

        .tab-link:hover {
            border-color: #667eea;
            color: #667eea;
            transform: translateY(-2px);
        }

        .tab-link.active {
            background: var(--gradient-primary);
            color: #ffffff;
            border-color: transparent;
            box-shadow: var(--shadow-glow);
        }

        .tab-panel {
            display: none;
            background: #ffffff;
            border-radius: 24px;
            padding: 3rem;
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
        }

        .tab-panel.active {
            display: block;
            animation: slideIn 0.5s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .tab-panel::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-accent);
        }

        .tab-panel h2 {
            margin: 0 0 1rem 0;
            font-size: 2rem;
            font-weight: 800;
            color: #1e293b;
        }

        .tab-panel > p {
            margin: 0 0 2rem 0;
            color: #64748b;
            line-height: 1.8;
            font-size: 1.05rem;
        }

        .experience-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .experience-card {
            border-radius: 20px;
            padding: 2rem;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
            border: 2px solid rgba(102, 126, 234, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .experience-card:hover {
            transform: translateY(-4px);
            border-color: rgba(102, 126, 234, 0.3);
            box-shadow: var(--shadow-md);
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.08) 100%);
        }

        .experience-card strong {
            display: block;
            font-size: 1.125rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.75rem;
        }

        .experience-card span {
            color: #64748b;
            line-height: 1.7;
            display: block;
        }

        /* CTA Panel */
        .cta-panel {
            margin: 5rem 0;
            border-radius: 32px;
            background: var(--gradient-primary);
            color: #ffffff;
            padding: clamp(3rem, 5vw, 5rem);
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-glow);
        }

        .cta-panel::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            filter: blur(60px);
        }

        .cta-panel::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            filter: blur(50px);
        }

        .cta-content {
            position: relative;
            z-index: 1;
            max-width: 800px;
        }

        .cta-panel .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.5rem;
            background: rgba(255, 255, 255, 0.2);
            color: #ffffff;
            border-radius: 999px;
            font-size: 0.875rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 1.5rem;
            backdrop-filter: blur(10px);
        }

        .cta-panel h2 {
            margin: 0 0 1.25rem 0;
            font-size: clamp(1.75rem, 3vw, 2.5rem);
            font-weight: 800;
            line-height: 1.3;
        }

        .cta-panel p {
            margin: 0 0 2rem 0;
            font-size: 1.125rem;
            line-height: 1.8;
            opacity: 0.95;
        }

        .cta-panel .cta-button {
            background: #ffffff;
            color: #667eea;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
        }

        .cta-panel .cta-button:hover {
            transform: translateY(-4px) scale(1.05);
            box-shadow: 0 8px 32px rgba(255, 255, 255, 0.4);
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .hero-services {
                grid-template-columns: 1fr;
                gap: 2.5rem;
            }

            .experience-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .hero-services {
                margin: 3rem auto 2.5rem;
            }

            .hero-content h1 {
                font-size: 2rem;
            }

            .service-card {
                padding: 2rem;
            }

            .tab-panel {
                padding: 2rem;
            }

            .tabs-nav {
                gap: 0.5rem;
            }

            .tab-link {
                padding: 0.875rem 1.25rem;
                font-size: 0.9rem;
            }

            .experience-card {
                padding: 1.5rem;
            }

            .cta-panel {
                padding: 2.5rem 1.5rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="services-container">
        <!-- Hero Section -->
        <section class="hero-services">
            <div class="hero-content">
                <h1>Hospitality services tailored for modern travelers & discerning hosts.</h1>
                <p>
                    Whether you're planning a restorative escape, curating a company retreat, or launching your boutique stay,
                    the bnbStay studio delivers strategy, style, and seamless execution.
                </p>
                <div class="hero-buttons">
                    <a class="cta-button" href="{{ route('website.contact') }}">
                        Connect with our team
                    </a>
                    <a class="cta-button secondary" href="#collections">
                        Explore offerings
                    </a>
                </div>
            </div>
            <div class="service-card">
                <h3>Bespoke stay blueprint</h3>
                <p>
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

        <!-- Tabs Section -->
        <section id="collections" class="tabs">
            <div class="tabs-nav">
                <button class="tab-link active" data-tab="tab1">Signature Guests</button>
                <button class="tab-link" data-tab="tab2">Corporate Retreats</button>
                <button class="tab-link" data-tab="tab3">Brand Collaborations</button>
                <button class="tab-link" data-tab="tab4">Host Partnerships</button>
            </div>

            <div id="tab1" class="tab-panel active">
                <h2>Signature guest services</h2>
                <p>
                    Ideal for couples, friends, and families seeking inspired escapes with concierge-level care.
                    We coordinate every touchpoint so you can focus on the experience.
                </p>
                <div class="experience-grid">
                    <article class="experience-card">
                        <strong>Stay selection</strong>
                        <span>
                            Access to our private collection of design-led homes, villas, and boutique hotels worldwide.
                        </span>
                    </article>
                    <article class="experience-card">
                        <strong>Wellness programming</strong>
                        <span>
                            Breathwork, sound healing, forest bathing, and movement rituals hosted by vetted practitioners.
                        </span>
                    </article>
                    <article class="experience-card">
                        <strong>Culinary journeys</strong>
                        <span>
                            Private chefs, regional tasting menus, progressive dinners, and sommelier pairings.
                        </span>
                    </article>
                    <article class="experience-card">
                        <strong>Moments that matter</strong>
                        <span>
                            Proposal planning, milestone celebrations, and surprise experiences tailored to your story.
                        </span>
                    </article>
                </div>
            </div>

            <div id="tab2" class="tab-panel">
                <h2>Corporate retreats & leadership offsites</h2>
                <p>
                    Build connection, creativity, and culture. We translate your objectives into retreats that balance strategy with play.
                </p>
                <div class="experience-grid">
                    <article class="experience-card">
                        <strong>Retreat design sprints</strong>
                        <span>
                            Collaborative workshops to align agenda goals, team dynamics, and retreat outcomes.
                        </span>
                    </article>
                    <article class="experience-card">
                        <strong>Experience production</strong>
                        <span>
                            Facilitation, AV, live chefs, and experiential activations handled end-to-end by our crew.
                        </span>
                    </article>
                    <article class="experience-card">
                        <strong>Wellbeing & team flow</strong>
                        <span>
                            Daily rituals, guided mindfulness, and energy management coaches for peak collaboration.
                        </span>
                    </article>
                    <article class="experience-card">
                        <strong>Impact-driven givebacks</strong>
                        <span>
                            Community projects and climate-positive initiatives aligned with your brand values.
                        </span>
                    </article>
                </div>
            </div>

            <div id="tab3" class="tab-panel">
                <h2>Brand collaborations & launches</h2>
                <p>
                    Transform properties into immersive environments that tell your brand story and engage your audience.
                </p>
                <div class="experience-grid">
                    <article class="experience-card">
                        <strong>Concept studios</strong>
                        <span>
                            Multi-sensory brand worlds crafted with production designers & creative directors.
                        </span>
                    </article>
                    <article class="experience-card">
                        <strong>Influencer residencies</strong>
                        <span>
                            Hosted stays for creators complete with curated content itineraries and production support.
                        </span>
                    </article>
                    <article class="experience-card">
                        <strong>Press preview stays</strong>
                        <span>
                            Bespoke guest journeys for media partners with white-glove hospitality teams.
                        </span>
                    </article>
                    <article class="experience-card">
                        <strong>Campaign storytelling</strong>
                        <span>
                            Documentary crews, stylists, and production managers to execute narrative-driven content.
                        </span>
                    </article>
                </div>
            </div>

            <div id="tab4" class="tab-panel">
                <h2>Host partnership program</h2>
                <p>
                    Join our curated portfolio, scale your revenue, and deliver elevated hospitality with bnbStay's guidance.
                </p>
                <div class="experience-grid">
                    <article class="experience-card">
                        <strong>Design consultation</strong>
                        <span>
                            Visual storytelling, furnishing selection, and guest flow tailored to your unique space.
                        </span>
                    </article>
                    <article class="experience-card">
                        <strong>Revenue strategy</strong>
                        <span>
                            Dynamic pricing, predictive demand, and seasonal programming built on data insights.
                        </span>
                    </article>
                    <article class="experience-card">
                        <strong>Guest experience playbooks</strong>
                        <span>
                            Rituals, welcome kits, and service standards that turn guests into lifelong fans.
                        </span>
                    </article>
                    <article class="experience-card">
                        <strong>Marketing collateral</strong>
                        <span>
                            Professional photography, storytelling frameworks, and campaign amplification.
                        </span>
                    </article>
                </div>
            </div>
        </section>

        <!-- CTA Panel -->
        <section class="cta-panel">
            <div class="cta-content">
                <span class="badge">🤝 Work with us</span>
                <h2>Let's design a hospitality experience that feels made for you.</h2>
                <p>
                    Tell us about your vision and we'll assemble the right hosts, experts, and storytellers to bring it to life—
                    from intimate escapes to global launches.
                </p>
                <a class="cta-button" href="{{ route('website.contact') }}">Schedule a discovery call</a>
            </div>
        </section>
    </div>

    <script>
        // Tab functionality
        document.addEventListener('DOMContentLoaded', function() {
            const tabLinks = document.querySelectorAll('.tab-link');
            const tabPanels = document.querySelectorAll('.tab-panel');

            tabLinks.forEach(link => {
                link.addEventListener('click', function() {
                    const targetTab = this.getAttribute('data-tab');

                    // Remove active class from all tabs and panels
                    tabLinks.forEach(l => l.classList.remove('active'));
                    tabPanels.forEach(p => p.classList.remove('active'));

                    // Add active class to clicked tab and corresponding panel
                    this.classList.add('active');
                    document.getElementById(targetTab).classList.add('active');
                });
            });
        });
    </script>678 nm,o876rwedzfsdhgyiuop[-980976rhefwqdQASDFGHJLK;;'?>,M BNVbnm,
    .']
@endsection