<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('layouts.partials.seo', [
        'title' => $post->title,
        'description' => Str::limit($post->excerpt ?: strip_tags($post->body), 155),
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
        'description' => Str::limit($post->excerpt ?: strip_tags($post->body), 155),
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
                <a href="{{ route('blog') }}" class="read-more" style="margin-bottom:1rem">← Back to all articles</a>

                <span class="cat-tag" style="text-transform:capitalize">{{ $post->category }}</span>
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

                <div class="post-body">
                    {{-- Stored as plain text. Blank lines start a paragraph and a
                         leading ## makes a heading, so nothing has to be escaped
                         by hand and no raw HTML is trusted. --}}
                    @foreach (preg_split('/\n\s*\n/', trim($post->body)) as $block)
                        @php $block = trim($block); @endphp
                        @if (Str::startsWith($block, '## '))
                            <h2>{{ Str::after($block, '## ') }}</h2>
                        @elseif (Str::startsWith($block, '# '))
                            <h2>{{ Str::after($block, '# ') }}</h2>
                        @else
                            <p>{!! nl2br(e($block)) !!}</p>
                        @endif
                    @endforeach
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
                                <p>{{ Str::limit($r->excerpt ?: strip_tags($r->body), 100) }}</p>
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
