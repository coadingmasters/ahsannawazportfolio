@extends('admin.layout')
@section('title', 'Blog')
@section('heading', 'Blog')
@section('crumb', 'Articles shown on your site')
@section('actions')
    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary btn-sm">+ New Post</a>
@endsection

@section('content')
<div class="card">
    @if ($posts->isEmpty())
        <div class="empty">
            <div class="e-ico">✎</div>
            <p>No posts yet. Your blog section stays hidden until you publish one.</p>
            <a href="{{ route('admin.posts.create') }}" class="btn btn-primary btn-sm">+ Write your first post</a>
        </div>
    @else
        <div class="table-wrap">
            <table class="tbl">
                <thead>
                    <tr><th>Post</th><th>Category</th><th>Date</th><th>Read</th><th>Live</th><th></th></tr>
                </thead>
                <tbody>
                @foreach ($posts as $post)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:.7rem">
                                @if ($post->image_url)
                                    <img src="{{ $post->image_url }}" alt="" class="thumb">
                                @endif
                                <div style="min-width:0">
                                    <div style="font-weight:600">{{ $post->title }}</div>
                                    <div style="font-size:.74rem;color:var(--muted)">/blog/{{ $post->slug }}</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="cat-tag">{{ $post->category }}</span></td>
                        <td style="white-space:nowrap">{{ $post->date_label }}</td>
                        <td>{{ $post->read_minutes }} min</td>
                        <td>
                            <span class="toggle {{ $post->is_published ? 'on' : '' }}"
                                  data-toggle-url="{{ route('admin.posts.toggle', $post) }}"
                                  role="switch" aria-label="Published"></span>
                        </td>
                        <td style="text-align:right;white-space:nowrap">
                            <a href="{{ route('post', $post) }}" target="_blank" rel="noopener" class="btn btn-ghost btn-sm">View</a>
                            <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-ghost btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" style="display:inline"
                                  data-confirm="Delete <b>{{ $post->title }}</b>? This cannot be undone.">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div style="margin-top:1rem">{{ $posts->links() }}</div>
    @endif
</div>
@endsection
