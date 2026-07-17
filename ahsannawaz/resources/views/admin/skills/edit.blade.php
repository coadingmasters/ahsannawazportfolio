@extends('admin.layout')

@section('title', 'Edit Skill')
@section('heading', 'Edit Skill')
@section('crumb', 'Skills / ' . $skill->name)

@section('content')
    <div class="card" style="max-width:820px">
        <form method="POST" action="{{ route('admin.skills.update', $skill) }}">
            @include('admin.skills._form', ['skill' => $skill])
        </form>
    </div>
@endsection
