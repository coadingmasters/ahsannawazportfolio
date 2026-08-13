{{-- ============================================
     PORTFOLIO HEADER — Dark + Orange Theme
     Color Scheme Variables (use these site-wide):
     --bg-dark:    var(--bg)  (main background)
     --bg-card:    var(--surface)  (cards/sections)
     --orange:     var(--accent)  (brand accent)
     --orange-lgt: var(--accent-hover)  (hover orange)
     --text-white: var(--text)  (primary text)
     --text-muted: var(--text-3)  (secondary text)
============================================ --}}

<style>
:root {
    --bg-dark: var(--bg);
    --bg-card: var(--surface);
    --bg-nav: rgba(255, 255, 255, 0.85);
    --orange: var(--accent);
    --orange-light: var(--accent-hover);
    --orange-dim: rgba(15, 118, 110, 0.12);
    --text-white: var(--text);
    --text-muted: var(--text-3);
}

* { margin: 0; padding: 0; box-sizing: border-box; }

body {
    background: var(--bg-dark);
    color: var(--text-white);
    font-family: 'DM Sans', system-ui, -apple-system, sans-serif;
}

/* ===== HEADER ===== */
header {
    background: var(--bg-nav);
    border-bottom: 1px solid var(--border);
    position: sticky;
    top: 0;
    z-index: 1000;
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
}

.header-inner {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1.5rem;
    height: 68px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

/* ===== LOGO ===== */
.logo {
    display: flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
}

.logo-icon {
    width: 38px;
    height: 38px;
    background: var(--orange);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    font-weight: 700;
    color: var(--text);
    flex-shrink: 0;
    transition: transform 0.2s, box-shadow 0.2s;
}

.logo:hover .logo-icon {
    transform: scale(1.08) rotate(-4deg);
    box-shadow: 0 0 18px rgba(15, 118, 110, 0.4);
}

.logo-text {
    font-size: 18px;
    font-weight: 700;
    color: var(--text-white);
}

.logo-text span { color: var(--orange); }

/* ===== DESKTOP NAV ===== */
nav { display: flex; align-items: center; gap: 4px; }

nav a {
    text-decoration: none;
    color: var(--text-muted);
    font-size: 16px;
    font-weight: 600;
    padding: 8px 14px;
    border-radius: 8px;
    transition: color 0.2s, background 0.2s;
    position: relative;
}

nav a::after {
    content: '';
    position: absolute;
    bottom: 4px;
    left: 50%;
    transform: translateX(-50%);
    width: 0;
    height: 2px;
    background: var(--orange);
    border-radius: 2px;
    transition: width 0.25s;
}

nav a:hover,
nav a.active {
    color: var(--text-white);
    background: var(--orange-dim);
}

nav a:hover::after,
nav a.active::after { width: 60%; }

nav a.active { color: var(--orange); }

/* ===== CTA BUTTON ===== */
.btn-hire {
    background: var(--orange);
    color: var(--text);
    border: none;
    padding: 9px 20px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
    white-space: nowrap;
    display: inline-block;
}

.btn-hire:hover {
    background: var(--orange-light);
    transform: translateY(-1px);
    box-shadow: 0 4px 16px rgba(15, 118, 110, 0.35);
}

.btn-hire:active { transform: translateY(0); }

/* ===== HAMBURGER ===== */
.hamburger {
    display: none;
    flex-direction: column;
    justify-content: center;
    gap: 5px;
    width: 36px;
    height: 36px;
    background: none;
    border: 1px solid var(--border);
    border-radius: 8px;
    cursor: pointer;
    padding: 8px;
}

.hamburger span {
    display: block;
    height: 2px;
    background: var(--text-white);
    border-radius: 2px;
    transition: all 0.3s;
}

.hamburger.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
.hamburger.open span:nth-child(2) { opacity: 0; transform: scaleX(0); }
.hamburger.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

/* ===== MOBILE MENU ===== */
.mobile-menu {
    display: none;
    background: var(--bg-card);
    border-top: 1px solid var(--border);
    padding: 1rem 1.5rem 1.5rem;
    flex-direction: column;
    gap: 4px;
    animation: slideDown 0.25s ease;
}

.mobile-menu.open { display: flex; }

.mobile-menu a {
    text-decoration: none;
    color: var(--text-muted);
    font-size: 15px;
    font-weight: 500;
    padding: 10px 12px;
    border-radius: 8px;
    border-left: 2px solid transparent;
    transition: color 0.2s, background 0.2s, border-color 0.2s;
}

.mobile-menu a:hover,
.mobile-menu a.active {
    color: var(--orange);
    background: var(--orange-dim);
    border-left-color: var(--orange);
}

.mobile-menu .btn-hire {
    margin-top: 10px;
    text-align: center;
    border-left: none !important;
}

/* ===== ANIMATIONS ===== */
@keyframes slideDown {
    from { opacity: 0; transform: translateY(-8px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    nav { display: none; }
    .header-cta .btn-hire { display: none; }
    .hamburger { display: flex; }
}

@media (max-width: 480px) {
    .header-inner { padding: 0 1rem; }
    .logo-text { font-size: 16px; }
}
</style>

<header id="mainHeader">
    <div class="header-inner">

        {{-- Logo --}}
        <a href="{{ url('/') }}" class="logo">
    <div class="logo-icon">A</div>
    <span class="logo-text">
        Ahsan Nawaz<span>.dev</span>
    </span>
</a>

        {{-- Desktop Navigation --}}
        <nav>
            <a href="{{ url('/') }}"       class="{{ request()->is('/') ? 'active' : '' }}">Home</a>
            <a href="{{ route('about') }}"    class="{{ request()->is('about') ? 'active' : '' }}">About</a>
            <a href="{{ route('skills') }}"   class="{{ request()->is('skills') ? 'active' : '' }}">Skills</a>
            <a href="{{ route('projects') }}" class="{{ request()->is('projects') ? 'active' : '' }}">Projects</a>
            <a href="{{ route('contact') }}"  class="{{ request()->is('contact') ? 'active' : '' }}">Contact</a>
        </nav>

        {{-- CTA + Hamburger --}}
        <div style="display:flex;align-items:center;gap:12px;">
            <a href="{{ route('contact') }}" class="btn-hire">Hire Me</a>
            <button class="hamburger" id="hamburger" aria-label="Toggle menu">
                <span></span><span></span><span></span>
            </button>
        </div>

    </div>

    {{-- Mobile Menu --}}
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
    const hamburger = document.getElementById('hamburger');
    const mobileMenu = document.getElementById('mobileMenu');

    hamburger.addEventListener('click', () => {
        hamburger.classList.toggle('open');
        mobileMenu.classList.toggle('open');
    });

    // Close mobile menu when a link is clicked
    mobileMenu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            hamburger.classList.remove('open');
            mobileMenu.classList.remove('open');
        });
    });
</script>