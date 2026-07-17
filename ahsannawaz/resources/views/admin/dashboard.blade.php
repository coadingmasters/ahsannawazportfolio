@extends('admin.layout')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')
@section('crumb', 'Overview of your portfolio content')

@section('content')

    {{-- ── STATS ── --}}
    <div class="stat-grid">
        <div class="stat-card">
            <div class="s-top">
                <span class="s-label">Total Skills</span>
                <span class="s-ico">⚡</span>
            </div>
            <div class="s-num">{{ $stats['total_skills'] }}</div>
            <div class="s-label" style="text-transform:none;letter-spacing:0">
                {{ $stats['active_skills'] }} active
            </div>
        </div>

        <div class="stat-card">
            <div class="s-top">
                <span class="s-label">Total Projects</span>
                <span class="s-ico">◧</span>
            </div>
            <div class="s-num">{{ $stats['total_projects'] }}</div>
            <div class="s-label" style="text-transform:none;letter-spacing:0">
                {{ $stats['active_projects'] }} active
            </div>
        </div>

        <div class="stat-card">
            <div class="s-top">
                <span class="s-label">Featured</span>
                <span class="s-ico">★</span>
            </div>
            <div class="s-num">{{ $stats['featured'] }}</div>
            <div class="s-label" style="text-transform:none;letter-spacing:0">
                shown prominently
            </div>
        </div>

        <div class="stat-card">
            <div class="s-top">
                <span class="s-label">Categories</span>
                <span class="s-ico">▦</span>
            </div>
            <div class="s-num">{{ $skillsByCategory->count() }}</div>
            <div class="s-label" style="text-transform:none;letter-spacing:0">
                skill groups
            </div>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1.55fr 1fr;gap:1.25rem;align-items:start">

        {{-- ── RECENT PROJECTS ── --}}
        <div class="card">
            <div class="card-head">
                <h2>Recent Projects</h2>
                <a href="{{ route('admin.projects.index') }}" class="btn btn-ghost btn-sm">View all</a>
            </div>

            @forelse ($recentProjects as $project)
                <div style="display:flex;align-items:center;gap:0.8rem;padding:0.65rem 0;border-bottom:1px solid rgba(255,255,255,0.05)">
                    <img src="{{ $project->image_url }}" alt="" class="thumb">
                    <div style="flex:1;min-width:0">
                        <div style="font-weight:600;font-size:0.88rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                            {{ $project->title }}
                        </div>
                        <div style="font-size:0.74rem;color:var(--muted)">
                            <span class="cat-tag">{{ $project->category }}</span>
                            <span style="margin-left:0.4rem">{{ $project->created_at?->diffForHumans() }}</span>
                        </div>
                    </div>
                    @if ($project->is_featured)
                        <span class="badge" style="color:var(--orange)">★ Featured</span>
                    @endif
                    <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-ghost btn-sm">Edit</a>
                </div>
            @empty
                <div class="empty">
                    <div class="e-ico">◧</div>
                    <p>No projects yet.</p>
                    <a href="{{ route('admin.projects.create') }}" class="btn btn-primary btn-sm">+ Add your first project</a>
                </div>
            @endforelse
        </div>

        {{-- ── SKILLS BY CATEGORY ── --}}
        <div class="card">
            <div class="card-head">
                <h2>Skills by Category</h2>
            </div>

            @php $maxCount = $skillsByCategory->max() ?: 1; @endphp

            @forelse ($skillsByCategory as $category => $count)
                <div style="margin-bottom:0.85rem">
                    <div style="display:flex;justify-content:space-between;font-size:0.82rem;margin-bottom:0.3rem">
                        <span style="text-transform:capitalize">{{ $category }}</span>
                        <span style="color:var(--muted)">{{ $count }}</span>
                    </div>
                    <div class="bar" style="width:100%">
                        <i style="width:{{ round($count / $maxCount * 100) }}%;background:linear-gradient(90deg,#f97316,#fb923c)"></i>
                    </div>
                </div>
            @empty
                <div class="empty">
                    <div class="e-ico">⚡</div>
                    <p>No skills yet.</p>
                    <a href="{{ route('admin.skills.create') }}" class="btn btn-primary btn-sm">+ Add a skill</a>
                </div>
            @endforelse
        </div>
    </div>

@endsection
