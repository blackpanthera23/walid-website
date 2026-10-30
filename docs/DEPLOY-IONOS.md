# Deploy to IONOS — Poliklinik Walid

> IONOS-specific runbook. General steps + checklist live in `docs/DEPLOY.md` and
> `HANDOFF-OMP.md`; this file covers the IONOS panel specifics. Recommended path: a **fresh
> WordPress install on IONOS**, then upload our theme + plugin and enter content (no DB migration).

## THIS PROJECT'S IONOS SETUP (confirmed)

| Item | Value |
|---|---|
| Plan | **Hosting for WordPress Grow** (use the Managed WordPress path below) |
| Domain | **poliklinikdrwalid.com** (replaces the current placeholder site in place) |
| SFTP host | `access-5021078157.webspace-host.com` · port **22** · protocol **SFTP** |
| SFTP user | `su703680` (password: from the IONOS panel — NEVER commit it) |
| Database | `dbs15968559` · **MariaDB 10.11** (DB user/password/host from the panel) |
| PHP | automated (ensure **8.2+** is selected) |
| SSL | enabled |

> Secrets (SFTP password, DB password, Google API key) live only in the IONOS panel /
> `wp-config.php` on the server. Do not put them in git or chat.

---

IONOS product paths (this plan = the first one):
- **Managed WordPress** (THIS PLAN) — WordPress is pre-installed/managed. Easiest; you just add our code.
- **Web Hosting (Linux/"Plus/Pro")** — a general hosting plan where you install WordPress yourself.

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

## ⚠️ This is a REPLACE-IN-PLACE on a LIVE domain

`poliklinikdrwalid.com` already serves the current placeholder site. Deploying changes what the
public sees. Do it safely:
1. **Back up first** — IONOS panel → back up the site + export the `dbs15968559` database before
   touching anything. (Managed WordPress also offers a **staging** site — prefer staging: build
   there, verify with §F checklist, then push staging → live.)
2. If there is no staging option, consider a brief maintenance window, or build under a temporary
   path/subdomain and switch the domain when verified.
3. Keep the current site's content export until the new site is confirmed good.

## B. Managed WordPress path (THIS PLAN)

1. IONOS panel → open the Managed WordPress site for `poliklinikdrwalid.com`; note its wp-admin URL.
2. Log into wp-admin. Set a strong admin password + enable login limiting.
3. Confirm **PHP 8.2+** in the IONOS panel (Hosting → PHP settings).
4. **Appearance → Themes → Add** install **Astra**; **Plugins → Add** install + activate
   **Advanced Custom Fields** and **Rank Math** (SEO). Do NOT add a page builder or multilingual plugin.
5. Upload our code via SFTP (see §C) and activate: theme **Walid Child**, plugin **Walid CPTs**.
6. Continue at §D (configure).

### Web Hosting (self-install)
1. IONOS panel → **WordPress / Website** → use the **1-click WordPress installer**, or install
   manually: create the MySQL DB (§A.4), download WordPress, upload via SFTP, run the installer
   pointing at the IONOS DB host/name/user/password.
2. Finish the WordPress 5-minute install (site title, admin user/password, admin email).
3. Log into wp-admin; install **Astra** + **ACF** + **Rank Math** (Appearance/Plugins).
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

**Via SFTP (this plan):**
1. Connect with an SFTP client (FileZilla/Cyberduck):
   - Host `access-5021078157.webspace-host.com` · Port `22` · Protocol `SFTP`
   - User `su703680` · Password from the IONOS panel
2. Navigate to the Managed WordPress site's web root for `poliklinikdrwalid.com`
   (the panel shows the document root; `wp-content/` lives under it).
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

1. **Brand palette** — set Astra Global Palette to navy. With SSH:
   `wp eval-file set-palette.php` (upload `bin/set-palette.php` first). Without SSH: Appearance →
   Customize → Astra Global Palette, set the 9 swatches per `docs/07-design-system.md` §6
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
   Doctors · About · International · Contact → assign to Astra's primary location.
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
