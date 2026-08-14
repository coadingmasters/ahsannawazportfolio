<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('layouts.partials.seo', [
        'title' => $post->title,
        {{-- An article's own headline IS the search title. Appending the brand
             pushes it past the ~60 characters Google shows, and the half that
             gets cut is the half carrying the keyword. --}}
        'titleFull' => Str::limit($post->title, 62, ''),
        'description' => Str::limit($post->excerpt ?: \App\Support\PostHtml::toText($post->body, 200), 155),
        'image' => $post->image_url ?: asset('images/ahsannawaz-720.webp'),
        'type' => 'article',
    ])
    <link rel="preload" as="font" type="font/woff2" crossorigin href="{{ asset('fonts/sora-latin.woff2') }}">
    <link rel="preload" as="font" type="font/woff2" crossorigin href="{{ asset('fonts/dm-sans-latin.woff2') }}">
    @styles('blog')

    {{-- Article schema, so a search result can show the date and author. --}}
    @php $ctx = '@'.'context'; @endphp
    <script type="application/ld+json">
    {!! json_encode([
        $ctx => 'https://schema.org',
        '@type' => 'BlogPosting',
        'headline' => $post->title,
        'description' => $post->excerpt ?: \App\Support\PostHtml::toText($post->body, 155),
        'image' => $post->image_url ?: asset('images/ahsannawaz-720.webp'),
        'datePublished' => optional($post->published_at ?? $post->created_at)->toAtomString(),
        'dateModified' => optional($post->updated_at)->toAtomString(),
        'author' => ['@type' => 'Person', 'name' => 'Ahsan Nawaz', 'url' => url('/')],
        'mainEntityOfPage' => route('post', $post),
    ], JSON_UNESCAPED_SLASHES) !!}
    </script>
</head>
<body>
    @include('layouts.partials.header')

    <main id="main-content">
        <article class="sec">
            <div style="max-width:760px;margin:0 auto">
                <div class="post-top">
                    <a href="{{ route('blog') }}" class="read-more">← Back to all articles</a>
                    <span class="cat-tag">{{ $post->category }}</span>
                </div>
                <h1 style="font-family:'Sora',sans-serif;font-size:clamp(1.7rem,1.3rem+1.8vw,2.5rem);line-height:1.2;margin:.6rem 0 .5rem">
                    {{ $post->title }}
                </h1>
                <p style="color:var(--text-3);font-size:var(--step--1)">
                    {{ $post->date_label }} · {{ $post->read_minutes }} min read
                </p>

                @if ($post->image_url)
                    <img src="{{ $post->image_url }}" alt="{{ $post->title }}" width="760" height="428"
                         style="width:100%;height:auto;border-radius:var(--r-lg);margin:1.5rem 0;box-shadow:var(--shadow)">
                @endif

                {{-- Sanitised on save by App\Support\PostHtml, so it is safe to
                     print. Nothing unescaped ever reaches the database. --}}
                <div class="post-body">
                    {!! $post->body !!}
                </div>
            </div>
        </article>

        @if ($related->isNotEmpty())
        <section class="sec sec-tint">
            <div class="sec-inner">
                <div class="sec-head"><h2 class="sec-title">Keep reading</h2></div>
                <div class="blog-grid">
                    @foreach ($related as $r)
                        <article class="h-card bpost">
                            @if ($r->image_url)
                                <div class="bpost-shot">
                                    <img src="{{ $r->image_url }}" width="420" height="236" loading="lazy" alt="{{ $r->title }}">
                                    <span class="bpost-date">{{ $r->date_label }}</span>
                                </div>
                            @endif
                            <div class="bpost-body">
                                <h3><a href="{{ route('post', $r) }}">{{ $r->title }}</a></h3>
                                <p>{{ $r->excerpt ?: \App\Support\PostHtml::toText($r->body, 100) }}</p>
                                <a href="{{ route('post', $r) }}" class="read-more">Read More
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-7-7 7 7-7 7"/></svg>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
        @endif
    </main>

    @include('layouts.partials.footer')
    @js('js/home.js')
    @stack('scripts')
</body>
</html>
