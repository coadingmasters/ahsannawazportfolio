/**
 * Extract above-the-fold ("critical") CSS per page.
 *
 * Loads each page in headless Chrome at a phone and a desktop viewport and
 * keeps only the rules whose elements actually sit inside that first screen.
 *
 * Chrome's CSS coverage was the obvious tool here and it is the wrong one: it
 * marks a rule "used" if it matches anything in the document, off-screen or
 * not, which produced a 44 KiB "critical" file out of a 75 KiB bundle. This
 * walks the CSSOM and geometry instead.
 *
 * Output feeds the layout, which inlines it and loads the full bundle
 * asynchronously, so first paint needs no stylesheet request.
 *
 *   node build-critical.mjs [baseUrl]
 */
import puppeteer from 'puppeteer-core';
import { transform } from 'lightningcss';
import { writeFileSync, mkdirSync } from 'node:fs';
import { join } from 'node:path';

// Default to a local snapshot. Pointing this at the live domain fetched
// Hostinger's bot-check interstitial instead of the site, and its
// `body{display:flex;justify-content:center}` silently became "critical CSS"
// — so the extractor now refuses anything that does not look like the site.
const BASE = process.argv[2] || 'http://127.0.0.1:8321';
const OUT = 'public/dist/css';
const CHROME = '/usr/bin/google-chrome';

const PAGES = {
  welcome: '/',
  about: '/about',
  skills: '/skills',
  projects: '/projects',
  contact: '/contact',
};

const VIEWPORTS = [
  { width: 390, height: 844, deviceScaleFactor: 2, isMobile: true },
  { width: 1440, height: 900, deviceScaleFactor: 1, isMobile: false },
];

// Runs inside the page.
function collectCritical() {
  const H = window.innerHeight;
  const out = [];

  // Each rule is tagged with its position in the original cascade so the two
  // viewport passes can be merged without reordering. The counter must advance
  // identically in both passes, so it counts EVERY rule — kept or not, matching
  // media or not. Counting only kept rules let the passes drift, which put
  // desktop's `.hero-inner{1fr 1fr}` after mobile's `@media` override and left
  // phones laying out in two columns until the real stylesheet arrived.
  let order = 0;

  const visible = (selectorText) => {
    const base = selectorText
      .split(',')
      .map((s) => s.replace(/::?(before|after|hover|focus|focus-visible|focus-within|active|visited|target|placeholder|selection|marker|first-line|first-letter|backdrop)\b(\([^)]*\))?/g, '').trim())
      .filter(Boolean)
      .join(',');
    if (!base) return false;
    let els;
    try { els = document.querySelectorAll(base); } catch { return true; }
    for (const el of els) {
      if (el === document.documentElement || el === document.body) return true;

      // Taken-out-of-flow elements must keep their rules even when they sit
      // off-screen. The skip link lives at top:-3rem; drop the rule that puts
      // it there and it falls back into the flow, pushing the whole page down
      // 25px until the real stylesheet lands. Same for blobs and orbit rings.
      const pos = getComputedStyle(el).position;
      if (pos === 'absolute' || pos === 'fixed') return true;

      const r = el.getBoundingClientRect();
      if (r.top < H && r.bottom > 0 && r.width > 0 && r.height > 0) return true;

      // An element can legitimately measure zero right now and still matter:
      // the typewriter span is empty between words, and its rule reserves the
      // width that stops the line shifting. Judge those by their parent's box.
      if (r.width === 0 || r.height === 0) {
        const p = el.parentElement;
        if (p) {
          const pr = p.getBoundingClientRect();
          if (pr.top < H && pr.bottom > 0 && pr.width > 0 && pr.height > 0) return true;
        }
      }
    }
    return false;
  };

  const declaresVars = (rule) => {
    for (let i = 0; rule.style && i < rule.style.length; i++) {
      if (rule.style[i].startsWith('--')) return true;
    }
    return false;
  };

  // `keep` goes false inside a non-matching @media: we still walk it so the
  // counter stays in step, we just do not collect anything from it.
  const walk = (rules, keep, open, close) => {
    for (const rule of rules) {
      const i = ++order;
      const wrap = (t) => (open ? open + t + close : t);

      switch (rule.type) {
        case CSSRule.STYLE_RULE:
          if (keep && (declaresVars(rule) || visible(rule.selectorText))) {
            out.push({ i, text: wrap(rule.cssText) });
          }
          break;
        case CSSRule.MEDIA_RULE:
          walk(rule.cssRules, keep && window.matchMedia(rule.conditionText).matches,
               `@media ${rule.conditionText}{`, '}');
          break;
        case CSSRule.SUPPORTS_RULE:
          walk(rule.cssRules, keep && CSS.supports(rule.conditionText),
               `@supports ${rule.conditionText}{`, '}');
          break;
        case CSSRule.FONT_FACE_RULE:
        case CSSRule.KEYFRAMES_RULE:
          if (keep) out.push({ i, text: rule.cssText });
          break;
      }
    }
  };

  for (const sheet of document.styleSheets) {
    // Skip the critical CSS this page already has inlined. Including it merges
    // a previous run's output with the real stylesheet, and because the inline
    // block is parsed first, the bundle's base rules end up AFTER the mobile
    // @media overrides they are supposed to lose to — which is how the header
    // came back as 88px on phones. Extraction must read the source of truth.
    if (sheet.ownerNode && sheet.ownerNode.id === 'critical-css') continue;

    let rules;
    try { rules = sheet.cssRules; } catch { continue; }   // cross-origin
    walk(rules, true, '', '');
  }

  // Identical rules can be reached from both viewport passes; keep the first
  // position each one had so the cascade is preserved without duplication.
  const byText = new Map();
  for (const r of out) if (!byText.has(r.text)) byText.set(r.text, r.i);
  return [...byText.entries()].map(([text, i]) => ({ i, text }));
}

mkdirSync(OUT, { recursive: true });

const browser = await puppeteer.launch({
  executablePath: CHROME,
  headless: 'new',
  args: ['--no-sandbox', '--disable-gpu', '--disable-dev-shm-usage'],
});

const kb = (n) => (n / 1024).toFixed(1) + ' KiB';
const failures = [];

// What the page looks like with its real stylesheet — the target the critical
// CSS has to reproduce.
const reference = {};
for (const [name, path] of Object.entries(PAGES)) {
  const page = await browser.newPage();
  await page.setViewport(VIEWPORTS[0]);
  await page.goto(BASE + path, { waitUntil: 'networkidle2', timeout: 60000 });
  reference[name] = await page.evaluate(() => {
    const m = document.querySelector('#main-content');
    const h = document.querySelector('.site-header');
    return {
      mainTop: m ? Math.round(m.getBoundingClientRect().top) : -1,
      headerH: h ? Math.round(h.getBoundingClientRect().height) : -1,
    };
  });
  await page.close();
}

for (const [name, path] of Object.entries(PAGES)) {
  const merged = new Map();   // order index -> rule text
  for (const vp of VIEWPORTS) {
    const page = await browser.newPage();
    await page.setViewport(vp);
    await page.goto(BASE + path, { waitUntil: 'networkidle2', timeout: 60000 });

    // Guard: if this is not the real page (bot check, error page, a redirect),
    // bail loudly rather than write nonsense over good critical CSS.
    const looksRight = await page.evaluate(
      () => !!document.querySelector('.site-header .brand') && !!document.querySelector('main#main-content')
    );
    if (!looksRight) {
      const title = await page.title();
      throw new Error(`${path} did not render the site (got "${title}") — refusing to write critical CSS`);
    }

    // The bundle arrives asynchronously; wait for it to actually apply.
    await page.waitForFunction(
      () => [...document.styleSheets].some((s) => (s.href || '').includes('page-')),
      { timeout: 15000 }
    ).catch(() => {});

    for (const { i, text } of await page.evaluate(collectCritical)) {
      if (!merged.has(i)) merged.set(i, text);
    }
    await page.close();
  }

  // Back into cascade order before minifying.
  const combined = [...merged.entries()].sort((a, b) => a[0] - b[0]).map(([, t]) => t).join('\n');

  const { code } = transform({
    filename: `critical-${name}.css`,
    code: Buffer.from(combined),
    minify: true,
    errorRecovery: true,
    targets: { chrome: 100 << 16, firefox: 100 << 16, safari: 15 << 16 },
  });

  writeFileSync(join(OUT, `critical-${name}.css`), code);

  // Verify it. Critical CSS that lays the page out differently from the real
  // stylesheet does not save anything — it just moves the work into a visible
  // jump. Every regression this file has had (two-column phones, a header at
  // the wrong height, a skip link back in the flow) would have been caught
  // here, so the check runs on every build.
  const page = await browser.newPage();
  await page.setViewport(VIEWPORTS[0]);
  await page.setRequestInterception(true);
  page.on('request', (r) => (/page-\w+\.css/.test(r.url()) ? r.abort() : r.continue()));
  await page.evaluateOnNewDocument(
    (css) => document.addEventListener('DOMContentLoaded', () => {
      const el = document.getElementById('critical-css');
      if (el) el.textContent = css;
    }),
    code.toString()
  );
  await page.goto(BASE + path, { waitUntil: 'domcontentloaded', timeout: 60000 });
  const probe = () => {
    const m = document.querySelector('#main-content');
    const h = document.querySelector('.site-header');
    return {
      mainTop: m ? Math.round(m.getBoundingClientRect().top) : -1,
      headerH: h ? Math.round(h.getBoundingClientRect().height) : -1,
    };
  };
  const withCritical = await page.evaluate(probe);
  await page.close();

  const drift =
    Math.abs(withCritical.mainTop - reference[name].mainTop) +
    Math.abs(withCritical.headerH - reference[name].headerH);

  const verdict = drift === 0 ? 'exact' : `DRIFT ${drift}px`;
  console.log(`  critical-${name}.css`.padEnd(28) + kb(code.length).padStart(9) + '   ' + verdict);
  if (drift > 0) {
    console.error(`    critical: main@${withCritical.mainTop} header=${withCritical.headerH}px`);
    console.error(`    real    : main@${reference[name].mainTop} header=${reference[name].headerH}px`);
    failures.push(name);
  }
}

if (failures.length) {
  console.error(`\nFAILED: ${failures.join(', ')} would shift on load. Not shipping a jump.`);
  process.exit(1);
}

await browser.close();
