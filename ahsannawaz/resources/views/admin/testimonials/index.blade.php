@extends('admin.layout')
@section('title', 'Testimonials')
@section('heading', 'Testimonials')
@section('crumb', 'Client reviews shown on your homepage')
@section('actions')
    <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary btn-sm">+ New Testimonial</a>
@endsection

@section('content')
<div class="card">
    @if ($testimonials->isEmpty())
        <div class="empty">
            <div class="e-ico">❝</div>
            <p>No testimonials yet. The section stays hidden until you add one.</p>
            <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary btn-sm">+ Add a review</a>
        </div>
    @else
        <div class="table-wrap">
            <table class="tbl">
                <thead><tr><th>Client</th><th>Review</th><th>Rating</th><th>Source</th><th>Order</th><th>Live</th><th></th></tr></thead>
                <tbody>
                @foreach ($testimonials as $t)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:.6rem">
                                @if ($t->avatar_url)
                                    <img src="{{ $t->avatar_url }}" alt="" style="width:38px;height:38px;border-radius:50%;object-fit:cover">
                                @else
                                    <span class="avatar">{{ $t->initials }}</span>
                                @endif
                                <div>
                                    <div style="font-weight:600">{{ $t->name }}</div>
                                    <div style="font-size:.74rem;color:var(--muted)">{{ $t->role }}{{ $t->company ? ' · '.$t->company : '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="max-width:340px;font-size:.82rem;color:var(--muted)">
                            {{ Str::limit($t->quote, 110) }}
                        </td>
                        <td style="white-space:nowrap;color:var(--amber)">{{ str_repeat('★', $t->rating) }}</td>
                        <td>{{ $t->source ? '' : '—' }}<span class="cat-tag">{{ $t->source }}</span></td>
                        <td>{{ $t->sort_order }}</td>
                        <td>
                            <span class="toggle {{ $t->is_active ? 'on' : '' }}"
                                  data-toggle-url="{{ route('admin.testimonials.toggle', $t) }}"
                                  role="switch" aria-label="Visible"></span>
                        </td>
                        <td style="text-align:right;white-space:nowrap">
                            <a href="{{ route('admin.testimonials.edit', $t) }}" class="btn btn-ghost btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.testimonials.destroy', $t) }}" style="display:inline"
                                  data-confirm="Delete the review from <b>{{ $t->name }}</b>?">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
