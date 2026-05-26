
<style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --orange:       #F97316;
            --orange-soft:  rgba(249,115,22,0.15);
            --orange-glow:  rgba(249,115,22,0.08);
            --bg:           #0d0d0d;
            --surface:      #161616;
            --surface2:     #1f1f1f;
            --border:       rgba(255,255,255,0.07);
            --border-o:     rgba(249,115,22,0.25);
            --text:         #ffffff;
            --muted:        #8a8a8a;
            --muted2:       #555;
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'Inter', sans-serif;
        }

        /* ════════════════════════════════════════
           FOOTER WRAPPER
        ════════════════════════════════════════ */
        footer {
            position: relative;
            overflow: hidden;
            background: var(--bg);
        }

        /* Top glowing divider line */
        footer::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg,
                transparent 0%,
                var(--orange) 30%,
                rgba(249,115,22,0.5) 50%,
                var(--orange) 70%,
                transparent 100%
            );
            animation: shimmer 4s ease-in-out infinite;
        }
        @keyframes shimmer {
            0%, 100% { opacity: 0.5; }
            50%       { opacity: 1; }
        }

        /* Ambient glow blobs */
        .f-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(140px);
            pointer-events: none;
            z-index: 0;
        }
        .f-blob-1 {
            width: 500px; height: 300px;
            background: radial-gradient(ellipse, rgba(249,115,22,0.07) 0%, transparent 70%);
            top: 0; left: -100px;
        }
        .f-blob-2 {
            width: 400px; height: 300px;
            background: radial-gradient(ellipse, rgba(249,115,22,0.05) 0%, transparent 70%);
            bottom: 0; right: -50px;
        }

        /* ════════════════════════════════════════
           MAIN FOOTER CONTENT
        ════════════════════════════════════════ */
        .footer-main {
            position: relative;
            z-index: 1;
            max-width: 1280px;
            margin: 0 auto;
            padding: 72px 50px 56px;
            display: grid;
            grid-template-columns: 1.4fr 1fr 1.6fr;
            gap: 3rem;
        }

        /* ── COL 1: Brand ── */
        .f-brand {}

        .brand-logo {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            margin-bottom: 1.4rem;
        }
        .logo-icon {
            width: 46px; height: 46px;
            background: var(--orange);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Syne', sans-serif;
            font-size: 1.25rem;
            font-weight: 800;
            color: #fff;
            flex-shrink: 0;
            box-shadow: 0 0 0 0 rgba(249,115,22,0.4);
            transition: box-shadow 0.3s, transform 0.3s;
        }
        .brand-logo:hover .logo-icon {
            transform: scale(1.06);
            box-shadow: 0 0 20px rgba(249,115,22,0.4);
        }
        .logo-text {
            font-family: 'Syne', sans-serif;
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--text);
            letter-spacing: -0.02em;
        }
        .logo-text em {
            color: var(--orange);
            font-style: normal;
        }

        .brand-desc {
            font-size: 0.875rem;
            line-height: 1.75;
            color: var(--muted);
            margin-bottom: 1.6rem;
            max-width: 280px;
        }

        /* Social icons */
        .social-row {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }
        .social-link {
            width: 38px; height: 38px;
            border-radius: 9px;
            border: 1px solid var(--border);
            background: var(--surface);
            display: flex; align-items: center; justify-content: center;
            color: var(--muted);
            text-decoration: none;
            font-size: 0.9rem;
            transition: border-color 0.25s, color 0.25s, background 0.25s, transform 0.25s;
            position: relative;
            overflow: hidden;
        }
        .social-link::before {
            content: '';
            position: absolute;
            inset: 0;
            background: var(--orange-soft);
            transform: scale(0);
            border-radius: inherit;
            transition: transform 0.25s;
        }
        .social-link:hover::before { transform: scale(1); }
        .social-link:hover {
            border-color: var(--border-o);
            color: var(--orange);
            transform: translateY(-3px);
        }
        .social-link svg { position: relative; z-index: 1; }

        /* ── COL 2 & 3: Quick Links ── */
        .f-links {}

        .f-col-title {
            font-family: 'Syne', sans-serif;
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--orange);
            margin-bottom: 1.4rem;
            position: relative;
            padding-bottom: 0.7rem;
        }
        .f-col-title::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0;
            width: 28px; height: 2px;
            background: var(--orange);
            border-radius: 2px;
        }

        .f-nav { list-style: none; display: flex; flex-direction: column; gap: 0.6rem; }
        .f-nav a {
            font-size: 0.875rem;
            color: var(--muted);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            transition: color 0.2s, gap 0.2s;
        }
        .f-nav a .arr {
            font-size: 0.75rem;
            color: var(--orange);
            opacity: 0;
            transform: translateX(-4px);
            transition: opacity 0.2s, transform 0.2s;
        }
        .f-nav a:hover { color: #fff; gap: 10px; }
        .f-nav a:hover .arr { opacity: 1; transform: translateX(0); }

        /* Services tags */
        .tags-wrap {
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
            margin-top: 0.2rem;
        }
        .tag {
            font-size: 0.72rem;
            font-weight: 500;
            padding: 4px 10px;
            border-radius: 999px;
            border: 1px solid var(--border);
            background: var(--surface);
            color: var(--muted);
            transition: border-color 0.2s, color 0.2s, background 0.2s;
            cursor: default;
        }
        .tag:hover {
            border-color: var(--border-o);
            color: var(--orange);
            background: var(--orange-glow);
        }

        /* ── COL 4: Newsletter ── */
        .f-newsletter {}

        .newsletter-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 1.8rem;
            position: relative;
            overflow: hidden;
            transition: border-color 0.3s;
        }
        .newsletter-card:hover { border-color: var(--border-o); }
        .newsletter-card::before {
            content: '';
            position: absolute;
            top: -40px; right: -40px;
            width: 120px; height: 120px;
            background: radial-gradient(circle, rgba(249,115,22,0.12) 0%, transparent 70%);
            pointer-events: none;
        }

        .newsletter-icon {
            width: 42px; height: 42px;
            background: var(--orange-soft);
            border: 1px solid var(--border-o);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 1rem;
            color: var(--orange);
        }
        .newsletter-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 0.45rem;
        }
        .newsletter-sub {
            font-size: 0.8rem;
            color: var(--muted);
            line-height: 1.6;
            margin-bottom: 1.2rem;
        }

        /* Email field */
        .input-wrap {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .newsletter-form-row {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .newsletter-form-row .email-field {
            flex: 1;
        }
        .email-field {
            position: relative;
        }
        .email-field input {
            width: 100%;
            background: var(--surface2);
            border: 1px solid var(--border);
            border-radius: 9px;
            padding: 11px 14px 11px 38px;
            font-size: 0.85rem;
            color: var(--text);
            outline: none;
            font-family: 'Inter', sans-serif;
            transition: border-color 0.25s, box-shadow 0.25s;
        }
        .email-field input::placeholder { color: var(--muted2); }
        .email-field input:focus {
            border-color: var(--orange);
            box-shadow: 0 0 0 3px rgba(249,115,22,0.12);
        }
        .email-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted2);
            pointer-events: none;
            transition: color 0.25s;
        }
        .email-field input:focus ~ .email-icon { color: var(--orange); }

        .subscribe-btn {
            flex: 0 0 180px;
            width: auto;
            background: var(--orange);
            color: #000;
            font-weight: 700;
            font-size: 0.875rem;
            font-family: 'Syne', sans-serif;
            padding: 11px 16px;
            border: none;
            border-radius: 9px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            transition: background 0.25s, transform 0.2s, box-shadow 0.25s;
            position: relative;
            overflow: hidden;
        }
        .subscribe-btn::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent);
            transition: left 0.4s;
        }
        .subscribe-btn:hover::before { left: 100%; }
        .subscribe-btn:hover {
            background: #fb923c;
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(249,115,22,0.35);
        }
        .subscribe-btn:active { transform: translateY(0); }
        .subscribe-btn .btn-arrow { transition: transform 0.2s; }
        .subscribe-btn:hover .btn-arrow { transform: translateX(3px); }

        /* Success state */
        .subscribe-success {
            display: none;
            align-items: center;
            gap: 8px;
            background: rgba(34,197,94,0.1);
            border: 1px solid rgba(34,197,94,0.25);
            border-radius: 9px;
            padding: 10px 14px;
            font-size: 0.8rem;
            color: #4ade80;
        }
        .privacy-note {
            font-size: 0.7rem;
            color: var(--muted2);
            text-align: center;
            margin-top: 4px;
        }

        /* ════════════════════════════════════════
           FOOTER BOTTOM BAR
        ════════════════════════════════════════ */
        .footer-bottom {
            position: relative;
            z-index: 1;
            border-top: 1px solid var(--border);
            padding: 20px 50px;
        }
        .footer-bottom-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .copyright {
            font-size: 0.8rem;
            color: var(--muted);
        }
        .copyright span { color: var(--orange); font-weight: 600; }
        .heart { color: #ef4444; display: inline-block; animation: heartbeat 1.4s ease-in-out infinite; }
        @keyframes heartbeat {
            0%, 100% { transform: scale(1); }
            14%       { transform: scale(1.25); }
            28%       { transform: scale(1); }
            42%       { transform: scale(1.15); }
            56%       { transform: scale(1); }
        }

        .bottom-links {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }
        .bottom-links a {
            font-size: 0.78rem;
            color: var(--muted);
            text-decoration: none;
            transition: color 0.2s;
        }
        .bottom-links a:hover { color: var(--orange); }
        .bottom-sep { width: 1px; height: 12px; background: var(--border); }

        .back-top {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.78rem;
            color: var(--muted);
            cursor: pointer;
            transition: color 0.2s;
            background: none;
            border: none;
            font-family: 'Inter', sans-serif;
        }
        .back-top:hover { color: var(--orange); }
        .back-top svg { transition: transform 0.2s; }
        .back-top:hover svg { transform: translateY(-3px); }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .footer-backtop-floating {
            position: absolute;
            right: 50px;
            bottom: 40px;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            border-radius: 999px;
            cursor: pointer;
            background: rgba(22, 22, 22, 0.55);
            border: 1px solid rgba(249, 115, 22, 0.30);
            color: var(--muted);
            backdrop-filter: blur(10px);
            transition: transform 0.2s, border-color 0.2s, background 0.2s, color 0.2s;
            animation: backtopFloat 2.4s ease-in-out infinite;
        }

        .footer-backtop-floating:hover {
            transform: translateY(-3px);
            border-color: rgba(249, 115, 22, 0.55);
            background: rgba(249, 115, 22, 0.10);
            color: #fff;
        }

        .footer-backtop-floating svg { flex-shrink: 0; }

        @keyframes backtopFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        /* ════════════════════════════════════════
           RESPONSIVE
        ════════════════════════════════════════ */
        @media (max-width: 1100px) {
            .footer-main { grid-template-columns: 1fr 1fr; gap: 2.5rem; }
            .f-newsletter { grid-column: 1 / -1; }
            .newsletter-card { max-width: 480px; }
        }

        @media (max-width: 680px) {
            .footer-main { grid-template-columns: 1fr; padding: 48px 1.25rem 40px; gap: 2rem; }
            .f-newsletter { grid-column: auto; }
            .newsletter-card { max-width: 100%; }
            .newsletter-form-row { flex-direction: column; align-items: stretch; }
            .subscribe-btn { flex: 0 0 auto; width: 100%; }
        }
</style>

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
                <div class="logo-icon">A</div>
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
                <li><a href="#"><span class="arr">›</span> Download CV</a></li>
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
