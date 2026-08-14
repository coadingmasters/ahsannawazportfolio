<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('layouts.partials.seo', [
        'title' => 'Contact',
        'titleFull' => "Hire a Laravel Developer | Contact Ahsan Nawaz",
        "description" => "Hire Ahsan Nawaz for Laravel, PHP, React or WordPress work. Free for freelance projects and long-term contracts — every message answered within 24 hours.",
        'keywords' => 'hire Laravel developer, hire PHP developer, freelance WordPress developer, contact web developer Pakistan',
        'type' => 'website',
    ])
    <link rel="preload" as="font" type="font/woff2" crossorigin
          href="{{ asset('fonts/sora-latin.woff2') }}">
    <link rel="preload" as="font" type="font/woff2" crossorigin
          href="{{ asset('fonts/dm-sans-latin.woff2') }}">
    {{-- Critical CSS inline; the rest loads without blocking paint. --}}
    @styles('contact')
</head>
<body>

    @include('layouts.partials.header')

    <main id="main-content">

    {{-- ══════════════════════════════════════
         PAGE HERO
    ══════════════════════════════════════ --}}
    <section class="ab-hero">
        <div class="ab-blob ab-blob-1"></div>
        <div class="ab-blob ab-blob-2"></div>
        <div class="ab-grid-bg"></div>

        <div class="ab-hero-inner">
            <nav class="ab-crumb ab-rv">
                <a href="{{ url('/') }}">Home</a>
                <span>/</span>
                <span class="ab-crumb-current">Contact</span>
            </nav>

            <h1 class="ab-hero-title ab-rv" style="transition-delay:0.08s">
                Let's <em>Talk</em>
            </h1>

            <p class="ab-hero-sub ab-rv" style="transition-delay:0.16s">
                Have a project, an idea, or just a question? I read every message and reply within 24 hours.
            </p>

            <div class="cp-hero-status ab-rv" style="transition-delay:0.22s">
                <span class="ct-status-dot"></span>
                Currently available for new projects
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════
         CONTACT METHODS
    ══════════════════════════════════════ --}}
    <section class="cp-methods">
        <div class="ab-inner">
            <div class="cp-method-grid">

                <a href="mailto:hello@ahsannawaz.dev" class="cp-method ab-rv" data-delay="0" style="--mc:#c2410c">
                    <span class="cp-method-ico">✉</span>
                    <h3 class="cp-method-title">Email Me</h3>
                    <p class="cp-method-desc">The fastest way to reach me. I reply to everything.</p>
                    <span class="cp-method-value">hello@ahsannawaz.dev</span>
                </a>

                <div class="cp-method ab-rv" data-delay="1" style="--mc:#0e7490">
                    <span class="cp-method-ico">◎</span>
                    <h3 class="cp-method-title">Location</h3>
                    <p class="cp-method-desc">Based in Pakistan, working with clients worldwide.</p>
                    <span class="cp-method-value">Pakistan 🇵🇰 · Remote</span>
                </div>

                <div class="cp-method ab-rv" data-delay="2" style="--mc:#15803d">
                    <span class="cp-method-ico">◷</span>
                    <h3 class="cp-method-title">Response Time</h3>
                    <p class="cp-method-desc">No message goes unanswered for more than a day.</p>
                    <span class="cp-method-value">Within 24 hours</span>
                </div>

                @if (config('social.fiverr'))
                <a href="{{ config('social.fiverr') }}" target="_blank" rel="noopener noreferrer"
                   class="cp-method ab-rv" data-delay="3" style="--mc:#b45309">
                    <span class="cp-method-ico">⭐</span>
                    <h3 class="cp-method-title">Hire on Fiverr</h3>
                    <p class="cp-method-desc">Prefer an escrow platform? Find me there.</p>
                    <span class="cp-method-value">5-Star Rated →</span>
                </a>
                @endif

            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════
         FORM + ASIDE
    ══════════════════════════════════════ --}}
    <section class="cp-form-section" id="contact">
        <div class="ab-blob ab-blob-3"></div>
        <div class="ab-inner">

            <div class="ab-head ab-rv">
                <span class="ab-label">Send a Message</span>
                <h2 class="ab-h2 ab-center">Tell me about your <em>project</em></h2>
                <p class="ab-head-desc">
                    The more detail you share, the more useful my first reply will be.
                </p>
            </div>

            <div class="cp-grid">

                {{-- ── FORM ── --}}
                <div class="ct-form-wrap ab-rv">

                    <form method="POST" action="{{ route('contact.store') }}" class="ct-form">
                        @csrf

                        {{-- Honeypot — hidden from humans, catches bots --}}
                        <div class="ct-hp" aria-hidden="true">
                            <label for="website">Website</label>
                            <input id="website" type="text" name="website" tabindex="-1" autocomplete="off">
                        </div>

                        <div class="ct-row">
                            <div class="ct-field">
                                <label for="ct-name">Your Name <span>*</span></label>
                                <input id="ct-name" type="text" name="name" value="{{ old('name') }}"
                                       placeholder="John Doe" maxlength="100" required>
                                @error('name') <div class="ct-err">{{ $message }}</div> @enderror
                            </div>

                            <div class="ct-field">
                                <label for="ct-email">Email <span>*</span></label>
                                <input id="ct-email" type="email" name="email" value="{{ old('email') }}"
                                       placeholder="john@company.com" maxlength="150" required>
                                @error('email') <div class="ct-err">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="ct-row">
                            <div class="ct-field">
                                <label for="ct-subject">Subject <span>*</span></label>
                                <input id="ct-subject" type="text" name="subject" value="{{ old('subject') }}"
                                       placeholder="Laravel project enquiry" maxlength="200" required>
                                @error('subject') <div class="ct-err">{{ $message }}</div> @enderror
                            </div>

                            <div class="ct-field">
                                <label for="ct-budget">Budget <span class="ct-opt">(optional)</span></label>
                                <select id="ct-budget" name="budget">
                                    <option value="">Select a range</option>
                                    @foreach (['< $500', '$500 – $1k', '$1k – $5k', '$5k – $10k', '$10k+'] as $range)
                                        <option value="{{ $range }}" @selected(old('budget') === $range)>{{ $range }}</option>
                                    @endforeach
                                </select>
                                @error('budget') <div class="ct-err">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="ct-field">
                            <label for="ct-message">Message <span>*</span></label>
                            <textarea id="ct-message" name="message" rows="6" maxlength="5000"
                                      placeholder="Tell me about your project, timeline, and what you're hoping to achieve…" required>{{ old('message') }}</textarea>
                            <div class="ct-meta">
                                <span class="ct-count"><b id="ct-count">0</b> / 5000</span>
                            </div>
                            @error('message') <div class="ct-err">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="ct-submit">
                            <span class="ct-submit-txt">✉ Send Message</span>
                            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </button>

                        <p class="ct-note">Your details stay private — never shared with anyone.</p>
                    </form>
                </div>

                {{-- ── ASIDE ── --}}
                <aside class="cp-aside ab-rv" style="transition-delay:0.1s">

                    <div class="cp-aside-card">
                        <h3 class="cp-aside-title">What happens next?</h3>
                        <ol class="cp-steps">
                            <li>
                                <span class="cp-step-num">1</span>
                                <span class="cp-step-body">
                                    <b>I read your message</b>
                                    <i>Usually within a few hours, always within 24.</i>
                                </span>
                            </li>
                            <li>
                                <span class="cp-step-num">2</span>
                                <span class="cp-step-body">
                                    <b>We scope it together</b>
                                    <i>A quick call or email thread to pin down what you actually need.</i>
                                </span>
                            </li>
                            <li>
                                <span class="cp-step-num">3</span>
                                <span class="cp-step-body">
                                    <b>You get a plan &amp; quote</b>
                                    <i>Clear deliverables, honest timeline, no surprises later.</i>
                                </span>
                            </li>
                            <li>
                                <span class="cp-step-num">4</span>
                                <span class="cp-step-body">
                                    <b>We build it</b>
                                    <i>Regular updates so you always know where things stand.</i>
                                </span>
                            </li>
                        </ol>
                    </div>

                    <div class="cp-aside-card">
                        <h3 class="cp-aside-title">Good fits for me</h3>
                        <ul class="cp-fits">
                            <li>Laravel apps, APIs &amp; SaaS platforms</li>
                            <li>React frontends &amp; dashboards</li>
                            <li>Custom WordPress plugins &amp; themes</li>
                            <li>Rescuing a project that stalled</li>
                            <li>Performance &amp; database optimisation</li>
                        </ul>
                    </div>

                    <div class="cp-aside-card cp-socials-card">
                        <h3 class="cp-aside-title">Find me elsewhere</h3>
                        <div class="ct-socials-row">
                @include('layouts.partials.socials', ['class' => 'ct-social'])
            
                        </div>
                    </div>

                </aside>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════
         FAQ
    ══════════════════════════════════════ --}}
    <section class="cp-faq">
        <div class="ab-inner">
            <div class="ab-head ab-rv">
                <span class="ab-label">FAQ</span>
                <h2 class="ab-h2 ab-center">Questions I get <em>a lot</em></h2>
            </div>

            @php
                $faqs = [
                    ['q' => 'How much does a project cost?', 'a' => 'It depends entirely on scope. A small WordPress plugin might be a few hundred dollars; a full Laravel SaaS runs into five figures. Tell me what you need and I\'ll give you an honest number — not a placeholder that doubles later.'],
                    ['q' => 'How long will it take?', 'a' => 'A landing page can ship in a week. A complex application takes months. I\'d rather quote a realistic timeline and hit it than promise something fast and miss it. You\'ll get a schedule before we start.'],
                    ['q' => 'Do you work with existing codebases?', 'a' => 'Yes — and often. I\'m comfortable inheriting a project someone else started, whether that means adding features, fixing bugs, or untangling something that grew faster than its architecture.'],
                    ['q' => 'What are your working hours?', 'a' => 'I\'m in Pakistan (PKT, UTC+5), but I work with clients across US and European time zones. I keep flexible hours for calls and I\'m responsive over email regardless of where you are.'],
                    ['q' => 'Do you offer support after launch?', 'a' => 'Always. Every project includes a handover and documentation, and I stay available afterwards for fixes and improvements. I don\'t disappear the day the invoice clears.'],
                    ['q' => 'What do you need from me to start?', 'a' => 'A description of the problem you\'re solving, any designs or references you have, and your rough budget and deadline. If you don\'t have all of that yet, that\'s fine — figuring it out is part of the job.'],
                ];
            @endphp

            <div class="cp-faq-list">
                @foreach ($faqs as $i => $faq)
                    <div class="cp-faq-item ab-rv" data-delay="{{ $i }}">
                        <button type="button" class="cp-faq-q" aria-expanded="false">
                            <span>{{ $faq['q'] }}</span>
                            <span class="cp-faq-icon" aria-hidden="true"></span>
                        </button>
                        <div class="cp-faq-a">
                            <p>{{ $faq['a'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════
         CTA
    ══════════════════════════════════════ --}}
    <section class="ab-cta">
        <div class="ab-inner">
            <div class="ab-cta-banner ab-rv">
                <div class="ab-cta-text">
                    <h3>Not ready to write a brief? <em>Just say hi.</em></h3>
                    <p>A two-line message is enough to start. We can figure out the details together.</p>
                </div>
                <div class="ab-cta-btns">
                    <a href="mailto:hello@ahsannawaz.dev" class="ab-btn-primary">
                        ✉ Email Me Directly
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                    <a href="{{ route('about') }}" class="ab-btn-ghost">About Me →</a>
                </div>
            </div>
        </div>
    </section>

    @include('layouts.partials.popup')

    </main>

    @include('layouts.partials.footer')

    @js('js/about.js')
    @js('js/popup.js')
    @js('js/contact-page.js')
</body>
</html>
