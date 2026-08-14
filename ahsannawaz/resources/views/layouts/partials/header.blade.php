{{-- ============================================
     SITE HEADER
     Colours come from theme.css. The aliases below only exist because
     older stylesheets on these pages still reference --orange etc.
============================================ --}}

<style>
:root {
    --bg-dark: var(--bg);
    --bg-card: var(--surface);
    --bg-nav: rgba(255, 255, 255, 0.72);
    --orange: var(--accent);
    --orange-light: var(--accent-hover);
    --orange-dim: rgba(15, 118, 110, 0.10);
    --text-white: var(--text);
    --text-muted: var(--text-3);

    /* Header height is a variable so pages can offset anchors against it. */
    --header-h: 88px;
}

* { margin: 0; padding: 0; box-sizing: border-box; }

body {
    background: var(--bg-dark);
    color: var(--text-white);
    font-family: 'DM Sans', system-ui, -apple-system, sans-serif;
}

/* Off-screen until focused, then it drops into view. */
.skip-link {
    position: absolute;
    left: 1rem;
    top: -3rem;
    z-index: 1100;
    background: var(--accent);
    color: var(--on-accent);
    padding: 0.6rem 1rem;
    border-radius: 0 0 10px 10px;
    font-weight: 700;
    font-size: 0.9rem;
    transition: top 0.2s ease;
}
.skip-link:focus { top: 0; }

/* ═══════════════ HEADER SHELL ═══════════════ */
.site-header {
    position: sticky;
    top: 0;
    z-index: 1000;
    background: var(--bg-nav);
    backdrop-filter: saturate(180%) blur(16px);
    -webkit-backdrop-filter: saturate(180%) blur(16px);
    border-bottom: 1px solid transparent;
    transition: height 0.3s cubic-bezier(0.22, 1, 0.36, 1),
                background 0.3s ease,
                border-color 0.3s ease,
                box-shadow 0.3s ease;
}

/* Once the page scrolls, the bar tightens and lifts off the content. */
.site-header.is-stuck {
    --header-h: 66px;
    background: rgba(255, 255, 255, 0.88);
    border-bottom-color: var(--border);
    box-shadow: 0 6px 24px rgba(15, 23, 42, 0.06);
}

.header-inner {
    max-width: 1240px;
    margin: 0 auto;
    padding: 0 clamp(1rem, 4vw, 2rem);
    height: var(--header-h);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    transition: height 0.3s cubic-bezier(0.22, 1, 0.36, 1);
}

/* ═══════════════ WORDMARK ═══════════════ */
.brand {
    display: inline-flex;
    align-items: baseline;
    gap: 2px;
    font-family: 'Sora', 'DM Sans', sans-serif;
    font-size: clamp(1.15rem, 0.95rem + 0.8vw, 1.5rem);
    font-weight: 800;
    letter-spacing: -0.03em;
    color: var(--text);
    white-space: nowrap;
    position: relative;
    padding-bottom: 2px;
}

.brand .dot { color: var(--accent); }

/* The wordmark underlines itself on hover, sweeping out from the left. */
.brand::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: -2px;
    height: 2px;
    width: 100%;
    background: linear-gradient(90deg, var(--accent), var(--accent-hover));
    border-radius: 2px;
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.35s cubic-bezier(0.22, 1, 0.36, 1);
}
.brand:hover::after { transform: scaleX(1); }

/* Each word rises into place on first load. */
.brand > span {
    display: inline-block;
    opacity: 0;
    transform: translateY(0.5em);
    animation: brandIn 0.55s cubic-bezier(0.22, 1, 0.36, 1) forwards;
}
.brand > span:nth-child(2) { animation-delay: 0.07s; }
.brand > span:nth-child(3) { animation-delay: 0.14s; }

@keyframes brandIn { to { opacity: 1; transform: none; } }

/* ═══════════════ DESKTOP NAV ═══════════════ */
.nav {
    display: flex;
    align-items: center;
    gap: 2px;
    position: relative;
}

.nav a {
    position: relative;
    z-index: 1;
    padding: 0.55rem 0.95rem;
    border-radius: 999px;
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--text-3);
    transition: color 0.22s ease;
    white-space: nowrap;
}
.nav a:hover { color: var(--text); }
.nav a.active { color: var(--accent); }

/* A single pill slides between items instead of each one having its own
   background — that movement is what makes the bar feel alive. It is
   positioned by JS; without JS the .active link still reads as active
   through its colour, so nothing is lost. */
.nav-pill {
    position: absolute;
    top: 50%;
    left: 0;
    height: 38px;
    border-radius: 999px;
    background: var(--accent-soft);
    border: 1px solid var(--accent-line);
    transform: translateY(-50%);
    transition: width 0.38s cubic-bezier(0.22, 1, 0.36, 1),
                transform 0.38s cubic-bezier(0.22, 1, 0.36, 1),
                opacity 0.25s ease;
    opacity: 0;
    pointer-events: none;
    z-index: 0;
}
.nav-pill.ready { opacity: 1; }

/* ═══════════════ CTA ═══════════════ */
.header-actions { display: flex; align-items: center; gap: 0.6rem; }

.btn-hire {
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    background: var(--accent);
    color: var(--on-accent);
    padding: 0.62rem 1.15rem;
    border-radius: 999px;
    font-size: 0.9rem;
    font-weight: 700;
    white-space: nowrap;
    border: 0;
    cursor: pointer;
    transition: background 0.2s, transform 0.15s, box-shadow 0.25s;
}
.btn-hire:hover {
    background: var(--accent-hover);
    transform: translateY(-1px);
    box-shadow: 0 8px 20px rgba(15, 118, 110, 0.25);
}
.btn-hire:active { transform: translateY(0); }

.btn-hire .arrow { transition: transform 0.25s cubic-bezier(0.22, 1, 0.36, 1); }
.btn-hire:hover .arrow { transform: translateX(3px); }

/* ═══════════════ SCROLL PROGRESS ═══════════════ */
.scroll-progress {
    position: absolute;
    left: 0;
    bottom: -1px;
    height: 2px;
    width: 100%;
    transform: scaleX(0);
    transform-origin: left;
    background: linear-gradient(90deg, var(--accent), var(--accent-hover));
}

/* ═══════════════ HAMBURGER ═══════════════ */
.hamburger {
    display: none;
    flex-direction: column;
    justify-content: center;
    gap: 5px;
    width: 44px;
    height: 44px;          /* a comfortable tap target */
    padding: 11px;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 12px;
    cursor: pointer;
}
.hamburger span {
    display: block;
    height: 2px;
    width: 100%;
    background: var(--text);
    border-radius: 2px;
    transition: transform 0.3s cubic-bezier(0.22, 1, 0.36, 1), opacity 0.2s;
}
.hamburger[aria-expanded="true"] span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
.hamburger[aria-expanded="true"] span:nth-child(2) { opacity: 0; transform: scaleX(0); }
.hamburger[aria-expanded="true"] span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

/* ═══════════════ MOBILE MENU ═══════════════ */
.mobile-menu {
    position: fixed;
    inset: var(--header-h) 0 auto 0;
    background: var(--surface);
    border-bottom: 1px solid var(--border);
    box-shadow: 0 20px 40px rgba(15, 23, 42, 0.10);
    padding: 0.75rem clamp(1rem, 4vw, 2rem) 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 0.15rem;
    /* Collapsed by height rather than display:none, so it can animate. */
    max-height: 0;
    overflow: hidden;
    opacity: 0;
    visibility: hidden;
    transition: max-height 0.4s cubic-bezier(0.22, 1, 0.36, 1),
                opacity 0.25s ease, visibility 0.25s;
    z-index: 999;
}
.mobile-menu.open {
    max-height: calc(100dvh - var(--header-h));
    opacity: 1;
    visibility: visible;
    overflow-y: auto;
}

.mobile-menu a {
    padding: 0.9rem 0.85rem;
    border-radius: 12px;
    font-size: 1.02rem;
    font-weight: 600;
    color: var(--text-2);
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid var(--border);
    /* Items stagger in behind the panel. */
    opacity: 0;
    transform: translateY(-6px);
}
.mobile-menu.open a { animation: itemIn 0.4s cubic-bezier(0.22, 1, 0.36, 1) forwards; }
.mobile-menu.open a:nth-child(1) { animation-delay: 0.04s; }
.mobile-menu.open a:nth-child(2) { animation-delay: 0.09s; }
.mobile-menu.open a:nth-child(3) { animation-delay: 0.14s; }
.mobile-menu.open a:nth-child(4) { animation-delay: 0.19s; }
.mobile-menu.open a:nth-child(5) { animation-delay: 0.24s; }
.mobile-menu.open a:nth-child(6) { animation-delay: 0.29s; }

@keyframes itemIn { to { opacity: 1; transform: none; } }

.mobile-menu a::after { content: '→'; opacity: 0.35; font-size: 0.9rem; }
.mobile-menu a:hover, .mobile-menu a.active { color: var(--accent); background: var(--accent-soft); }
.mobile-menu a.active::after { opacity: 1; }

.mobile-menu .btn-hire {
    margin-top: 0.9rem;
    justify-content: center;
    border-bottom: 0;
    color: var(--on-accent);
    font-size: 1rem;
    padding: 0.9rem 1.2rem;
}
.mobile-menu .btn-hire::after { content: none; }
.mobile-menu .btn-hire:hover { background: var(--accent-hover); color: var(--on-accent); }

/* ═══════════════ RESPONSIVE ═══════════════ */
@media (max-width: 1024px) {
    :root { --header-h: 78px; }
    .nav a { padding: 0.5rem 0.75rem; font-size: 0.9rem; }
}

@media (max-width: 860px) {
    :root { --header-h: 72px; }
    .site-header.is-stuck { --header-h: 62px; }
    .nav, .nav-pill { display: none; }
    .header-actions .btn-hire { display: none; }
    .hamburger { display: flex; }
}

@media (max-width: 380px) {
    .brand { font-size: 1.05rem; }
}

/* Someone who asked for less motion gets a static bar, not a jittery one. */
@media (prefers-reduced-motion: reduce) {
    .site-header, .header-inner, .nav-pill, .mobile-menu,
    .brand > span, .mobile-menu.open a { transition: none; animation: none; }
    .brand > span { opacity: 1; transform: none; }
    .mobile-menu.open a { opacity: 1; transform: none; }
}
</style>

<a class="skip-link" href="#main-content">Skip to content</a>

<header class="site-header" id="mainHeader">
    <div class="header-inner">

        <a href="{{ url('/') }}" class="brand" aria-label="Ahsan Nawaz — home">
            <span>Ahsan</span><span>&nbsp;Nawaz</span><span class="dot">.dev</span>
        </a>

        <nav class="nav" id="primaryNav" aria-label="Primary">
            <span class="nav-pill" id="navPill" aria-hidden="true"></span>
            <a href="{{ url('/') }}"          class="{{ request()->is('/') ? 'active' : '' }}">Home</a>
            <a href="{{ route('about') }}"    class="{{ request()->is('about') ? 'active' : '' }}">About</a>
            <a href="{{ route('skills') }}"   class="{{ request()->is('skills') ? 'active' : '' }}">Skills</a>
            <a href="{{ route('projects') }}" class="{{ request()->is('projects') ? 'active' : '' }}">Projects</a>
            <a href="{{ route('contact') }}"  class="{{ request()->is('contact') ? 'active' : '' }}">Contact</a>
        </nav>

        <div class="header-actions">
            <a href="{{ route('contact') }}" class="btn-hire">
                Hire Me <span class="arrow" aria-hidden="true">→</span>
            </a>
            <button class="hamburger" id="hamburger" aria-label="Toggle menu"
                    aria-expanded="false" aria-controls="mobileMenu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>

    <span class="scroll-progress" id="scrollProgress" aria-hidden="true"></span>

    <div class="mobile-menu" id="mobileMenu">
        <a href="{{ url('/') }}"          class="{{ request()->is('/') ? 'active' : '' }}">Home</a>
        <a href="{{ route('about') }}"    class="{{ request()->is('about') ? 'active' : '' }}">About</a>
        <a href="{{ route('skills') }}"   class="{{ request()->is('skills') ? 'active' : '' }}">Skills</a>
        <a href="{{ route('projects') }}" class="{{ request()->is('projects') ? 'active' : '' }}">Projects</a>
        <a href="{{ route('contact') }}"  class="{{ request()->is('contact') ? 'active' : '' }}">Contact</a>
        <a href="{{ route('contact') }}"  class="btn-hire">Hire Me</a>
    </div>
</header>

<script>
(function () {
    var header   = document.getElementById('mainHeader');
    var nav      = document.getElementById('primaryNav');
    var pill     = document.getElementById('navPill');
    var burger   = document.getElementById('hamburger');
    var menu     = document.getElementById('mobileMenu');
    var progress = document.getElementById('scrollProgress');
    var reduced  = matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* ---- sliding pill ---------------------------------------------- */
    var activeLink = nav ? nav.querySelector('a.active') : null;

    function movePill(el) {
        if (!pill || !el || !nav.offsetParent) return;   // hidden on mobile
        pill.style.width = el.offsetWidth + 'px';
        pill.style.transform = 'translate(' + el.offsetLeft + 'px, -50%)';
        pill.classList.add('ready');
    }
    function resetPill() { movePill(activeLink); if (!activeLink && pill) pill.classList.remove('ready'); }

    if (nav) {
        nav.querySelectorAll('a').forEach(function (a) {
            a.addEventListener('mouseenter', function () { movePill(a); });
            a.addEventListener('focus', function () { movePill(a); });
        });
        nav.addEventListener('mouseleave', resetPill);
        nav.addEventListener('focusout', resetPill);
        // Fonts change link widths, so place it once they have settled.
        if (document.fonts && document.fonts.ready) document.fonts.ready.then(resetPill);
        else window.addEventListener('load', resetPill);
        resetPill();
        window.addEventListener('resize', resetPill);
    }

    /* ---- shrink-on-scroll + progress ------------------------------- */
    var ticking = false;
    function onScroll() {
        var y = window.scrollY || document.documentElement.scrollTop;
        header.classList.toggle('is-stuck', y > 12);

        if (progress) {
            var doc = document.documentElement;
            var max = (doc.scrollHeight - window.innerHeight) || 1;
            progress.style.transform = 'scaleX(' + Math.min(1, y / max) + ')';
        }
        // Link widths do not move, but the pill's offset does if the bar reflows.
        if (!reduced) resetPill();
        ticking = false;
    }
    window.addEventListener('scroll', function () {
        if (!ticking) { ticking = true; requestAnimationFrame(onScroll); }
    }, { passive: true });
    onScroll();

    /* ---- mobile menu ----------------------------------------------- */
    function setMenu(open) {
        burger.setAttribute('aria-expanded', open ? 'true' : 'false');
        menu.classList.toggle('open', open);
        // Stop the page behind the panel from scrolling with it.
        document.body.style.overflow = open ? 'hidden' : '';
    }
    burger.addEventListener('click', function () {
        setMenu(burger.getAttribute('aria-expanded') !== 'true');
    });
    menu.querySelectorAll('a').forEach(function (a) {
        a.addEventListener('click', function () { setMenu(false); });
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') setMenu(false);
    });
    // Resizing past the breakpoint should not leave the panel stuck open.
    window.addEventListener('resize', function () {
        if (window.innerWidth > 860) setMenu(false);
    });
})();
</script>
