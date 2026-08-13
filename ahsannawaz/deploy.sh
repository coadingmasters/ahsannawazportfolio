#!/usr/bin/env bash
#
# One-command deploy to Hostinger.
#
#   ./deploy.sh            normal deploy (build + upload + migrate + cache)
#   ./deploy.sh --no-build skip the local `npm run build`
#   ./deploy.sh --seed     also run database seeders (first deploy only)
#   ./deploy.sh --fresh    DROP all tables and re-migrate  (destroys live data)
#
# Auth is via the SSH key in ~/.ssh/hostinger_ahsannawaz (host alias `ahsan-host`),
# so no password is ever typed or stored here.
#
set -euo pipefail

HOST="ahsan-host"
REMOTE="/home/u783099422/domains/ahsannawaz.purrquery.com/public_html"
LOCAL="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

BUILD=1
SEED=0
FRESH=0
for arg in "$@"; do
  case "$arg" in
    --no-build) BUILD=0 ;;
    --seed)     SEED=1 ;;
    --fresh)    FRESH=1 ;;
    *) echo "unknown flag: $arg" >&2; exit 2 ;;
  esac
done

say() { printf '\n\033[1;36m==> %s\033[0m\n' "$1"; }

# ---------------------------------------------------------------------------
# 1. Build assets locally — Hostinger has no node/npm on PATH.
# ---------------------------------------------------------------------------
if [ "$BUILD" = 1 ]; then
  say "Building Vite assets locally"
  ( cd "$LOCAL" && npm run build )
else
  say "Skipping build (--no-build)"
fi

if [ ! -f "$LOCAL/public/build/manifest.json" ]; then
  echo "public/build/manifest.json missing — run without --no-build" >&2
  exit 1
fi

# ---------------------------------------------------------------------------
# 2. Upload.
#
# --delete keeps the server a mirror of local, but everything in the exclude
# list is left untouched on the server: the live .env, composer's vendor/,
# runtime logs/caches, and — critically — public/storage, which holds the CV
# and project images uploaded through the admin panel.
# ---------------------------------------------------------------------------
say "Uploading to $HOST:$REMOTE"
rsync -az --delete --info=stats1 \
  --exclude '.git' \
  --exclude '.github' \
  --exclude 'node_modules' \
  --exclude '.env' \
  --exclude '.env.*' \
  --exclude 'vendor' \
  --exclude 'tests' \
  --exclude 'deploy.sh' \
  --exclude 'storage/logs/*' \
  --exclude 'storage/framework/cache/*' \
  --exclude 'storage/framework/sessions/*' \
  --exclude 'storage/framework/views/*' \
  --exclude 'storage/app/public/*' \
  --exclude 'public/storage' \
  --exclude 'public/hot' \
  --exclude '.phpunit.result.cache' \
  "$LOCAL/" "$HOST:$REMOTE/"

# ---------------------------------------------------------------------------
# 3. Remote install + migrate + cache.
# ---------------------------------------------------------------------------
say "Running remote install"
ssh "$HOST" REMOTE="$REMOTE" SEED="$SEED" FRESH="$FRESH" 'bash -s' <<'REMOTE_SCRIPT'
set -euo pipefail
cd "$REMOTE"

# The account's default CLI PHP is 8.3, but Laravel 13 pulls Symfony 8 which
# needs >= 8.4. alt-php84 is installed, so use it explicitly for composer+artisan.
PHP=/opt/alt/php84/usr/bin/php
$PHP -v | head -1

echo "-- composer install"
$PHP /usr/local/bin/composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

echo "-- writable runtime dirs"
mkdir -p storage/framework/{cache/data,sessions,views} storage/logs storage/app/public
mkdir -p public/storage/projects public/storage/cv
chmod -R 775 storage bootstrap/cache public/storage

echo "-- migrations"
if [ "$FRESH" = "1" ]; then
  $PHP artisan migrate:fresh --force
else
  $PHP artisan migrate --force
fi
[ "$SEED" = "1" ] && $PHP artisan db:seed --force

echo "-- caches"
$PHP artisan config:clear
$PHP artisan optimize:clear
$PHP artisan config:cache
$PHP artisan route:cache
$PHP artisan view:cache

echo "-- done"
$PHP artisan about --only=environment 2>/dev/null || true
REMOTE_SCRIPT

say "Deployed -> https://ahsannawaz.purrquery.com"
