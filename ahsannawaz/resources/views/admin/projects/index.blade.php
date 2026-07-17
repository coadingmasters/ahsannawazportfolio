@extends('admin.layout')

@section('title', 'Projects')
@section('heading', 'Projects')
@section('crumb', 'Manage your portfolio work')

@section('actions')
    <a href="{{ route('admin.projects.create') }}" class="btn btn-primary btn-sm">+ New Project</a>
@endsection

@section('content')

    {{-- Bulk action bar — slides in once something is ticked --}}
    <div class="bulk-bar" id="bulk-bar" data-noun="project">
        <span class="bulk-count" id="bulk-count"><b>0</b> projects selected</span>
        <div class="bulk-actions">
            <button type="button" class="btn btn-ghost btn-sm" id="bulk-clear">Clear</button>
            <button type="button" class="btn btn-danger btn-sm" id="bulk-delete">🗑 Delete selected</button>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.projects.bulk-destroy') }}" id="bulk-form" class="hidden-form">
        @csrf
    </form>

    <div class="card">
        @if ($projects->isEmpty())
            <div class="empty">
                <div class="e-ico">◧</div>
                <p>No projects yet. Add your first one to showcase your work.</p>
                <a href="{{ route('admin.projects.create') }}" class="btn btn-primary btn-sm">+ New Project</a>
            </div>
        @else
            <div class="table-wrap">
                <table class="tbl">
                    <thead>
                        <tr>
                            <th class="col-check">
                                <input type="checkbox" class="check-group" data-group="all"
                                       title="Select all projects" aria-label="Select all projects">
                            </th>
                            <th></th>
                            <th>Project</th>
                            <th>Category</th>
                            <th>Tech Stack</th>
                            <th>Links</th>
                            <th>Order</th>
                            <th>Active</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $project)
                            <tr>
                                <td class="col-check">
                                    <input type="checkbox" class="row-check"
                                           value="{{ $project->id }}"
                                           data-group="all"
                                           aria-label="Select {{ $project->title }}">
                                </td>
                                <td><img src="{{ $project->image_url }}" alt="" class="thumb"></td>
                                <td>
                                    <div style="display:flex;align-items:center;gap:0.4rem">
                                        <strong>{{ $project->title }}</strong>
                                        @if ($project->is_featured)
                                            <span title="Featured" style="color:var(--orange)">★</span>
                                        @endif
                                    </div>
                                    <div style="font-size:0.75rem;color:var(--muted);max-width:280px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                                        {{ $project->description }}
                                    </div>
                                </td>
                                <td><span class="cat-tag">{{ $project->category }}</span></td>
                                <td>
                                    <div class="stack-tags">
                                        @forelse (array_slice($project->tech_stack ?? [], 0, 3) as $tech)
                                            <span class="cat-tag">{{ $tech }}</span>
                                        @empty
                                            <span style="color:var(--muted);font-size:0.75rem">—</span>
                                        @endforelse
                                        @if (count($project->tech_stack ?? []) > 3)
                                            <span class="cat-tag">+{{ count($project->tech_stack) - 3 }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div style="display:flex;gap:0.35rem">
                                        @if ($project->live_url)
                                            <a href="{{ $project->live_url }}" target="_blank" rel="noopener"
                                               class="cat-tag" title="{{ $project->live_url }}">↗ Live</a>
                                        @endif
                                        @if ($project->github_url)
                                            <a href="{{ $project->github_url }}" target="_blank" rel="noopener"
                                               class="cat-tag" title="{{ $project->github_url }}">⎇ Code</a>
                                        @endif
                                        @if (!$project->live_url && !$project->github_url)
                                            <span style="color:var(--muted);font-size:0.75rem">—</span>
                                        @endif
                                    </div>
                                </td>
                                <td style="color:var(--muted)">{{ $project->sort_order }}</td>
                                <td>
                                    <div class="toggle {{ $project->is_active ? 'on' : '' }}"
                                         data-toggle-url="{{ route('admin.projects.toggle', $project) }}"
                                         title="Toggle active"></div>
                                </td>
                                <td>
                                    <div class="row-actions">
                                        <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-ghost btn-sm">Edit</a>
                                        <form method="POST"
                                              action="{{ route('admin.projects.destroy', $project) }}"
                                              data-confirm="Delete the project &quot;{{ $project->title }}&quot;? This cannot be undone.">
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
        @endif
    </div>

@endsection
