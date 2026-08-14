/* ============================================================
   Minimal rich-text editor for the article body.

   Deliberately dependency-free rather than a CDN drop-in: this site had a
   404 from an external font host once already, and an editor that fails to
   load would leave the admin with no way to write.

   The field stays a real <textarea> underneath, so the form submits and
   validates exactly as before and the page still works without JS. Output
   is sanitised server-side by App\Support\PostHtml regardless of what the
   browser puts in here.
============================================================ */
(function () {
    const area = document.getElementById('body');
    if (!area) return;

    const wrap = document.createElement('div');
    wrap.className = 'rte';

    const bar = document.createElement('div');
    bar.className = 'rte-bar';

    const canvas = document.createElement('div');
    canvas.className = 'rte-canvas input';
    canvas.contentEditable = 'true';
    canvas.spellcheck = true;
    canvas.setAttribute('role', 'textbox');
    canvas.setAttribute('aria-multiline', 'true');
    canvas.setAttribute('aria-label', 'Article body');
    canvas.innerHTML = area.value.trim() || '<p><br></p>';

    const TOOLS = [
        ['H2', 'Heading', () => block('h2')],
        ['H3', 'Sub-heading', () => block('h3')],
        ['P', 'Paragraph', () => block('p')],
        ['sep'],
        ['<b>B</b>', 'Bold (Ctrl+B)', () => cmd('bold')],
        ['<i>I</i>', 'Italic (Ctrl+I)', () => cmd('italic')],
        ['sep'],
        ['&bull; List', 'Bullet list', () => cmd('insertUnorderedList')],
        ['1. List', 'Numbered list', () => cmd('insertOrderedList')],
        ['&ldquo;&rdquo;', 'Quote', () => block('blockquote')],
        ['&lt;/&gt;', 'Code block', () => block('pre')],
        ['sep'],
        ['Link', 'Add link (Ctrl+K)', link],
        ['Unlink', 'Remove link', () => cmd('unlink')],
        ['sep'],
        ['Clear', 'Strip formatting from the selection', () => cmd('removeFormat')],
    ];

    function cmd(name, value) {
        canvas.focus();
        document.execCommand(name, false, value ?? null);
        sync();
    }
    function block(tag) { cmd('formatBlock', '<' + tag + '>'); }

    function link() {
        const sel = window.getSelection();
        if (!sel || sel.isCollapsed) { alert('Select the words you want to link first.'); return; }
        const url = prompt('Link to:', 'https://');
        if (url) cmd('createLink', url.trim());
    }

    TOOLS.forEach(([label, title, fn]) => {
        if (label === 'sep') {
            const s = document.createElement('span');
            s.className = 'rte-sep';
            bar.appendChild(s);
            return;
        }
        const b = document.createElement('button');
        b.type = 'button';
        b.className = 'rte-btn';
        b.innerHTML = label;
        b.title = title;
        b.addEventListener('click', fn);
        bar.appendChild(b);
    });

    const count = document.createElement('span');
    count.className = 'rte-count';
    bar.appendChild(count);

    // The textarea is the thing that submits; the canvas just edits it.
    function sync() {
        area.value = canvas.innerHTML.trim();
        const words = canvas.textContent.trim().split(/\s+/).filter(Boolean).length;
        count.textContent = words + (words === 1 ? ' word' : ' words')
            + ' · ~' + Math.max(1, Math.round(words / 200)) + ' min read';
    }

    canvas.addEventListener('input', sync);
    canvas.addEventListener('blur', sync);

    // Paste as plain text: pasting from Word or a browser drags in a mountain
    // of markup the sanitiser would only strip again.
    canvas.addEventListener('paste', (e) => {
        e.preventDefault();
        const text = (e.clipboardData || window.clipboardData).getData('text/plain');
        document.execCommand('insertText', false, text);
    });

    canvas.addEventListener('keydown', (e) => {
        if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') { e.preventDefault(); link(); }
    });

    // Keep the textarea current if the form is submitted by any route.
    area.form?.addEventListener('submit', sync);

    area.classList.add('rte-source');
    area.setAttribute('aria-hidden', 'true');
    area.tabIndex = -1;
    area.parentNode.insertBefore(wrap, area);
    wrap.appendChild(bar);
    wrap.appendChild(canvas);
    wrap.appendChild(area);
    sync();
})();
