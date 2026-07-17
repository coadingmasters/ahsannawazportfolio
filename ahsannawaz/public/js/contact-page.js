/* ══════════════════════════════════════
   CONTACT PAGE
   Reveals + counters come from about.js;
   this file owns the FAQ and the form behaviour.
══════════════════════════════════════ */
(() => {
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* ── FAQ accordion ── */
    const items = document.querySelectorAll('.cp-faq-item');

    const close = (item) => {
        const panel = item.querySelector('.cp-faq-a');
        const btn = item.querySelector('.cp-faq-q');
        item.classList.remove('open');
        btn.setAttribute('aria-expanded', 'false');
        panel.style.maxHeight = null;
    };

    const open = (item) => {
        const panel = item.querySelector('.cp-faq-a');
        const btn = item.querySelector('.cp-faq-q');
        item.classList.add('open');
        btn.setAttribute('aria-expanded', 'true');
        // Explicit px height so the transition has something to animate to.
        panel.style.maxHeight = panel.scrollHeight + 'px';
    };

    items.forEach(item => {
        const btn = item.querySelector('.cp-faq-q');
        btn.addEventListener('click', () => {
            const isOpen = item.classList.contains('open');
            items.forEach(close);          // accordion: only one open at a time
            if (!isOpen) open(item);
        });
    });

    // Re-measure the open panel if the viewport reflows the text.
    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            const openItem = document.querySelector('.cp-faq-item.open');
            if (openItem) {
                const panel = openItem.querySelector('.cp-faq-a');
                panel.style.maxHeight = panel.scrollHeight + 'px';
            }
        }, 150);
    });

    /* ── Live character counter ── */
    const msg = document.getElementById('ct-message');
    const count = document.getElementById('ct-count');
    if (msg && count) {
        const sync = () => { count.textContent = msg.value.length; };
        msg.addEventListener('input', sync);
        sync();
    }

    /* ── Submit feedback — prevents double-posting ── */
    const form = document.querySelector('.ct-form');
    if (form) {
        form.addEventListener('submit', () => {
            const btn = form.querySelector('.ct-submit');
            const txt = form.querySelector('.ct-submit-txt');
            if (btn && txt) {
                btn.classList.add('sending');
                txt.textContent = 'Sending…';
            }
        });
    }

    /* ── Bring a success/error alert into view after redirect ── */
    const alertEl = document.querySelector('.ct-alert');
    if (alertEl) {
        alertEl.scrollIntoView({
            behavior: reduceMotion ? 'auto' : 'smooth',
            block: 'center',
        });
    }
})();
