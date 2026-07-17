@extends('admin.layout')

@section('title', 'Edit Project')
@section('heading', 'Edit Project')
@section('crumb', 'Projects / ' . $project->title)

@section('content')
    <div class="card" style="max-width:820px">
        <form method="POST" action="{{ route('admin.projects.update', $project) }}" enctype="multipart/form-data">
            @include('admin.projects._form', ['project' => $project])
        </form>
    </div>
@endsection
