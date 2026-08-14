<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('layouts.partials.seo', [
        'title' => 'Skills',
        'titleFull' => "Laravel, PHP & React Skills | Ahsan Nawaz",
        "description" => "Laravel, PHP, React JS, JavaScript, WordPress, MySQL and Tailwind CSS — the tools Ahsan Nawaz works with, rated honestly rather than all at 100%.",
        'keywords' => 'Laravel skills, PHP developer skills, React JS, WordPress plugin development, MySQL, Tailwind CSS',
        'type' => 'website',
    ])
    <link rel="preload" as="font" type="font/woff2" crossorigin
          href="{{ asset('fonts/sora-latin.woff2') }}">
    <link rel="preload" as="font" type="font/woff2" crossorigin
          href="{{ asset('fonts/dm-sans-latin.woff2') }}">
    {{-- Critical CSS inline; the rest loads without blocking paint. --}}
    @styles('skills')
    {{-- Reused here: .pj-filter* pills, .pj-empty / .pj-noresults, and the pjPop keyframe --}}
</head>
<body>

    @include('layouts.partials.header')

    <main id="main-content">

    @php
        // ucfirst() would render "Cms" — spell the category labels properly.
        $catLabels = [
            'backend'  => 'Backend',
            'frontend' => 'Frontend',
            'cms'      => 'CMS',
            'database' => 'Database',
            'tools'    => 'Tools',
        ];
        $label = fn ($c) => $catLabels[$c] ?? ucfirst($c);

        $catBlurbs = [
            'backend'  => 'Where the real logic lives — APIs, business rules, and the code that has to be right.',
            'frontend' => 'The part people actually touch. Fast, responsive, and pixel-accurate.',
            'cms'      => 'Custom WordPress work — plugins and themes built properly, not bolted together.',
            'database' => 'Schema design and queries that stay fast as the data grows.',
            'tools'    => 'The workflow around the code — version control, containers, and deployment.',
        ];
    @endphp

    {{-- ══════════════════════════════════════
         MASTHEAD
    ══════════════════════════════════════ --}}
    <section class="sp-masthead">
        <div class="ab-blob ab-blob-1"></div>
        <div class="ab-blob ab-blob-2"></div>
        <div class="ab-grid-bg"></div>

        <div class="ab-inner">
            <nav class="ab-crumb ab-rv">
                <a href="{{ url('/') }}">Home</a>
                <span>/</span>
                <span class="ab-crumb-current">Skills</span>
            </nav>

            <h1 class="sp-title ab-rv" style="transition-delay:0.06s">
                Skills &amp; <em>Expertise</em>
            </h1>

            <p class="sp-lede ab-rv" style="transition-delay:0.12s">
                An honest breakdown of what I work with. The percentages aren't marketing —
                they're how confident I actually am reaching for each one under pressure.
            </p>

            {{-- Stats strip --}}
            <div class="sp-stats ab-rv" style="transition-delay:0.18s">
                <div class="sp-stat">
                    <span class="sp-stat-num" data-count="{{ $siteStats['skills'] }}">{{ $siteStats['skills'] }}</span>
                    <span class="sp-stat-label">Technologies</span>
                </div>
                <span class="sp-stat-div"></span>
                <div class="sp-stat">
                    <span class="sp-stat-num" data-count="{{ $siteStats['categories'] }}">{{ $siteStats['categories'] }}</span>
                    <span class="sp-stat-label">Categories</span>
                </div>
                <span class="sp-stat-div"></span>
                <div class="sp-stat">
                    <span class="sp-stat-num" data-count="{{ $siteStats['expert'] }}">{{ $siteStats['expert'] }}</span>
                    <span class="sp-stat-label">Expert Level</span>
                </div>
                <span class="sp-stat-div"></span>
                <div class="sp-stat">
                    <span class="sp-stat-num" data-count="{{ $siteStats['average'] }}" data-suffix="%">{{ $siteStats['average'] }}%</span>
                    <span class="sp-stat-label">Avg. Proficiency</span>
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════
         FILTERS + RING GRID
    ══════════════════════════════════════ --}}
    <section class="sp-main">
        <div class="ab-inner">

            <div class="sp-toolbar ab-rv">
                <div class="pj-filters" role="tablist" aria-label="Filter skills by category">
                    <button type="button" class="pj-filter is-active" data-filter="all" role="tab" aria-selected="true">
                        All <span class="pj-filter-n">{{ $all->count() }}</span>
                    </button>
                    @foreach ($categories as $cat => $n)
                        <button type="button" class="pj-filter" data-filter="{{ $cat }}" role="tab" aria-selected="false">
                            {{ $label($cat) }} <span class="pj-filter-n">{{ $n }}</span>
                        </button>
                    @endforeach
                </div>

                {{-- Level legend --}}
                <div class="sp-legend">
                    <span class="sp-legend-item"><i style="background:var(--ramp-3)"></i> Expert</span>
                    <span class="sp-legend-item"><i style="background:var(--ramp-2)"></i> Advanced</span>
                    <span class="sp-legend-item"><i style="background:var(--ramp-1)"></i> Good</span>
                </div>
            </div>

            @if ($all->isEmpty())
                <div class="pj-empty">
                    <span class="pj-empty-ico">⚡</span>
                    <p>No skills to show yet. Add some in the admin panel.</p>
                </div>
            @else
                <div class="sp-grid" id="sp-grid">
                    @foreach ($all as $skill)
                        {{-- The proficiency ring doubles as the icon frame: one
                             mark carrying both the brand and the level, instead
                             of an emoji beside a bar. --}}
                        <article class="sk-card ab-rv"
                                 data-category="{{ $skill->category }}"
                                 data-delay="{{ $loop->index % 4 }}">

                            <div class="sk-ring-wrap">
                                <svg class="sk-ring" viewBox="0 0 100 100" aria-hidden="true">
                                    <circle class="sk-ring-track" cx="50" cy="50" r="43"/>
                                    <circle class="sk-ring-fill" cx="50" cy="50" r="43"
                                            data-pct="{{ $skill->percentage }}"/>
                                </svg>
                                <span class="sk-ring-ico">
                                    @include('layouts.partials.tech-icon', ['name' => $skill->name])
                                </span>
                            </div>

                            <h3 class="sk-name">{{ $skill->name }}</h3>
                            <span class="sk-cat">{{ $label($skill->category) }}</span>

                            <div class="sk-bar" aria-hidden="true">
                                <i data-pct="{{ $skill->percentage }}"></i>
                            </div>

                            <div class="sk-foot">
                                <span class="sk-pct" data-pct="{{ $skill->percentage }}">{{ $skill->percentage }}%</span>
                                <span class="sk-badge sk-badge-{{ $skill->level }}">{{ $skill->level }}</span>
                            </div>
                        </article>
                    @endforeach
                </div>

                <p class="pj-noresults" id="sp-noresults" hidden>
                    Nothing in this category yet.
                </p>
            @endif
        </div>
    </section>

    {{-- ══════════════════════════════════════
         CATEGORY BREAKDOWN
    ══════════════════════════════════════ --}}
    <section class="sp-breakdown">
        <div class="ab-blob ab-blob-3"></div>
        <div class="ab-inner">
            <div class="ab-head ab-rv">
                <span class="ab-label">By Discipline</span>
                <h2 class="ab-h2 ab-center">Where my <em>depth</em> is</h2>
                <p class="ab-head-desc">Grouped by what each technology is actually for.</p>
            </div>

            <div class="sp-break-grid">
                @foreach ($all->groupBy('category') as $cat => $group)
                    <div class="sp-break-card ab-rv" data-delay="{{ $loop->index }}">
                        <div class="sp-break-head">
                            <h3>{{ $label($cat) }}</h3>
                            <span class="sp-break-avg">{{ (int) round($group->avg('percentage')) }}%<i>avg</i></span>
                        </div>

                        <p class="sp-break-blurb">{{ $catBlurbs[$cat] ?? '' }}</p>

                        <div class="sp-break-list">
                            @foreach ($group as $skill)
                                <div class="sp-break-row">
                                    <span class="sp-break-name">
                                        <span class="sp-break-ico">{{ $skill->icon }}</span>{{ $skill->name }}
                                    </span>
                                    <div class="sp-break-bar">
                                        <i data-width="{{ $skill->percentage }}" style="background:{{ $skill->color_gradient }}"></i>
                                    </div>
                                    <span class="sp-break-pct">{{ $skill->percentage }}%</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════
         CTA
    ══════════════════════════════════════ --}}
    <section class="ab-cta">
        <div class="ab-inner">
            <div class="ab-cta-banner ab-rv">
                <div class="ab-cta-text">
                    <h3>Need one of these on your project? <em>Let's talk.</em></h3>
                    <p>Tell me what you're building and I'll tell you honestly whether I'm the right fit.</p>
                </div>
                <div class="ab-cta-btns">
                    <a href="{{ route('contact') }}" class="ab-btn-primary">
                        ✉ Start a Project
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                    <a href="{{ route('projects') }}" class="ab-btn-ghost">See My Work →</a>
                </div>
            </div>
        </div>
    </section>

    </main>

    @include('layouts.partials.footer')

    @js('js/about.js')
    @js('js/skills.js')
</body>
</html>
