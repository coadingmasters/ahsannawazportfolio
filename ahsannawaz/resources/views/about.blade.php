<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('layouts.partials.seo', [
        'title' => 'About',
        "description" => "About Ahsan Nawaz — a full-stack developer with 2+ years building Laravel backends, React frontends and custom WordPress solutions for clients worldwide.",
        'keywords' => 'about Ahsan Nawaz, Laravel developer Pakistan, full stack developer experience',
        'type' => 'profile',
    ])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet">
    @css('css/theme.css')
    @css('css/welcome.css')
    @css('css/about.css')
</head>
<body>

    @include('layouts.partials.header')

    {{-- ══════════════════════════════════════
         PAGE HERO
    ══════════════════════════════════════ --}}
    <section class="ab-hero">
        <div class="ab-blob ab-blob-1"></div>
        <div class="ab-blob ab-blob-2"></div>
        <div class="ab-grid-bg"></div>

        <div class="ab-hero-inner">
            <nav class="ab-crumb ab-rv">
                <a href="{{ url('/') }}">Home</a>
                <span>/</span>
                <span class="ab-crumb-current">About</span>
            </nav>

            <h1 class="ab-hero-title ab-rv" style="transition-delay:0.08s">
                About <em>Me</em>
            </h1>

            <p class="ab-hero-sub ab-rv" style="transition-delay:0.16s">
                Developer, problem-solver, and lifelong learner — here's the story behind the code.
            </p>
        </div>
    </section>

    {{-- ══════════════════════════════════════
         STORY
    ══════════════════════════════════════ --}}
    <section class="ab-story">
        <div class="ab-inner">
            <div class="ab-story-grid">

                {{-- LEFT — PHOTO --}}
                <div class="ab-photo-col ab-rv">
                    <div class="ab-photo-deco ab-photo-deco-1"></div>
                    <div class="ab-photo-deco ab-photo-deco-2"></div>

                    <div class="ab-photo-frame">
                        <img src="{{ asset('images/ahsannawaz.webp') }}" alt="Ahsan Nawaz, full-stack web developer specialising in Laravel, PHP and React" class="ab-photo">
                        <div class="ab-photo-glow"></div>
                    </div>

                    <div class="ab-photo-badge">
                        <span class="ab-badge-num">5+</span>
                        <span class="ab-badge-txt">Years<br>Experience</span>
                    </div>

                    <div class="ab-float-chip ab-chip-1">
                        <span class="ab-chip-ico">⚡</span>
                        <span>
                            <b>Laravel</b>
                            <i>Backend Expert</i>
                        </span>
                    </div>

                    <div class="ab-float-chip ab-chip-2">
                        <span class="ab-chip-ico">⭐</span>
                        <span>
                            <b>5-Star Rated</b>
                            <i>On Fiverr</i>
                        </span>
                    </div>
                </div>

                {{-- RIGHT — TEXT --}}
                <div class="ab-story-col">
                    <span class="ab-label ab-rv">My Story</span>

                    <h2 class="ab-h2 ab-rv" style="transition-delay:0.08s">
                        Turning complex ideas into<br><em>elegant solutions</em>
                    </h2>

                    <p class="ab-text ab-rv" style="transition-delay:0.14s">
                        Hi, I'm <strong>Ahsan Nawaz</strong> — a full-stack web developer based in Pakistan with
                        over 5 years of hands-on experience building robust, scalable, and visually compelling
                        web applications. I specialise in Laravel, PHP, React JS, and WordPress.
                    </p>

                    <p class="ab-text ab-rv" style="transition-delay:0.2s">
                        I've worked with clients across the globe — from early-stage startups to established
                        businesses — delivering clean architecture, well-tested code, and pixel-perfect
                        frontends. Whether it's a custom WordPress plugin, a full-scale Laravel SaaS, or a
                        lightning-fast React interface, I bring the same craft to every project.
                    </p>

                    <p class="ab-text ab-rv" style="transition-delay:0.26s">
                        I care about the details most people never see: the query that runs in 8ms instead of
                        800, the migration that rolls back cleanly, the component that still works at 320px.
                        Good software feels effortless — and that's earned in the parts nobody notices.
                    </p>

                    <div class="ab-info-grid ab-rv" style="transition-delay:0.32s">
                        <div class="ab-info">
                            <span class="ab-info-label">Name</span>
                            <span class="ab-info-value">Ahsan Nawaz</span>
                        </div>
                        <div class="ab-info">
                            <span class="ab-info-label">Location</span>
                            <span class="ab-info-value">Pakistan 🇵🇰</span>
                        </div>
                        <div class="ab-info">
                            <span class="ab-info-label">Experience</span>
                            <span class="ab-info-value">5+ Years</span>
                        </div>
                        <div class="ab-info">
                            <span class="ab-info-label">Availability</span>
                            <span class="ab-info-value ab-open">● Open to Work</span>
                        </div>
                        <div class="ab-info">
                            <span class="ab-info-label">Email</span>
                            <span class="ab-info-value"><a href="mailto:hello@ahsannawaz.dev">hello@ahsannawaz.dev</a></span>
                        </div>
                        <div class="ab-info">
                            <span class="ab-info-label">Languages</span>
                            <span class="ab-info-value">English · Urdu</span>
                        </div>
                    </div>

                    <div class="ab-cta-row ab-rv" style="transition-delay:0.38s">
                        <a href="{{ url('/#contact') }}" class="ab-btn-primary">
                            ✉ Hire Me
                            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                        @if ($hasCv)
                            <a href="{{ route('cv.download') }}" class="ab-btn-ghost">↓ Download CV</a>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════
         STATS
    ══════════════════════════════════════ --}}
    <section class="ab-stats">
        <div class="ab-inner">
            <div class="ab-stats-grid">
                <div class="ab-stat ab-rv">
                    <span class="ab-stat-num" data-count="5">0</span>
                    <span class="ab-stat-label">Years Experience</span>
                </div>
                <div class="ab-stat ab-rv" style="transition-delay:0.08s">
                    <span class="ab-stat-num" data-count="50">0</span>
                    <span class="ab-stat-label">Projects Delivered</span>
                </div>
                <div class="ab-stat ab-rv" style="transition-delay:0.16s">
                    <span class="ab-stat-num" data-count="30">0</span>
                    <span class="ab-stat-label">Happy Clients</span>
                </div>
                <div class="ab-stat ab-rv" style="transition-delay:0.24s">
                    <span class="ab-stat-num" data-count="{{ $stats['skills'] }}">0</span>
                    <span class="ab-stat-label">Technologies</span>
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════
         WHAT I BRING
    ══════════════════════════════════════ --}}
    <section class="ab-values">
        <div class="ab-inner">
            <div class="ab-head ab-rv">
                <span class="ab-label">What I Bring</span>
                <h2 class="ab-h2 ab-center">More than just <em>writing code</em></h2>
                <p class="ab-head-desc">
                    Shipping software is the easy part. Here's what I actually bring to a project.
                </p>
            </div>

            <div class="ab-val-grid">
                @php
                    $values = [
                        ['icon' => '🏗', 'title' => 'Clean Architecture', 'desc' => 'Code organised so the next developer — often future you — can change it without fear.', 'color' => '#c2410c'],
                        ['icon' => '⚡', 'title' => 'Performance First', 'desc' => 'Optimised queries, cached where it counts, and pages that load before you notice.', 'color' => '#0e7490'],
                        ['icon' => '📱', 'title' => 'Truly Responsive', 'desc' => 'Every layout tested from 320px phones up to ultrawide monitors. No excuses.', 'color' => '#6d28d9'],
                        ['icon' => '🔒', 'title' => 'Security Minded', 'desc' => 'Validation, rate limiting, and escaping applied by default — not bolted on later.', 'color' => '#15803d'],
                        ['icon' => '💬', 'title' => 'Clear Communication', 'desc' => 'Honest timelines and plain-English updates. You always know where things stand.', 'color' => '#b45309'],
                        ['icon' => '🤝', 'title' => 'Long-Term Support', 'desc' => "I don't disappear at launch. Handover, docs, and help when you need it.", 'color' => '#1d4ed8'],
                    ];
                @endphp

                @foreach ($values as $i => $v)
                    <div class="ab-val-card ab-rv" data-delay="{{ $i }}" style="--vc:{{ $v['color'] }}">
                        <span class="ab-val-ico">{{ $v['icon'] }}</span>
                        <h3 class="ab-val-title">{{ $v['title'] }}</h3>
                        <p class="ab-val-desc">{{ $v['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════
         JOURNEY TIMELINE
    ══════════════════════════════════════ --}}
    <section class="ab-journey">
        <div class="ab-blob ab-blob-3"></div>
        <div class="ab-inner">
            <div class="ab-head ab-rv">
                <span class="ab-label">The Journey</span>
                <h2 class="ab-h2 ab-center">How I got <em>here</em></h2>
            </div>

            <div class="ab-timeline">
                @php
                    $timeline = [
                        ['year' => '2019', 'title' => 'First Lines of Code', 'org' => 'Self-taught', 'desc' => 'Started with HTML, CSS and PHP — building small sites for local businesses and breaking a lot of things along the way.'],
                        ['year' => '2020', 'title' => 'WordPress Developer', 'org' => 'Freelance', 'desc' => 'Moved into custom themes and plugins. Learned how real clients think, and that requirements always change.'],
                        ['year' => '2021', 'title' => 'Discovered Laravel', 'org' => 'Full-Stack Shift', 'desc' => 'Laravel changed everything. Eloquent, migrations, queues — I finally had structure for ambitious projects.'],
                        ['year' => '2022', 'title' => 'React & Modern Frontend', 'org' => 'Full-Stack', 'desc' => 'Paired Laravel APIs with React frontends. Started shipping SPAs and dashboards for international clients.'],
                        ['year' => '2023', 'title' => 'SaaS & Scale', 'org' => 'Senior Work', 'desc' => 'Built multi-tenant SaaS platforms with Stripe billing, role-based access and real-time notifications.'],
                        ['year' => 'Now', 'title' => 'Open for Projects', 'org' => 'Freelance & Contract', 'desc' => "Taking on freelance work and long-term collaborations. If you're building something, let's talk.", 'current' => true],
                    ];
                @endphp

                <div class="ab-tl-line"><i class="ab-tl-fill"></i></div>

                @foreach ($timeline as $i => $t)
                    <div class="ab-tl-item ab-rv {{ ($t['current'] ?? false) ? 'is-current' : '' }}" data-delay="{{ $i }}">
                        <div class="ab-tl-dot"></div>
                        <div class="ab-tl-card">
                            <span class="ab-tl-year">{{ $t['year'] }}</span>
                            <h3 class="ab-tl-title">{{ $t['title'] }}</h3>
                            <span class="ab-tl-org">{{ $t['org'] }}</span>
                            <p class="ab-tl-desc">{{ $t['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════
         SKILLS — LIVE FROM THE DATABASE
    ══════════════════════════════════════ --}}
    @if ($skills->isNotEmpty())
    <section class="ab-skills">
        <div class="ab-inner">
            <div class="ab-head ab-rv">
                <span class="ab-label">My Toolkit</span>
                <h2 class="ab-h2 ab-center">Technologies I <em>work with</em></h2>
                <p class="ab-head-desc">The stack I reach for, and how confident I am in each.</p>
            </div>

            <div class="ab-skill-cats">
                @foreach ($skills as $category => $group)
                    <div class="ab-skill-cat ab-rv" data-delay="{{ $loop->index }}">
                        <div class="ab-skill-cat-head">
                            <h3>{{ ucfirst($category) }}</h3>
                            <span class="ab-skill-count">{{ $group->count() }}</span>
                        </div>

                        @foreach ($group as $skill)
                            <div class="ab-skill">
                                <div class="ab-skill-top">
                                    <span class="ab-skill-name">
                                        <span class="ab-skill-ico">{{ $skill->icon }}</span>{{ $skill->name }}
                                    </span>
                                    <span class="ab-skill-pct">{{ $skill->percentage }}%</span>
                                </div>
                                <div class="ab-skill-bar">
                                    <i data-width="{{ $skill->percentage }}" style="background:{{ $skill->color_gradient }}"></i>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ══════════════════════════════════════
         CTA
    ══════════════════════════════════════ --}}
    <section class="ab-cta">
        <div class="ab-inner">
            <div class="ab-cta-banner ab-rv">
                <div class="ab-cta-text">
                    <h3>Have a project in mind? Let's <em>build it together.</em></h3>
                    <p>Whether it's a quick fix or a full-scale application, I'm ready to bring your vision to life.</p>
                </div>
                <div class="ab-cta-btns">
                    <a href="{{ url('/#contact') }}" class="ab-btn-primary">
                        ✉ Start a Project
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                    <a href="{{ url('/') }}" class="ab-btn-ghost">← Back Home</a>
                </div>
            </div>
        </div>
    </section>

    @include('layouts.partials.footer')

    @js('js/about.js')
</body>
</html>
