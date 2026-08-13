{{-- ============================================
     SOCIAL ICON ROW
     Reads config/social.php, so every page shows the same links and an
     unfilled profile is skipped rather than rendered as a dead "#".

     Usage:  @include('layouts.partials.socials', ['class' => 'social-icon'])
============================================ --}}

@php
    $s = config('social');

    $wa = $s['whatsapp']
        ? 'https://wa.me/' . preg_replace('/\D/', '', $s['whatsapp'])
            . '?text=' . rawurlencode($s['whatsapp_message'] ?? '')
        : '';

    $links = array_filter([
        ['name' => 'GitHub',   'url' => $s['github'],   'icon' => 'github'],
        ['name' => 'LinkedIn', 'url' => $s['linkedin'], 'icon' => 'linkedin'],
        ['name' => 'WhatsApp', 'url' => $wa,            'icon' => 'whatsapp'],
        ['name' => 'Facebook', 'url' => $s['facebook'], 'icon' => 'facebook'],
        ['name' => 'Fiverr',   'url' => $s['fiverr'],   'icon' => 'fiverr'],
        ['name' => 'Upwork',   'url' => $s['upwork'],   'icon' => 'upwork'],
    ], fn ($l) => ! empty($l['url']));

    $cls = $class ?? 'social-icon';
@endphp

@foreach ($links as $link)
    <a href="{{ $link['url'] }}" class="{{ $cls }}" target="_blank" rel="noopener noreferrer"
       title="{{ $link['name'] }}" aria-label="{{ $link['name'] }}">
        @switch($link['icon'])
            @case('github')
                <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 .5C5.37.5 0 5.87 0 12.5c0 5.3 3.44 9.8 8.21 11.39.6.11.82-.26.82-.58v-2.03c-3.34.73-4.04-1.61-4.04-1.61-.55-1.39-1.34-1.76-1.34-1.76-1.09-.75.08-.73.08-.73 1.2.09 1.84 1.24 1.84 1.24 1.07 1.83 2.81 1.3 3.5.99.11-.78.42-1.3.76-1.6-2.67-.3-5.47-1.33-5.47-5.93 0-1.31.47-2.38 1.24-3.22-.13-.3-.54-1.52.11-3.18 0 0 1.01-.32 3.3 1.23a11.5 11.5 0 0 1 6.01 0c2.29-1.55 3.3-1.23 3.3-1.23.65 1.66.24 2.88.12 3.18.77.84 1.23 1.91 1.23 3.22 0 4.61-2.8 5.62-5.48 5.92.43.37.81 1.1.81 2.22v3.29c0 .32.22.7.83.58A12.01 12.01 0 0 0 24 12.5C24 5.87 18.63.5 12 .5z"/></svg>
                @break
            @case('linkedin')
                <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M4.98 3.5a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5zM2.4 21.5h5.16V9.75H2.4zM10 9.75h4.95v1.6h.07c.69-1.24 2.37-2.55 4.88-2.55 5.22 0 6.18 3.29 6.18 7.57v7.13h-5.15v-6.32c0-1.51-.03-3.45-2.16-3.45-2.16 0-2.49 1.64-2.49 3.34v6.43H10z"/></svg>
                @break
            @case('whatsapp')
                <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.47 14.38c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.96-.94 1.16-.17.2-.35.22-.65.07-.3-.15-1.26-.46-2.4-1.48-.89-.79-1.49-1.77-1.66-2.07-.17-.3-.02-.46.13-.61.14-.14.3-.35.45-.53.15-.18.2-.3.3-.5.1-.2.05-.38-.03-.53-.07-.15-.67-1.62-.92-2.21-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.38-.27.3-1.04 1.02-1.04 2.48s1.07 2.88 1.22 3.08c.15.2 2.1 3.2 5.08 4.49.71.3 1.26.49 1.7.63.71.23 1.36.19 1.87.12.57-.09 1.76-.72 2.01-1.41.25-.7.25-1.29.17-1.41-.07-.13-.27-.2-.57-.35zM12.05 2C6.55 2 2.1 6.45 2.1 11.95c0 1.76.46 3.48 1.34 5L2 22l5.2-1.36a9.9 9.9 0 0 0 4.85 1.24h.01c5.49 0 9.95-4.45 9.95-9.95 0-2.66-1.04-5.16-2.92-7.04A9.88 9.88 0 0 0 12.05 2z"/></svg>
                @break
            @case('facebook')
                <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M24 12.07C24 5.4 18.63 0 12 0S0 5.4 0 12.07C0 18.1 4.39 23.1 10.13 24v-8.44H7.08v-3.49h3.05V9.41c0-3.02 1.79-4.69 4.53-4.69 1.31 0 2.68.24 2.68.24v2.96h-1.51c-1.49 0-1.96.93-1.96 1.89v2.26h3.33l-.53 3.49h-2.8V24C19.61 23.1 24 18.1 24 12.07z"/></svg>
                @break
            @case('fiverr')
                <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23 9.25h-9.37c.057-.487.258-.876.604-1.167.346-.29.864-.436 1.554-.436h1.1V4.5h-1.47c-1.83 0-3.29.52-4.35 1.56-1.06 1.04-1.6 2.47-1.62 4.29v.9H7v3.25h2.43V24H13V14.5h4.6V24h3.61V14.5H23V9.25zM6.03 8.75a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/></svg>
                @break
            @case('upwork')
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.56 5.53c-2.5 0-4.21 1.62-4.9 4.2-.79-1.2-1.4-2.62-1.79-3.83H9.4v5.02a2.16 2.16 0 0 1-4.32 0V5.9H2.6v5.02A4.66 4.66 0 0 0 7.24 15.6a4.66 4.66 0 0 0 4.64-4.68V9.4c.37.75.82 1.55 1.36 2.26l-1.16 5.45h2.53l.83-3.94c.73.47 1.57.75 2.55.75 2.72 0 4.94-2.24 4.94-5.2 0-2.97-2.22-5.2-4.94-5.2zm0 7.87c-.98 0-1.9-.42-2.65-1.1l.24-1.03v-.02c.17-1.02.72-2.72 2.41-2.72 1.27 0 2.3 1.05 2.3 2.44 0 1.4-1.03 2.44-2.3 2.44z"/></svg>
                @break
        @endswitch
    </a>
@endforeach
