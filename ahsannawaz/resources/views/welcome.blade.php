<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('layouts.partials.seo', [
        "description" => "Full-stack web developer from Pakistan building fast, secure Laravel, PHP, React and WordPress websites, REST APIs and WooCommerce stores. Hire me.",
        'keywords' => 'full stack web developer, Laravel developer, PHP developer, React developer, WordPress developer Pakistan, REST API developer, WooCommerce developer, freelance web developer',
        'type' => 'profile',
    ])
    <link rel="preload" as="font" type="font/woff2" crossorigin
          href="{{ asset('fonts/sora-latin.woff2') }}">
    <link rel="preload" as="font" type="font/woff2" crossorigin
          href="{{ asset('fonts/dm-sans-latin.woff2') }}">
    {{-- Critical CSS inline; the rest loads without blocking paint. --}}
    @styles('welcome')
</head>
<body>
    @include('layouts.partials.header')

    <main id="main-content">

    {{-- ══════════════════ HERO ══════════════════ --}}
    <section id="hero">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>

        <div class="hero-inner">
            <div class="hero-left">
                <div class="badge"><span class="badge-dot"></span> Laravel Developer</div>

                <h1 class="hero-title">Hi, I'm <span>Ahsan</span> Nawaz</h1>

                @php
                    // Fall back to a sensible list if no skills are set yet.
                    $typed = $typedSkills->isNotEmpty()
                        ? $typedSkills
                        : collect(['Laravel', 'PHP', 'React JS', 'MySQL', 'REST APIs', 'WordPress']);
                    // The reserved width has to fit the longest entry, or the
                    // line re-centres on every keystroke and logs a layout shift.
                    $longest = $typed->max(fn ($t) => mb_strlen($t));
                @endphp
                <p class="hero-lead">
                    Building secure &amp; scalable web applications with
                    <span class="typed-wrap" style="--typed-ch: {{ $longest }}">
                        <span id="typed" class="typed"
                              data-words='@json($typed)'
                              aria-live="off">{{ $typed->first() }}</span><span class="typed-caret" aria-hidden="true"></span>
                    </span>
                </p>

                <p class="hero-desc">
                    I'm a backend-focused developer with 2+ years of experience building modern web
                    applications using <strong>Laravel</strong>, <strong>REST APIs</strong> and
                    <strong>MySQL</strong>. I turn ideas into real-world solutions with clean code
                    and great performance.
                </p>

                <div class="cta-row">
                    @if ($hasCv)
                        <a href="{{ route('cv.download') }}" class="btn-primary">
                            Download CV
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v12m0 0 4-4m-4 4-4-4M4 19h16"/></svg>
                        </a>
                    @endif
                    <a href="{{ route('contact') }}" class="btn-outline">
                        Let's Talk
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 2 11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                    </a>
                </div>

                <div class="social-row">
                    @include('layouts.partials.socials', ['class' => 'social-icon'])
                </div>
            </div>

            <div class="hero-right">
                <div class="profile-wrap">
                    <div class="ring ring-1"><div class="ring-dot"></div></div>
                    <div class="ring ring-2"></div>

                    <div class="photo-frame">
                        <div class="photo-circle">
                            <img src="{{ asset('images/ahsannawaz-540.webp') }}"
                                 srcset="{{ asset('images/ahsannawaz-360.webp') }} 360w,
                                         {{ asset('images/ahsannawaz-420.webp') }} 420w,
                                         {{ asset('images/ahsannawaz-540.webp') }} 540w,
                                         {{ asset('images/ahsannawaz-640.webp') }} 640w,
                                         {{ asset('images/ahsannawaz-720.webp') }} 720w"
                                 sizes="(max-width: 640px) 78vw, 390px" width="390" height="490"
                                 alt="Ahsan Nawaz, full-stack web developer specialising in Laravel, PHP and React"
                                 fetchpriority="high">
                        </div>
                    </div>

                    {{-- The stack, orbiting the portrait. Decorative, so hidden
                         from assistive tech — the skills section states it. --}}
                    <span class="orbit orbit-1" aria-hidden="true">@include('layouts.partials.tech-icon', ['name' => 'Laravel'])</span>
                    <span class="orbit orbit-2" aria-hidden="true">@include('layouts.partials.tech-icon', ['name' => 'MySQL'])</span>
                    <span class="orbit orbit-3" aria-hidden="true">@include('layouts.partials.tech-icon', ['name' => 'PHP'])</span>
                    <span class="orbit orbit-4" aria-hidden="true">@include('layouts.partials.tech-icon', ['name' => 'REST API'])</span>
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════ STATS ══════════════════ --}}
    <section class="sec" style="padding-top:0">
        <div class="sec-inner">
            <div class="stats">
                @php
                    $statCards = [
                        ['n' => $siteStats['years'].'+',    'l' => 'Years Experience',   'i' => 'M8 2v4m8-4v4M3 10h18M5 6h14a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2z'],
                        ['n' => $siteStats['projects'].'+', 'l' => 'Projects Completed', 'i' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7l5 5v11a2 2 0 0 1-2 2z'],
                        ['n' => $siteStats['clients'].'+',  'l' => 'Happy Clients',      'i' => 'M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm14 10v-2a4 4 0 0 0-3-3.87'],
                        ['n' => $siteStats['satisfaction'], 'l' => 'Client Satisfaction','i' => 'm12 2 3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1L12 2z'],
                        ['n' => $siteStats['support'],      'l' => 'Support Availability','i' => 'M3 18v-6a9 9 0 0 1 18 0v6M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z'],
                    ];
                @endphp
                @foreach ($statCards as $i => $c)
                    <div class="stat-c rv rv-d{{ min($i, 3) }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="{{ $c['i'] }}"/></svg>
                        <div class="stat-n">{{ $c['n'] }}</div>
                        <div class="stat-l">{{ $c['l'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ══════════════════ ABOUT ══════════════════ --}}
    <section class="sec" style="padding-top:0">
        <div class="sec-inner">
            <div class="about-strip rv">
                <div class="about-shot">
                    <img src="{{ asset('images/ahsannawaz-540.webp') }}" width="420" height="330"
                         alt="Ahsan Nawaz at work on a Laravel project" loading="lazy" decoding="async">
                    <div class="about-ticks">
                        <span>✓ Clean Code</span>
                        <span>✓ Scalable</span>
                        <span>✓ Secure</span>
                    </div>
                </div>

                <div>
                    <span class="sec-eyebrow" style="font-size:var(--step--1);letter-spacing:.08em;text-transform:uppercase">About Me</span>
                    <h2 class="sec-title" style="text-align:left;margin:.3rem 0 .7rem">
                        Building digital solutions with passion &amp; precision.
                    </h2>
                    <p style="color:var(--text-3);font-size:var(--step--1);line-height:1.75">
                        I specialise in <strong style="color:var(--text)">Laravel development</strong> and have
                        strong experience building REST APIs, admin panels and dynamic web applications.
                        I focus on writing clean, efficient and maintainable code that delivers real business value.
                    </p>

                    <div class="chip-grid">
                        @foreach ([
                            ['REST API Development',   'M10 13a5 5 0 0 0 7.5.5l3-3a5 5 0 0 0-7-7l-1.7 1.7M14 11a5 5 0 0 0-7.5-.5l-3 3a5 5 0 0 0 7 7l1.7-1.7'],
                            ['Admin Panel Development','M3 5h18M3 12h18M3 19h11'],
                            ['Database Design',        'M4 6c0-1.66 3.58-3 8-3s8 1.34 8 3-3.58 3-8 3-8-1.34-8-3zM4 6v12c0 1.66 3.58 3 8 3s8-1.34 8-3V6M4 12c0 1.66 3.58 3 8 3s8-1.34 8-3'],
                            ['Performance Tuning',     'm13 2-9 12h7l-1 8 9-12h-7l1-8z'],
                        ] as $chip)
                            <div class="chip" title="{{ $chip[0] }}">
                                <span class="chip-ico" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="{{ $chip[1] }}"/></svg>
                                </span>
                                {{ $chip[0] }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════ TECH STACK ══════════════════ --}}
    @if ($skills->isNotEmpty())
    <section class="sec sec-tint" id="skills">
        <div class="sec-inner">
            <div class="sec-head">
                <span class="sec-eyebrow">My Tech Stack</span>
                <h2 class="sec-title">Technologies &amp; tools I work with</h2>
            </div>

            <div class="tech-grid">
                @foreach ($skills->take(12) as $i => $skill)
                    <div class="tech rv rv-d{{ min($i % 4, 3) }}">
                        @include('layouts.partials.tech-icon', ['name' => $skill->name])
                        <b>{{ $skill->name }}</b>
                    </div>
                @endforeach
            </div>

            <div style="text-align:center;margin-top:1.6rem">
                <a href="{{ route('skills') }}" class="btn-outline">
                    View all skills
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-7-7 7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </section>
    @endif

    {{-- ══════════════════ FEATURED PROJECTS ══════════════════ --}}
    @if ($featured->isNotEmpty())
    <section class="sec" id="projects">
        <div class="sec-inner">
            <div class="sec-head">
                <span class="sec-eyebrow">Featured Projects</span>
                <h2 class="sec-title">Some of my recent work</h2>
            </div>

            <div class="proj-grid">
                @foreach ($featured as $i => $project)
                    <article class="h-card proj rv rv-d{{ min($i, 3) }}">
                        <div class="proj-shot">
                            <img src="{{ $project->image_url }}" width="480" height="300" loading="lazy" decoding="async"
                                 alt="{{ $project->title }} — {{ ucfirst($project->category) }} project by Ahsan Nawaz">
                            <span class="proj-tag">{{ $project->category === 'api' ? 'API' : ucfirst($project->category) }}</span>
                        </div>
                        <div class="proj-body">
                            <h3>{{ $project->title }}</h3>
                            <p>{{ Str::limit($project->description, 120) }}</p>
                            <div class="stack-row">
                                @foreach (array_slice($project->tech_stack ?? [], 0, 3) as $tech)
                                    <span>{{ $tech }}</span>
                                @endforeach
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div style="text-align:center;margin-top:1.8rem">
                <a href="{{ route('projects') }}" class="btn-primary">
                    View all projects
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-7-7 7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </section>
    @endif

    {{-- ══════════════════ SERVICES + PROCESS ══════════════════ --}}
    <section class="sec sec-tint">
        <div class="sec-inner">
            <div class="svc-split">
                <div class="svc-panel rv">
                    <h3>What I Do</h3>
                    <ul>
                        @foreach ([
                            'Web Application Development (Laravel)',
                            'REST API Integration',
                            'Admin Panel Development',
                            'Database Design &amp; Optimisation',
                        ] as $item)
                            <li>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m4 12 5 5L20 6"/></svg>
                                {!! $item !!}
                            </li>
                        @endforeach
                    </ul>
                    <a href="{{ route('contact') }}" class="btn-light">
                        Start a project
                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-7-7 7 7-7 7"/></svg>
                    </a>
                </div>

                <div class="rv rv-d1">
                    <h2 class="sec-title" style="text-align:left">My Development Process</h2>
                    <p class="sec-sub" style="text-align:left;margin-bottom:0">
                        Clean code. Smart planning. Better results. Every project runs through the
                        same five stages, so you always know where things stand.
                    </p>
                </div>
            </div>

            {{-- Each stage says what actually happens in it — a number and a
                 two-word label alone told the reader nothing. --}}
            @php
                $process = [
                    ['Discuss Requirements', 'We talk through what you need, who it is for, and what "done" looks like.',
                     'M8 10h8M8 14h5M21 12a8 8 0 0 1-8 8H7l-4 3v-6.5A8 8 0 0 1 11 4h2a8 8 0 0 1 8 8z'],
                    ['Plan &amp; Design', 'Scope, database schema and screens mapped out before a line of code is written.',
                     'M3 3v18h18M7 15l3-4 3 3 5-7'],
                    ['Develop &amp; Test', 'Built in small reviewable pieces, tested as it goes rather than all at the end.',
                     'm8 8-4 4 4 4m8-8 4 4-4 4M14 4l-4 16'],
                    ['Deploy', 'Shipped to your server with SSL, backups and caching configured properly.',
                     'M12 2 4 7v10l8 5 8-5V7l-8-5zM12 12l8-5M12 12v10M12 12 4 7'],
                    ['Support', 'Fixes, updates and improvements after launch — I do not disappear at handover.',
                     'M3 18v-6a9 9 0 0 1 18 0v6M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z'],
                ];
            @endphp

            <ol class="proc-grid">
                @foreach ($process as $i => $step)
                    <li class="proc rv rv-d{{ min($i % 4, 3) }}">
                        <span class="proc-n">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        <span class="proc-ico" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="{{ $step[2] }}"/></svg>
                        </span>
                        <h3>{!! $step[0] !!}</h3>
                        <p>{{ $step[1] }}</p>
                        <span class="proc-link" aria-hidden="true"></span>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- ══════════════════ TESTIMONIALS ══════════════════ --}}
    @if ($testimonials->isNotEmpty())
    <section class="sec">
        <div class="sec-inner">
            <div class="sec-head">
                <h2 class="sec-title">What Clients Say</h2>
                <p class="sec-sub">Real feedback from real people</p>
            </div>

            <div class="quote-grid">
                @foreach ($testimonials->take(3) as $i => $t)
                    <figure class="h-card quote rv rv-d{{ min($i, 3) }}">
                        <span class="quote-mark" aria-hidden="true">&ldquo;</span>
                        <blockquote><p>{{ $t->quote }}</p></blockquote>
                        <figcaption class="quote-by">
                            @if ($t->avatar_url)
                                <img src="{{ $t->avatar_url }}" alt="" width="42" height="42" loading="lazy">
                            @else
                                <span class="quote-av" aria-hidden="true">{{ $t->initials }}</span>
                            @endif
                            <span>
                                <b>{{ $t->name }}</b>
                                <span>{{ $t->role }}{{ $t->company ? ', '.$t->company : '' }}</span>
                            </span>
                            <span class="stars" aria-label="{{ $t->rating }} out of 5">{{ str_repeat('★', $t->rating) }}</span>
                        </figcaption>
                    </figure>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ══════════════════ BLOG ══════════════════ --}}
    @if ($posts->isNotEmpty())
    <section class="sec sec-tint">
        <div class="sec-inner">
            <div class="sec-head">
                <h2 class="sec-title">Latest from the Blog</h2>
                <p class="sec-sub">Insights, tips and Laravel best practices</p>
            </div>

            <div class="blog-grid">
                @foreach ($posts as $i => $post)
                    <article class="h-card bpost rv rv-d{{ min($i, 3) }}">
                        @if ($post->image_url)
                            <div class="bpost-shot">
                                <img src="{{ $post->image_url }}" width="420" height="236" loading="lazy" decoding="async"
                                     alt="{{ $post->title }}">
                                <span class="bpost-date">{{ $post->date_label }}</span>
                            </div>
                        @endif
                        <div class="bpost-body">
                            @unless ($post->image_url)
                                <span class="bpost-date" style="position:static;align-self:flex-start;margin-bottom:.5rem">{{ $post->date_label }}</span>
                            @endunless
                            <h3><a href="{{ route('post', $post) }}">{{ $post->title }}</a></h3>
                            <p>{{ Str::limit($post->excerpt ?: strip_tags($post->body), 110) }}</p>
                            <a href="{{ route('post', $post) }}" class="read-more">
                                Read More
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-7-7 7 7-7 7"/></svg>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            <div style="text-align:center;margin-top:1.8rem">
                <a href="{{ route('blog') }}" class="btn-outline">
                    All articles
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-7-7 7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </section>
    @endif

    {{-- ══════════════════ CTA ══════════════════ --}}
    <section class="sec" style="padding-top:clamp(2rem,4vw,3rem)">
        <div class="sec-inner">
            <div class="cta-band rv">
                <span class="rocket" aria-hidden="true">🚀</span>
                <div>
                    <h3>Let's Build Something Great Together</h3>
                    <p>Have a project in mind? I'd love to help.</p>
                </div>
                <a href="{{ route('contact') }}" class="btn-primary">
                    Hire Me Now
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-7-7 7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </section>

    </main>

    @include('layouts.partials.footer')

    @js('js/home.js')
    @stack('scripts')
</body>
</html>
