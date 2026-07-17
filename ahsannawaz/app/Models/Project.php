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

    public function getImageUrlAttribute(): string
    {
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            // asset() resolves against the current host, so images load on any port.
            return asset('storage/' . $this->image);
        }
        return 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=600&q=80';
    }
}
