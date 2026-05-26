<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
</head>
    <body>
        @include('layouts.partials.header')
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
                <a href="#" class="btn-secondary" download>
                    ↓ Download CV
                </a>
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
                Hi, I'm <strong style="color:#fff">Ahsan Nawaz</strong>, a full-stack web developer based in Pakistan
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
                    <span class="info-value" style="color:#4ade80">● Open to Work</span>
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

        {{-- ── FILTER TABS ── --}}
        <div class="sk-tabs sk-reveal" style="transition-delay:0.1s" id="sk-tabs">
            <button class="sk-tab active" data-filter="all">All</button>
            <button class="sk-tab" data-filter="backend">Backend</button>
            <button class="sk-tab" data-filter="frontend">Frontend</button>
            <button class="sk-tab" data-filter="cms">CMS</button>
            <button class="sk-tab" data-filter="database">Database</button>
            <button class="sk-tab" data-filter="tools">Tools</button>
        </div>

        {{-- ── CARDS GRID ── --}}
        <div class="sk-grid" id="sk-grid">

            {{-- Backend --}}
            <div class="sk-card" data-cat="backend">
                <span class="sk-level level-expert">Expert</span>
                <div class="sk-card-icon" style="background:rgba(249,115,22,0.12);">🔥</div>
                <div class="sk-card-name">Laravel</div>
                <div class="sk-card-cat">PHP Framework</div>
                <div class="sk-bar-track"><div class="sk-bar-fill" data-w="95" style="background:linear-gradient(90deg,#F97316,#fb923c)"></div></div>
                <div class="sk-bar-pct">95%</div>
            </div>

            <div class="sk-card" data-cat="backend">
                <span class="sk-level level-expert">Expert</span>
                <div class="sk-card-icon" style="background:rgba(139,92,246,0.12);">🐘</div>
                <div class="sk-card-name">PHP</div>
                <div class="sk-card-cat">Server Language</div>
                <div class="sk-bar-track"><div class="sk-bar-fill" data-w="93" style="background:linear-gradient(90deg,#7c3aed,#a78bfa)"></div></div>
                <div class="sk-bar-pct">93%</div>
            </div>

            <div class="sk-card" data-cat="backend">
                <span class="sk-level level-advanced">Advanced</span>
                <div class="sk-card-icon" style="background:rgba(59,130,246,0.12);">🔗</div>
                <div class="sk-card-name">REST API</div>
                <div class="sk-card-cat">API Development</div>
                <div class="sk-bar-track"><div class="sk-bar-fill" data-w="90" style="background:linear-gradient(90deg,#2563eb,#60a5fa)"></div></div>
                <div class="sk-bar-pct">90%</div>
            </div>

           

            {{-- Frontend --}}
            <div class="sk-card" data-cat="frontend">
                <span class="sk-level level-advanced">Advanced</span>
                <div class="sk-card-icon" style="background:rgba(6,182,212,0.12);">⚛️</div>
                <div class="sk-card-name">React JS</div>
                <div class="sk-card-cat">JS Framework</div>
                <div class="sk-bar-track"><div class="sk-bar-fill" data-w="88" style="background:linear-gradient(90deg,#0891b2,#22d3ee)"></div></div>
                <div class="sk-bar-pct">88%</div>
            </div>

            <div class="sk-card" data-cat="frontend">
                <span class="sk-level level-expert">Expert</span>
                <div class="sk-card-icon" style="background:rgba(249,115,22,0.12);">🎨</div>
                <div class="sk-card-name">HTML5 / CSS3</div>
                <div class="sk-card-cat">Markup & Style</div>
                <div class="sk-bar-track"><div class="sk-bar-fill" data-w="97" style="background:linear-gradient(90deg,#F97316,#fb923c)"></div></div>
                <div class="sk-bar-pct">97%</div>
            </div>

            <div class="sk-card" data-cat="frontend">
                <span class="sk-level level-expert">Expert</span>
                <div class="sk-card-icon" style="background:rgba(234,179,8,0.12);">✨</div>
                <div class="sk-card-name">JavaScript</div>
                <div class="sk-card-cat">Core Language</div>
                <div class="sk-bar-track"><div class="sk-bar-fill" data-w="91" style="background:linear-gradient(90deg,#b45309,#fbbf24)"></div></div>
                <div class="sk-bar-pct">91%</div>
            </div>

            <div class="sk-card" data-cat="frontend">
                <span class="sk-level level-expert">Expert</span>
                <div class="sk-card-icon" style="background:rgba(99,102,241,0.12);">💡</div>
                <div class="sk-card-name">jQuery</div>
                <div class="sk-card-cat">JS Library</div>
                <div class="sk-bar-track"><div class="sk-bar-fill" data-w="94" style="background:linear-gradient(90deg,#4338ca,#818cf8)"></div></div>
                <div class="sk-bar-pct">94%</div>
            </div>

            <div class="sk-card" data-cat="frontend">
                <span class="sk-level level-advanced">Advanced</span>
                <div class="sk-card-icon" style="background:rgba(6,182,212,0.12);">🌊</div>
                <div class="sk-card-name">Tailwind CSS</div>
                <div class="sk-card-cat">Utility Framework</div>
                <div class="sk-bar-track"><div class="sk-bar-fill" data-w="87" style="background:linear-gradient(90deg,#0891b2,#22d3ee)"></div></div>
                <div class="sk-bar-pct">87%</div>
            </div>

            <div class="sk-card" data-cat="frontend">
                <span class="sk-level level-advanced">Advanced</span>
                <div class="sk-card-icon" style="background:rgba(139,92,246,0.12);">🅱️</div>
                <div class="sk-card-name">Bootstrap</div>
                <div class="sk-card-cat">CSS Framework</div>
                <div class="sk-bar-track"><div class="sk-bar-fill" data-w="93" style="background:linear-gradient(90deg,#7c3aed,#a78bfa)"></div></div>
                <div class="sk-bar-pct">93%</div>
            </div>

            {{-- CMS --}}
            <div class="sk-card" data-cat="cms">
                <span class="sk-level level-expert">Expert</span>
                <div class="sk-card-icon" style="background:rgba(59,130,246,0.12);">📝</div>
                <div class="sk-card-name">WordPress</div>
                <div class="sk-card-cat">CMS Platform</div>
                <div class="sk-bar-track"><div class="sk-bar-fill" data-w="92" style="background:linear-gradient(90deg,#1d4ed8,#60a5fa)"></div></div>
                <div class="sk-bar-pct">92%</div>
            </div>

            <div class="sk-card" data-cat="cms">
                <span class="sk-level level-expert">Expert</span>
                <div class="sk-card-icon" style="background:rgba(249,115,22,0.12);">🔌</div>
                <div class="sk-card-name">Plugin Dev</div>
                <div class="sk-card-cat">WP Plugins</div>
                <div class="sk-bar-track"><div class="sk-bar-fill" data-w="90" style="background:linear-gradient(90deg,#F97316,#fb923c)"></div></div>
                <div class="sk-bar-pct">90%</div>
            </div>

            <div class="sk-card" data-cat="cms">
                <span class="sk-level level-advanced">Advanced</span>
                <div class="sk-card-icon" style="background:rgba(16,185,129,0.12);">🎭</div>
                <div class="sk-card-name">Theme Dev</div>
                <div class="sk-card-cat">WP Themes</div>
                <div class="sk-bar-track"><div class="sk-bar-fill" data-w="88" style="background:linear-gradient(90deg,#059669,#34d399)"></div></div>
                <div class="sk-bar-pct">88%</div>
            </div>

            {{-- Database --}}
            <div class="sk-card" data-cat="database">
                <span class="sk-level level-expert">Expert</span>
                <div class="sk-card-icon" style="background:rgba(249,115,22,0.12);">🗄️</div>
                <div class="sk-card-name">MySQL</div>
                <div class="sk-card-cat">Relational DB</div>
                <div class="sk-bar-track"><div class="sk-bar-fill" data-w="92" style="background:linear-gradient(90deg,#F97316,#fb923c)"></div></div>
                <div class="sk-bar-pct">92%</div>
            </div>

            <div class="sk-card" data-cat="database">
                <span class="sk-level level-good">Good</span>
                <div class="sk-card-icon" style="background:rgba(16,185,129,0.12);">🍃</div>
                <div class="sk-card-name">MongoDB</div>
                <div class="sk-card-cat">NoSQL DB</div>
                <div class="sk-bar-track"><div class="sk-bar-fill" data-w="70" style="background:linear-gradient(90deg,#059669,#34d399)"></div></div>
                <div class="sk-bar-pct">70%</div>
            </div>

            <div class="sk-card" data-cat="database">
                <span class="sk-level level-advanced">Advanced</span>
                <div class="sk-card-icon" style="background:rgba(59,130,246,0.12);">📊</div>
                <div class="sk-card-name">DB Design</div>
                <div class="sk-card-cat">Schema & Query</div>
                <div class="sk-bar-track"><div class="sk-bar-fill" data-w="85" style="background:linear-gradient(90deg,#2563eb,#60a5fa)"></div></div>
                <div class="sk-bar-pct">85%</div>
            </div>

            {{-- Tools --}}
            <div class="sk-card" data-cat="tools">
                <span class="sk-level level-expert">Expert</span>
                <div class="sk-card-icon" style="background:rgba(234,179,8,0.12);">🐙</div>
                <div class="sk-card-name">Git / GitHub</div>
                <div class="sk-card-cat">Version Control</div>
                <div class="sk-bar-track"><div class="sk-bar-fill" data-w="92" style="background:linear-gradient(90deg,#b45309,#fbbf24)"></div></div>
                <div class="sk-bar-pct">92%</div>
            </div>

            <div class="sk-card" data-cat="tools">
                <span class="sk-level level-advanced">Advanced</span>
                <div class="sk-card-icon" style="background:rgba(6,182,212,0.12);">🐳</div>
                <div class="sk-card-name">Docker</div>
                <div class="sk-card-cat">Containerization</div>
                <div class="sk-bar-track"><div class="sk-bar-fill" data-w="75" style="background:linear-gradient(90deg,#0891b2,#22d3ee)"></div></div>
                <div class="sk-bar-pct">75%</div>
            </div>

            <div class="sk-card" data-cat="tools">
                <span class="sk-level level-advanced">Advanced</span>
                <div class="sk-card-icon" style="background:rgba(249,115,22,0.12);">🚀</div>
                <div class="sk-card-name">Composer / NPM</div>
                <div class="sk-card-cat">Package Managers</div>
                <div class="sk-bar-track"><div class="sk-bar-fill" data-w="94" style="background:linear-gradient(90deg,#F97316,#fb923c)"></div></div>
                <div class="sk-bar-pct">94%</div>
            </div>

            <div class="sk-card" data-cat="tools">
                <span class="sk-level level-good">Good</span>
                <div class="sk-card-icon" style="background:rgba(139,92,246,0.12);">☁️</div>
                <div class="sk-card-name">AWS / cPanel</div>
                <div class="sk-card-cat">Hosting & Cloud</div>
                <div class="sk-bar-track"><div class="sk-bar-fill" data-w="78" style="background:linear-gradient(90deg,#7c3aed,#a78bfa)"></div></div>
                <div class="sk-bar-pct">78%</div>
            </div>

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
            <div class="srv-card" data-delay="0" style="--card-color:#22d3ee;--card-glow:rgba(34,211,238,0.08)">
                <span class="srv-num">01</span>
                <div class="srv-icon" style="background:rgba(34,211,238,0.1);">⚛️</div>
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
            <div class="srv-card" data-delay="1" style="--card-color:#60a5fa;--card-glow:rgba(96,165,250,0.08)">
                <span class="srv-num">02</span>
                <div class="srv-icon" style="background:rgba(96,165,250,0.1);">📝</div>
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
            <div class="srv-card" data-delay="2" style="--card-color:#a78bfa;--card-glow:rgba(167,139,250,0.08)">
                <span class="srv-num">03</span>
                <div class="srv-icon" style="background:rgba(167,139,250,0.1);">🔌</div>
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
            <div class="srv-card" data-delay="3" style="--card-color:#fbbf24;--card-glow:rgba(251,191,36,0.08)">
                <span class="srv-num">04</span>
                <div class="srv-icon" style="background:rgba(251,191,36,0.1);">🎨</div>
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
            <div class="srv-card" data-delay="4" style="--card-color:#34d399;--card-glow:rgba(52,211,153,0.08)">
                <span class="srv-num">05</span>
                <div class="srv-icon" style="background:rgba(52,211,153,0.1);">🔗</div>
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
            <div class="srv-card" data-delay="5" style="--card-color:#F97316;--card-glow:rgba(249,115,22,0.1)">
                <span class="srv-num">06</span>
                <div class="srv-icon" style="background:rgba(249,115,22,0.1);">🗄️</div>
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
            <div class="srv-card visible" style="--card-color:#f87171;--card-glow:rgba(248,113,113,0.08);opacity:1;transform:none;">
                <span class="srv-num">07</span>
                <div class="srv-icon" style="background:rgba(248,113,113,0.1);">🐛</div>
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
            <div class="srv-card visible" style="--card-color:#818cf8;--card-glow:rgba(129,140,248,0.08);opacity:1;transform:none;">
                <span class="srv-num">08</span>
                <div class="srv-icon" style="background:rgba(129,140,248,0.1);">☁️</div>
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
                <a href="#" class="srv-cta-btn-secondary" download>
                    ↓ Download CV
                </a>
            </div>
        </div>

    </div>
</section>




        @include('layouts.partials.footer')

<script src="{{ asset('js/welcome.js') }}"></script>
</body>
</html>
