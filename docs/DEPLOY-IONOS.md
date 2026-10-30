# Deploy to IONOS — Poliklinik Walid

> IONOS-specific runbook. General steps + checklist live in `docs/DEPLOY.md` and
> `HANDOFF-OMP.md`; this file covers the IONOS panel specifics. Recommended path: a **fresh
> WordPress install on IONOS**, then upload our theme + plugin and enter content (no DB migration).

IONOS sells two relevant products. Pick the one you have:
- **Managed WordPress** — WordPress is pre-installed/managed. Easiest; you just add our code.
- **Web Hosting (Linux/"Plus/Pro")** — a general hosting plan with the IONOS panel, MySQL,
  SFTP, and (on Plus/Pro) SSH. You install WordPress yourself (1-click or manual).

---

## A. What you need from IONOS (gather first)

1. **Domain** pointed at the hosting (e.g. `poliklinikwalid.com` or the chosen domain).
2. **Hosting plan type** (Managed WP vs Web Hosting) — determines the steps below.
3. **SFTP/SSH credentials** (IONOS panel → Hosting → "SFTP & SSH" / "User Administration"):
   host, username, password, port (SFTP 22). SSH is available on Web Hosting Plus/Pro and lets
   you run WP-CLI; if your plan has no SSH, use SFTP + the panel UI instead.
4. **MySQL database** (IONOS panel → "Databases" → create one): DB name, DB user, password, and
   the **DB host** (IONOS gives a specific host like `dbxxxx.hosting-data.io`, NOT localhost).
5. **SSL**: IONOS provides free SSL; enable it for the domain in the panel before launch.

> You do NOT need to share these with any agent. Deployment is done in your IONOS panel + SFTP;
> the code to upload is in this repo.

---

## B. Fresh install path (recommended)

### Managed WordPress
1. IONOS panel → your Managed WordPress site is already running; note its admin URL.
2. Log into wp-admin. Set a strong admin password.
3. Go to **Appearance → Themes** and **Plugins** and install:
   - Theme: **Kadence**
   - Plugins: **Advanced Custom Fields**, **Rank Math** (SEO)
4. Upload our code (see §C) and activate: theme `Walid Child`, plugin `Walid CPTs`.
5. Continue at §D (configure).

### Web Hosting (self-install)
1. IONOS panel → **WordPress / Website** → use the **1-click WordPress installer**, or install
   manually: create the MySQL DB (§A.4), download WordPress, upload via SFTP, run the installer
   pointing at the IONOS DB host/name/user/password.
2. Finish the WordPress 5-minute install (site title, admin user/password, admin email).
3. Log into wp-admin; install **Kadence** + **ACF** + **Rank Math** (Appearance/Plugins).
4. Upload our code (§C), activate theme + plugin.
5. Continue at §D.

---

## C. Upload our code (both paths)

Only two folders from this repo go to the server, into `wp-content/`:

```
wp-content/themes/walid-child/     → <webroot>/wp-content/themes/walid-child/
wp-content/plugins/walid-cpts/     → <webroot>/wp-content/plugins/walid-cpts/
```
(`walid-child/acf-json/` must come along — it auto-registers the fields.)

**Via SFTP (works on every plan):**
1. Connect with an SFTP client (FileZilla/Cyberduck) using the IONOS SFTP creds.
2. Navigate to the site's web root (often `/` or a folder shown in the panel).
3. Upload the two folders into `wp-content/themes/` and `wp-content/plugins/`.
4. In wp-admin: Appearance → Themes → activate **Walid Child**; Plugins → activate **Walid CPTs**.

**Via SSH + git (if your plan has SSH, faster for updates):**
```bash
ssh <user>@<host>
cd <webroot>/wp-content/themes && git clone <repo> _walid && \
  cp -r _walid/wp-content/themes/walid-child . && \
  cp -r _walid/wp-content/plugins/walid-cpts ../plugins/ && rm -rf _walid
```
(or just `scp -r` the two folders).

---

## D. Configure (both paths)

Do these in wp-admin (and WP-CLI if SSH is available):

1. **Brand palette** — set Kadence Global Palette to navy. With SSH:
   `wp eval-file set-palette.php` (upload `bin/set-palette.php` first). Without SSH: Appearance →
   Customize → Kadence Global Palette, set the 9 swatches per `docs/07-design-system.md` §6
   (navy #232B8F, green #1E8E66, gold #C9A227, etc.).
2. **Static homepage** — Settings → Reading → "A static page" → create/select page "Home".
   `front-page.php` renders automatically.
3. **Permalinks** — Settings → Permalinks → **Post name** (gives `/services/...`, `/branches/...`).
4. **Create pages** and assign templates (Page → Attributes → Template):
   | Page | Slug | Template |
   |---|---|---|
   | About | about | About / Governance |
   | Contact | contact | Contact |
   | International Patients | international-patients | International Patients |
5. **Primary menu** — Appearance → Menus → create `Primary` with Home · Services · Branches ·
   Doctors · About · International · Contact → assign to Kadence's primary location.
6. **Google reviews key** (optional) — add to `wp-config.php` via SFTP:
   `define( 'WALID_GOOGLE_PLACES_KEY', '...' );` then set each branch's Place ID. See
   `docs/GOOGLE-REVIEWS.md`.

---

## E. IONOS gotchas

- **DB host is not localhost.** IONOS uses a dedicated DB host (e.g. `dbNNNN.hosting-data.io`).
  Use the exact value from the panel in `wp-config.php` / the installer.
- **PHP version**: set it to **8.2+** in the IONOS panel (Hosting → PHP settings). The theme
  requires 8.2+.
- **File permissions**: IONOS web root may differ per plan; upload into the folder the panel
  shows as the document root for the domain.
- **Caching**: if IONOS site-caching or a CDN is on, purge it after deploying so CSS changes show.
- **Staging**: Managed WordPress offers a staging site — deploy + test there first, then push live.
- **No SSH on your plan?** Everything is still doable via SFTP + wp-admin UI; you just set the
  palette and pages by clicking instead of WP-CLI.

---

## F. Then: pre-launch checklist
Run the checklist in `HANDOFF-OMP.md` §4 (HTTPS, permalinks, palette, CPTs/ACF, WhatsApp routing,
no empty social hrefs, schema validates, real logo swapped, backups). Enable IONOS auto-backups.

## G. Content + launch
Enter the 10 branches, doctors, services, and permitted reviews via the CMS (the sample seeder is
LOCAL ONLY — do not run it on IONOS). Link Google Business Profile per branch. Submit the Rank
Math sitemap to Google Search Console.
