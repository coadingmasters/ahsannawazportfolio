<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Models\Project;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_skills'    => Skill::count(),
            'active_skills'   => Skill::where('is_active', true)->count(),
            'total_projects'  => Project::count(),
            'active_projects' => Project::where('is_active', true)->count(),
            'featured'        => Project::where('is_featured', true)->count(),
        ];

        $recentProjects = Project::latest()->take(5)->get();
        $skillsByCategory = Skill::selectRaw('category, COUNT(*) as count')
            ->groupBy('category')
            ->pluck('count', 'category');

        return view('admin.dashboard', compact('stats', 'recentProjects', 'skillsByCategory'));
    }
}
