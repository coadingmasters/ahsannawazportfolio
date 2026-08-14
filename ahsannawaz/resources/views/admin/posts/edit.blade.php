@extends('admin.layout')
@section('title', 'Edit Post')
@section('heading', 'Edit Post')
@section('crumb', 'Blog / ' . $post->title)
@section('content')
    <div class="card" style="max-width:900px">
        <form method="POST" action="{{ route('admin.posts.update', $post) }}" enctype="multipart/form-data">
            @include('admin.posts._form')
        </form>
    </div>
@endsection
