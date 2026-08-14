{{-- ============================================
     SEO HEAD
     Every public page includes this once, inside <head>.

     @include('layouts.partials.seo', [
         'title'       => 'Projects',              // page name; the brand is appended
         'description' => '…',                     // 120–160 characters
         'keywords'    => 'optional, extra, terms',
         'image'       => asset('images/og.jpg'),  // optional social preview
         'type'        => 'website',               // or 'profile' / 'article'
     ])
============================================ --}}

@php
    $brand    = 'Ahsan Nawaz';
    $tagline  = 'Full-Stack Web Developer';
    $siteName = $brand . ' — ' . $tagline;

    // A page passes its own name; the homepage leads with the brand instead.
    // Kept under ~60 characters so search results show the whole thing.
    $pageTitle = isset($title) && $title !== ''
        ? $title . ' | ' . $brand . ' — Web Developer'
        : $brand . ' — Laravel, React & WordPress Developer';

    // Search engines truncate around 160 characters, so keep the useful part first.
    $desc = trim($description ?? 'Ahsan Nawaz is a full-stack web developer from Pakistan building fast, secure and search-friendly websites with Laravel, PHP, React JS and WordPress.');

    $canonical = url()->current();
    $ogImage   = $image ?? asset('images/ahsannawaz.webp');
    $ogType    = $type ?? 'website';
    $social    = config('social');

    // Laravel ships a real @context Blade directive, so writing '@context'
    // literally in this file compiles it into PHP and corrupts the JSON-LD.
    // Building the key here keeps that literal out of Blade's scanner.
    $ctx = '@'.'context';
@endphp

<title>{{ $pageTitle }}</title>
<meta name="description" content="{{ $desc }}">
@isset($keywords)<meta name="keywords" content="{{ $keywords }}">@endisset
<meta name="author" content="{{ $brand }}">
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
<link rel="canonical" href="{{ $canonical }}">
<meta name="theme-color" content="#0f766e">

{{-- Open Graph — how the link renders on LinkedIn, Facebook, WhatsApp --}}
<meta property="og:type" content="{{ $ogType }}">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:title" content="{{ $pageTitle }}">
<meta property="og:description" content="{{ $desc }}">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:image" content="{{ $ogImage }}">
<meta property="og:image:alt" content="{{ $brand }}, {{ $tagline }}">
<meta property="og:locale" content="en_US">

{{-- Twitter / X --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $pageTitle }}">
<meta name="twitter:description" content="{{ $desc }}">
<meta name="twitter:image" content="{{ $ogImage }}">

{{-- Structured data. The Person graph is what lets Google show a knowledge
     panel and connect the profiles below to this site. --}}
<script type="application/ld+json">
{!! json_encode(array_filter([
    $ctx => 'https://schema.org',
    '@type' => 'Person',
    'name' => $brand,
    'url' => url('/'),
    'image' => $ogImage,
    'jobTitle' => $tagline,
    'description' => $desc,
    'nationality' => 'Pakistani',
    'address' => ['@type' => 'PostalAddress', 'addressCountry' => 'PK'],
    'knowsAbout' => [
        'Laravel', 'PHP', 'React JS', 'WordPress', 'MySQL',
        'REST API development', 'WooCommerce', 'Tailwind CSS', 'JavaScript',
    ],
    'sameAs' => array_values(array_filter([
        $social['github'] ?? null,
        $social['linkedin'] ?? null,
        $social['facebook'] ?? null,
        $social['fiverr'] ?? null,
        $social['upwork'] ?? null,
    ])),
]), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>

<script type="application/ld+json">
{!! json_encode([
    $ctx => 'https://schema.org',
    '@type' => 'WebSite',
    'name' => $siteName,
    'url' => url('/'),
    'inLanguage' => 'en',
], JSON_UNESCAPED_SLASHES) !!}
</script>

{{-- Breadcrumbs on inner pages, so results show Home › Projects --}}
@isset($title)
<script type="application/ld+json">
{!! json_encode([
    $ctx => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
        ['@type' => 'ListItem', 'position' => 2, 'name' => $title, 'item' => $canonical],
    ],
], JSON_UNESCAPED_SLASHES) !!}
</script>
@endisset
