const roles = [
    'Laravel Developer',
    'PHP Developer',
    'React JS Developer',
    'WordPress Developer',
    'Plugin Developer',
    'Full-Stack Developer',
];

let roleIndex = 0;
let charIndex = 0;
let deleting = false;
const typewriterEl = document.getElementById('typewriter');

function type() {
    if (!typewriterEl) return;

    const current = roles[roleIndex];
    if (!deleting) {
        typewriterEl.textContent = current.slice(0, ++charIndex);
        if (charIndex === current.length) {
            deleting = true;
            setTimeout(type, 1800);
            return;
        }
    } else {
        typewriterEl.textContent = current.slice(0, --charIndex);
        if (charIndex === 0) {
            deleting = false;
            roleIndex = (roleIndex + 1) % roles.length;
        }
    }

    setTimeout(type, deleting ? 45 : 90);
}

function animateCounters() {
    document.querySelectorAll('[data-target]').forEach((counterEl) => {
        const target = Number(counterEl.dataset.target || 0);
        const suffix = '+';
        let current = 0;

        const step = () => {
            current += Math.ceil(target / 40);
            if (current >= target) {
                counterEl.textContent = `${target}${suffix}`;
                return;
            }
            counterEl.textContent = `${current}${suffix}`;
            requestAnimationFrame(step);
        };

        step();
    });
}

setTimeout(type, 1200);

const heroEl = document.getElementById('hero');
if (heroEl) {
    const observer = new IntersectionObserver((entries) => {
        if (entries[0]?.isIntersecting) {
            animateCounters();
            observer.disconnect();
        }
    }, { threshold: 0.3 });

    observer.observe(heroEl);
}


/* ── SCROLL REVEAL ── */
(function () {
    const els = document.querySelectorAll('#about .reveal');
    const io = new IntersectionObserver(entries => {
        entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); } });
    }, { threshold: 0.15 });
    els.forEach(el => io.observe(el));
})();

/* ── SKILL BAR ANIMATION ── */
(function () {
    const bars = document.querySelectorAll('#about .skill-bar-fill');
    const io = new IntersectionObserver(entries => {
        if (entries[0].isIntersecting) {
            bars.forEach(b => { b.style.width = b.dataset.width + '%'; });
            io.disconnect();
        }
    }, { threshold: 0.4 });
    const section = document.getElementById('skill-bars');
    if (section) io.observe(section);
})();

/* ── READ MORE TOGGLE ── */
function toggleReadMore(e) {
    e.preventDefault();
    const extra  = document.getElementById('about-extra-text');
    const label  = document.getElementById('read-more-label');
    const arrow  = document.getElementById('read-more-arrow');
    const isOpen = extra.classList.contains('visible');
    extra.classList.toggle('visible', !isOpen);
    label.textContent = isOpen ? 'Read More' : 'Read Less';
    arrow.style.transform = isOpen ? '' : 'rotate(90deg)';
}

(function () {
    /* ── Scroll reveal ── */
    const revealEls = document.querySelectorAll('#skills .sk-reveal');
    const revealIO = new IntersectionObserver(entries => {
        entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
    }, { threshold: 0.12 });
    revealEls.forEach(el => revealIO.observe(el));

    /* ── Cards staggered pop-in ── */
    const cards = document.querySelectorAll('#sk-grid .sk-card');
    const cardIO = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                const idx = [...cards].indexOf(e.target);
                setTimeout(() => {
                    e.target.classList.add('visible');
                    animateBar(e.target);
                }, idx * 60);
                cardIO.unobserve(e.target);
            }
        });
    }, { threshold: 0.1 });
    cards.forEach(c => cardIO.observe(c));

    function animateBar(card) {
        const fill = card.querySelector('.sk-bar-fill');
        if (fill) fill.style.width = fill.dataset.w + '%';
    }

    /* ── Filter tabs ── */
    document.getElementById('sk-tabs').addEventListener('click', function (e) {
        const btn = e.target.closest('.sk-tab');
        if (!btn) return;
        document.querySelectorAll('.sk-tab').forEach(t => t.classList.remove('active'));
        btn.classList.add('active');
        const filter = btn.dataset.filter;
        cards.forEach(card => {
            const show = filter === 'all' || card.dataset.cat === filter;
            card.style.display = show ? '' : 'none';
        });
    });

    /* ── Stat counters ── */
    const statIO = new IntersectionObserver(entries => {
        if (!entries[0].isIntersecting) return;
        document.querySelectorAll('#skills .sk-stat-num').forEach(el => {
            const target = +el.dataset.target;
            let n = 0;
            const step = () => {
                n = Math.min(n + Math.ceil(target / 40), target);
                el.textContent = n + '+';
                if (n < target) requestAnimationFrame(step);
            };
            step();
        });
        statIO.disconnect();
    }, { threshold: 0.4 });
    const statsEl = document.querySelector('#skills .sk-stats');
    if (statsEl) statIO.observe(statsEl);
})();



(function () {
    /* Scroll reveal */
    const revEls = document.querySelectorAll('#services .srv-reveal');
    const revIO = new IntersectionObserver(entries => {
        entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
    }, { threshold: 0.1 });
    revEls.forEach(el => revIO.observe(el));

    /* Staggered card pop-in */
    const cards = document.querySelectorAll('#services .srv-grid .srv-card');
    const cardIO = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                const delay = +(e.target.dataset.delay || 0) * 80;
                setTimeout(() => e.target.classList.add('visible'), delay);
                cardIO.unobserve(e.target);
            }
        });
    }, { threshold: 0.08 });
    cards.forEach(c => cardIO.observe(c));
})();
