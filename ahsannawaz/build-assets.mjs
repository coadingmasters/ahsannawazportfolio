/**
 * Minify public/css into public/dist/css.
 *
 * The Blade @css() directive prefers the dist copy when it is newer than the
 * source, so editing a stylesheet keeps working during development and the
 * deploy just runs this first.
 *
 * lightningcss ships with Vite, so there is nothing extra to install. It is a
 * real CSS parser rather than a regex, which matters here: these stylesheets
 * contain data: URIs, calc() and custom properties that naive minifiers break.
 */
import { transform } from 'lightningcss';
import { readdirSync, readFileSync, writeFileSync, mkdirSync, statSync } from 'node:fs';
import { join } from 'node:path';

const SRC = 'public/css';
const OUT = 'public/dist/css';

mkdirSync(OUT, { recursive: true });

let totalIn = 0;
let totalOut = 0;
const rows = [];

for (const file of readdirSync(SRC).filter((f) => f.endsWith('.css'))) {
  const src = join(SRC, file);
  const dst = join(OUT, file);
  const code = readFileSync(src);

  let out;
  try {
    ({ code: out } = transform({
      filename: file,
      code,
      minify: true,
      // Match roughly the browsers Laravel targets; anything older would only
      // add prefixes nobody here needs.
      targets: { chrome: 100 << 16, firefox: 100 << 16, safari: 15 << 16 },
    }));
  } catch (err) {
    // A stylesheet that cannot be parsed is shipped unchanged rather than
    // dropped — a slightly larger file beats a broken page.
    console.error(`  ! ${file}: ${err.message.split('\n')[0]} — copied as-is`);
    out = code;
  }

  writeFileSync(dst, out);
  totalIn += code.length;
  totalOut += out.length;
  rows.push([file, code.length, out.length]);
}

const kb = (n) => (n / 1024).toFixed(1) + ' KiB';
for (const [f, a, b] of rows.sort((x, y) => y[1] - x[1])) {
  console.log(`  ${f.padEnd(14)} ${kb(a).padStart(9)} → ${kb(b).padStart(9)}  (-${Math.round((1 - b / a) * 100)}%)`);
}
console.log(`  ${'TOTAL'.padEnd(14)} ${kb(totalIn).padStart(9)} → ${kb(totalOut).padStart(9)}  saved ${kb(totalIn - totalOut)}`);
