#!/usr/bin/env bash
# Provision the local WordPress for the Poliklinik Walid build.
# Reproducible setup via WP-CLI: core install, theme, and plugins.
# Run AFTER `docker compose up -d`:
#   docker compose run --rm wpcli bash /scripts/provision.sh
#
# Reads WP_* env vars (see .env.example). Safe to re-run (idempotent-ish).

set -euo pipefail

WP_URL="${WP_URL:-http://localhost:8080}"
WP_TITLE="${WP_TITLE:-Poliklinik Walid (local)}"
WP_ADMIN_USER="${WP_ADMIN_USER:-admin}"
WP_ADMIN_PASSWORD="${WP_ADMIN_PASSWORD:-admin}"
WP_ADMIN_EMAIL="${WP_ADMIN_EMAIL:-admin@example.com}"

cd /var/www/html

echo "==> Waiting for the database..."
until wp db check --allow-root >/dev/null 2>&1; do
  sleep 2
done

if ! wp core is-installed --allow-root >/dev/null 2>&1; then
  echo "==> Installing WordPress core..."
  wp core install --allow-root \
    --url="$WP_URL" \
    --title="$WP_TITLE" \
    --admin_user="$WP_ADMIN_USER" \
    --admin_password="$WP_ADMIN_PASSWORD" \
    --admin_email="$WP_ADMIN_EMAIL" \
    --skip-email
else
  echo "==> WordPress already installed, skipping core install."
fi

echo "==> Installing Kadence parent theme..."
wp theme install kadence --allow-root || echo "   (kadence install skipped/failed — check network)"

echo "==> Activating walid-child child theme..."
wp theme activate walid-child --allow-root || echo "   (walid-child not ready yet — activate after task 3)"

echo "==> Installing ACF (custom fields)..."
wp plugin install advanced-custom-fields --activate --allow-root || echo "   (ACF install skipped/failed)"

echo "==> Installing Rank Math (SEO)..."
wp plugin install seo-by-rank-math --activate --allow-root || echo "   (Rank Math install skipped/failed)"

echo "==> Activating walid-cpts plugin..."
wp plugin activate walid-cpts --allow-root || echo "   (walid-cpts not ready yet — activate after task 5)"

echo "==> NOT installing page builders or multilingual plugins (by design)."

echo "==> Done. Theme list:"
wp theme list --allow-root || true
echo "==> Plugin list:"
wp plugin list --allow-root || true
