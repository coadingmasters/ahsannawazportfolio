<?php

namespace App\Support;

use App\Models\Project;
use App\Models\Skill;
use Illuminate\Support\Facades\Schema;

class SiteStats
{
    /**
     * The figures quoted anywhere on the site.
     *
     * Derived from real content where that is possible and from
     * config/profile.php where it is not, so a number cannot say one thing on
     * the homepage and another on the about page.
     */
    public static function all(): array
    {
        // Guard the table checks: migrations run before these tables exist.
        $projects = Schema::hasTable('projects') ? Project::where('is_active', true)->count() : 0;
        $skills = Schema::hasTable('skills') ? Skill::where('is_active', true)->get() : collect();

        return [
            'projects' => max($projects, (int) config('profile.min_projects')),
            'skills' => $skills->count(),
            'categories' => $skills->groupBy('category')->count(),
            'expert' => $skills->where('level', 'expert')->count(),
            'average' => (int) round($skills->avg('percentage') ?? 0),
            'years' => (int) config('profile.years_experience'),
            'clients' => (int) config('profile.happy_clients'),
            'satisfaction' => config('profile.client_satisfaction'),
            'support' => config('profile.support'),
        ];
    }
}
