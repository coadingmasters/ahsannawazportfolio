<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('layouts.partials.seo', [
        'title' => 'Terms of Service',
        'titleFull' => "Terms of Service | Ahsan Nawaz",
        'description' => "The terms freelance web development work is carried out under — quotes, payment, revisions, ownership of code, timelines and what happens after delivery.",
    ])
    <link rel="preload" as="font" type="font/woff2" crossorigin href="{{ asset('fonts/sora-latin.woff2') }}">
    <link rel="preload" as="font" type="font/woff2" crossorigin href="{{ asset('fonts/dm-sans-latin.woff2') }}">
    @styles('terms')
</head>
<body>
    @include('layouts.partials.header')

    @php $l = config('legal'); @endphp

    <main id="main-content">
        <section class="sec sec-tint" style="padding-bottom:clamp(2rem,4vw,3rem)">
            <div class="sec-inner sec-head" style="margin-bottom:0">
                <span class="sec-eyebrow">Legal</span>
                <h1 class="sec-title" style="font-size:clamp(1.8rem,1.4rem+1.8vw,2.6rem)">Terms of Service</h1>
                <p class="sec-sub">Last updated {{ $l['updated'] }}</p>
            </div>
        </section>

        <section class="sec" style="padding-top:clamp(2rem,4vw,3rem)">
            <div class="legal-doc">
                <p class="legal-lead">
                    These terms cover the use of this website and the freelance development work
                    carried out by {{ $l['entity'] }}. They are written plainly on purpose — a
                    project runs better when both sides know what was agreed.
                </p>

                <h2>1. Using this site</h2>
                <p>The content here — text, code samples, layout and images — is mine unless stated otherwise. You are welcome to read it, quote it with attribution and use the code samples in your own projects. You may not republish whole articles as your own or copy the site's design wholesale.</p>
                <p>The site is provided as it is. I keep it accurate and online, but do not guarantee it is free of errors or never unavailable.</p>

                <h2>2. Quotes and scope</h2>
                <p>Every project is quoted individually after we discuss what you need. A quote covers the scope written into it and stays valid for 30 days.</p>
                <p>Work outside that scope is not included. If a request changes the scope, I will tell you before doing it, with what it adds in time and cost, so nothing appears on an invoice unannounced.</p>

                <h2>3. Payment</h2>
                <ul>
                    <li>Projects usually run on <strong>50% up front, 50% on delivery</strong>. Longer projects can be split into milestones.</li>
                    <li>Work begins once the first payment clears.</li>
                    <li>Invoices are due within <strong>7 days</strong> unless we agreed otherwise in writing.</li>
                    <li>Work on an overdue account may pause until payment is settled.</li>
                    @if (! $l['takes_payments_onsite'])
                        <li>No payments are taken through this website. Invoices are settled by bank transfer or by the platform we are working through, such as Fiverr or Upwork.</li>
                    @endif
                </ul>

                <h2>4. Timelines</h2>
                <p>Each project gets an estimated timeline before it starts. That estimate assumes content, access and feedback arrive when needed. Delays on those move the delivery date, which I will flag as it happens rather than at the deadline.</p>

                <h2>5. Revisions</h2>
                <p>Quotes include <strong>two rounds of revisions</strong> on the agreed scope. Revisions are for adjusting what was built; they are not a route to new features. Further rounds, or changes that alter the scope, are quoted separately.</p>

                <h2>6. Who owns the work</h2>
                <p>On full payment, ownership of the custom code and design produced for your project passes to you, along with the source and any credentials created for it.</p>
                <p>Two exceptions:</p>
                <ul>
                    <li><strong>Third-party components</strong> — frameworks, packages, fonts, stock images and plugins stay under their own licences.</li>
                    <li><strong>General know-how</strong> — techniques and non-specific code patterns remain mine to reuse.</li>
                </ul>
                <p>Until payment is complete, ownership stays with me.</p>

                <h2>7. Your responsibilities</h2>
                <ul>
                    <li>Supply content, images and access in reasonable time.</li>
                    <li>Confirm you hold the rights to anything you supply.</li>
                    <li>Give feedback in consolidated rounds rather than piecemeal.</li>
                    <li>Keep your own backups once the project is handed over.</li>
                </ul>

                <h2>8. After delivery</h2>
                <p>Bugs in the delivered work are fixed <strong>free for 30 days</strong> after handover. That covers defects in what was built — not new features, third-party changes, or issues caused by edits made after delivery.</p>
                <p>Beyond that window, support and new work are quoted hourly or per project.</p>

                <h2>9. Cancellation</h2>
                <p>Either of us can end a project in writing. If you cancel, work completed to that point is payable and the deposit is not refundable, since the time is already spent. If I cancel, you receive everything completed and a refund of anything paid for work not delivered.</p>

                <h2>10. Confidentiality</h2>
                <p>Anything you share about your business is kept confidential and used only to deliver the project. I may show the finished public-facing work in my portfolio unless you ask me not to — just say so and it stays private.</p>

                <h2>11. Liability</h2>
                <p>I take care to deliver work that functions as agreed. Liability for any claim is limited to the amount you paid for that project. I am not liable for indirect losses such as lost profit or lost data, and you are responsible for maintaining backups of your live site.</p>

                <h2>12. Governing law</h2>
                <p>These terms are governed by the laws of {{ $l['country'] }}. Where possible, disputes should be settled by talking first.</p>

                <h2>13. Changes</h2>
                <p>These terms may be updated; the date at the top shows when. Changes apply to new projects, not to work already agreed under an earlier version.</p>

                <h2>Contact</h2>
                <p>Questions about these terms: <a href="mailto:{{ $l['email'] }}">{{ $l['email'] }}</a>.</p>
            </div>
        </section>
    </main>

    @include('layouts.partials.footer')
    @js('js/home.js')
    @stack('scripts')
</body>
</html>
