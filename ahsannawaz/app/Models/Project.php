<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Project extends Model
{
    protected $fillable = [
        'title', 'description', 'image', 'tech_stack',
        'live_url', 'github_url', 'category',
        'is_featured', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'tech_stack'  => 'array',
        'is_featured' => 'boolean',
        'is_active'   => 'boolean',
        'sort_order'  => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderByDesc('is_featured');
    }

    /**
     * Category-appropriate stand-ins used until a real cover is uploaded.
     * Several per category so a grid of placeholders doesn't repeat one photo.
     */
    private const PLACEHOLDERS = [
        'web' => [
            'photo-1467232004584-a241de8bcf5d',
            'photo-1460925895917-afdab827c52f',
            'photo-1547658719-da2b51169166',
            'photo-1481487196290-c152efe083f5',
        ],
        'mobile' => [
            'photo-1512941937669-90a1b58e7e9c',
            'photo-1526498460520-4c246339dccb',
            'photo-1607252650355-f7fd0460ccdb',
        ],
        'api' => [
            'photo-1558494949-ef010cbdcc31',
            'photo-1518770660439-4636190af475',
            'photo-1544197150-b99a580bb7a8',
        ],
        'wordpress' => [
            'photo-1499750310107-5fef28a66643',
            'photo-1432888622747-4eb9a8efeb07',
            'photo-1486312338219-ce68d2c6f44d',
        ],
    ];

    public function getImageUrlAttribute(): string
    {
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            // asset() resolves against the current host, so images load on any port.
            return asset('storage/' . $this->image);
        }

        return $this->placeholderUrl(1200);
    }

    /**
     * Deterministic per-project placeholder — the same project always gets the
     * same photo, so the grid stays stable between page loads.
     */
    public function placeholderUrl(int $width = 1200): string
    {
        $set = self::PLACEHOLDERS[$this->category] ?? self::PLACEHOLDERS['web'];

        // Hash the title rather than the id — sequential ids in one category
        // share a parity and would keep landing on the same photo.
        $photo = $set[crc32((string) $this->title) % count($set)];

        return "https://images.unsplash.com/{$photo}?w={$width}&q=80&auto=format&fit=crop";
    }

    public function getHasRealImageAttribute(): bool
    {
        return (bool) ($this->image && Storage::disk('public')->exists($this->image));
    }
}
