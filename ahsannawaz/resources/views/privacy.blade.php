<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('layouts.partials.seo', [
        'title' => 'Privacy Policy',
        'titleFull' => "Privacy Policy | Ahsan Nawaz",
        'description' => "What data this site collects, why it is collected, how long it is kept and how to have it deleted. Short, specific, and true to what the site does.",
    ])
    <link rel="preload" as="font" type="font/woff2" crossorigin href="{{ asset('fonts/sora-latin.woff2') }}">
    <link rel="preload" as="font" type="font/woff2" crossorigin href="{{ asset('fonts/dm-sans-latin.woff2') }}">
    @styles('privacy')
</head>
<body>
    @include('layouts.partials.header')

    @php $l = config('legal'); @endphp

    <main id="main-content">
        <section class="sec sec-tint" style="padding-bottom:clamp(2rem,4vw,3rem)">
            <div class="sec-inner sec-head" style="margin-bottom:0">
                <span class="sec-eyebrow">Legal</span>
                <h1 class="sec-title" style="font-size:clamp(1.8rem,1.4rem+1.8vw,2.6rem)">Privacy Policy</h1>
                <p class="sec-sub">Last updated {{ $l['updated'] }}</p>
            </div>
        </section>

        <section class="sec" style="padding-top:clamp(2rem,4vw,3rem)">
            <div class="legal-doc">
                <p class="legal-lead">
                    This site is a personal portfolio run by {{ $l['entity'] }}, a freelance web
                    developer based in {{ $l['country'] }}. It collects as little as possible:
                    there is no analytics script, no advertising, no tracking cookies and no
                    newsletter. The only personal data reaching me is what you type into the
                    contact form.
                </p>

                <h2>What is collected</h2>
                <h3>Contact form</h3>
                <p>When you send a message, the form stores your name, email address, subject, the message itself and an optional budget range. Your IP address is recorded alongside it, which is used only to block automated spam.</p>
                <p>This information is used to reply to you and, if we work together, to carry out the project. It is never sold, rented or shared with anyone for marketing.</p>

                <h3>Session cookie</h3>
                <p>The site sets one functional cookie. Laravel uses it to keep your form session valid and to protect the form against cross-site request forgery. It carries no identifying information and is not used to track you across other sites.</p>
                @unless ($l['uses_analytics'])
                    <p>There is no Google Analytics, no Meta pixel and no third-party advertising or tracking script on this site.</p>
                @endunless

                <h3>Server logs</h3>
                <p>The hosting provider keeps standard web server logs — IP address, requested URL, timestamp and browser user agent. These are generated automatically by the server, are used for security and diagnostics, and are subject to the host's own retention policy.</p>

                <h2>Why it is collected</h2>
                <ul>
                    <li><strong>To reply to you.</strong> Without an email address I cannot answer your enquiry.</li>
                    <li><strong>To deliver work.</strong> If you become a client, your contact details are needed to run the project.</li>
                    <li><strong>To keep the site secure.</strong> IP addresses and logs are what make blocking abuse possible.</li>
                </ul>
                <p>Where the law requires a legal basis, that basis is your consent when you submit the form, and legitimate interest for security logging.</p>

                <h2>How long it is kept</h2>
                <p>Enquiries are kept for as long as they are useful — typically up to two years — so I can refer back to earlier conversations. Project-related correspondence may be kept longer where it forms part of a business record. You can ask for your message to be deleted at any time and it will be removed within 30 days.</p>

                <h2>Who else sees it</h2>
                <p>No one, other than the service providers needed to run the site:</p>
                <ul>
                    <li><strong>The hosting provider</strong>, which stores the database and serves the pages.</li>
                    <li><strong>Email delivery</strong>, used to notify me that a message arrived.</li>
                </ul>
                <p>These providers process data on my behalf and cannot use it for their own purposes. Nothing is passed to advertisers or data brokers.</p>

                <h2>Your rights</h2>
                <p>You can ask me to:</p>
                <ul>
                    <li>tell you what data I hold about you</li>
                    <li>correct anything inaccurate</li>
                    <li>delete your data entirely</li>
                    <li>stop using it for any particular purpose</li>
                </ul>
                <p>Email <a href="mailto:{{ $l['email'] }}">{{ $l['email'] }}</a> and it will be handled within 30 days. No account or form is required — a plain email is enough.</p>

                <h2>Security</h2>
                <p>The site runs over HTTPS, form submissions are validated and protected against CSRF, and the administration area sits behind authentication. No system is perfect, so please do not send passwords, card numbers or other sensitive credentials through the contact form.</p>

                <h2>Children</h2>
                <p>This site offers professional services and is not directed at children under 16. I do not knowingly collect their data. If you believe a child has sent information through the form, contact me and it will be deleted.</p>

                <h2>Links to other sites</h2>
                <p>Some pages link out to GitHub, LinkedIn and similar platforms. Once you follow such a link you are on their service, under their privacy policy, not this one.</p>

                <h2>Changes</h2>
                <p>If what the site does changes — adding analytics, for example — this page is updated and the date at the top changes with it. The policy is written to describe what actually happens rather than to cover every hypothetical.</p>

                <h2>Contact</h2>
                <p>Questions about this policy: <a href="mailto:{{ $l['email'] }}">{{ $l['email'] }}</a>.</p>
            </div>
        </section>
    </main>

    @include('layouts.partials.footer')
    @js('js/home.js')
    @stack('scripts')
</body>
</html>
