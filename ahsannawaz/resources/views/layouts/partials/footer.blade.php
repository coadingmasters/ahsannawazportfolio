

{{-- ═══════════════════════════════════════════
     FOOTER
═══════════════════════════════════════════ --}}
<footer class="site-footer">
    <div class="f-inner">

        {{-- Brand --}}
        <div class="f-brand">
            <a href="{{ url('/') }}" class="brand-logo" aria-label="Ahsan Nawaz — home">
                <img class="footer-logo"
                     src="{{ asset('images/brand/logo-220.webp') }}"
                     srcset="{{ asset('images/brand/logo-220.webp') }} 220w,
                             {{ asset('images/brand/logo-330.webp') }} 330w,
                             {{ asset('images/brand/logo-440.webp') }} 440w"
                     sizes="(max-width: 640px) 180px, 220px"
                     width="220" height="156" loading="lazy" decoding="async"
                     alt="Ahsan Nawaz — Web Developer">
            </a>

            <p class="f-desc">
                Full-stack developer building Laravel applications, REST APIs and
                WordPress sites for clients worldwide. Clean code, honest timelines,
                support that continues after launch.
            </p>

            <div class="f-socials">
                @include('layouts.partials.socials', ['class' => 'social-link'])
            </div>
        </div>

        {{-- Every link here resolves to a real route; none is a "#". --}}
        {{-- Trimmed to the pages a visitor actually goes looking for. The
             rest are one click away on the sitemap rather than listed twice,
             and FAQ and Contact already sit in the bottom bar. --}}
        <nav class="f-col" aria-label="Quick links">
            <h2 class="f-title">Quick Links</h2>
            <ul>
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ route('about') }}">About</a></li>
                <li><a href="{{ route('projects') }}">Projects</a></li>
                @if (\App\Models\Post::published()->exists())
                    <li><a href="{{ route('blog') }}">Blog</a></li>
                @endif
                <li><a href="{{ route('sitemap.page') }}">All pages</a></li>
            </ul>
        </nav>

        <nav class="f-col" aria-label="Services">
            <h2 class="f-title">Services</h2>
            <ul>
                <li><a href="{{ route('contact') }}?service=laravel">Laravel Development</a></li>
                <li><a href="{{ route('contact') }}?service=api">REST API Development</a></li>
                <li><a href="{{ route('contact') }}?service=admin">Admin Panels</a></li>
                <li><a href="{{ route('contact') }}?service=wordpress">WordPress &amp; WooCommerce</a></li>
                <li><a href="{{ route('contact') }}?service=performance">Performance &amp; SEO</a></li>
            </ul>
        </nav>

        <div class="f-col f-contact">
            <h2 class="f-title">Get in touch</h2>
            <ul>
                <li>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 4h16v16H4z"/><path d="m4 6 8 6 8-6"/></svg>
                    <a href="mailto:hello@ahsannawaz.dev">hello@ahsannawaz.dev</a>
                </li>
                <li>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 21s-7-6.2-7-11a7 7 0 1 1 14 0c0 4.8-7 11-7 11z"/><circle cx="12" cy="10" r="2.5"/></svg>
                    <span>Pakistan · Working remotely</span>
                </li>
                <li>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
                    <span>Replies within 24 hours</span>
                </li>
            </ul>

            <a href="{{ route('contact') }}" class="btn-primary f-cta">
                Start a project
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-7-7 7 7-7 7"/></svg>
            </a>
        </div>
    </div>

    <div class="f-bar">
        <p>&copy; {{ date('Y') }} Ahsan Nawaz. All rights reserved.</p>
        <p class="f-bar-links">
            <a href="{{ route('faq') }}">FAQ</a>
            <span aria-hidden="true">·</span>
            <a href="{{ route('privacy') }}">Privacy Policy</a>
            <span aria-hidden="true">·</span>
            <a href="{{ route('terms') }}">Terms</a>
            <span aria-hidden="true">·</span>
            <a href="{{ route('sitemap.page') }}">Sitemap</a>
            <span aria-hidden="true">·</span>
            <a href="{{ route('contact') }}">Contact</a>
        </p>
    </div>
</footer>

<script>
function handleSubscribe() {
    const emailInput = document.getElementById('newsletter-email');
    const btn        = document.getElementById('subscribe-btn');
    const label      = document.getElementById('btn-label');
    const icon       = document.getElementById('btn-icon');
    const formRow    = document.getElementById('newsletter-form-row');
    const success    = document.getElementById('sub-success');
    const email      = emailInput.value.trim();

    if (!email || !email.includes('@')) {
        emailInput.focus();
        emailInput.style.borderColor = '#ef4444';
        emailInput.style.boxShadow   = '0 0 0 3px rgba(239,68,68,0.15)';
        setTimeout(() => {
            emailInput.style.borderColor = '';
            emailInput.style.boxShadow   = '';
        }, 2000);
        return;
    }

    // Loading state
    btn.disabled = true;
    label.textContent = 'Subscribing…';
    icon.innerHTML = '<circle cx="12" cy="12" r="8" stroke-dasharray="50" stroke-dashoffset="0" style="animation:spin 0.8s linear infinite;transform-origin:center"/>';

    setTimeout(() => {
        btn.style.display      = 'none';
        if (formRow) formRow.style.display = 'none';
        success.style.display  = 'flex';
    }, 1200);
}
</script>
