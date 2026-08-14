

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
            <a href="#" class="brand-logo">
                <span class="logo-text">Ahsan Nawaz<em>.dev</em></span>
            </a>

            <p class="brand-desc">
                Passionate full-stack developer crafting clean, scalable, and pixel-perfect web experiences.
                From powerful Laravel backends to dynamic React frontends — let's build something great together.
            </p>

            <div class="social-row">
                {{-- Facebook --}}
                <a href="#" class="social-link" title="Facebook" aria-label="Facebook">
                    <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                </a>
                {{-- LinkedIn --}}
                <a href="#" class="social-link" title="LinkedIn" aria-label="LinkedIn">
                    <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-4 0v7h-4v-7a6 6 0 0 1 6-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>
                </a>
                {{-- GitHub --}}
                <a href="#" class="social-link" title="GitHub" aria-label="GitHub">
                    <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"/></svg>
                </a>
                {{-- Twitter/X --}}
                <a href="#" class="social-link" title="Twitter / X" aria-label="Twitter">
                    <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.748l7.73-8.835L1.254 2.25H8.08l4.259 5.63zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                </a>
                {{-- Fiverr --}}
                <a href="#" class="social-link" title="Fiverr" aria-label="Fiverr">
                    <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24"><path d="M23 9.49h-4.47a7.67 7.67 0 0 0-7.42-5.75 7.67 7.67 0 0 0-7.42 7.67 7.67 7.67 0 0 0 7.42 7.67V22H5v-2.92A10.5 10.5 0 0 1 1 11.41a10.5 10.5 0 0 1 10.11-10.5 10.5 10.5 0 0 1 10.11 8.58H23zm-2 2h-8v8h2v-6h4v4h2z"/></svg>
                </a>
                {{-- Upwork --}}
                <a href="#" class="social-link" title="Upwork" aria-label="Upwork">
                    <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24"><path d="M18.5 9.5c-1.9 0-3.4 1.2-4 3H14l-1.5-5H10l1.5 5.5c-.5 2-1.5 3-3 3-1.7 0-2.8-1.2-2.8-3s1.1-3 2.8-3c.4 0 .7.1 1 .2L10 8.2C9.4 8 8.7 7.9 8.1 7.9 5 7.9 2.5 10.4 2.5 13.5s2.5 5.6 5.6 5.6c2.5 0 4.4-1.5 5.1-4h.4c.6 1.8 2.1 4 4.9 4C21 19.1 23.5 16.6 23.5 13.5s-2.5-4-5-4zm0 8c-1.7 0-2.8-1.5-3-3 .2-1.7 1.3-3 3-3s3 1.3 3 3-1.3 3-3 3z"/></svg>
                </a>
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
