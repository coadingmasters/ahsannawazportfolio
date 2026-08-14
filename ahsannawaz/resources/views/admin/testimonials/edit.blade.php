@extends('admin.layout')
@section('title', 'Edit Testimonial')
@section('heading', 'Edit Testimonial')
@section('crumb', 'Testimonials / ' . $testimonial->name)
@section('content')
    <div class="card" style="max-width:820px">
        <form method="POST" action="{{ route('admin.testimonials.update', $testimonial) }}" enctype="multipart/form-data">
            @include('admin.testimonials._form')
        </form>
    </div>
@endsection
