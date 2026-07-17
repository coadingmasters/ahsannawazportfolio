@extends('admin.layout')

@section('title', 'Skills')
@section('heading', 'Skills')
@section('crumb', 'Manage the skills shown on your portfolio')

@section('actions')
    <a href="{{ route('admin.skills.create') }}" class="btn btn-primary btn-sm">+ New Skill</a>
@endsection

@section('content')

    @forelse ($skills as $category => $group)
        <div class="card" style="margin-bottom:1.25rem">
            <div class="card-head">
                <h2 style="text-transform:capitalize">{{ $category }}</h2>
                <span class="cat-tag">{{ $group->count() }} {{ Str::plural('skill', $group->count()) }}</span>
            </div>

            <div class="table-wrap">
                <table class="tbl">
                    <thead>
                        <tr>
                            <th>Skill</th>
                            <th>Level</th>
                            <th>Proficiency</th>
                            <th>Order</th>
                            <th>Active</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($group as $skill)
                            <tr>
                                <td>
                                    <span class="skill-ico">{{ $skill->icon }}</span>
                                    <strong>{{ $skill->name }}</strong>
                                </td>
                                <td>
                                    <span class="badge" style="color:{{ $skill->level_badge_color }}">
                                        {{ $skill->level }}
                                    </span>
                                </td>
                                <td>
                                    <div style="display:flex;align-items:center;gap:0.5rem">
                                        <div class="bar">
                                            <i style="width:{{ $skill->percentage }}%;background:{{ $skill->color_gradient }}"></i>
                                        </div>
                                        <span class="pct">{{ $skill->percentage }}%</span>
                                    </div>
                                </td>
                                <td style="color:var(--muted)">{{ $skill->sort_order }}</td>
                                <td>
                                    <div class="toggle {{ $skill->is_active ? 'on' : '' }}"
                                         data-toggle-url="{{ route('admin.skills.toggle', $skill) }}"
                                         title="Toggle active"></div>
                                </td>
                                <td>
                                    <div class="row-actions">
                                        <a href="{{ route('admin.skills.edit', $skill) }}" class="btn btn-ghost btn-sm">Edit</a>
                                        <form method="POST"
                                              action="{{ route('admin.skills.destroy', $skill) }}"
                                              data-confirm="Delete the skill &quot;{{ $skill->name }}&quot;? This cannot be undone.">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div class="card">
            <div class="empty">
                <div class="e-ico">⚡</div>
                <p>No skills yet. Add your first one to see it on the portfolio.</p>
                <a href="{{ route('admin.skills.create') }}" class="btn btn-primary btn-sm">+ New Skill</a>
            </div>
        </div>
    @endforelse

@endsection
