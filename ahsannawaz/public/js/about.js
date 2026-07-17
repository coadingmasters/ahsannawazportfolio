/* ══════════════════════════════════════
   ABOUT PAGE — scroll animations
   Mirrors the IntersectionObserver pattern in welcome.js
══════════════════════════════════════ */
(() => {
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* ── Generic reveal, with optional stagger via data-delay ── */
    const revealEls = document.querySelectorAll('.ab-rv');

    if (reduceMotion) {
        revealEls.forEach(el => el.classList.add('visible'));
    } else {
        const revealIO = new IntersectionObserver(entries => {
            entries.forEach(e => {
                if (!e.isIntersecting) return;
                const delay = +(e.target.dataset.delay || 0) * 90;
                setTimeout(() => e.target.classList.add('visible'), delay);
                revealIO.unobserve(e.target);
            });
        }, { threshold: 0.12 });
        revealEls.forEach(el => revealIO.observe(el));
    }

    /* ── Animated stat counters ── */
    const statEls = document.querySelectorAll('.ab-stat-num[data-count]');
    if (statEls.length) {
        const countIO = new IntersectionObserver(entries => {
            entries.forEach(e => {
                if (!e.isIntersecting) return;
                const el = e.target;
                const target = +el.dataset.count || 0;

                if (reduceMotion) {
                    el.textContent = target + '+';
                } else {
                    let n = 0;
                    const step = () => {
                        n = Math.min(n + Math.ceil(target / 35), target);
                        el.textContent = n + '+';
                        if (n < target) requestAnimationFrame(step);
                    };
                    step();
                }
                countIO.unobserve(el);
            });
        }, { threshold: 0.4 });
        statEls.forEach(el => countIO.observe(el));
    }

    /* ── Skill bars fill when their card scrolls in ── */
    const skillCats = document.querySelectorAll('.ab-skill-cat');
    if (skillCats.length) {
        const barIO = new IntersectionObserver(entries => {
            entries.forEach(e => {
                if (!e.isIntersecting) return;
                e.target.querySelectorAll('.ab-skill-bar > i').forEach((bar, i) => {
                    const w = bar.dataset.width + '%';
                    if (reduceMotion) {
                        bar.style.width = w;
                    } else {
                        setTimeout(() => { bar.style.width = w; }, i * 90);
                    }
                });
                barIO.unobserve(e.target);
            });
        }, { threshold: 0.25 });
        skillCats.forEach(c => barIO.observe(c));
    }

    /* ── Timeline progress line follows the scroll position ── */
    const line = document.querySelector('.ab-tl-line');
    const fill = document.querySelector('.ab-tl-fill');
    if (line && fill && !reduceMotion) {
        let ticking = false;

        const update = () => {
            const rect = line.getBoundingClientRect();
            const vh = window.innerHeight;
            // 0 when the line's top hits mid-screen, 1 once its bottom passes
            const progress = (vh * 0.55 - rect.top) / rect.height;
            fill.style.height = Math.max(0, Math.min(1, progress)) * 100 + '%';
            ticking = false;
        };

        window.addEventListener('scroll', () => {
            if (!ticking) {
                requestAnimationFrame(update);
                ticking = true;
            }
        }, { passive: true });

        update();
    } else if (fill && reduceMotion) {
        fill.style.height = '100%';
    }
})();
