<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
<div class="admin">

    {{-- ── SIDEBAR ── --}}
    <aside class="sidebar">

        <div class="side-logo">
            <div class="mark">AN</div>
            <div>
                <div class="name">Ahsan Nawaz</div>
                <div class="role">Admin Panel</div>
            </div>
        </div>

        <div class="nav-label">Menu</div>

        <a href="{{ route('admin.dashboard') }}"
           class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="ico">▤</span> Dashboard
        </a>

        <a href="{{ route('admin.skills.index') }}"
           class="nav-item {{ request()->routeIs('admin.skills.*') ? 'active' : '' }}">
            <span class="ico">⚡</span> Skills
        </a>

        <a href="{{ route('admin.projects.index') }}"
           class="nav-item {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
            <span class="ico">◧</span> Projects
        </a>

        <div class="nav-label">Site</div>

        <a href="{{ url('/') }}" target="_blank" rel="noopener" class="nav-item">
            <span class="ico">↗</span> View Portfolio
        </a>

        <div class="side-foot">
            <div class="side-user">
                <div class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 2)) }}</div>
                <div>
                    <div class="u-name">{{ auth()->user()->name ?? 'Admin' }}</div>
                    <div class="u-mail">{{ auth()->user()->email ?? '' }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="btn btn-ghost btn-sm" style="width:100%">⎋ Sign Out</button>
            </form>
        </div>
    </aside>

    {{-- ── MAIN ── --}}
    <div class="main">

        <div class="topbar">
            <div>
                <h1>@yield('heading', 'Dashboard')</h1>
                <div class="crumb">@yield('crumb', 'Overview')</div>
            </div>
            <div>@yield('actions')</div>
        </div>

        <div class="content">

            @if (session('success'))
                <div class="alert alert-success">✓ {{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-error">⚠ {{ session('error') }}</div>
            @endif

            @yield('content')
        </div>
    </div>
</div>

<script>
// Active/inactive toggle — posts to the controller's JSON toggle route.
document.querySelectorAll('[data-toggle-url]').forEach(function (el) {
    el.addEventListener('click', function () {
        el.classList.add('busy');
        fetch(el.dataset.toggleUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
        })
        .then(function (r) {
            if (!r.ok) throw new Error('Request failed (' + r.status + ')');
            return r.json();
        })
        .then(function (data) {
            el.classList.toggle('on', data.is_active);
        })
        .catch(function () {
            alert('Could not update status. Please reload and try again.');
        })
        .finally(function () {
            el.classList.remove('busy');
        });
    });
});

// Confirm before destructive submits.
document.querySelectorAll('form[data-confirm]').forEach(function (form) {
    form.addEventListener('submit', function (e) {
        if (!confirm(form.dataset.confirm)) e.preventDefault();
    });
});
</script>
@stack('scripts')
</body>
</html>
