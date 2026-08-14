<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index()
    {
        return view('admin.testimonials.index', [
            'testimonials' => Testimonial::ordered()->get(),
        ]);
    }

    public function create()
    {
        return view('admin.testimonials.create', ['testimonial' => new Testimonial(['rating' => 5, 'is_active' => true])]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        if ($avatar = $this->storeAvatar($request)) {
            $data['avatar'] = $avatar;
        }

        Testimonial::create($data);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial added.');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $data = $this->validated($request);

        if ($avatar = $this->storeAvatar($request)) {
            $this->deleteAvatar($testimonial->avatar);
            $data['avatar'] = $avatar;
        }

        $testimonial->update($data);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial updated.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $this->deleteAvatar($testimonial->avatar);
        $testimonial->delete();

        return back()->with('success', 'Testimonial deleted.');
    }

    public function toggleActive(Testimonial $testimonial)
    {
        $testimonial->update(['is_active' => ! $testimonial->is_active]);

        return response()->json(['is_active' => $testimonial->is_active]);
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'role' => ['nullable', 'string', 'max:120'],
            'company' => ['nullable', 'string', 'max:120'],
            'quote' => ['required', 'string', 'max:1000'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'source' => ['nullable', 'string', 'max:40'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;
        unset($data['avatar']);

        return $data;
    }

    private function storeAvatar(Request $request): ?string
    {
        return $request->hasFile('avatar')
            ? $request->file('avatar')->store('testimonials', 'public')
            : null;
    }

    private function deleteAvatar(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
