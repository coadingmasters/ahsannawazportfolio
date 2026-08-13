<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    /** Skill levels, weakest first — the order the ordinal colour ramp follows. */
    private const LEVELS = ['good', 'advanced', 'expert'];

    public function index()
    {
        $skills = Skill::all();
        $projects = Project::all();

        $stats = [
            'total_skills' => $skills->count(),
            'active_skills' => $skills->where('is_active', true)->count(),
            'total_projects' => $projects->count(),
            'active_projects' => $projects->where('is_active', true)->count(),
            'featured' => $projects->where('is_featured', true)->count(),
            'unread' => ContactMessage::where('is_read', false)->count(),
            'messages' => ContactMessage::count(),
            'avg_percentage' => (int) round($skills->avg('percentage') ?? 0),
        ];

        // ── Skills per category, with the average proficiency of each group.
        // Nominal categories, so every bar wears the same accent hue; length
        // alone carries the magnitude.
        $skillsByCategory = $skills->groupBy('category')
            ->map(fn ($group, $category) => [
                'category' => $category,
                'count' => $group->count(),
                'avg' => (int) round($group->avg('percentage')),
            ])
            ->sortByDesc('count')
            ->values();

        // ── Proficiency mix. `level` is an ordered scale, so this is ordinal
        // and gets a single-hue ramp rather than categorical colours.
        $levelMix = collect(self::LEVELS)
            ->map(fn ($level) => [
                'level' => $level,
                'count' => $skills->where('level', $level)->count(),
            ])
            ->filter(fn ($row) => $row['count'] > 0)
            ->values();

        // ── Projects added per month over the last six months. Months with no
        // projects still appear, so the gaps in the timeline stay visible.
        $trend = collect(range(5, 0))->map(function ($back) use ($projects) {
            $month = Carbon::now()->startOfMonth()->subMonths($back);

            return [
                'label' => $month->format('M'),
                'full' => $month->format('F Y'),
                // Compare on Y-m rather than isSameMonth(), whose year-matching
                // default differs between Carbon versions.
                'count' => $projects->filter(
                    fn ($p) => $p->created_at?->format('Y-m') === $month->format('Y-m')
                )->count(),
            ];
        });

        // Running total across the same window — the "grown to" line.
        $running = 0;
        $trend = $trend->map(function ($row) use (&$running) {
            $running += $row['count'];
            $row['cumulative'] = $running;

            return $row;
        });

        $projectsByCategory = $projects->groupBy('category')
            ->map(fn ($group, $category) => [
                'category' => $category,
                'count' => $group->count(),
            ])
            ->sortByDesc('count')
            ->values();

        // ── Strongest skills, for the ranked bar list.
        $topSkills = $skills->sortByDesc('percentage')->take(6)->values();

        $recentProjects = Project::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentProjects',
            'skillsByCategory',
            'levelMix',
            'trend',
            'projectsByCategory',
            'topSkills'
        ));
    }
}
