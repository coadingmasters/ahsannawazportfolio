@extends('admin.layout')

@section('title', 'New Project')
@section('heading', 'New Project')
@section('crumb', 'Projects / Create')

@section('content')
    <div class="card" style="max-width:820px">
        <form method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data">
            @include('admin.projects._form', ['project' => null])
        </form>
    </div>
@endsection
