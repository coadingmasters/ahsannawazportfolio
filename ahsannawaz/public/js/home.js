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
