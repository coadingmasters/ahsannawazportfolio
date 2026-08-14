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
}
