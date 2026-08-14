<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('layouts.partials.seo', [
        'title' => 'Sitemap',
        'titleFull' => "Sitemap | Ahsan Nawaz — Web Developer",
        'description' => "Every page on ahsannawaz.dev in one place — services, projects, skills, articles and contact details for Laravel developer Ahsan Nawaz.",
    ])
    <link rel="preload" as="font" type="font/woff2" crossorigin href="{{ asset('fonts/sora-latin.woff2') }}">
    <link rel="preload" as="font" type="font/woff2" crossorigin href="{{ asset('fonts/dm-sans-latin.woff2') }}">
    @styles('sitemap')
</head>
<body>
    @include('layouts.partials.header')

    <main id="main-content">
        <section class="sec sec-tint" style="padding-bottom:clamp(2rem,4vw,3rem)">
            <div class="sec-inner sec-head" style="margin-bottom:0">
                <span class="sec-eyebrow">Sitemap</span>
                <h1 class="sec-title" style="font-size:clamp(1.8rem,1.4rem+1.8vw,2.6rem)">Every page, in one place</h1>
                <p class="sec-sub">
                    A readable index of the site. Search engines use
                    <a href="{{ route('sitemap') }}" style="color:var(--accent)">the XML version</a>.
                </p>
            </div>
        </section>

        <section class="sec" style="padding-top:clamp(2rem,4vw,3rem)">
            <div class="sec-inner map-grid">

                <div class="map-col">
                    <h2>Main pages</h2>
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a><span>Laravel developer portfolio and services</span></li>
                        <li><a href="{{ route('about') }}">About</a><span>Background, how I work, and what I focus on</span></li>
                        <li><a href="{{ route('skills') }}">Skills</a><span>The full stack with honest proficiency levels</span></li>
                        <li><a href="{{ route('projects') }}">Projects</a><span>Selected client work with the stack behind each</span></li>
                        <li><a href="{{ route('contact') }}">Contact</a><span>Start a project or ask a question</span></li>
                    </ul>
                </div>

                <div class="map-col">
                    <h2>Services</h2>
                    <ul>
                        <li><a href="{{ route('contact') }}?service=laravel">Laravel Development</a><span>Custom web applications built on Laravel</span></li>
                        <li><a href="{{ route('contact') }}?service=api">REST API Development</a><span>Documented APIs with authentication</span></li>
                        <li><a href="{{ route('contact') }}?service=admin">Admin Panels</a><span>Dashboards your team can actually use</span></li>
                        <li><a href="{{ route('contact') }}?service=wordpress">WordPress &amp; WooCommerce</a><span>Custom themes, plugins and store work</span></li>
                        <li><a href="{{ route('contact') }}?service=performance">Performance &amp; SEO</a><span>Core Web Vitals, indexing and speed</span></li>
                    </ul>
                </div>

                <div class="map-col">
                    <h2>Help &amp; legal</h2>
                    <ul>
                        <li><a href="{{ route('faq') }}">FAQ</a><span>Cost, timelines and what happens after launch</span></li>
                        <li><a href="{{ route('privacy') }}">Privacy Policy</a><span>What data this site collects and why</span></li>
                        <li><a href="{{ route('terms') }}">Terms of Service</a><span>The terms work is carried out under</span></li>
                        <li><a href="{{ route('sitemap') }}">XML Sitemap</a><span>The machine-readable index for search engines</span></li>
                    </ul>
                </div>

                @if ($posts->isNotEmpty())
                <div class="map-col map-wide">
                    <h2>Articles</h2>
                    <ul>
                        @foreach ($posts as $post)
                            <li>
                                <a href="{{ route('post', $post) }}">{{ $post->title }}</a>
                                <span>{{ $post->date_label }} · {{ $post->read_minutes }} min read</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </section>
    </main>

    @include('layouts.partials.footer')
    @js('js/home.js')
    @stack('scripts')
</body>
</html>
