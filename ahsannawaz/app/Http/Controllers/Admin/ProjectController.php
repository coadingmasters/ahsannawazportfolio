<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::ordered()->get();
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:200',
            'description' => 'required|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tech_stack'  => 'nullable|string',
            'live_url'    => 'nullable|url|max:500',
            'github_url'  => 'nullable|url|max:500',
            'category'    => 'required|in:web,mobile,api,wordpress',
            'is_featured' => 'nullable|boolean',
            'sort_order'  => 'nullable|integer|min:0',
            'is_active'   => 'nullable|boolean',
        ]);

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active']   = $request->boolean('is_active', true);
        $data['sort_order']  = $data['sort_order'] ?? 0;
        $data['tech_stack']  = $this->parseTechStack($request->tech_stack);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('projects', 'public');
        }

        Project::create($data);

        return redirect()->route('admin.projects.index')
            ->with('success', "Project \"{$data['title']}\" created successfully!");
    }

    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:200',
            'description' => 'required|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tech_stack'  => 'nullable|string',
            'live_url'    => 'nullable|url|max:500',
            'github_url'  => 'nullable|url|max:500',
            'category'    => 'required|in:web,mobile,api,wordpress',
            'is_featured' => 'nullable|boolean',
            'sort_order'  => 'nullable|integer|min:0',
            'is_active'   => 'nullable|boolean',
        ]);

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active']   = $request->boolean('is_active', true);
        $data['sort_order']  = $data['sort_order'] ?? 0;
        $data['tech_stack']  = $this->parseTechStack($request->tech_stack);

        if ($request->hasFile('image')) {
            // Remove old image
            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }
            $data['image'] = $request->file('image')->store('projects', 'public');
        }

        $project->update($data);

        return redirect()->route('admin.projects.index')
            ->with('success', "Project \"{$project->title}\" updated successfully!");
    }

    public function destroy(Project $project)
    {
        if ($project->image) {
            Storage::disk('public')->delete($project->image);
        }
        $title = $project->title;
        $project->delete();
        return redirect()->route('admin.projects.index')
            ->with('success', "Project \"{$title}\" deleted successfully!");
    }

    public function toggleActive(Project $project)
    {
        $project->update(['is_active' => !$project->is_active]);
        return response()->json(['is_active' => $project->is_active]);
    }

    /**
     * Delete several projects at once from the index checkboxes.
     */
    public function bulkDestroy(Request $request)
    {
        $data = $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'integer|exists:projects,id',
        ], [
            'ids.required' => 'Select at least one project to delete.',
        ]);

        $projects = Project::whereIn('id', $data['ids'])->get();

        foreach ($projects as $project) {
            // Don't orphan the uploaded cover images.
            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }
            $project->delete();
        }

        $count = $projects->count();

        return redirect()->route('admin.projects.index')
            ->with('success', $count . ' ' . Str::plural('project', $count) . ' deleted successfully!');
    }

    private function parseTechStack(?string $input): array
    {
        if (!$input) return [];
        return array_values(array_filter(array_map('trim', explode(',', $input))));
    }
}
