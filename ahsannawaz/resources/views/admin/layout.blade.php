<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    {{-- Applied before the first paint, otherwise the panel flashes light
         then snaps to dark on every page load. --}}
    <script>
        (function () {
            var t = localStorage.getItem('admin-theme');
            if (!t) t = matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', t);
        })();
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Admin</title>
    @css('dist/css/page-admin.css')
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

        <a href="{{ route('admin.settings.index') }}"
           class="nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            <span class="ico">⚙</span> Settings
        </a>

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
            <div class="topbar-actions">
                <button type="button" id="theme-toggle" class="theme-toggle"
                        aria-label="Switch between light and dark mode" title="Light / dark">
                    <span class="tt-sun" aria-hidden="true">☀</span>
                    <span class="tt-moon" aria-hidden="true">☾</span>
                </button>
                @yield('actions')
            </div>
        </div>

        <div class="content">
            @yield('content')
        </div>
    </div>
</div>

{{-- ── Success popup — replaces the inline flash alert ── --}}
<div class="modal-backdrop" id="success-modal" style="--modal-accent:var(--green)" role="alertdialog" aria-modal="true" aria-labelledby="success-title" hidden>
    <div class="modal">
        <button type="button" class="modal-close" data-modal-dismiss aria-label="Close">✕</button>

        <div class="modal-ico">
            <svg class="modal-tick" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M4 12.5l5 5L20 6.5"/>
            </svg>
        </div>

        <h3 class="modal-title" id="success-title">Done!</h3>
        <p class="modal-text" id="success-text"></p>

        <div class="modal-actions">
            <button type="button" class="btn btn-primary" data-modal-dismiss>Got it</button>
        </div>

        <span class="modal-timer"></span>
    </div>
</div>

{{-- ── Error popup ── --}}
<div class="modal-backdrop" id="error-modal" style="--modal-accent:var(--red)" role="alertdialog" aria-modal="true" aria-labelledby="error-title" hidden>
    <div class="modal">
        <button type="button" class="modal-close" data-modal-dismiss aria-label="Close">✕</button>
        <div class="modal-ico">⚠</div>
        <h3 class="modal-title" id="error-title">Something went wrong</h3>
        <p class="modal-text" id="error-text"></p>
        <div class="modal-actions">
            <button type="button" class="btn btn-ghost" data-modal-dismiss>Close</button>
        </div>
    </div>
</div>

{{-- ── Confirm popup — replaces window.confirm() ── --}}
<div class="modal-backdrop" id="confirm-modal" style="--modal-accent:var(--red)" role="alertdialog" aria-modal="true" aria-labelledby="confirm-title" hidden>
    <div class="modal">
        <button type="button" class="modal-close" data-modal-dismiss aria-label="Close">✕</button>
        <div class="modal-ico">🗑</div>
        <h3 class="modal-title" id="confirm-title">Are you sure?</h3>
        <p class="modal-text" id="confirm-text"></p>
        <div class="modal-actions">
            <button type="button" class="btn btn-ghost" data-modal-dismiss>Cancel</button>
            <button type="button" class="btn btn-danger" id="confirm-ok">Yes, delete</button>
        </div>
    </div>
</div>

@if (session('success'))
    <template id="flash-success">{{ session('success') }}</template>
@endif
@if (session('error'))
    <template id="flash-error">{{ session('error') }}</template>
@endif

<script>
/* ═══════════════════════════════════════
   THEME TOGGLE
═══════════════════════════════════════ */
(function () {
    var btn = document.getElementById('theme-toggle');
    if (!btn) return;
    btn.addEventListener('click', function () {
        var next = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', next);
        localStorage.setItem('admin-theme', next);
    });
})();

/* ═══════════════════════════════════════
   MODALS
═══════════════════════════════════════ */
const Modal = (() => {
    let lastFocus = null;
    let autoTimer = null;

    const open = (el) => {
        lastFocus = document.activeElement;
        el.hidden = false;
        // Next frame, so the transition has a start state to animate from.
        requestAnimationFrame(() => el.classList.add('open'));
        document.body.style.overflow = 'hidden';
        const focusable = el.querySelector('.btn');
        if (focusable) setTimeout(() => focusable.focus(), 120);
    };

    const close = (el) => {
        clearTimeout(autoTimer);
        el.classList.remove('open');
        document.body.style.overflow = '';
        setTimeout(() => { el.hidden = true; }, 260);
        if (lastFocus) lastFocus.focus();
    };

    const closeAll = () => document.querySelectorAll('.modal-backdrop.open').forEach(close);

    // Dismiss buttons, backdrop clicks and Escape all close.
    document.addEventListener('click', (e) => {
        if (e.target.closest('[data-modal-dismiss]')) {
            const back = e.target.closest('.modal-backdrop');
            if (back) close(back);
        } else if (e.target.classList.contains('modal-backdrop')) {
            close(e.target);
        }
    });
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeAll(); });

    return {
        success(message) {
            const el = document.getElementById('success-modal');
            document.getElementById('success-text').textContent = message;
            // Restart the timer bar animation each time.
            const timer = el.querySelector('.modal-timer');
            timer.style.animation = 'none';
            void timer.offsetWidth;
            timer.style.animation = '';
            open(el);
            autoTimer = setTimeout(() => close(el), 3200);
        },
        error(message) {
            const el = document.getElementById('error-modal');
            document.getElementById('error-text').textContent = message;
            open(el);
        },
        confirm(message, onConfirm) {
            const el = document.getElementById('confirm-modal');
            document.getElementById('confirm-text').innerHTML = message;
            const ok = document.getElementById('confirm-ok');
            // Replace the node to drop any listener from a previous call.
            const fresh = ok.cloneNode(true);
            ok.parentNode.replaceChild(fresh, ok);
            fresh.addEventListener('click', () => { close(el); onConfirm(); });
            open(el);
        },
    };
})();

/* Show flashed messages as popups instead of inline alerts.
   A <template>'s children live in an inert .content fragment, so read through
   that — its own textContent is empty, and innerHTML would leak entities. */
const readTpl = (el) => (el.content ? el.content.textContent : el.textContent).trim();

const flashOk = document.getElementById('flash-success');
if (flashOk) Modal.success(readTpl(flashOk));
const flashErr = document.getElementById('flash-error');
if (flashErr) Modal.error(readTpl(flashErr));

/* ═══════════════════════════════════════
   ACTIVE / INACTIVE TOGGLE
═══════════════════════════════════════ */
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
            Modal.error('Could not update the status. Please reload and try again.');
        })
        .finally(function () {
            el.classList.remove('busy');
        });
    });
});

/* ═══════════════════════════════════════
   CONFIRM BEFORE DESTRUCTIVE SUBMITS
═══════════════════════════════════════ */
document.querySelectorAll('form[data-confirm]').forEach(function (form) {
    form.addEventListener('submit', function (e) {
        if (form.dataset.confirmed === 'yes') return;   // already approved
        e.preventDefault();
        Modal.confirm(form.dataset.confirm, function () {
            form.dataset.confirmed = 'yes';
            form.submit();
        });
    });
});

/* ═══════════════════════════════════════
   BULK SELECT
═══════════════════════════════════════ */
(function () {
    const bar = document.getElementById('bulk-bar');
    if (!bar) return;

    const boxes = Array.from(document.querySelectorAll('.row-check'));
    const groupChecks = Array.from(document.querySelectorAll('.check-group'));
    const countEl = document.getElementById('bulk-count');
    const form = document.getElementById('bulk-form');
    const noun = bar.dataset.noun || 'item';

    const selected = () => boxes.filter(b => b.checked);
    const inGroup = (g) => boxes.filter(b => b.dataset.group === g);

    const sync = () => {
        const n = selected().length;
        bar.classList.toggle('open', n > 0);
        if (countEl) countEl.innerHTML = '<b>' + n + '</b> ' + noun + (n === 1 ? '' : 's') + ' selected';
        boxes.forEach(b => b.closest('tr')?.classList.toggle('is-selected', b.checked));

        // Each group header reflects its own rows (checked / indeterminate / empty).
        groupChecks.forEach(gc => {
            const mine = inGroup(gc.dataset.group);
            const hit = mine.filter(b => b.checked).length;
            gc.checked = hit > 0 && hit === mine.length;
            gc.indeterminate = hit > 0 && hit < mine.length;
        });
    };

    boxes.forEach(b => b.addEventListener('change', sync));

    groupChecks.forEach(gc => {
        gc.addEventListener('change', () => {
            inGroup(gc.dataset.group).forEach(b => { b.checked = gc.checked; });
            sync();
        });
    });

    const clearBtn = document.getElementById('bulk-clear');
    if (clearBtn) {
        clearBtn.addEventListener('click', () => {
            boxes.forEach(b => { b.checked = false; });
            sync();
        });
    }

    const delBtn = document.getElementById('bulk-delete');
    if (delBtn && form) {
        delBtn.addEventListener('click', () => {
            const chosen = selected();
            if (!chosen.length) return;

            Modal.confirm(
                'Delete <b>' + chosen.length + '</b> ' + noun + (chosen.length === 1 ? '' : 's') +
                '? This cannot be undone.',
                () => {
                    // Rebuild the hidden inputs from the current selection.
                    form.querySelectorAll('input[name="ids[]"]').forEach(i => i.remove());
                    chosen.forEach(b => {
                        const hidden = document.createElement('input');
                        hidden.type = 'hidden';
                        hidden.name = 'ids[]';
                        hidden.value = b.value;
                        form.appendChild(hidden);
                    });
                    form.submit();
                }
            );
        });
    }

    sync();
})();
</script>
@stack('scripts')
</body>
</html>
