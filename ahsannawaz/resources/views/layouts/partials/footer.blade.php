

{{-- ═══════════════════════════════════════════
     FOOTER
═══════════════════════════════════════════ --}}
<footer>

    <div class="f-blob f-blob-1"></div>
    <div class="f-blob f-blob-2"></div>

    {{-- ── MAIN GRID ── --}}
    <div class="footer-main">

        {{-- COL 1: Brand --}}
        <div class="f-brand">
            <a href="{{ url('/') }}" class="brand-logo" aria-label="Ahsan Nawaz — home">
                {{-- The footer has the vertical room for the full lockup, so it
                     carries the artwork rather than the text wordmark. --}}
                <img class="footer-logo"
                     src="{{ asset('images/brand/logo-220.webp') }}"
                     srcset="{{ asset('images/brand/logo-220.webp') }} 220w,
                             {{ asset('images/brand/logo-330.webp') }} 330w,
                             {{ asset('images/brand/logo-440.webp') }} 440w"
                     sizes="(max-width: 640px) 180px, 220px"
                     width="220" height="156" loading="lazy" decoding="async"
                     alt="Ahsan Nawaz — Web Developer">
            </a>

            <p class="brand-desc">
                Passionate full-stack developer crafting clean, scalable, and pixel-perfect web experiences.
                From powerful Laravel backends to dynamic React frontends — let's build something great together.
            </p>

            <div class="social-row">
                @include('layouts.partials.socials', ['class' => 'social-link'])
            
            </div>
        </div>

        {{-- COL 2: Quick Links --}}
        <div class="f-links">
            <h4 class="f-col-title">Quick Links</h4>
            <ul class="f-nav">
                <li><a href="#"><span class="arr">›</span> Home</a></li>
                <li><a href="#about"><span class="arr">›</span> About Me</a></li>
                <li><a href="#portfolio"><span class="arr">›</span> Portfolio</a></li>
                <li><a href="#testimonials"><span class="arr">›</span> Testimonials</a></li>
                <li><a href="#contact"><span class="arr">›</span> Contact</a></li>
                @if ($hasCv)
                    <li><a href="{{ route('cv.download') }}"><span class="arr">›</span> Download CV</a></li>
                @endif
            </ul>
        </div>

        {{-- COL 4: Newsletter --}}
        <div class="f-newsletter">
            <div class="newsletter-card">
                <div class="newsletter-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M22 13V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8"/>
                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                        <path d="M16 19h6M19 16v6"/>
                    </svg>
                </div>
                <h4 class="newsletter-title">Stay in the Loop</h4>
                <p class="newsletter-sub">Get the latest dev tips, project updates, and exclusive offers delivered straight to your inbox. No spam — ever.</p>

                <div class="input-wrap">
                    <div class="newsletter-form-row" id="newsletter-form-row">
                        <div class="email-field">
                            <input type="email" id="newsletter-email" placeholder="your@email.com" autocomplete="email">
                            <span class="email-icon">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M22 13V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8"/>
                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                                </svg>
                            </span>
                        </div>

                        <button class="subscribe-btn" id="subscribe-btn" onclick="handleSubscribe()">
                            <span id="btn-label">Subscribe Now</span>
                            <svg class="btn-arrow" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" id="btn-icon">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>

                    <div class="subscribe-success" id="sub-success">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M20 6 9 17l-5-5"/></svg>
                        You're subscribed! Welcome aboard 🎉
                    </div>

                    <p class="privacy-note">🔒 Your privacy is safe. Unsubscribe anytime.</p>
                </div>
            </div>
        </div>

    </div>

    <button class="footer-backtop-floating" onclick="window.scrollTo({top:0,behavior:'smooth'})" aria-label="Back to top">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M12 19V5M5 12l7-7 7 7"/>
        </svg>
        Back to top
    </button>

    {{-- ── BOTTOM BAR (Copyright only) ── --}}
    <div class="footer-bottom">
        <div class="footer-bottom-inner">
            <p class="copyright">
                © 2026 <span>Ahsan Nawaz</span>. <strong>All rights reserved</strong>. Made with <span class="heart">♥</span> in Pakistan.
            </p>
        </div>
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
