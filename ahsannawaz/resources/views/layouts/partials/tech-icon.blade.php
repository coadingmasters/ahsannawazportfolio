{{-- ============================================
     TECH ICON
     Real brand marks instead of emoji. Matching is on the skill name, so
     the admin panel stays the source of truth; anything unrecognised falls
     back to a lettermark badge rather than a broken or generic image.

     @include('layouts.partials.tech-icon', ['name' => $skill->name])
============================================ --}}

@php
    $key = strtolower(preg_replace('/[^a-z0-9]/i', '', $name));
    // Fold the variants people actually type in the admin panel.
    $alias = [
        'laravel' => 'laravel', 'php' => 'php',
        'javascript' => 'js', 'js' => 'js', 'vanillajs' => 'js',
        'mysql' => 'mysql', 'mariadb' => 'mysql',
        'html5css3' => 'html', 'html5' => 'html', 'html' => 'html',
        'css3' => 'css', 'css' => 'css',
        'bootstrap' => 'bootstrap',
        'tailwindcss' => 'tailwind', 'tailwind' => 'tailwind',
        'reactjs' => 'react', 'react' => 'react',
        'jquery' => 'jquery',
        'gitgithub' => 'git', 'git' => 'git', 'github' => 'git',
        'wordpress' => 'wordpress',
        'docker' => 'docker',
        'postman' => 'postman',
        'vscode' => 'vscode', 'visualstudiocode' => 'vscode',
        'restapi' => 'api', 'api' => 'api',
        'composernpm' => 'npm', 'npm' => 'npm', 'composer' => 'npm',
        'mongodb' => 'mongo',
        'awscpanel' => 'cloud', 'aws' => 'cloud',
        'dbdesign' => 'db', 'databasedesign' => 'db',
        'plugindev' => 'plugin', 'plugindevelopment' => 'plugin',
        'themedev' => 'theme', 'themedevelopment' => 'theme',
    ];
    $icon = $alias[$key] ?? null;
@endphp

@switch($icon)
    @case('laravel')
        <svg viewBox="0 0 24 24" fill="#FF2D20" aria-hidden="true"><path d="M23.64 6.55a.42.42 0 0 1 .01.11v5.66c0 .08-.04.15-.11.19l-4.4 2.53v5.43c0 .08-.04.15-.11.19l-9.18 5.29a.4.4 0 0 1-.21 0l-.02-.01-9.17-5.28A.22.22 0 0 1 .34 20.5V3.52c0-.04 0-.08.02-.11a.2.2 0 0 1 .03-.06l.04-.04.05-.03 4.6-2.65a.22.22 0 0 1 .22 0l4.59 2.65h.01l.04.04.03.05.02.06.01.06v10.6l3.83-2.2V6.66c0-.04 0-.08.02-.11l.03-.06.04-.04.05-.03 4.59-2.65a.22.22 0 0 1 .22 0l4.59 2.65.05.03.04.05zM22.8 12.1V7.32l-1.6.93-2.22 1.28v4.78l3.83-2.2zM17.9 19.9v-4.78l-2.18 1.25-6.23 3.55v4.83l8.41-4.85zM1.2 4.28v15.97l8.4 4.84v-4.83l-4.4-2.48-.04-.03-.04-.04-.03-.05-.01-.06V6.5L2.8 5.2 1.2 4.28zm4.03-2.6L1.4 3.9l3.83 2.2 3.82-2.2-3.82-2.21zm1.99 13.72 2.22-1.28V4.28L7.83 5.21 5.62 6.49v10.12l1.6-.93zM18.5 4.48l-3.83 2.2 3.83 2.21 3.82-2.2-3.82-2.21zm-.43 5.15-2.21-1.28-1.6-.93v4.78l2.21 1.28 1.6.92V9.63zM10.02 19.5l5.6-3.2 2.79-1.6-3.82-2.2-4.4 2.54-4.01 2.31 3.84 2.15z"/></svg>
        @break
    @case('php')
        <svg viewBox="0 0 24 24" fill="#777BB4" aria-hidden="true"><path d="M12 5.5C5.37 5.5 0 8.4 0 12s5.37 6.5 12 6.5S24 15.6 24 12 18.63 5.5 12 5.5zM6.9 14.6H5.6l-.4 2H3.9l1.3-6.6h2.6c1.3 0 2 .7 1.8 1.9-.2 1.6-1.2 2.7-2.7 2.7zm5.3-2.3-.6 3.1h-1.3l1.3-6.6h1.3l-.4 1.8h1.2c1.2 0 1.7.6 1.5 1.6l-.6 3.2h-1.3l.6-3c.1-.5 0-.7-.5-.7h-1.2zm7.3 2.3h-1.3l-.4 2h-1.3l1.3-6.6h2.6c1.3 0 2 .7 1.8 1.9-.2 1.6-1.2 2.7-2.7 2.7zM6.6 11.3h-.9l-.4 2.2h.8c.8 0 1.3-.4 1.4-1.2.1-.7-.2-1-.9-1zm12.6 0h-.9l-.4 2.2h.8c.8 0 1.3-.4 1.4-1.2.1-.7-.2-1-.9-1z"/></svg>
        @break
    @case('js')
        <svg viewBox="0 0 24 24" aria-hidden="true"><rect width="24" height="24" rx="3" fill="#F7DF1E"/><path d="M6.5 18.4l1.7-1c.33.58.63 1.08 1.35 1.08.69 0 1.13-.27 1.13-1.32v-7.1h2.09v7.13c0 2.16-1.27 3.15-3.12 3.15-1.67 0-2.64-.87-3.13-1.92zm7.4-.22 1.7-.98c.45.73 1.03 1.27 2.06 1.27.87 0 1.42-.43 1.42-1.03 0-.71-.57-.97-1.52-1.38l-.52-.23c-1.5-.64-2.5-1.44-2.5-3.14 0-1.56 1.19-2.74 3.04-2.74 1.32 0 2.27.46 2.95 1.66l-1.62.04c-.35-.63-.73-.88-1.33-.88-.61 0-1 .39-1 .88 0 .62.39.87 1.28 1.26l.52.22c1.77.76 2.77 1.53 2.77 3.28 0 1.87-1.47 2.9-3.45 2.9-1.93 0-3.18-.92-3.8-2.13z" fill="#111"/></svg>
        @break
    @case('mysql')
        <svg viewBox="0 0 24 24" fill="#00758F" aria-hidden="true"><path d="M12 2.2c-4.9 0-8.9 1.6-8.9 3.6v12.4c0 2 4 3.6 8.9 3.6s8.9-1.6 8.9-3.6V5.8c0-2-4-3.6-8.9-3.6zm0 1.6c4.2 0 7.3 1.2 7.3 2s-3.1 2-7.3 2-7.3-1.2-7.3-2 3.1-2 7.3-2zM4.7 8.1c1.6.9 4.2 1.4 7.3 1.4s5.7-.5 7.3-1.4v3c0 .8-3.1 2-7.3 2s-7.3-1.2-7.3-2v-3zm0 5.2c1.6.9 4.2 1.4 7.3 1.4s5.7-.5 7.3-1.4v3c0 .8-3.1 2-7.3 2s-7.3-1.2-7.3-2v-3z"/></svg>
        @break
    @case('html')
        <svg viewBox="0 0 24 24" fill="#E34F26" aria-hidden="true"><path d="M3 2l1.6 18L12 22l7.4-2L21 2H3zm14.4 5.6H8.2l.2 2.3h8.8l-.6 7-4.6 1.3-4.6-1.3-.3-3.5h2.2l.2 1.8 2.5.7 2.5-.7.3-3H6.9l-.6-6.8h11.3l-.2 2.2z"/></svg>
        @break
    @case('css')
        <svg viewBox="0 0 24 24" fill="#1572B6" aria-hidden="true"><path d="M3 2l1.6 18L12 22l7.4-2L21 2H3zm14.7 5.6H8.4l.2 2.2h8.9l-.6 7L12 18.1l-4.9-1.3-.3-3.6h2.2l.2 1.8 2.8.8 2.8-.8.3-3.1H6.7l-.6-6.5h11.8l-.2 2.2z"/></svg>
        @break
    @case('bootstrap')
        <svg viewBox="0 0 24 24" fill="#7952B3" aria-hidden="true"><path d="M4.2 2h15.6A2.2 2.2 0 0 1 22 4.2v15.6a2.2 2.2 0 0 1-2.2 2.2H4.2A2.2 2.2 0 0 1 2 19.8V4.2A2.2 2.2 0 0 1 4.2 2zm4 4.7v10.6h4.6c2.4 0 3.9-1.2 3.9-3.1 0-1.5-1-2.6-2.5-2.7v-.1c1.1-.2 1.9-1.2 1.9-2.4 0-1.7-1.3-2.8-3.4-2.8H8.2zm2.1 1.7h1.9c1.1 0 1.7.5 1.7 1.4s-.7 1.5-1.9 1.5h-1.7V8.4zm0 4.2h2c1.3 0 2 .6 2 1.6s-.7 1.6-2 1.6h-2v-3.2z"/></svg>
        @break
    @case('tailwind')
        <svg viewBox="0 0 24 24" fill="#06B6D4" aria-hidden="true"><path d="M12 6c-2.7 0-4.3 1.3-5 4 1-1.3 2.2-1.8 3.5-1.5.75.19 1.29.73 1.88 1.33.97.98 2.09 2.12 4.62 2.12 2.7 0 4.3-1.3 5-4-1 1.3-2.2 1.8-3.5 1.5-.75-.19-1.29-.73-1.88-1.33C15.65 7.14 14.53 6 12 6zM7 12c-2.7 0-4.3 1.3-5 4 1-1.3 2.2-1.8 3.5-1.5.75.19 1.29.73 1.88 1.33.97.98 2.09 2.12 4.62 2.12 2.7 0 4.3-1.3 5-4-1 1.3-2.2 1.8-3.5 1.5-.75-.19-1.29-.73-1.88-1.33C10.65 13.14 9.53 12 7 12z"/></svg>
        @break
    @case('react')
        <svg viewBox="0 0 24 24" fill="none" stroke="#61DAFB" stroke-width="1.1" aria-hidden="true"><circle cx="12" cy="12" r="2" fill="#61DAFB" stroke="none"/><ellipse cx="12" cy="12" rx="10" ry="4"/><ellipse cx="12" cy="12" rx="10" ry="4" transform="rotate(60 12 12)"/><ellipse cx="12" cy="12" rx="10" ry="4" transform="rotate(120 12 12)"/></svg>
        @break
    @case('jquery')
        <svg viewBox="0 0 24 24" fill="#0769AD" aria-hidden="true"><path d="M2.6 6.3c-1.6 3.7-.9 8 1.9 11.1 3.5 3.9 9 4.6 13 2.1-3.5 1-7.4-.1-9.9-2.9C4.8 13.5 4.4 9.4 6 6c-1.3.9-2.6 0-3.4.3zm4.7-2.9c-1.2 3-.4 6.4 1.9 8.9 2.8 3.1 7.2 3.7 10.4 1.7-2.8.8-5.9-.1-7.9-2.3-1.9-2.1-2.4-5-1.4-7.5-1 .3-2.1-.4-3-.8zM12.6 1c-.7 2 .1 4.2 1.8 5.7 1.8 1.6 4.3 1.8 6.2.7-1.6.3-3.3-.2-4.5-1.4-1.2-1.2-1.6-2.9-1.2-4.4-.8.1-1.6-.3-2.3-.6z"/></svg>
        @break
    @case('git')
        <svg viewBox="0 0 24 24" fill="#F05032" aria-hidden="true"><path d="M23.5 11 13 .5a1.7 1.7 0 0 0-2.4 0L8.4 2.7l2.8 2.8a2 2 0 0 1 2.6 2.6l2.7 2.7a2 2 0 1 1-1.2 1.1l-2.5-2.5v6.6a2 2 0 1 1-1.7-.1V8.4a2 2 0 0 1-1.1-2.6L7.2 3.9.5 10.6a1.7 1.7 0 0 0 0 2.4L11 23.5a1.7 1.7 0 0 0 2.4 0l10-10a1.7 1.7 0 0 0 .1-2.5z"/></svg>
        @break
    @case('wordpress')
        <svg viewBox="0 0 24 24" fill="#21759B" aria-hidden="true"><path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20zM3.1 12c0-1.3.3-2.5.8-3.6l4.3 11.8A8.9 8.9 0 0 1 3.1 12zM12 20.9c-.9 0-1.7-.1-2.5-.4l2.6-7.6 2.7 7.4v.1c-.9.3-1.8.5-2.8.5zm1.2-13.1c.5 0 1-.1 1-.1.5-.1.4-.8-.1-.8 0 0-1.4.1-2.3.1-.8 0-2.3-.1-2.3-.1-.5 0-.5.7 0 .8 0 0 .5.1.9.1l1.3 3.6-1.9 5.6-3.1-9.2c.5 0 1-.1 1-.1.5-.1.4-.8-.1-.8 0 0-1.4.1-2.3.1h-.6A8.9 8.9 0 0 1 16.6 4.4h-.3c-.9 0-1.6.8-1.6 1.7 0 .8.5 1.4.9 2.2.4.6.8 1.4.8 2.6 0 .8-.3 1.8-.7 3.1l-.9 3-3.3-9.7c.5 0 .9-.1.9-.1zM20.6 8a8.9 8.9 0 0 1-1.4 9.4l2.7-7.9c.5-1.3.7-2.3.7-3.2 0-.3 0-.6-.1-.9.4.8.7 1.7.9 2.6z"/></svg>
        @break
    @case('docker')
        <svg viewBox="0 0 24 24" fill="#2496ED" aria-hidden="true"><path d="M13.9 10.2h2.4v-2.2h-2.4v2.2zm-3 0h2.4v-2.2h-2.4v2.2zm0-2.9h2.4V5.1h-2.4v2.2zm-3 2.9h2.4v-2.2H7.9v2.2zm-3 0h2.4v-2.2H4.9v2.2zm12 0h2.4v-2.2h-2.4v2.2zM23 11.2c-.5-.35-1.7-.5-2.6-.3-.1-.9-.6-1.7-1.4-2.3l-.5-.35-.35.5c-.45.7-.6 1.85-.15 2.6-.25.1-.6.25-1.1.25H1.2c-.2.9-.2 5.8 3.2 8 2.6 1.7 5.7 2 8.2 1.4 4.4-1.05 6.6-4 7.9-7.35.6.05 1.9.05 2.5-1.15.1-.15.35-.6.5-1.05l-.5-.25z"/></svg>
        @break
    @case('postman')
        <svg viewBox="0 0 24 24" fill="#FF6C37" aria-hidden="true"><path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20zm3.9 5.4c.4.4.4 1 0 1.4l-1.2 1.2 1.1 1.1c.3.3.3.7 0 1l-.6.6-1.5-1.5-3.6 3.6c-.5.5-1.3.6-1.9.2l-.5-.3 1-1c.2-.2.2-.5 0-.7s-.5-.2-.7 0l-1 1-.3-.5c-.4-.6-.3-1.4.2-1.9l6-6c.4-.4 1-.4 1.4 0l1.6.8z"/></svg>
        @break
    @case('vscode')
        <svg viewBox="0 0 24 24" fill="#007ACC" aria-hidden="true"><path d="M17.6 1.3 8.9 9.4 4.6 6.1l-1.8.9 3.6 5-3.6 5 1.8.9 4.3-3.3 8.7 8.1L22 20V4l-4.4-2.7zm.3 5.2v11l-5.9-5.5 5.9-5.5z"/></svg>
        @break
    @case('npm')
        <svg viewBox="0 0 24 24" fill="#CB3837" aria-hidden="true"><path d="M2 2v20h20V2H2zm17 17h-3V7H9v12H5V5h14v14z"/></svg>
        @break
    @case('mongo')
        <svg viewBox="0 0 24 24" fill="#47A248" aria-hidden="true"><path d="M12 1.5s-1.1 2.6-3.1 5C6.5 9.4 5.8 11.4 6 14c.3 3.4 3 5.9 5.2 6.6l.3 1.9h1l.3-1.9c2.2-.7 4.9-3.2 5.2-6.6.2-2.6-.5-4.6-2.9-7.5-2-2.4-3.1-5-3.1-5zm.5 17.8V6.2c.6 1 1.6 2.4 2.4 3.9 1.1 2.1 1.3 3.5 1.1 5.3-.2 2.1-1.8 3.4-3.5 3.9z"/></svg>
        @break
    @case('api')
        <svg viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><path d="M10 13a5 5 0 0 0 7.5.5l3-3a5 5 0 0 0-7-7l-1.7 1.7"/><path d="M14 11a5 5 0 0 0-7.5-.5l-3 3a5 5 0 0 0 7 7l1.7-1.7"/></svg>
        @break
    @case('db')
        <svg viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="1.8" aria-hidden="true"><ellipse cx="12" cy="5.5" rx="7.5" ry="3"/><path d="M4.5 5.5v13c0 1.66 3.36 3 7.5 3s7.5-1.34 7.5-3v-13"/><path d="M4.5 12c0 1.66 3.36 3 7.5 3s7.5-1.34 7.5-3"/></svg>
        @break
    @case('plugin')
        <svg viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="1.8" stroke-linejoin="round" aria-hidden="true"><path d="M10 3v3M14 3v3M6 8h12v6a5 5 0 0 1-5 5h-2a5 5 0 0 1-5-5V8zM12 19v3"/></svg>
        @break
    @case('theme')
        <svg viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="1.8" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 9h18M8 9v11"/></svg>
        @break
    @case('cloud')
        <svg viewBox="0 0 24 24" fill="none" stroke="var(--accent)" stroke-width="1.8" stroke-linejoin="round" aria-hidden="true"><path d="M17.5 19a4.5 4.5 0 0 0 .5-9 6 6 0 0 0-11.6-1.5A4 4 0 0 0 6.5 19z"/></svg>
        @break
    @default
        {{-- Unknown technology: a lettermark reads better than a generic glyph. --}}
        <span class="tech-letter" aria-hidden="true">{{ strtoupper(mb_substr($name, 0, 2)) }}</span>
@endswitch
