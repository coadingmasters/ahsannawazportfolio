#!/usr/bin/env bash
# Serve a local copy of the live pages so critical-CSS extraction never has to
# go through the CDN (whose bot check returns an interstitial to headless
# Chrome). Pages come from the server's own loopback; assets from public/.
set -euo pipefail
DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
SNAP="${TMPDIR:-/tmp}/ahsan-snapshot"
PORT=8321

rm -rf "$SNAP"; mkdir -p "$SNAP"
cp -r "$DIR/public/dist" "$DIR/public/fonts" "$DIR/public/images" "$DIR/public/js" "$DIR/public/css" "$SNAP/" 2>/dev/null || true

fetch() { ssh ahsan-host "curl -sSk -H 'Host: ahsannawaz.purrquery.com' https://127.0.0.1$1 2>/dev/null"; }

save() { # $1 = url path, $2 = output file
  mkdir -p "$(dirname "$SNAP/$2")"
  fetch "$1" | sed 's|https://ahsannawaz\.purrquery\.com||g' > "$SNAP/$2"
  local n; n=$(wc -c < "$SNAP/$2")
  echo "  $1 -> $2 (${n} bytes)"
  [ "$n" -gt 5000 ] || { echo "  ! $1 looks too small — aborting" >&2; exit 1; }
}

echo "Snapshotting pages"
save "/"          "index.html"
save "/about"     "about/index.html"
save "/skills"    "skills/index.html"
save "/projects"  "projects/index.html"
save "/contact"   "contact/index.html"
save "/blog"      "blog/index.html"
save "/faq"       "faq/index.html"

python3 -m http.server "$PORT" --directory "$SNAP" >/dev/null 2>&1 &
SERVER=$!
trap 'kill $SERVER 2>/dev/null || true' EXIT
sleep 1

if [ "${EXTRACT:-1}" = "1" ]; then
  ( cd "$DIR" && node build-critical.mjs "http://127.0.0.1:$PORT" )
else
  echo "Snapshot ready at http://127.0.0.1:$PORT (extraction skipped)"
fi
