{{-- ============================================
     SITE HEADER
     Colours come from theme.css. The aliases below only exist because
     older stylesheets on these pages still reference --orange etc.
============================================ --}}


<a class="skip-link" href="#main-content">Skip to content</a>

<header class="site-header" id="mainHeader">
    <div class="header-inner">

        <a href="{{ url('/') }}" class="brand" aria-label="Ahsan Nawaz — home">
            {{-- The mark is the artwork; the name stays live text so it holds
                 its edge at any size and keeps the entrance animation. --}}
            <img class="brand-mark"
                 src="{{ asset('images/brand/logo-mark-96.webp') }}"
                 srcset="{{ asset('images/brand/logo-mark-96.webp') }} 96w,
                         {{ asset('images/brand/logo-mark-144.webp') }} 144w,
                         {{ asset('images/brand/logo-mark-192.webp') }} 192w"
                 sizes="64px" width="64" height="39" alt="" aria-hidden="true"
                 fetchpriority="high" decoding="async">
            <span class="brand-name">
                <span>Ahsan</span><span>&nbsp;Nawaz</span><span class="dot">.dev</span>
            </span>
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
        ticking = false;
    }
    window.addEventListener('scroll', function () {
        if (!ticking) { ticking = true; requestAnimationFrame(onScroll); }
    }, { passive: true });

    // The bar changes height when it sticks, which is the only scroll-driven
    // event that can move the pill. Reading geometry here costs one layout
    // instead of one per frame.
    header.addEventListener('transitionend', function (e) {
        if (e.propertyName === 'height') resetPill();
    });
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
