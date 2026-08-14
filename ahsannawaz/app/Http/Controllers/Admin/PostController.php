<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Support\PostHtml;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        return view('admin.posts.index', [
            'posts' => Post::latestFirst()->paginate(15),
        ]);
    }

    public function create()
    {
        return view('admin.posts.create', ['post' => new Post(['is_published' => true])]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['image'] = $this->storeImage($request);

        Post::create($data);

        return redirect()->route('admin.posts.index')->with('success', 'Post published.');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $data = $this->validated($request, $post);

        if ($image = $this->storeImage($request)) {
            $this->deleteImage($post->image);
            $data['image'] = $image;
        }

        $post->update($data);

        return redirect()->route('admin.posts.index')->with('success', 'Post updated.');
    }

    public function destroy(Post $post)
    {
        $this->deleteImage($post->image);
        $post->delete();

        return back()->with('success', 'Post deleted.');
    }

    public function toggleActive(Post $post)
    {
        $post->update(['is_published' => ! $post->is_published]);

        return response()->json(['is_active' => $post->is_published]);
    }

    private function validated(Request $request, ?Post $post = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'slug' => ['nullable', 'string', 'max:200', 'unique:posts,slug'.($post ? ",{$post->id}" : '')],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['required', 'string'],
            'category' => ['required', 'string', 'max:40'],
            'read_minutes' => ['required', 'integer', 'min:1', 'max:60'],
            'published_at' => ['nullable', 'date'],
            'image' => ['nullable', 'image', 'max:4096'],
        ]);

        $data['slug'] = Str::slug($data['slug'] ?: $data['title']);

        // The body arrives as HTML from the editor, so it is sanitised here.
        // Storing it already clean means the article template can print it
        // without escaping, and nothing unsafe is ever written to the table.
        $data['body'] = PostHtml::clean($data['body']);
        $data['excerpt'] = $data['excerpt'] ?: PostHtml::toText($data['body'], 180);
        $data['is_published'] = $request->boolean('is_published');
        $data['published_at'] = $data['published_at'] ?? now();
        unset($data['image']);

        return $data;
    }

    private function storeImage(Request $request): ?string
    {
        return $request->hasFile('image')
            ? $request->file('image')->store('posts', 'public')
            : null;
    }

    private function deleteImage(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
