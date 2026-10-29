# Deployment guide — Poliklinik Walid

How to take the site from local Docker to a live host. The repo ships only our code
(`walid-child` theme + `walid-cpts` plugin + ACF field JSON); WordPress core, uploads, and the
database are environment-specific and are created fresh on the host.

> Audience: the person deploying (owner/OMP). Assumes shared hosting or a VPS with WordPress
> install access. Nothing here is destructive to the local Docker environment.

---

## What travels to the host vs what is created there

| Travels from this repo | Created fresh on the host |
|---|---|
| `wp-content/themes/walid-child/` (theme + `acf-json/`) | WordPress core |
| `wp-content/plugins/walid-cpts/` (content model) | Database |
| `docs/07-design-system.md` palette values | Uploads / media |
| `bin/set-palette.php` (Kadence palette) | Kadence, ACF, Rank Math (install on host) |

Content (branches, doctors, services, reviews) is entered on the host via the CMS. The sample
seeder (`bin/seed-sample-content.php`) is for local preview only. Do NOT seed on production.

---

## Option A — Fresh install on the host (recommended)

Cleanest path. No database migration; real content is entered on the live site.

1. **Provision hosting + domain.** PHP 8.2+, MySQL/MariaDB, HTTPS (Let's Encrypt). Point the
   domain, confirm SSL before going live (healthcare site).
2. **Install WordPress** (host one-click or manual). Set a strong admin password; enable login
   limiting.
3. **Install the parent theme + plugins** from wp-admin or WP-CLI:
   - Theme: **Kadence**
   - Plugins: **Advanced Custom Fields**, **Rank Math** (or Yoast)
   - Do NOT install a page builder or a multilingual plugin.
4. **Upload our code** (SFTP, Git deploy, or host file manager):
   - `wp-content/themes/walid-child/`  (includes `acf-json/` — fields auto-register)
   - `wp-content/plugins/walid-cpts/`
5. **Activate**: theme `Walid Child`, plugin `Walid CPTs`.
6. **Set the brand palette** (so Kadence uses navy): run `bin/set-palette.php` via WP-CLI
   (`wp eval-file set-palette.php`), or set the 9 Kadence Global Palette swatches by hand to the
   values in `docs/07-design-system.md` §6.
7. **Set the static homepage**: Settings → Reading → "A static page" → create/select a page named
   Home (the `front-page.php` template renders automatically for the front page).
8. **Permalinks**: Settings → Permalinks → Post name (gives `/branches/...`, `/services/...`).
9. **Enter content** via the CMS: the 10 Branches (address, hours, phone, region, provides-minor-
   surgery), Doctors, Services (set pillar + lead specialist), and permitted Reviews.
10. **Rank Math**: run its setup wizard; submit the sitemap to Google Search Console.
11. **Google Business Profile**: link each branch; keep NAP (name/address/phone) consistent with
    the branch pages (this is the local-SEO engine).

---

## Option B — Migrate the local DB (only if you added real content locally)

If real content was entered into the local Docker site and you want to move it:

1. Export the local DB and uploads:
   ```bash
   docker compose run --rm wpcli wp db export /scripts/walid.sql
   # uploads live in the wp_core volume: wp-content/uploads
   docker compose run --rm wpcli tar czf /scripts/uploads.tgz -C /var/www/html/wp-content uploads
   ```
   (Both files land in `./bin` via the mount. They are git-ignored — do NOT commit the DB.)
2. On the host: install WordPress, then import the DB (`wp db import`) and extract uploads into
   `wp-content/uploads`.
3. **Search-replace the URL** (local → live), carefully (serialized data):
   ```bash
   wp search-replace 'http://localhost:8080' 'https://your-domain.com' --precise --recount
   ```
4. Install/activate Kadence + ACF + Rank Math, our theme + plugin, set the palette (step 6 above).
5. Re-save permalinks.

> Prefer Option A unless you have real content locally. Migration carries serialized-data and
> URL-rewrite risks that a fresh install avoids.

---

## Pre-launch checklist

- [ ] HTTPS active; http → https redirect.
- [ ] Static homepage set; permalinks = Post name; `/branches/...` resolve.
- [ ] Kadence palette = navy/green/gold; Fraunces + Inter load.
- [ ] CPTs visible in admin; ACF fields show on each; relationships save.
- [ ] Floating WhatsApp button on every page; both numbers correct and routing right.
- [ ] Every social icon links (TikTok/FB/IG/Google). No empty hrefs.
- [ ] No content behind `[confirm]` / `[TBD]` / `[permission pending]` is published.
- [ ] Reviews shown only where the permission toggle is ON.
- [ ] Branch JSON-LD validates (Rich Results Test); org aggregateRating matches real figures.
- [ ] Official logo swapped in at `wp-content/themes/walid-child/assets/logo.svg`.
- [ ] Lighthouse/aXe spot check (performance + accessibility).
- [ ] Backups scheduled (UpdraftPlus or host); updates plan agreed.

---

## Owner-blocked items to resolve before launch (see docs/08-owner-decisions.md)
Official logo file + exact hex · Dr Anis exact credential · the 4th pillar · aesthetics launch
scope · named-review permissions + source URLs · full 10-branch dataset · confirm current social
follower counts.
