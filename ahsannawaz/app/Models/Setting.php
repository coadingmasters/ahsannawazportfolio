<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    private const CACHE_PREFIX = 'setting:';

    protected static function booted(): void
    {
        // Any write invalidates that key's cache.
        static::saved(fn (Setting $s) => Cache::forget(self::CACHE_PREFIX . $s->key));
        static::deleted(fn (Setting $s) => Cache::forget(self::CACHE_PREFIX . $s->key));
    }

    /**
     * Read a setting. Cached because these are hit on every public page.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::rememberForever(
            self::CACHE_PREFIX . $key,
            fn () => static::where('key', $key)->value('value')
        ) ?? $default;
    }

    public static function put(string $key, ?string $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public static function forget(string $key): void
    {
        static::where('key', $key)->delete();
        Cache::forget(self::CACHE_PREFIX . $key);
    }
}
