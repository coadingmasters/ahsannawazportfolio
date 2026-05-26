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
        return match ($this->level) {
            'expert'   => '#F97316',
            'advanced' => '#22d3ee',
            'good'     => '#4ade80',
            default    => '#94a3b8',
        };
    }
}
