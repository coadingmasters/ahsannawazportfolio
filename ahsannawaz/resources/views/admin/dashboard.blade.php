@extends('admin.layout')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')
@section('crumb', 'Overview of your portfolio content')

@section('content')

@php
    // Ordinal ramp for skill level — weakest to strongest, one hue.
    // Validated against the #161616 surface: monotone lightness, 28° hue
    // spread, light end at 3.49:1.
    $levelColor = ['good' => '#c2410c', 'advanced' => '#f97316', 'expert' => '#fdba74'];
    $totalLevels = $levelMix->sum('count') ?: 1;

    // ucfirst() alone would render these as "Cms" / "Api" / "Wordpress".
    $labelMap = [
        'cms' => 'CMS', 'api' => 'API', 'seo' => 'SEO', 'ui' => 'UI', 'ux' => 'UX',
        'wordpress' => 'WordPress', 'ios' => 'iOS',
    ];
    $label = fn ($v) => $labelMap[strtolower($v)] ?? ucfirst($v);
@endphp

{{-- ══════════ KPI ROW ══════════ --}}
<div class="kpi-grid">
    <div class="kpi" style="--i:0">
        <div class="kpi-top">
            <span class="kpi-label">Skills</span>
            <span class="kpi-ico">⚡</span>
        </div>
        <div class="kpi-val" data-count="{{ $stats['total_skills'] }}">0</div>
        <div class="kpi-sub"><b>{{ $stats['active_skills'] }}</b> live on the site</div>
    </div>

    <div class="kpi" style="--i:1">
        <div class="kpi-top">
            <span class="kpi-label">Projects</span>
            <span class="kpi-ico">◧</span>
        </div>
        <div class="kpi-val" data-count="{{ $stats['total_projects'] }}">0</div>
        <div class="kpi-sub"><b>{{ $stats['active_projects'] }}</b> live on the site</div>
    </div>

    <div class="kpi" style="--i:2">
        <div class="kpi-top">
            <span class="kpi-label">Featured</span>
            <span class="kpi-ico">★</span>
        </div>
        <div class="kpi-val" data-count="{{ $stats['featured'] }}">0</div>
        <div class="kpi-sub">shown at the top of the grid</div>
    </div>

    <div class="kpi" style="--i:3">
        <div class="kpi-top">
            <span class="kpi-label">Messages</span>
            <span class="kpi-ico">✉</span>
        </div>
        <div class="kpi-val" data-count="{{ $stats['messages'] }}">0</div>
        <div class="kpi-sub">
            @if ($stats['unread'] > 0)
                <b>{{ $stats['unread'] }}</b> unread
            @else
                all read
            @endif
        </div>
    </div>
</div>

{{-- ══════════ TREND + PROFICIENCY METER ══════════ --}}
<div class="chart-row two">

    {{-- Projects added over time — one series, so no legend box; the title says
         what is plotted. Crosshair + tooltip on hover. --}}
    <div class="card">
        <div class="card-head">
            <div>
                <h2>Projects added</h2>
                <div class="sub">Last 6 months · {{ $trend->sum('count') }} added in total</div>
            </div>
            <button type="button" class="table-toggle" data-table-toggle="trend-table">Show table</button>
        </div>

        @php
            $tw = 620; $th = 190;          // viewBox units
            $padL = 34; $padR = 16; $padT = 14; $padB = 26;
            $maxY = max(1, $trend->max('count'));
            // Round the axis top to a clean number.
            $axisTop = (int) max(1, ceil($maxY / 2) * 2);
            $n = max(1, $trend->count() - 1);
            $px = fn ($i) => $padL + ($i / $n) * ($tw - $padL - $padR);
            $py = fn ($v) => $padT + (1 - $v / $axisTop) * ($th - $padT - $padB);
            $pts = $trend->values()->map(fn ($r, $i) => ['x' => $px($i), 'y' => $py($r['count'])]);
            $line = $pts->map(fn ($p) => round($p['x'], 1) . ',' . round($p['y'], 1))->implode(' ');
            $area = "{$padL}," . ($th - $padB) . " {$line} " . round($px($trend->count() - 1), 1) . ',' . ($th - $padB);
        @endphp

        <div class="linechart" id="trend-chart">
            <svg viewBox="0 0 {{ $tw }} {{ $th }}" role="img"
                 aria-label="Projects added per month over the last six months">

                {{-- Hairline gridlines, solid, one step off the surface --}}
                @foreach ([0, 0.5, 1] as $g)
                    @php $gy = $padT + $g * ($th - $padT - $padB); @endphp
                    <line class="lc-grid" x1="{{ $padL }}" y1="{{ round($gy, 1) }}"
                          x2="{{ $tw - $padR }}" y2="{{ round($gy, 1) }}"/>
                    <text class="lc-tick" x="{{ $padL - 8 }}" y="{{ round($gy + 4, 1) }}" text-anchor="end">
                        {{ (int) round($axisTop * (1 - $g)) }}
                    </text>
                @endforeach

                <polygon class="lc-area" points="{{ $area }}"/>
                <polyline class="lc-line" id="trend-line" points="{{ $line }}"/>

                <line class="lc-cross" id="trend-cross" y1="{{ $padT }}" y2="{{ $th - $padB }}"/>

                @foreach ($pts as $i => $p)
                    <circle class="lc-dot" data-dot="{{ $i }}"
                            cx="{{ round($p['x'], 1) }}" cy="{{ round($p['y'], 1) }}" r="4.5"/>
                @endforeach

                {{-- Hit areas are far wider than the dots, so hovering is easy --}}
                @foreach ($trend as $i => $row)
                    <rect class="lc-hit" data-i="{{ $i }}"
                          data-label="{{ $row['full'] }}"
                          data-count="{{ $row['count'] }}"
                          data-cum="{{ $row['cumulative'] }}"
                          x="{{ round($px($i) - ($tw / $trend->count()) / 2, 1) }}" y="{{ $padT }}"
                          width="{{ round($tw / $trend->count(), 1) }}" height="{{ $th - $padT - $padB }}"/>
                @endforeach

                @foreach ($trend as $i => $row)
                    <text class="lc-tick" x="{{ round($px($i), 1) }}" y="{{ $th - 8 }}" text-anchor="middle">
                        {{ $row['label'] }}
                    </text>
                @endforeach
            </svg>
            <div class="chart-tip" id="trend-tip"></div>
        </div>

        <div hidden id="trend-table">
            <table class="data-table">
                <thead><tr><th>Month</th><th>Added</th><th>Total</th></tr></thead>
                <tbody>
                @foreach ($trend as $row)
                    <tr><td>{{ $row['full'] }}</td><td>{{ $row['count'] }}</td><td>{{ $row['cumulative'] }}</td></tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Average proficiency — a single ratio against a limit, so a meter --}}
    <div class="card">
        <div class="card-head">
            <div>
                <h2>Average proficiency</h2>
                <div class="sub">Across all {{ $stats['total_skills'] }} skills</div>
            </div>
        </div>

        @php
            $r = 68; $circ = 2 * M_PI * $r;
        @endphp

        <div class="meter-wrap">
            <div class="meter">
                <svg viewBox="0 0 172 172" width="172" height="172" role="img"
                     aria-label="Average skill proficiency {{ $stats['avg_percentage'] }} percent">
                    <circle class="meter-track" cx="86" cy="86" r="{{ $r }}" fill="none" stroke-width="12"/>
                    <circle class="meter-fill" id="meter-fill" cx="86" cy="86" r="{{ $r }}" fill="none" stroke-width="12"
                            stroke-dasharray="{{ round($circ, 2) }}"
                            stroke-dashoffset="{{ round($circ, 2) }}"
                            data-target="{{ round($circ * (1 - $stats['avg_percentage'] / 100), 2) }}"/>
                </svg>
                <div class="meter-mid">
                    <div class="meter-num"><span data-count="{{ $stats['avg_percentage'] }}">0</span><span>%</span></div>
                    <div class="meter-cap">Average</div>
                </div>
            </div>
        </div>

        <div class="legend" style="justify-content:center">
            <div class="legend-item">
                <span class="legend-dot" style="background:var(--orange)"></span>
                <span class="legend-name">Strongest</span>
                <span class="legend-val">{{ $topSkills->first()?->name ?? '—' }} · {{ $topSkills->first()?->percentage ?? 0 }}%</span>
            </div>
        </div>
    </div>
</div>

{{-- ══════════ CATEGORY BARS + PROFICIENCY MIX ══════════ --}}
<div class="chart-row two">

    {{-- Nominal categories: every bar wears the same accent hue. Length alone
         encodes the count — colouring by value would double-encode it. --}}
    <div class="card">
        <div class="card-head">
            <div>
                <h2>Skills by category</h2>
                <div class="sub">Count per group, with average proficiency</div>
            </div>
            <button type="button" class="table-toggle" data-table-toggle="cat-table">Show table</button>
        </div>

        @php $maxCat = max(1, $skillsByCategory->max('count')); @endphp

        @if ($skillsByCategory->isEmpty())
            <div class="empty">
                <div class="e-ico">⚡</div>
                <p>No skills yet.</p>
                <a href="{{ route('admin.skills.create') }}" class="btn btn-primary btn-sm">+ Add a skill</a>
            </div>
        @else
            <div class="hbar-list">
                @foreach ($skillsByCategory as $row)
                    <div class="hbar-row"
                         title="{{ $label($row['category']) }} — {{ $row['count'] }} skills, {{ $row['avg'] }}% average">
                        <div class="hbar-meta">
                            <span class="hbar-name">{{ $label($row['category']) }}</span>
                            <span class="hbar-val"><b>{{ $row['count'] }}</b> · {{ $row['avg'] }}% avg</span>
                        </div>
                        <div class="hbar-track">
                            <i class="hbar-fill" data-w="{{ round($row['count'] / $maxCat * 100, 1) }}"></i>
                        </div>
                    </div>
                @endforeach
            </div>

            <div hidden id="cat-table">
                <table class="data-table">
                    <thead><tr><th>Category</th><th>Skills</th><th>Avg %</th></tr></thead>
                    <tbody>
                    @foreach ($skillsByCategory as $row)
                        <tr><td>{{ $label($row['category']) }}</td><td>{{ $row['count'] }}</td><td>{{ $row['avg'] }}</td></tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- Level is an ordered scale, so this is ordinal: one hue, light to dark,
         part-to-whole as a stacked bar with 2px surface gaps. --}}
    <div class="card">
        <div class="card-head">
            <div>
                <h2>Proficiency mix</h2>
                <div class="sub">How your {{ $stats['total_skills'] }} skills are rated</div>
            </div>
        </div>

        @if ($levelMix->isEmpty())
            <div class="empty">
                <div class="e-ico">▦</div>
                <p>No skills to rate yet.</p>
            </div>
        @else
            <div class="stack">
                @foreach ($levelMix as $row)
                    <span class="stack-seg"
                          style="background:{{ $levelColor[$row['level']] ?? '#f97316' }}"
                          data-w="{{ round($row['count'] / $totalLevels * 100, 2) }}"
                          title="{{ ucfirst($row['level']) }} — {{ $row['count'] }} skills"></span>
                @endforeach
            </div>

            <div class="legend">
                @foreach ($levelMix as $row)
                    <div class="legend-item">
                        <span class="legend-dot" style="background:{{ $levelColor[$row['level']] ?? '#f97316' }}"></span>
                        <span class="legend-name">{{ $row['level'] }}</span>
                        <span class="legend-val">{{ $row['count'] }} · {{ round($row['count'] / $totalLevels * 100) }}%</span>
                    </div>
                @endforeach
            </div>

            {{-- Strongest skills, ranked --}}
            <div style="margin-top:1.4rem">
                <div class="kpi-label" style="margin-bottom:0.7rem">Strongest skills</div>
                <div class="hbar-list">
                    @foreach ($topSkills as $skill)
                        <div class="hbar-row" title="{{ $skill->name }} — {{ $skill->percentage }}%">
                            <div class="hbar-meta">
                                <span>{{ $skill->icon }} {{ $skill->name }}</span>
                                <span class="hbar-val"><b>{{ $skill->percentage }}</b>%</span>
                            </div>
                            <div class="hbar-track">
                                <i class="hbar-fill" data-w="{{ $skill->percentage }}"></i>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

{{-- ══════════ RECENT PROJECTS + PROJECT CATEGORIES ══════════ --}}
<div class="chart-row split">

    <div class="card">
        <div class="card-head">
            <h2>Recent projects</h2>
            <a href="{{ route('admin.projects.index') }}" class="btn btn-ghost btn-sm">View all</a>
        </div>

        @forelse ($recentProjects as $project)
            <div class="recent-row">
                <img src="{{ $project->image_url }}" alt="" class="thumb">
                <div style="flex:1;min-width:0">
                    <div class="recent-title">{{ $project->title }}</div>
                    <div class="recent-meta">
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

    <div class="card">
        <div class="card-head">
            <div>
                <h2>Projects by category</h2>
                <div class="sub">{{ $stats['total_projects'] }} projects in total</div>
            </div>
        </div>

        @php $maxPc = max(1, $projectsByCategory->max('count') ?? 1); @endphp

        @if ($projectsByCategory->isEmpty())
            <div class="empty">
                <div class="e-ico">◧</div>
                <p>Nothing to chart yet.</p>
            </div>
        @else
            <div class="hbar-list">
                @foreach ($projectsByCategory as $row)
                    <div class="hbar-row" title="{{ $label($row['category']) }} — {{ $row['count'] }} projects">
                        <div class="hbar-meta">
                            <span class="hbar-name">{{ $label($row['category']) }}</span>
                            <span class="hbar-val"><b>{{ $row['count'] }}</b></span>
                        </div>
                        <div class="hbar-track">
                            <i class="hbar-fill" data-w="{{ round($row['count'] / $maxPc * 100, 1) }}"></i>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
/* ═══════════════════════════════════════
   DASHBOARD CHART ANIMATION
   Everything renders at its final value in the
   markup; JS only animates from zero, so the
   page is correct even if this never runs.
═══════════════════════════════════════ */
(function () {
    const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* ---- count up ---- */
    const countUp = (el) => {
        const target = parseInt(el.dataset.count, 10) || 0;
        if (reduced || target === 0) { el.textContent = target; return; }
        const dur = 900, start = performance.now();
        const step = (now) => {
            const t = Math.min(1, (now - start) / dur);
            // ease-out cubic, so it decelerates into the final number
            el.textContent = Math.round(target * (1 - Math.pow(1 - t, 3)));
            if (t < 1) requestAnimationFrame(step);
        };
        requestAnimationFrame(step);
    };

    /* ---- reveal: play each chart when it scrolls into view ---- */
    const play = (root) => {
        root.querySelectorAll('[data-count]').forEach(countUp);
        root.querySelectorAll('.hbar-fill').forEach((el, i) => {
            setTimeout(() => { el.style.width = el.dataset.w + '%'; }, reduced ? 0 : i * 60);
        });
        root.querySelectorAll('.stack-seg').forEach((el, i) => {
            setTimeout(() => { el.style.width = el.dataset.w + '%'; }, reduced ? 0 : i * 90);
        });
        const meter = root.querySelector('#meter-fill');
        if (meter) setTimeout(() => { meter.style.strokeDashoffset = meter.dataset.target; }, reduced ? 0 : 150);

        const line = root.querySelector('#trend-line');
        if (line) {
            const len = line.getTotalLength();
            line.style.strokeDasharray = len;
            line.style.strokeDashoffset = reduced ? 0 : len;
            requestAnimationFrame(() => { line.style.strokeDashoffset = 0; });
            setTimeout(() => {
                root.querySelectorAll('.lc-dot').forEach((d, i) =>
                    setTimeout(() => d.classList.add('on'), i * 70));
            }, reduced ? 0 : 700);
        }
    };

    const cards = document.querySelectorAll('.card, .kpi-grid');
    if ('IntersectionObserver' in window) {
        const io = new IntersectionObserver((entries) => {
            entries.forEach((e) => {
                if (!e.isIntersecting) return;
                play(e.target);
                io.unobserve(e.target);
            });
        }, { threshold: 0.2 });
        cards.forEach((c) => io.observe(c));
    } else {
        cards.forEach(play);
    }

    /* ---- line chart crosshair + tooltip ---- */
    const chart = document.getElementById('trend-chart');
    if (chart) {
        const tip = document.getElementById('trend-tip');
        const cross = document.getElementById('trend-cross');
        const svg = chart.querySelector('svg');

        chart.querySelectorAll('.lc-hit').forEach((hit) => {
            const show = () => {
                const i = hit.dataset.i;
                const dot = chart.querySelector('.lc-dot[data-dot="' + i + '"]');
                if (!dot) return;

                // Map viewBox units to on-screen pixels for the HTML tooltip.
                const box = svg.getBoundingClientRect();
                const vb = svg.viewBox.baseVal;
                const sx = box.width / vb.width, sy = box.height / vb.height;
                const cx = parseFloat(dot.getAttribute('cx')), cy = parseFloat(dot.getAttribute('cy'));

                tip.innerHTML =
                    '<div class="t-key">' + hit.dataset.label + '</div>' +
                    '<div><span class="t-val">' + hit.dataset.count + '</span> added' +
                    ' · <span class="t-key">' + hit.dataset.cum + ' total</span></div>';
                tip.style.left = (cx * sx) + 'px';
                tip.style.top = (cy * sy) + 'px';
                tip.classList.add('on');

                cross.setAttribute('x1', cx);
                cross.setAttribute('x2', cx);
                cross.classList.add('on');
                dot.setAttribute('r', 6);
            };
            const hide = () => {
                tip.classList.remove('on');
                cross.classList.remove('on');
                const dot = chart.querySelector('.lc-dot[data-dot="' + hit.dataset.i + '"]');
                if (dot) dot.setAttribute('r', 4.5);
            };
            hit.addEventListener('mouseenter', show);
            hit.addEventListener('mouseleave', hide);
            hit.addEventListener('focus', show);
            hit.addEventListener('blur', hide);
        });
    }

    /* ---- table view toggles ---- */
    document.querySelectorAll('[data-table-toggle]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const panel = document.getElementById(btn.dataset.tableToggle);
            if (!panel) return;
            panel.hidden = !panel.hidden;
            btn.textContent = panel.hidden ? 'Show table' : 'Hide table';
        });
    });
})();
</script>
@endpush
