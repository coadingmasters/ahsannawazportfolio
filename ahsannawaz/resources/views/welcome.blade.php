<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    {{-- Reused by the homepage projects section: .ab-* shell + .pj-card* --}}
    <link rel="stylesheet" href="{{ asset('css/about.css') }}">
    <link rel="stylesheet" href="{{ asset('css/projects.css') }}">
    <link rel="stylesheet" href="{{ asset('css/popup.css') }}">
</head>
    <body>
        @include('layouts.partials.header')

        @php
            // ucfirst() would render "Cms"/"Api" — spell these properly.
            $catLabels = [
                'backend' => 'Backend', 'frontend' => 'Frontend', 'cms' => 'CMS',
                'database' => 'Database', 'tools' => 'Tools',
                'web' => 'Web', 'mobile' => 'Mobile', 'api' => 'API', 'wordpress' => 'WordPress',
            ];
        @endphp
<section id="hero">

    <!-- Ambient blobs -->
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <div class="hero-inner">

        {{-- ── LEFT CONTENT ── --}}
        <div class="hero-left">

            <div class="badge">
                <span class="badge-dot"></span>
                Available for  work
            </div>

            <h1 class="hero-title">
                Hi, I'm <span>Ahsan</span><br>Nawaz
            </h1>

            <p class="role-line">
                I'm a <span class="role-highlight" id="typewriter"></span>
            </p>

            <p class="hero-desc">
                Passionate developer crafting clean, scalable and beautiful web experiences.
                From dynamic Laravel backends to pixel-perfect React frontends — I build it all.
                Also specializing in WordPress plugin development and custom solutions.
            </p>

            <div class="stats-row">
                <div class="stat">
                    <span class="stat-num" data-target="23">0</span>
                    <span class="stat-label">Projects Delivered</span>
                </div>
                <div class="stat">
                    <span class="stat-num" data-target="2">0</span>
                    <span class="stat-label">Years Experience</span>
                </div>
                <div class="stat">
                    <span class="stat-num" data-target="10">0</span>
                    <span class="stat-label">Happy Clients</span>
                </div>
            </div>

            <div class="cta-row">
                <a href="#contact" class="btn-primary">
                    ✉ Hire Me
                </a>
                @if ($hasCv)
                    <a href="{{ route('cv.download') }}" class="btn-secondary">
                        ↓ Download CV
                    </a>
                @endif
            </div>

            <div class="social-row">
                <span class="social-label">Follow me:</span>
                <a href="#" class="social-icon" title="Facebook">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                </a>
                <a href="#" class="social-icon" title="LinkedIn">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>
                </a>
                <a href="#" class="social-icon" title="GitHub">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"/></svg>
                </a>
                <a href="#" class="social-icon" title="Twitter / X">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.73-8.835L1.254 2.25H8.08l4.713 6.057zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                </a>
                <a href="#" class="social-icon" title="Fiverr">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M23 9.25h-9.37c.057-.487.258-.876.604-1.167.346-.29.864-.436 1.554-.436h1.1V4.5h-1.47c-1.83 0-3.29.52-4.35 1.56-1.06 1.04-1.6 2.47-1.62 4.29v.9H7v3.25h2.43V24H13V14.5h4.6V24h3.61V14.5H23V9.25zM6.03 8.75a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/></svg>
                </a>
            </div>

        </div>

        {{-- ── RIGHT VISUAL ── --}}
        <div class="hero-right">
            <div class="profile-wrap">

                <!-- Orbit rings -->
                <div class="ring ring-1"><div class="ring-dot"></div></div>
                <div class="ring ring-2"></div>

                <!-- Profile photo circle -->
                 <div class="photo-frame">
                <div class="photo-circle">
                    <img src="{{ asset('images/ahsannawaz.webp') }}" alt="Ahsan Nawaz">
                </div>
                </div>

                <!-- Floating badge: Projects -->
                <div class="float-card card-top">
                    <div class="card-icon">🚀</div>
                    <div class="card-text">
                        <p>50+ Projects</p>
                        <p>Delivered</p>
                    </div>
                </div>

                <!-- Floating badge: Rating -->
                <div class="float-card card-bottom">
                    <div class="card-icon">⭐</div>
                    <div class="card-text">
                        <p>5 Star Rating</p>
                        <p>On Fiverr</p>
                    </div>
                </div>

                <!-- Floating badge: Tech -->
                <div class="float-card card-left">
                    <div class="card-icon">⚡</div>
                    <div class="card-text">
                        <p>Laravel Expert</p>
                        <p>PHP & React</p>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>
{{-- ═══════════════════════════════════════════════
    About Me Section — Ahsan Nawaz Portfolio
═══════════════════════════════════════════════ --}}
<section id="about">

    <div class="about-inner">

        {{-- ── LEFT: ANIMATED IMAGE ── --}}
        <div class="about-left reveal left">

            {{-- Orbit rings --}}
            <div class="a-ring a-ring-1"></div>
            <div class="a-ring a-ring-2"></div>
            <div class="a-ring a-ring-3"></div>

            {{-- Orbiting dots --}}
            <div class="orbit-dot orbit-dot-1"></div>
            <div class="orbit-dot orbit-dot-2"></div>
            <div class="orbit-dot orbit-dot-3"></div>

            {{-- Corner brackets --}}
            <div class="bracket bracket-tl"></div>
            <div class="bracket bracket-tr"></div>
            <div class="bracket bracket-bl"></div>
            <div class="bracket bracket-br"></div>

            {{-- Main photo --}}
            <div class="photo-frame">
                <div class="photo-img">
                    
                        <img src="{{ asset('images/ahsannawaz.webp') }}" alt="Ahsan Nawaz" style="width:100%;height:100%;object-fit:cover;object-position:top;border-radius:22px;">
                   
                    <!-- <div class="photo-placeholder">
                        <span>AN</span>
                        <span>YOUR PHOTO</span>
                    </div> -->
                </div>

                {{-- Experience badge --}}
                <div class="exp-badge">
                    <span>5+</span>
                    <span>Years<br>Exp.</span>
                </div>
            </div>

            {{-- Floating chips --}}
            <div class="skill-chip chip-1">
                <div class="chip-icon">⚡</div>
                <div>
                    <div>Laravel</div>
                    <div class="chip-sub">Backend Expert</div>
                </div>
            </div>

            <div class="skill-chip chip-2">
                <div class="chip-icon">⭐</div>
                <div>
                    <div>5-Star Rated</div>
                    <div class="chip-sub">On Fiverr</div>
                </div>
            </div>

            <div class="skill-chip chip-3">
                <div class="chip-icon">🚀</div>
                <div>
                    <div>50+ Projects</div>
                    <div class="chip-sub">Delivered</div>
                </div>
            </div>

        </div>

        {{-- ── RIGHT: CONTENT ── --}}
        <div class="about-right">

            <span class="section-label reveal right" style="transition-delay:0.1s">About Me</span>

            <h2 class="about-heading reveal right" style="transition-delay:0.2s">
                Passionate Developer<br>Building <em>Digital Excellence</em>
            </h2>

            <p class="about-text reveal right" style="transition-delay:0.3s">
                Hi, I'm <strong style="color:var(--text)">Ahsan Nawaz</strong>, a full-stack web developer based in Pakistan
                with over 5 years of hands-on experience building robust, scalable, and visually compelling
                web applications. I specialise in Laravel, PHP, React JS, and WordPress — turning complex
                ideas into elegant solutions.
            </p>

            <p class="about-text about-extra reveal right" style="transition-delay:0.35s" id="about-extra-text">
                I've worked with clients across the globe — from startups to established businesses —
                delivering high-quality code, clean architecture, and pixel-perfect frontends.
                Whether it's a custom WordPress plugin, a full-scale Laravel SaaS, or a
                lightning-fast React interface, I bring the same level of dedication and craft to every project.
            </p>

            <div class="info-grid reveal right" style="transition-delay:0.4s">
                <div class="info-item">
                    <span class="info-label">Name</span>
                    <span class="info-value">Ahsan Nawaz</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Location</span>
                    <span class="info-value">Pakistan 🇵🇰</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Experience</span>
                    <span class="info-value">5+ Years</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Availability</span>
                    <span class="info-value" style="color:#15803d">● Open to Work</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Freelance</span>
                    <span class="info-value"><a href="#">Fiverr Profile →</a></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email</span>
                    <span class="info-value"><a href="mailto:hello@ahsannawaz.dev">hello@ahsan.dev</a></span>
                </div>
            </div>

            {{-- Skill bars --}}
            <div class="skill-bars reveal right" style="transition-delay:0.5s" id="skill-bars">
                <div class="skill-bar-item">
                    <div class="skill-bar-top"><span>Laravel / PHP</span><span>95%</span></div>
                    <div class="skill-bar-track"><div class="skill-bar-fill" data-width="95"></div></div>
                </div>
                <div class="skill-bar-item">
                    <div class="skill-bar-top"><span>React JS</span><span>88%</span></div>
                    <div class="skill-bar-track"><div class="skill-bar-fill" data-width="88"></div></div>
                </div>
                <div class="skill-bar-item">
                    <div class="skill-bar-top"><span>WordPress & Plugins</span><span>92%</span></div>
                    <div class="skill-bar-track"><div class="skill-bar-fill" data-width="92"></div></div>
                </div>
                <div class="skill-bar-item">
                    <div class="skill-bar-top"><span>REST API / MySQL</span><span>90%</span></div>
                    <div class="skill-bar-track"><div class="skill-bar-fill" data-width="90"></div></div>
                </div>
            </div>

            {{-- Read More button --}}
            <a href="#" class="read-more-btn reveal right" style="transition-delay:0.6s" id="read-more-btn" onclick="toggleReadMore(event)">
                <span id="read-more-label">Read More</span>
                <svg class="btn-arrow" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" id="read-more-arrow">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </a>

        </div>
    </div>

</section>
{{-- ═══════════════════════════════════════════════
    Skills / Tech Stack Section — Ahsan Nawaz
═══════════════════════════════════════════════ --}}




<section id="skills">
    <div class="sk-blob sk-blob-1"></div>
    <div class="sk-blob sk-blob-2"></div>

    <div class="skills-inner">

        {{-- ── HEADER ── --}}
        <div class="sk-header sk-reveal">
            <div class="sk-label">What I Work With</div>
            <h2 class="sk-title">Skills & <em>Tech Stack</em></h2>
            <p class="sk-desc">A curated set of technologies I've mastered over 5+ years of building real-world, production-grade web applications.</p>
        </div>

        {{-- ── FILTER TABS — built from the categories actually in the DB ── --}}
        <div class="sk-tabs sk-reveal" style="transition-delay:0.1s" id="sk-tabs">
            <button class="sk-tab active" data-filter="all">All</button>
            @foreach ($skills->keys() as $cat)
                <button class="sk-tab" data-filter="{{ $cat }}">{{ $catLabels[$cat] ?? ucfirst($cat) }}</button>
            @endforeach
        </div>

        {{-- ── CARDS GRID ── --}}
        <div class="sk-grid" id="sk-grid">

            {{-- Cards come straight from the DB (admin → Skills) --}}
            @foreach ($skills->flatten() as $skill)
                <div class="sk-card" data-cat="{{ $skill->category }}">
                    <span class="sk-level level-{{ $skill->level }}">{{ ucfirst($skill->level) }}</span>
                    <div class="sk-card-icon" style="background:{{ $skill->color }}1f;">{{ $skill->icon }}</div>
                    <div class="sk-card-name">{{ $skill->name }}</div>
                    <div class="sk-card-cat">{{ $catLabels[$skill->category] ?? ucfirst($skill->category) }}</div>
                    <div class="sk-bar-track">
                        <div class="sk-bar-fill" data-w="{{ $skill->percentage }}" style="background:{{ $skill->color_gradient }}"></div>
                    </div>
                    <div class="sk-bar-pct">{{ $skill->percentage }}%</div>
                </div>
            @endforeach

        </div>

        {{-- ── TAG CLOUD ── --}}
        <div class="sk-tagcloud-wrap sk-reveal" style="transition-delay:0.2s">
            <div class="sk-tagcloud-title">Also Familiar With</div>
            <div class="sk-tagcloud">
                @foreach(['AJAX','Livewire','Alpine.js','Vue.js','SASS/SCSS','Webpack','Vite','Blade Templates','Eloquent ORM','Sanctum / Passport','PHPUnit','Redis','Stripe API','PayPal API','SendGrid','Twilio','Figma','Postman','VS Code','Linux CLI','SEO Basics','Google Analytics','WooCommerce','ACF Pro','Elementor','WPML','CPT UI','Yoast SEO','REST API Auth','JWT','OAuth2','MVC Pattern','SOLID Principles','Agile / Scrum'] as $tag)
                <span class="sk-tag">{{ $tag }}</span>
                @endforeach
            </div>
        </div>

        {{-- ── STATS STRIP ── --}}
        <div class="sk-stats sk-reveal" style="transition-delay:0.3s">
            <div class="sk-stat">
                <span class="sk-stat-num" data-target="20">0</span>
                <span class="sk-stat-label">Technologies Mastered</span>
            </div>
            <div class="sk-stat">
                <span class="sk-stat-num" data-target="23">0</span>
                <span class="sk-stat-label">Projects Delivered</span>
            </div>
            <div class="sk-stat">
                <span class="sk-stat-num" data-target="3">0</span>
                <span class="sk-stat-label">Years of Experience</span>
            </div>
            <div class="sk-stat">
                <span class="sk-stat-num" data-target="23">0</span>
                <span class="sk-stat-label">Happy Clients</span>
            </div>
        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════════
    Services Section — Ahsan Nawaz Portfolio
═══════════════════════════════════════════════ --}}



<section id="services">
    <div class="srv-blob srv-blob-1"></div>
    <div class="srv-blob srv-blob-2"></div>

    <div class="srv-inner">

        {{-- ── HEADER ── --}}
        <div class="srv-header srv-reveal">
            <div class="srv-label">What I Offer</div>
            <h2 class="srv-title">My <em>Services</em></h2>
            <p class="srv-desc">End-to-end web development solutions — from scalable backends to pixel-perfect frontends. Here's how I can help your business grow.</p>
        </div>

        {{-- ── FEATURED CARD — Laravel ── --}}
        <div class="srv-featured srv-reveal" style="transition-delay:0.1s">
            <div class="srv-featured-left">
                <div class="srv-feat-badge">
                    <span>⭐</span> Most Popular
                </div>
                <h3 class="srv-feat-title">Laravel & PHP<br><em>Backend Development</em></h3>
                <p class="srv-feat-desc">
                    I build robust, secure, and scalable Laravel applications — from REST APIs and SaaS platforms to complex multi-tenant systems. Clean architecture, optimised queries, and production-grade code every time.
                </p>
                <div class="srv-feat-pills">
                    <span class="srv-pill">Laravel 11</span>
                    <span class="srv-pill">RESTful API</span>
                    <span class="srv-pill">Sanctum / Passport</span>
                    <span class="srv-pill">Eloquent ORM</span>
                    <span class="srv-pill">Queue Jobs</span>
                    <span class="srv-pill">Events & Listeners</span>
                    <span class="srv-pill">PHPUnit Tests</span>
                    <span class="srv-pill">Multi-tenancy</span>
                </div>
                <a href="#contact" class="srv-feat-cta">
                    Get a Quote
                    <svg class="arr" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
            <div class="srv-featured-right">
                <div class="srv-feat-img-wrap">
                    <img
                        src="https://images.unsplash.com/photo-1587620962725-abab7fe55159?w=700&q=80"
                        alt="Laravel Backend Development"
                        class="srv-feat-img"
                    >
                    <div class="srv-feat-img-overlay">
                        <div class="srv-feat-img-badge">
                            <span>🔥</span>
                            <span>Laravel Expert</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── MAIN 3-COL GRID ── --}}
        <div class="srv-grid">

            {{-- React JS --}}
            <div class="srv-card" data-delay="0" style="--card-color:#0e7490;--card-glow:rgba(14,116,144,0.08)">
                <span class="srv-num">01</span>
                <div class="srv-icon" style="background:rgba(14,116,144,0.1);">⚛️</div>
                <h4 class="srv-card-title">React JS Development</h4>
                <p class="srv-card-desc">Dynamic, fast, and interactive SPAs and dashboards built with modern React — hooks, context, and clean component architecture.</p>
                <ul class="srv-list">
                    <li>Single Page Applications</li>
                    <li>Custom Dashboards & Admin Panels</li>
                    <li>REST API Integration</li>
                    <li>Redux / Context State Management</li>
                </ul>
                <a href="#contact" class="srv-link">
                    Learn More
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>

            {{-- WordPress --}}
            <div class="srv-card" data-delay="1" style="--card-color:#1d4ed8;--card-glow:rgba(29,78,216,0.08)">
                <span class="srv-num">02</span>
                <div class="srv-icon" style="background:rgba(29,78,216,0.1);">📝</div>
                <h4 class="srv-card-title">WordPress Development</h4>
                <p class="srv-card-desc">Custom themes, full-site editing, and bespoke WordPress solutions that are fast, SEO-friendly, and easy to manage.</p>
                <ul class="srv-list">
                    <li>Custom Theme Development</li>
                    <li>WooCommerce Stores</li>
                    <li>Page Speed Optimisation</li>
                    <li>Elementor & ACF Pro</li>
                </ul>
                <a href="#contact" class="srv-link">
                    Learn More
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>

            {{-- Plugin Dev --}}
            <div class="srv-card" data-delay="2" style="--card-color:#6d28d9;--card-glow:rgba(109,40,217,0.08)">
                <span class="srv-num">03</span>
                <div class="srv-icon" style="background:rgba(109,40,217,0.1);">🔌</div>
                <h4 class="srv-card-title">WordPress Plugin Dev</h4>
                <p class="srv-card-desc">Tailor-made WordPress plugins built from scratch — extending functionality exactly how your business needs it, without bloat.</p>
                <ul class="srv-list">
                    <li>Custom Post Types & Taxonomies</li>
                    <li>Payment Gateway Plugins</li>
                    <li>Third-party API Plugins</li>
                    <li>Admin Settings Panels</li>
                </ul>
                <a href="#contact" class="srv-link">
                    Learn More
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>

            {{-- Frontend Dev --}}
            <div class="srv-card" data-delay="3" style="--card-color:#b45309;--card-glow:rgba(180,83,9,0.08)">
                <span class="srv-num">04</span>
                <div class="srv-icon" style="background:rgba(180,83,9,0.1);">🎨</div>
                <h4 class="srv-card-title">Frontend Development</h4>
                <p class="srv-card-desc">Pixel-perfect HTML, CSS, JavaScript & jQuery interfaces — responsive on every device, smooth animations, and clean code.</p>
                <ul class="srv-list">
                    <li>HTML5 / CSS3 / Tailwind</li>
                    <li>Bootstrap & Custom Layouts</li>
                    <li>jQuery & AJAX Interactions</li>
                    <li>Cross-browser Compatibility</li>
                </ul>
                <a href="#contact" class="srv-link">
                    Learn More
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>

            {{-- REST API --}}
            <div class="srv-card" data-delay="4" style="--card-color:#047857;--card-glow:rgba(4,120,87,0.08)">
                <span class="srv-num">05</span>
                <div class="srv-icon" style="background:rgba(4,120,87,0.1);">🔗</div>
                <h4 class="srv-card-title">REST API Development</h4>
                <p class="srv-card-desc">Scalable, well-documented REST APIs and third-party integrations — built for performance, security, and easy consumption.</p>
                <ul class="srv-list">
                    <li>Laravel API with Sanctum/JWT</li>
                    <li>Stripe, PayPal, Twilio APIs</li>
                    <li>Webhook Implementation</li>
                    <li>API Documentation (Postman)</li>
                </ul>
                <a href="#contact" class="srv-link">
                    Learn More
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>

            {{-- Database --}}
            <div class="srv-card" data-delay="5" style="--card-color:#c2410c;--card-glow:rgba(194,65,12,0.1)">
                <span class="srv-num">06</span>
                <div class="srv-icon" style="background:rgba(194,65,12,0.1);">🗄️</div>
                <h4 class="srv-card-title">Database Design & Optimisation</h4>
                <p class="srv-card-desc">Efficient schema design, query optimisation, and database architecture for MySQL — making your app fast and reliable at scale.</p>
                <ul class="srv-list">
                    <li>MySQL Schema Architecture</li>
                    <li>Query Optimisation & Indexing</li>
                    <li>Laravel Migrations & Seeders</li>
                    <li>Data Migration & Backup</li>
                </ul>
                <a href="#contact" class="srv-link">
                    Learn More
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>

        </div>

        {{-- ── BOTTOM STRIP — 2 smaller cards ── --}}
        <div class="srv-strip srv-reveal" style="transition-delay:0.25s">

            {{-- Bug Fixing --}}
            <div class="srv-card visible" style="--card-color:#b91c1c;--card-glow:rgba(185,28,28,0.08);opacity:1;transform:none;">
                <span class="srv-num">07</span>
                <div class="srv-icon" style="background:rgba(185,28,28,0.1);">🐛</div>
                <h4 class="srv-card-title">Bug Fixing & Code Review</h4>
                <p class="srv-card-desc">Fast, accurate debugging of Laravel, PHP, WordPress, and React codebases. I'll find the issue and fix it properly — not just patch it.</p>
                <ul class="srv-list">
                    <li>Laravel / PHP Debugging</li>
                    <li>WordPress Error Resolution</li>
                    <li>Performance Bottleneck Fixes</li>
                </ul>
                <a href="#contact" class="srv-link">Get Help <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
            </div>

            {{-- Deployment --}}
            <div class="srv-card visible" style="--card-color:#4338ca;--card-glow:rgba(67,56,202,0.08);opacity:1;transform:none;">
                <span class="srv-num">08</span>
                <div class="srv-icon" style="background:rgba(67,56,202,0.1);">☁️</div>
                <h4 class="srv-card-title">Deployment & Server Setup</h4>
                <p class="srv-card-desc">I'll deploy your application to cPanel, VPS, or cloud servers — with SSL, NGINX/Apache config, and CI/CD pipeline setup.</p>
                <ul class="srv-list">
                    <li>cPanel & VPS Deployment</li>
                    <li>SSL & Domain Configuration</li>
                    <li>Git-based CI/CD Workflows</li>
                </ul>
                <a href="#contact" class="srv-link">Get Help <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
            </div>

        </div>

        {{-- ── CTA BANNER ── --}}
        <div class="srv-cta-banner srv-reveal" style="transition-delay:0.35s">
            <div class="srv-cta-text">
                <h3>Have a project in mind? Let's <em>build it together.</em></h3>
                <p>Whether it's a quick fix or a full-scale application, I'm ready to bring your vision to life. Let's talk about what you need.</p>
            </div>
            <div class="srv-cta-btns">
                <a href="#contact" class="srv-cta-btn-primary">
                    ✉ Hire Me
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
                @if ($hasCv)
                    <a href="{{ route('cv.download') }}" class="srv-cta-btn-secondary">
                        ↓ Download CV
                    </a>
                @endif
            </div>
        </div>

    </div>
</section>


{{-- ══════════════════════════════════════
     PROJECTS — straight from the DB (admin → Projects)
══════════════════════════════════════ --}}
@if ($projects->isNotEmpty())
<section id="projects">
    <div class="hp-blob hp-blob-1"></div>

    <div class="hp-inner">

        <div class="hp-header ab-rv">
            <div class="ab-label">Recent Work</div>
            <h2 class="hp-title">Featured <em>Projects</em></h2>
            <p class="hp-desc">
                A few things I've shipped recently. Every one built for a real client with real deadlines.
            </p>
        </div>

        <div class="pj-grid hp-grid">
            @foreach ($projects->take(6) as $project)
                <article class="pj-card ab-rv" data-delay="{{ $loop->index % 3 }}">
                    <span class="pj-card-num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>

                    <div class="pj-card-media">
                        <img src="{{ $project->image_url }}" alt="{{ $project->title }}" class="pj-card-img" loading="lazy">
                        <div class="pj-card-overlay">
                            <div class="pj-card-actions">
                                @if ($project->live_url)
                                    <a href="{{ $project->live_url }}" target="_blank" rel="noopener"
                                       class="pj-action" title="View live" aria-label="View {{ $project->title }} live">↗</a>
                                @endif
                                @if ($project->github_url)
                                    <a href="{{ $project->github_url }}" target="_blank" rel="noopener"
                                       class="pj-action" title="View source" aria-label="View {{ $project->title }} source">⎇</a>
                                @endif
                            </div>
                        </div>
                        @if ($project->is_featured)
                            <span class="pj-card-star" title="Featured">★</span>
                        @endif
                    </div>

                    <div class="pj-card-body">
                        <span class="pj-cat">{{ $catLabels[$project->category] ?? ucfirst($project->category) }}</span>
                        <h3 class="pj-card-title">{{ $project->title }}</h3>
                        <p class="pj-card-desc">{{ $project->description }}</p>

                        @if ($project->tech_stack)
                            <div class="pj-stack">
                                @foreach (array_slice($project->tech_stack, 0, 4) as $tech)
                                    <span class="pj-chip">{{ $tech }}</span>
                                @endforeach
                                @if (count($project->tech_stack) > 4)
                                    <span class="pj-chip pj-chip-more">+{{ count($project->tech_stack) - 4 }}</span>
                                @endif
                            </div>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>

        <div class="hp-more ab-rv">
            <a href="{{ route('projects') }}" class="ab-btn-primary">
                View All Projects
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>

    </div>
</section>
@endif

{{-- ══════════════════════════════════════
     CONTACT
══════════════════════════════════════ --}}
<section id="contact">

    <!-- Ambient blobs -->
    <div class="ct-blob ct-blob-1"></div>
    <div class="ct-blob ct-blob-2"></div>

    <div class="ct-inner">

        {{-- ── HEADER ── --}}
        <div class="ct-header ct-reveal">
            <div class="ct-label">Get In Touch</div>
            <h2 class="ct-title">Let's <em>Work Together</em></h2>
            <p class="ct-desc">
                Have a project, an idea, or just a question? Drop me a message and I'll reply within 24 hours.
            </p>
        </div>

        <div class="ct-grid">

            {{-- ── LEFT — INFO ── --}}
            <div class="ct-aside ct-reveal" style="transition-delay:0.1s">

                <div class="ct-status">
                    <span class="ct-status-dot"></span>
                    Available for new projects
                </div>

                <h3 class="ct-aside-title">Let's build something <em>great.</em></h3>
                <p class="ct-aside-text">
                    I'm currently taking on freelance work and long-term collaborations.
                    Tell me what you're building and I'll get back to you with a plan.
                </p>

                <div class="ct-info-list">
                    <a href="mailto:hello@ahsannawaz.dev" class="ct-info-item">
                        <span class="ct-info-ico">✉</span>
                        <span class="ct-info-body">
                            <span class="ct-info-label">Email</span>
                            <span class="ct-info-value">hello@ahsannawaz.dev</span>
                        </span>
                        <svg class="ct-info-arr" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>

                    <div class="ct-info-item">
                        <span class="ct-info-ico">◎</span>
                        <span class="ct-info-body">
                            <span class="ct-info-label">Location</span>
                            <span class="ct-info-value">Pakistan 🇵🇰 · Remote worldwide</span>
                        </span>
                    </div>

                    <div class="ct-info-item">
                        <span class="ct-info-ico">◷</span>
                        <span class="ct-info-body">
                            <span class="ct-info-label">Response Time</span>
                            <span class="ct-info-value">Usually within 24 hours</span>
                        </span>
                    </div>
                </div>

                <div class="ct-socials">
                    <span class="ct-socials-label">Follow me</span>
                    <div class="ct-socials-row">
                        <a href="#" class="ct-social" title="LinkedIn" aria-label="LinkedIn">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>
                        </a>
                        <a href="#" class="ct-social" title="GitHub" aria-label="GitHub">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"/></svg>
                        </a>
                        <a href="#" class="ct-social" title="Twitter / X" aria-label="Twitter">
                            <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.73-8.835L1.254 2.25H8.08l4.713 6.057z"/></svg>
                        </a>
                        <a href="#" class="ct-social" title="Facebook" aria-label="Facebook">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            {{-- ── RIGHT — FORM ── --}}
            <div class="ct-form-wrap ct-reveal" style="transition-delay:0.2s">

                <form method="POST" action="{{ route('contact.store') }}" class="ct-form">
                    @csrf

                    {{-- Honeypot — hidden from humans, catches bots --}}
                    <div class="ct-hp" aria-hidden="true">
                        <label for="website">Website</label>
                        <input id="website" type="text" name="website" tabindex="-1" autocomplete="off">
                    </div>

                    <div class="ct-row">
                        <div class="ct-field">
                            <label for="ct-name">Your Name <span>*</span></label>
                            <input id="ct-name" type="text" name="name" value="{{ old('name') }}"
                                   placeholder="John Doe" maxlength="100" required>
                            @error('name') <div class="ct-err">{{ $message }}</div> @enderror
                        </div>

                        <div class="ct-field">
                            <label for="ct-email">Email <span>*</span></label>
                            <input id="ct-email" type="email" name="email" value="{{ old('email') }}"
                                   placeholder="john@company.com" maxlength="150" required>
                            @error('email') <div class="ct-err">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="ct-row">
                        <div class="ct-field">
                            <label for="ct-subject">Subject <span>*</span></label>
                            <input id="ct-subject" type="text" name="subject" value="{{ old('subject') }}"
                                   placeholder="Laravel project enquiry" maxlength="200" required>
                            @error('subject') <div class="ct-err">{{ $message }}</div> @enderror
                        </div>

                        <div class="ct-field">
                            <label for="ct-budget">Budget <span class="ct-opt">(optional)</span></label>
                            <select id="ct-budget" name="budget">
                                <option value="">Select a range</option>
                                @foreach (['< $500', '$500 – $1k', '$1k – $5k', '$5k – $10k', '$10k+'] as $range)
                                    <option value="{{ $range }}" @selected(old('budget') === $range)>{{ $range }}</option>
                                @endforeach
                            </select>
                            @error('budget') <div class="ct-err">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="ct-field">
                        <label for="ct-message">Message <span>*</span></label>
                        <textarea id="ct-message" name="message" rows="5" maxlength="5000"
                                  placeholder="Tell me about your project, timeline, and what you're hoping to achieve…" required>{{ old('message') }}</textarea>
                        <div class="ct-meta">
                            <span class="ct-count"><b id="ct-count">0</b> / 5000</span>
                        </div>
                        @error('message') <div class="ct-err">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="ct-submit">
                        <span class="ct-submit-txt">✉ Send Message</span>
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </button>

                    <p class="ct-note">Your details stay private — never shared with anyone.</p>
                </form>
            </div>

        </div>
    </div>
</section>


        @include('layouts.partials.popup')

        @include('layouts.partials.footer')

<script src="{{ asset('js/popup.js') }}"></script>
<script src="{{ asset('js/about.js') }}"></script>
<script src="{{ asset('js/welcome.js') }}"></script>
</body>
</html>
