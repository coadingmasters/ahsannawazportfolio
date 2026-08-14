<?php

namespace App\Support;

class Asset
{
    /**
     * Resolve a public asset to its cache-busted URL, preferring the minified
     * build when one exists.
     *
     * Two problems this solves:
     *
     * 1. Hostinger's CDN caches assets for seven days, so without a version
     *    stamp a deploy leaves visitors on the previous file.
     * 2. `build-assets.mjs` writes minified copies to public/dist. Those are
     *    used only when they are at least as new as the source, so editing a
     *    stylesheet during development still shows up without a rebuild.
     */
    public static function url(string $path): string
    {
        $source = public_path($path);
        $minified = public_path('dist/'.$path);

        $useMin = is_file($minified)
            && is_file($source)
            && filemtime($minified) >= filemtime($source);

        $file = $useMin ? $minified : $source;
        $public = $useMin ? 'dist/'.$path : $path;

        return asset($public).(is_file($file) ? '?v='.filemtime($file) : '');
    }

    /**
     * Inline a page's above-the-fold CSS and fetch the rest without blocking.
     *
     * The critical file is produced by build-critical.mjs from what the browser
     * actually paints in the first screen. Inlining it means the first paint
     * needs no stylesheet request at all; the full bundle then arrives via
     * preload and upgrades itself to a stylesheet once it lands.
     */
    public static function pageStyles(string $page): string
    {
        $bundle = self::url("dist/css/page-{$page}.css");
        $critical = public_path("dist/css/critical-{$page}.css");

        // No critical file means we cannot safely defer: loading the bundle
        // asynchronously without inlined styles would show an unstyled page
        // first. Fall back to a normal blocking link instead.
        if (! is_file($critical)) {
            return '<link rel="stylesheet" href="'.e($bundle).'">';
        }

        return '<style id="critical-css">'.file_get_contents($critical).'</style>'
            .'<link rel="preload" as="style" href="'.e($bundle).'"'
            .' onload="this.onload=null;this.rel=\'stylesheet\'">'
            // Without JS the preload never upgrades, so state the plain link too.
            .'<noscript><link rel="stylesheet" href="'.e($bundle).'"></noscript>';
    }
}
