@extends('admin.layout')

@section('title', 'New Skill')
@section('heading', 'New Skill')
@section('crumb', 'Skills / Create')

@section('content')
    <div class="card" style="max-width:820px">
        <form method="POST" action="{{ route('admin.skills.store') }}">
            @include('admin.skills._form', ['skill' => null])
        </form>
    </div>
@endsection
