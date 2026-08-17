/* Homepage behaviour: reveal sections as they scroll in, and type the role
   line. Everything renders correctly without this file — the reveal classes
   only add motion, and the markup already holds its final text. */
(function () {
    const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const items = document.querySelectorAll('.rv');

    if (reduced || !('IntersectionObserver' in window)) {
        items.forEach((el) => el.classList.add('in'));
        return;
    }

    const io = new IntersectionObserver((entries) => {
        entries.forEach((e) => {
            if (!e.isIntersecting) return;
            e.target.classList.add('in');
            io.unobserve(e.target);
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px' });

    items.forEach((el) => io.observe(el));
})();

/* Hero typewriter — cycles the skills the admin panel actually holds.
   The markup already contains the first word, so a visitor without JS (or
   with reduced motion) reads a complete sentence rather than a gap. */
(function () {
    const el = document.getElementById('typed');
    if (!el) return;

    let words;
    try { words = JSON.parse(el.dataset.words || '[]'); } catch { return; }
    if (words.length < 2) return;
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    const TYPE = 85, ERASE = 40, HOLD = 1600, PAUSE = 320;
    let w = 0, i = words[0].length, erasing = true;

    const tick = () => {
        const word = words[w];

        if (erasing) {
            el.textContent = word.slice(0, --i);
            if (i === 0) { erasing = false; w = (w + 1) % words.length; return setTimeout(tick, PAUSE); }
            return setTimeout(tick, ERASE);
        }

        el.textContent = words[w].slice(0, ++i);
        if (i === words[w].length) { erasing = true; return setTimeout(tick, HOLD); }
        setTimeout(tick, TYPE);
    };

    setTimeout(tick, HOLD);
})();

/* Table of contents: highlight the section currently in view. Purely a
   nicety — the links work regardless, so this does nothing if it fails. */
(function () {
    const links = document.querySelectorAll('.toc a[data-toc]');
    if (!links.length || !('IntersectionObserver' in window)) return;

    const byId = new Map();
    links.forEach((a) => byId.set(a.getAttribute('href').slice(1), a));

    const heads = [...byId.keys()].map((id) => document.getElementById(id)).filter(Boolean);
    if (!heads.length) return;

    const io = new IntersectionObserver((entries) => {
        entries.forEach((e) => {
            if (!e.isIntersecting) return;
            links.forEach((a) => a.classList.remove('here'));
            byId.get(e.target.id)?.classList.add('here');
        });
    }, { rootMargin: '-90px 0px -70% 0px', threshold: 0 });

    heads.forEach((h) => io.observe(h));
})();

/* FAQ accordion.
   <details> alone snaps open with no transition, and removing the attribute
   immediately would hide the panel before it could animate shut. So opening
   sets [open] straight away and lets CSS grow the row; closing plays the
   animation first and drops [open] when it finishes. Without JS the element
   still opens and closes on its own — it just does it instantly. */
(function () {
    const items = document.querySelectorAll('.faq-list .faq');
    if (!items.length) return;

    const still = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    items.forEach((item) => {
        const summary = item.querySelector('summary');
        if (!summary) return;

        summary.addEventListener('click', (e) => {
            if (still) return;               // let the browser do it plainly
            e.preventDefault();

            if (item.open) {
                item.classList.add('is-closing');
                const done = () => {
                    item.open = false;
                    item.classList.remove('is-closing');
                    item.removeEventListener('transitionend', done);
                };
                // transitionend can be missed if the panel is display:none'd
                // mid-flight, so back it with a timeout of the same length.
                item.addEventListener('transitionend', done);
                setTimeout(done, 450);
                return;
            }

            // One panel at a time reads better than a page of open answers.
            items.forEach((other) => {
                if (other !== item && other.open) {
                    other.classList.add('is-closing');
                    setTimeout(() => {
                        other.open = false;
                        other.classList.remove('is-closing');
                    }, 400);
                }
            });

            item.open = true;
        });
    });
})();
