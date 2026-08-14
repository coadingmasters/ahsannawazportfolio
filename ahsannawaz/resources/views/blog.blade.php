<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('layouts.partials.seo', [
        'title' => 'Blog',
        'titleFull' => "Laravel & PHP Development Blog | Ahsan Nawaz",
        "description" => "Practical Laravel, PHP and REST API articles from Ahsan Nawaz — notes from real client projects, not theory. New posts on building and shipping web apps.",
        'keywords' => 'Laravel blog, PHP tutorials, REST API guide, WordPress development tips',
    ])
    <link rel="preload" as="font" type="font/woff2" crossorigin href="{{ asset('fonts/sora-latin.woff2') }}">
    <link rel="preload" as="font" type="font/woff2" crossorigin href="{{ asset('fonts/dm-sans-latin.woff2') }}">
    @styles('blog')
</head>
<body>
    @include('layouts.partials.header')

    <main id="main-content">
        <section class="sec sec-tint" style="padding-bottom:clamp(2rem,4vw,3rem)">
            <div class="sec-inner sec-head" style="margin-bottom:0">
                <span class="sec-eyebrow">The Blog</span>
                <h1 class="sec-title" style="font-size:clamp(1.8rem,1.4rem+1.8vw,2.6rem)">Notes from building things</h1>
                <p class="sec-sub">Laravel, PHP and the lessons that only show up on real projects.</p>
            </div>
        </section>

        <section class="sec" style="padding-top:clamp(2rem,4vw,3rem)">
            <div class="sec-inner">
                @if ($posts->isEmpty())
                    <p style="text-align:center;color:var(--text-3)">No articles published yet — check back soon.</p>
                @else
                    <div class="blog-grid">
                        @foreach ($posts as $i => $post)
                            <article class="h-card bpost rv rv-d{{ min($i % 3, 3) }}">
                                @if ($post->image_url)
                                    <div class="bpost-shot">
                                        <img src="{{ $post->image_url }}" width="420" height="236" loading="lazy"
                                             decoding="async" alt="{{ $post->title }}">
                                        <span class="bpost-date">{{ $post->date_label }}</span>
                                    </div>
                                @endif
                                <div class="bpost-body">
                                    @unless ($post->image_url)
                                        <span class="bpost-date" style="position:static;align-self:flex-start;margin-bottom:.5rem">{{ $post->date_label }}</span>
                                    @endunless
                                    <h2 style="font-size:var(--step-0);line-height:1.4;margin-bottom:.4rem">
                                        <a href="{{ route('post', $post) }}">{{ $post->title }}</a>
                                    </h2>
                                    <p>{{ $post->excerpt ?: \App\Support\PostHtml::toText($post->body, 120) }}</p>
                                    <a href="{{ route('post', $post) }}" class="read-more">
                                        Read More<span class="sr-only"> about {{ $post->title }}</span>
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-7-7 7 7-7 7"/></svg>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                    <div style="margin-top:2rem">{{ $posts->links() }}</div>
                @endif
            </div>
        </section>
    </main>

    @include('layouts.partials.footer')
    @js('js/home.js')
    @stack('scripts')
</body>
</html>
