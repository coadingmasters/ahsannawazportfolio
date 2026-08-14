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
