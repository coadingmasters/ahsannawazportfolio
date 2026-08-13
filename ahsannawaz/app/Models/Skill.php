<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'name', 'category', 'percentage', 'level',
        'icon', 'color', 'color_gradient', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'percentage' => 'integer',
        'sort_order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    public function getLevelBadgeColorAttribute(): string
    {
        // Level is an ordered scale, so it wears the ordinal ramp. Returning the
        // token rather than a literal keeps it readable in the admin's dark mode,
        // where the ramp re-steps against the darker surface.
        return match ($this->level) {
            'expert' => 'var(--ramp-3)',
            'advanced' => 'var(--ramp-2)',
            'good' => 'var(--ramp-1)',
            default => 'var(--text-3)',
        };
    }
}
