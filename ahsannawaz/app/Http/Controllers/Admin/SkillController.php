<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::ordered()->get()->groupBy('category');
        return view('admin.skills.index', compact('skills'));
    }

    public function create()
    {
        return view('admin.skills.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'             => 'required|string|max:100',
            'category'         => 'required|in:backend,frontend,cms,database,tools',
            'percentage'       => 'required|integer|min:1|max:100',
            'level'            => 'required|in:expert,advanced,good',
            'icon'             => 'required|string|max:10',
            'color'            => 'required|string|max:20',
            'color_gradient'   => 'required|string|max:200',
            'sort_order'       => 'nullable|integer|min:0',
            'is_active'        => 'nullable|boolean',
        ]);

        $data['is_active']   = $request->boolean('is_active', true);
        $data['sort_order']  = $data['sort_order'] ?? 0;

        Skill::create($data);

        return redirect()->route('admin.skills.index')
            ->with('success', "Skill \"{$data['name']}\" created successfully!");
    }

    public function edit(Skill $skill)
    {
        return view('admin.skills.edit', compact('skill'));
    }

    public function update(Request $request, Skill $skill)
    {
        $data = $request->validate([
            'name'             => 'required|string|max:100',
            'category'         => 'required|in:backend,frontend,cms,database,tools',
            'percentage'       => 'required|integer|min:1|max:100',
            'level'            => 'required|in:expert,advanced,good',
            'icon'             => 'required|string|max:10',
            'color'            => 'required|string|max:20',
            'color_gradient'   => 'required|string|max:200',
            'sort_order'       => 'nullable|integer|min:0',
            'is_active'        => 'nullable|boolean',
        ]);

        $data['is_active']  = $request->boolean('is_active', true);
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $skill->update($data);

        return redirect()->route('admin.skills.index')
            ->with('success', "Skill \"{$skill->name}\" updated successfully!");
    }

    public function destroy(Skill $skill)
    {
        $name = $skill->name;
        $skill->delete();
        return redirect()->route('admin.skills.index')
            ->with('success', "Skill \"{$name}\" deleted successfully!");
    }

    public function toggleActive(Skill $skill)
    {
        $skill->update(['is_active' => !$skill->is_active]);
        return response()->json(['is_active' => $skill->is_active]);
    }

    /**
     * Delete several skills at once from the index checkboxes.
     */
    public function bulkDestroy(Request $request)
    {
        $data = $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'integer|exists:skills,id',
        ], [
            'ids.required' => 'Select at least one skill to delete.',
        ]);

        $count = Skill::whereIn('id', $data['ids'])->count();
        Skill::whereIn('id', $data['ids'])->delete();

        return redirect()->route('admin.skills.index')
            ->with('success', $count . ' ' . Str::plural('skill', $count) . ' deleted successfully!');
    }
}
