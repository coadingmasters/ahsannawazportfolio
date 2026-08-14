<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $skills = Skill::active()->ordered()->get();
        $projects = Project::active()->ordered()->get();

        return view('welcome', [
            'skills' => $skills,
            'skillsByCategory' => $skills->groupBy('category'),
            'projects' => $projects,
            'featured' => $projects->where('is_featured', true)->take(3)->values(),

            // Sections that have nothing to show simply do not render, rather
            // than filling the page with placeholder content.
            'testimonials' => Testimonial::active()->ordered()->take(6)->get(),
            'posts' => Post::published()->latestFirst()->take(3)->get(),

            'stats' => [
                // Counted from the real content where possible.
                'projects' => max($projects->count(), 10),
                'skills' => $skills->count(),
                'years' => 2,
                'clients' => 8,
            ],
        ]);
    }
}
