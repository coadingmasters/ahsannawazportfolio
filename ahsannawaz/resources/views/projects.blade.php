<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('layouts.partials.seo', [
        'title' => 'Projects',
        "description" => "Portfolio of Ahsan Nawaz — Laravel SaaS platforms, React admin dashboards, REST APIs, WooCommerce plugins and custom WordPress themes built for real clients.",
        'keywords' => 'Laravel projects, React dashboard, REST API project, WooCommerce plugin, WordPress theme portfolio',
        'type' => 'website',
    ])
    <link rel="preload" as="font" type="font/woff2" crossorigin
          href="{{ asset('fonts/sora-latin.woff2') }}">
    <link rel="preload" as="font" type="font/woff2" crossorigin
          href="{{ asset('fonts/dm-sans-latin.woff2') }}">
    {{-- Critical CSS inline; the rest loads without blocking paint. --}}
    @styles('projects')
</head>
<body>

    @include('layouts.partials.header')

    <main id="main-content">

    @php
        // ucfirst() would render "Api" and "Wordpress" — spell them properly.
        $catLabels = [
            'web'       => 'Web',
            'mobile'    => 'Mobile',
            'api'       => 'API',
            'wordpress' => 'WordPress',
        ];
        $label = fn ($c) => $catLabels[$c] ?? ucfirst($c);
    @endphp

    {{-- ══════════════════════════════════════
         MASTHEAD
    ══════════════════════════════════════ --}}
    <section class="pj-masthead">
        <div class="ab-blob ab-blob-1"></div>
        <div class="ab-blob ab-blob-2"></div>
        <div class="ab-grid-bg"></div>

        <div class="ab-inner">
            <nav class="ab-crumb ab-rv">
                <a href="{{ url('/') }}">Home</a>
                <span>/</span>
                <span class="ab-crumb-current">Projects</span>
            </nav>

            <div class="pj-masthead-row">
                <h1 class="pj-title ab-rv" style="transition-delay:0.06s">
                    Selected<br><em>Work</em>
                </h1>

                <div class="pj-masthead-meta ab-rv" style="transition-delay:0.14s">
                    <p class="pj-lede">
                        A look at what I've built — Laravel platforms, React interfaces, APIs and
                        custom WordPress work. Every one shipped for a real client with real deadlines.
                    </p>
                    <div class="pj-count">
                        <span class="pj-count-num">{{ str_pad($grid->count() + ($featured ? 1 : 0), 2, '0', STR_PAD_LEFT) }}</span>
                        <span class="pj-count-label">Projects<br>in this issue</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if ($featured)
    {{-- ══════════════════════════════════════
         FEATURED SPREAD
    ══════════════════════════════════════ --}}
    <section class="pj-featured">
        <div class="ab-inner">
            <div class="pj-feat-label ab-rv">
                <span class="pj-rule"></span>
                <span>Featured Project</span>
                <span class="pj-rule"></span>
            </div>

            <article class="pj-feat ab-rv" style="transition-delay:0.08s">

                <div class="pj-feat-media">
                    <div class="pj-feat-img-wrap">
                        <img src="{{ $featured->image_url }}" alt="{{ $featured->title }} — featured {{ $catLabels[$featured->category] ?? ucfirst($featured->category) }} project by Ahsan Nawaz" class="pj-feat-img" loading="eager">
                        <span class="pj-feat-shine"></span>
                    </div>
                    <span class="pj-feat-tag">★ Featured</span>
                </div>

                <div class="pj-feat-body">
                    <span class="pj-cat">{{ $label($featured->category) }}</span>

                    <h2 class="pj-feat-title">{{ $featured->title }}</h2>

                    <p class="pj-feat-desc">{{ $featured->description }}</p>

                    @if ($featured->tech_stack)
                        <div class="pj-stack">
                            @foreach ($featured->tech_stack as $tech)
                                <span class="pj-chip">{{ $tech }}</span>
                            @endforeach
                        </div>
                    @endif

                    <div class="pj-feat-links">
                        @if ($featured->live_url)
                            <a href="{{ $featured->live_url }}" target="_blank" rel="noopener" class="ab-btn-primary">
                                ↗ View Live
                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </a>
                        @endif
                        @if ($featured->github_url)
                            <a href="{{ $featured->github_url }}" target="_blank" rel="noopener" class="ab-btn-ghost">⎇ Source Code</a>
                        @endif
                        @if (!$featured->live_url && !$featured->github_url)
                            <a href="{{ route('contact') }}" class="ab-btn-ghost">Ask about this project →</a>
                        @endif
                    </div>
                </div>
            </article>
        </div>
    </section>
    @endif

    {{-- ══════════════════════════════════════
         GRID + FILTERS
    ══════════════════════════════════════ --}}
    <section class="pj-archive">
        <div class="ab-inner">

            <div class="pj-archive-head ab-rv">
                <h2 class="pj-archive-title">The <em>Archive</em></h2>

                @if ($categories->count() > 1)
                    <div class="pj-filters" role="tablist" aria-label="Filter projects by category">
                        <button type="button" class="pj-filter is-active" data-filter="all" role="tab" aria-selected="true">
                            All <span class="pj-filter-n">{{ $grid->count() }}</span>
                        </button>
                        @foreach ($categories as $cat => $n)
                            <button type="button" class="pj-filter" data-filter="{{ $cat }}" role="tab" aria-selected="false">
                                {{ $label($cat) }} <span class="pj-filter-n">{{ $n }}</span>
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            @if ($grid->isEmpty())
                <div class="pj-empty">
                    <span class="pj-empty-ico">◧</span>
                    <p>No other projects to show yet.</p>
                    <a href="{{ route('contact') }}" class="ab-btn-primary">Start a project →</a>
                </div>
            @else
                <div class="pj-grid" id="pj-grid">
                    @foreach ($grid as $project)
                        <article class="pj-card ab-rv"
                                 data-category="{{ $project->category }}"
                                 data-delay="{{ $loop->index % 3 }}">

                            <span class="pj-card-num">{{ str_pad($loop->iteration + 1, 2, '0', STR_PAD_LEFT) }}</span>

                            <div class="pj-card-media">
                                <img src="{{ $project->image_url }}" alt="{{ $project->title }} — {{ $catLabels[$project->category] ?? ucfirst($project->category) }} project by Ahsan Nawaz" class="pj-card-img" loading="lazy">
                                <div class="pj-card-overlay">
                                    <div class="pj-card-actions">
                                        @if ($project->live_url)
                                            <a href="{{ $project->live_url }}" target="_blank" rel="noopener"
                                               class="pj-action" title="View live site" aria-label="View {{ $project->title }} live">↗</a>
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
                                <span class="pj-cat">{{ $label($project->category) }}</span>
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

                <p class="pj-noresults" id="pj-noresults" hidden>
                    Nothing in this category yet.
                </p>
            @endif
        </div>
    </section>

    {{-- ══════════════════════════════════════
         CTA
    ══════════════════════════════════════ --}}
    <section class="ab-cta">
        <div class="ab-inner">
            <div class="ab-cta-banner ab-rv">
                <div class="ab-cta-text">
                    <h3>Like what you see? <em>Let's build yours.</em></h3>
                    <p>Every project here started with a message. Yours can too.</p>
                </div>
                <div class="ab-cta-btns">
                    <a href="{{ route('contact') }}" class="ab-btn-primary">
                        ✉ Start a Project
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                    <a href="{{ route('about') }}" class="ab-btn-ghost">About Me →</a>
                </div>
            </div>
        </div>
    </section>

    </main>

    @include('layouts.partials.footer')

    @js('js/about.js')
    @js('js/projects.js')
</body>
</html>
