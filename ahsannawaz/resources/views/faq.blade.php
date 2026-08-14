<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('layouts.partials.seo', [
        'title' => 'FAQ',
        'titleFull' => "Web Development FAQ | Ahsan Nawaz",
        'description' => "Costs, timelines, technologies and what happens after launch — straight answers to the questions clients ask before hiring a Laravel developer.",
        'keywords' => 'laravel developer faq, web development cost, hire php developer questions, freelance developer process',
    ])
    <link rel="preload" as="font" type="font/woff2" crossorigin href="{{ asset('fonts/sora-latin.woff2') }}">
    <link rel="preload" as="font" type="font/woff2" crossorigin href="{{ asset('fonts/dm-sans-latin.woff2') }}">
    @styles('faq')

    {{-- FAQPage data. Google requires the answer here to be the complete one
         shown on the page, so both are rendered from the same config. --}}
    @php $faqs = config('faq'); @endphp
    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => collect($faqs)->map(fn ($f) => [
            '@type' => 'Question',
            'name' => $f['q'],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
        ])->all(),
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>
</head>
<body>
    @include('layouts.partials.header')

    <main id="main-content">
        <section class="sec sec-tint" style="padding-bottom:clamp(2rem,4vw,3rem)">
            <div class="sec-inner sec-head" style="margin-bottom:0">
                <span class="sec-eyebrow">Questions &amp; Answers</span>
                <h1 class="sec-title" style="font-size:clamp(1.8rem,1.4rem+1.8vw,2.6rem)">
                    Frequently asked questions
                </h1>
                <p class="sec-sub">
                    What it costs, how long it takes and what happens after launch — answered
                    before you have to ask.
                </p>
            </div>
        </section>

        <section class="sec" style="padding-top:clamp(2rem,4vw,3rem)">
            <div class="sec-inner faq-wrap">
                <div class="faq-list">
                    @foreach ($faqs as $i => $faq)
                        {{-- <details> gives working accordions with no JavaScript,
                             and keeps the answer in the DOM for crawlers. --}}
                        <details class="faq rv rv-d{{ min($i % 4, 3) }}" @if ($i === 0) open @endif>
                            <summary>
                                <span>{{ $faq['q'] }}</span>
                                <svg class="faq-chev" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                     stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="m6 9 6 6 6-6"/>
                                </svg>
                            </summary>
                            <div class="faq-a"><p>{{ $faq['a'] }}</p></div>
                        </details>
                    @endforeach
                </div>

                <aside class="faq-aside rv rv-d1">
                    <h2>Still have a question?</h2>
                    <p>If your situation is not covered here, send it over. You will get a real answer within 24 hours, not a sales pitch.</p>
                    <a href="{{ route('contact') }}" class="btn-primary">
                        Ask a question
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-7-7 7 7-7 7"/></svg>
                    </a>

                    <ul class="faq-links">
                        <li><a href="{{ route('skills') }}">See the full tech stack</a></li>
                        <li><a href="{{ route('projects') }}">Browse recent projects</a></li>
                        <li><a href="{{ route('about') }}">More about how I work</a></li>
                    </ul>
                </aside>
            </div>
        </section>
    </main>

    @include('layouts.partials.footer')
    @js('js/home.js')
    @stack('scripts')
</body>
</html>
