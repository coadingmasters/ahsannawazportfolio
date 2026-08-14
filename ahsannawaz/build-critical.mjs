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
  const seen = new Set();

  const push = (text) => {
    if (text && !seen.has(text)) { seen.add(text); out.push(text); }
  };

  // A selector only tells us what it *could* match; geometry tells us whether
  // any of those elements is on the first screen.
  const visible = (selectorText) => {
    // State and pseudo-element suffixes never match at rest, so test the base.
    const base = selectorText
      .split(',')
      .map((s) => s.replace(/::?(before|after|hover|focus|focus-visible|focus-within|active|visited|target|placeholder|selection|marker|first-line|first-letter|backdrop)\b(\([^)]*\))?/g, '').trim())
      .filter(Boolean)
      .join(',');
    if (!base) return false;
    let els;
    try { els = document.querySelectorAll(base); } catch { return true; } // unparseable → keep
    for (const el of els) {
      const r = el.getBoundingClientRect();
      if (r.top < H && r.bottom > 0 && r.width > 0 && r.height > 0) return true;
      // html/body have odd boxes but always matter.
      if (el === document.documentElement || el === document.body) return true;
    }
    return false;
  };

  const walk = (rules, wrapOpen, wrapClose) => {
    for (const rule of rules) {
      const wrap = (t) => (wrapOpen ? wrapOpen + t + wrapClose : t);

      if (rule.type === CSSRule.STYLE_RULE) {
        // Custom-property blocks (:root, [data-theme]) style nothing directly
        // but everything depends on them. Test the declarations, not the text:
        // cssText also contains every var() *usage*, which is nearly every rule.
        let declaresVars = false;
        for (let i = 0; rule.style && i < rule.style.length; i++) {
            if (rule.style[i].startsWith('--')) { declaresVars = true; break; }
        }
        if (declaresVars || visible(rule.selectorText)) push(wrap(rule.cssText));
      } else if (rule.type === CSSRule.MEDIA_RULE) {
        if (window.matchMedia(rule.conditionText).matches) {
          walk(rule.cssRules, `@media ${rule.conditionText}{`, '}');
        }
      } else if (rule.type === CSSRule.SUPPORTS_RULE) {
        if (CSS.supports(rule.conditionText)) walk(rule.cssRules, `@supports ${rule.conditionText}{`, '}');
      } else if (rule.type === CSSRule.FONT_FACE_RULE) {
        push(rule.cssText);                       // needed before first paint
      } else if (rule.type === CSSRule.KEYFRAMES_RULE) {
        push(rule.cssText);                       // entrance animations run immediately
      }
    }
  };

  for (const sheet of document.styleSheets) {
    let rules;
    try { rules = sheet.cssRules; } catch { continue; }   // cross-origin
    walk(rules, '', '');
  }
  return out.join('\n');
}

mkdirSync(OUT, { recursive: true });

const browser = await puppeteer.launch({
  executablePath: CHROME,
  headless: 'new',
  args: ['--no-sandbox', '--disable-gpu', '--disable-dev-shm-usage'],
});

const kb = (n) => (n / 1024).toFixed(1) + ' KiB';

for (const [name, path] of Object.entries(PAGES)) {
  let combined = '';
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

    combined += '\n' + (await page.evaluate(collectCritical));
    await page.close();
  }

  const { code } = transform({
    filename: `critical-${name}.css`,
    code: Buffer.from(combined),
    minify: true,
    errorRecovery: true,
    targets: { chrome: 100 << 16, firefox: 100 << 16, safari: 15 << 16 },
  });

  writeFileSync(join(OUT, `critical-${name}.css`), code);
  console.log(`  critical-${name}.css`.padEnd(28) + kb(code.length).padStart(9));
}

await browser.close();
