/* ══════════════════════════════════════
   PROJECTS PAGE — category filtering
   Reveals come from about.js (.ab-rv)
══════════════════════════════════════ */
(() => {
    const grid = document.getElementById('pj-grid');
    if (!grid) return;

    const filters = document.querySelectorAll('.pj-filter');
    const cards = Array.from(grid.querySelectorAll('.pj-card'));
    const noResults = document.getElementById('pj-noresults');
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const apply = (value) => {
        let shown = 0;

        cards.forEach(card => {
            const match = value === 'all' || card.dataset.category === value;

            if (match) {
                card.classList.remove('is-hidden');
                // Restart the pop-in animation for cards entering the view.
                if (!reduceMotion) {
                    card.classList.remove('is-filtering');
                    void card.offsetWidth;            // force reflow so the animation replays
                    card.style.animationDelay = (shown % 6) * 40 + 'ms';
                    card.classList.add('is-filtering');
                }
                shown++;
            } else {
                card.classList.add('is-hidden');
                card.classList.remove('is-filtering');
            }
        });

        if (noResults) noResults.hidden = shown > 0;
    };

    filters.forEach(btn => {
        btn.addEventListener('click', () => {
            if (btn.classList.contains('is-active')) return;

            filters.forEach(b => {
                b.classList.remove('is-active');
                b.setAttribute('aria-selected', 'false');
            });
            btn.classList.add('is-active');
            btn.setAttribute('aria-selected', 'true');

            apply(btn.dataset.filter);
        });
    });

    /* Deep link support: /projects#web preselects that filter */
    const hash = window.location.hash.replace('#', '');
    if (hash) {
        const target = document.querySelector(`.pj-filter[data-filter="${CSS.escape(hash)}"]`);
        if (target) target.click();
    }
})();
