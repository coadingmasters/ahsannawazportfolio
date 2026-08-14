/* ══════════════════════════════════════
   SKILLS PAGE — rings, counters, filtering
   Reveals come from about.js (.ab-rv)
══════════════════════════════════════ */
(() => {
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const CIRCUMFERENCE = 2 * Math.PI * 42; // r=42 in the SVG viewBox

    /* ── Animate a ring + its % readout when the card scrolls in ── */
    const cards = Array.from(document.querySelectorAll('.sp-card'));

    const fillCard = (card) => {
        const ring = card.querySelector('.sp-ring-fill');
        const pctEl = card.querySelector('.sp-pct');
        if (!ring) return;

        const pct = Math.max(0, Math.min(100, +ring.dataset.pct || 0));
        const offset = CIRCUMFERENCE - (pct / 100) * CIRCUMFERENCE;

        ring.style.strokeDashoffset = offset;

        if (!pctEl) return;
        if (reduceMotion) {
            pctEl.textContent = pct + '%';
            return;
        }
        let n = 0;
        const step = () => {
            n = Math.min(n + Math.ceil(pct / 30), pct);
            pctEl.textContent = n + '%';
            if (n < pct) requestAnimationFrame(step);
        };
        step();
    };

    if (cards.length) {
        const ringIO = new IntersectionObserver(entries => {
            entries.forEach(e => {
                if (!e.isIntersecting) return;
                const delay = (+e.target.dataset.delay || 0) * 90;
                setTimeout(() => fillCard(e.target), reduceMotion ? 0 : delay);
                ringIO.unobserve(e.target);
            });
        }, { threshold: 0.3 });
        cards.forEach(c => ringIO.observe(c));
    }

    /* ── Masthead counters ── */
    document.querySelectorAll('.sp-stat-num[data-count]').forEach(el => {
        const target = +el.dataset.count || 0;
        const suffix = el.dataset.suffix || '';
        const io = new IntersectionObserver(entries => {
            entries.forEach(e => {
                if (!e.isIntersecting) return;
                if (reduceMotion) {
                    el.textContent = target + suffix;
                } else {
                    let n = 0;
                    const step = () => {
                        n = Math.min(n + Math.ceil(target / 30), target);
                        el.textContent = n + suffix;
                        if (n < target) requestAnimationFrame(step);
                    };
                    step();
                }
                io.unobserve(el);
            });
        }, { threshold: 0.5 });
        io.observe(el);
    });

    /* ── Breakdown bars ── */
    document.querySelectorAll('.sp-break-card').forEach(cardEl => {
        const io = new IntersectionObserver(entries => {
            entries.forEach(e => {
                if (!e.isIntersecting) return;
                e.target.querySelectorAll('.sp-break-bar > i').forEach((bar, i) => {
                    const w = bar.dataset.width + '%';
                    if (reduceMotion) bar.style.width = w;
                    else setTimeout(() => { bar.style.width = w; }, i * 80);
                });
                io.unobserve(e.target);
            });
        }, { threshold: 0.25 });
        io.observe(cardEl);
    });

    /* ── Category filtering ── */
    const grid = document.getElementById('sp-grid');
    if (!grid) return;

    const filters = document.querySelectorAll('.pj-filter');
    const noResults = document.getElementById('sp-noresults');

    const apply = (value) => {
        let shown = 0;

        cards.forEach(card => {
            const match = value === 'all' || card.dataset.category === value;

            if (match) {
                card.classList.remove('is-hidden');
                if (!reduceMotion) {
                    card.classList.remove('is-filtering');
                    void card.offsetWidth;             // force reflow so it replays
                    card.style.animationDelay = (shown % 8) * 35 + 'ms';
                    card.classList.add('is-filtering');
                }
                // A card revealed by filtering may never have had its ring drawn.
                fillCard(card);
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

    /* Deep link support: /skills#backend preselects that filter */
    const hash = window.location.hash.replace('#', '');
    if (hash) {
        const target = document.querySelector(`.pj-filter[data-filter="${CSS.escape(hash)}"]`);
        if (target) target.click();
    }
})();

/* Fill the rings and bars when a card scrolls into view. The percentage is
   already in the markup, so nothing is hidden if this never runs. */
(function () {
    const cards = document.querySelectorAll('.sk-card');
    if (!cards.length) return;

    const still = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const CIRC = 270.2;   // 2πr for r = 43

    const fill = (card) => {
        const ring = card.querySelector('.sk-ring-fill');
        const bar = card.querySelector('.sk-bar i');
        const pct = Number(ring?.dataset.pct || bar?.dataset.pct || 0);
        if (ring) ring.style.strokeDashoffset = CIRC - (CIRC * pct) / 100;
        if (bar) bar.style.width = pct + '%';
    };

    if (still || !('IntersectionObserver' in window)) {
        cards.forEach(fill);
        return;
    }

    const io = new IntersectionObserver((entries) => {
        entries.forEach((e) => {
            if (!e.isIntersecting) return;
            fill(e.target);
            io.unobserve(e.target);
        });
    }, { threshold: 0.25 });

    cards.forEach((c) => io.observe(c));
})();
