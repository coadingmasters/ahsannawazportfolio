<?php

namespace App\Support;

use HTMLPurifier;
use HTMLPurifier_Config;
use Illuminate\Support\Str;

class PostHtml
{
    /**
     * Clean the HTML an article was written with.
     *
     * The editor is a contenteditable field, so whatever a browser (or a
     * paste from Word) produces can arrive here. Everything is run through
     * an allowlist on save: what is stored is already safe, so the article
     * template can print it without escaping.
     */
    public static function clean(?string $html): string
    {
        if (blank($html)) {
            return '';
        }

        $config = HTMLPurifier_Config::createDefault();
        $config->set('Cache.SerializerPath', storage_path('framework/cache'));

        $config->set('HTML.Allowed', implode(',', [
            'p', 'br', 'strong', 'b', 'em', 'i', 'u', 's',
            'h2', 'h3', 'h4',
            'ul', 'ol', 'li',
            'blockquote', 'pre', 'code',
            'a[href|title|target|rel]',
            'img[src|alt|width|height|loading]',
            'hr',
        ]));

        // Outbound links open in a new tab and must not pass along referrer
        // trust — added here rather than trusted from the editor's markup.
        $config->set('HTML.TargetBlank', true);
        $config->set('HTML.Nofollow', false);
        $config->set('AutoFormat.RemoveEmpty', true);
        $config->set('AutoFormat.AutoParagraph', false);

        return trim((new HTMLPurifier($config))->purify($html));
    }

    /** Plain text for meta descriptions and card excerpts. */
    public static function toText(?string $html, int $limit = 160): string
    {
        return Str::limit(
            trim(preg_replace('/\s+/', ' ', strip_tags((string) $html))),
            $limit
        );
    }
}
