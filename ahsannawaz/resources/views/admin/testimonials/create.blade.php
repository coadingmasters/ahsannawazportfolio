@extends('admin.layout')
@section('title', 'New Testimonial')
@section('heading', 'New Testimonial')
@section('crumb', 'Testimonials / Create')
@section('content')
    <div class="card" style="max-width:820px">
        <form method="POST" action="{{ route('admin.testimonials.store') }}" enctype="multipart/form-data">
            @include('admin.testimonials._form')
        </form>
    </div>
@endsection
