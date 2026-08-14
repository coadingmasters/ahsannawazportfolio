@extends('admin.layout')
@section('title', 'New Post')
@section('heading', 'New Post')
@section('crumb', 'Blog / Create')
@section('content')
    <div class="card" style="max-width:900px">
        <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data">
            @include('admin.posts._form')
        </form>
    </div>
@endsection
