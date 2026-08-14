/**
 * Asset build.
 *
 *   1. Bundles each page's stylesheets into one file, in the same order the
 *      page used to link them, so a page costs one blocking request rather
 *      than five or six.
 *   2. Minifies the result with lightningcss (already a Vite dependency, and
 *      a real parser — these stylesheets carry data: URIs, calc() and custom
 *      properties that a regex minifier mangles).
 *   3. Also emits standalone minified copies, so anything still linking an
 *      individual file keeps working.
 *
 * Output lands in public/dist/css and is committed: Hostinger's process
 * limits stop a bundler running there, so the build happens here.
 */
import { transform } from 'lightningcss';
import { readdirSync, readFileSync, writeFileSync, mkdirSync } from 'node:fs';
import { join } from 'node:path';

const SRC = 'public/css';
const OUT = 'public/dist/css';

// Order matters: later files override earlier ones.
// header/footer come last: they were inline at the end of the document, so
// that is where they sat in the cascade.
const BUNDLES = {
  welcome: ['fonts', 'theme', 'welcome', 'about', 'projects', 'popup', 'header', 'footer'],
  about: ['fonts', 'theme', 'welcome', 'about', 'header', 'footer'],
  skills: ['fonts', 'theme', 'welcome', 'about', 'projects', 'skills', 'header', 'footer'],
  projects: ['fonts', 'theme', 'welcome', 'about', 'projects', 'header', 'footer'],
  contact: ['fonts', 'theme', 'welcome', 'about', 'contact', 'popup', 'header', 'footer'],
  admin: ['fonts', 'theme', 'admin'],
};

mkdirSync(OUT, { recursive: true });

const targets = { chrome: 100 << 16, firefox: 100 << 16, safari: 15 << 16 };

function minify(name, code) {
  try {
    return transform({ filename: name, code, minify: true, targets }).code;
  } catch (err) {
    // Ship it unchanged rather than dropped — a bigger file beats a broken page.
    console.error(`  ! ${name}: ${err.message.split('\n')[0]} — kept as-is`);
    return code;
  }
}

const kb = (n) => (n / 1024).toFixed(1) + ' KiB';

console.log('  bundles');
let inTotal = 0;
let outTotal = 0;
for (const [page, parts] of Object.entries(BUNDLES)) {
  const joined = parts
    .map((p) => `/* ---- ${p}.css ---- */\n` + readFileSync(join(SRC, `${p}.css`), 'utf8'))
    .join('\n');
  const buf = Buffer.from(joined);
  const out = minify(`page-${page}.css`, buf);
  writeFileSync(join(OUT, `page-${page}.css`), out);
  inTotal += buf.length;
  outTotal += out.length;
  console.log(
    `    page-${page}.css`.padEnd(26) +
      `${parts.length} files  ${kb(buf.length).padStart(9)} → ${kb(out.length).padStart(9)}`
  );
}

console.log('  standalone');
for (const file of readdirSync(SRC).filter((f) => f.endsWith('.css'))) {
  const code = readFileSync(join(SRC, file));
  writeFileSync(join(OUT, file), minify(file, code));
}

console.log(`  TOTAL bundled ${kb(inTotal)} → ${kb(outTotal)} (saved ${kb(inTotal - outTotal)})`);
