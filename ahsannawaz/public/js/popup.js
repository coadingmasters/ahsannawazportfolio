/* ══════════════════════════════════════
   FRONTEND POPUP
   Centered, animated replacement for inline form alerts.
   Exposes window.Popup.success() / .error()
══════════════════════════════════════ */
window.Popup = (() => {
    const back = document.getElementById('pop');
    if (!back) return { success() {}, error() {} };

    const titleEl = document.getElementById('pop-title');
    const textEl = document.getElementById('pop-text');
    const listEl = document.getElementById('pop-list');
    const timerEl = document.getElementById('pop-timer');
    const btnEl = document.getElementById('pop-btn');
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    let autoTimer = null;
    let lastFocus = null;

    const close = () => {
        clearTimeout(autoTimer);
        back.classList.remove('open');
        document.body.style.overflow = '';
        setTimeout(() => { back.hidden = true; }, 300);
        if (lastFocus) lastFocus.focus();
    };

    const open = () => {
        lastFocus = document.activeElement;
        back.hidden = false;
        requestAnimationFrame(() => back.classList.add('open'));
        document.body.style.overflow = 'hidden';
        setTimeout(() => btnEl.focus(), 140);
    };

    back.addEventListener('click', (e) => {
        if (e.target === back || e.target.closest('[data-pop-dismiss]')) close();
    });
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && back.classList.contains('open')) close();
    });

    const show = ({ title, text, items = [], isError, autoClose }) => {
        back.classList.toggle('is-error', !!isError);
        titleEl.textContent = title;
        textEl.textContent = text;

        // Only render a bullet list when there's more than one message.
        if (items.length > 1) {
            listEl.innerHTML = '';
            items.forEach(msg => {
                const li = document.createElement('li');
                li.textContent = msg;      // textContent — never trust message HTML
                listEl.appendChild(li);
            });
            listEl.hidden = false;
        } else {
            listEl.hidden = true;
        }

        timerEl.classList.remove('run');
        if (autoClose && !reduceMotion) {
            void timerEl.offsetWidth;      // restart the bar animation
            timerEl.classList.add('run');
            autoTimer = setTimeout(close, 4000);
        }

        open();
    };

    return {
        success(message) {
            show({
                title: 'Message sent!',
                text: message,
                isError: false,
                autoClose: true,
            });
        },
        error(messages) {
            const items = Array.isArray(messages) ? messages : [messages];
            show({
                title: items.length > 1 ? 'Please check the form' : 'Almost there',
                text: items.length > 1
                    ? 'A few fields need fixing before this can be sent:'
                    : items[0],
                items,
                isError: true,
                autoClose: false,
            });
        },
        close,
    };
})();

/* Surface whatever the server flashed back after a redirect. */
(() => {
    // A <template>'s children live in an inert .content fragment, so its own
    // textContent is always empty — read through .content instead.
    const read = (el) => (el.content ? el.content.textContent : el.textContent).trim();

    const ok = document.getElementById('pop-flash-success');
    if (ok) {
        window.Popup.success(read(ok));
        return;                             // never show both at once
    }

    const errs = document.getElementById('pop-flash-errors');
    if (errs) {
        try {
            const list = JSON.parse(read(errs));
            if (list.length) window.Popup.error(list);
        } catch (e) {
            /* malformed payload — leave the inline field errors to do the job */
        }
    }
})();
