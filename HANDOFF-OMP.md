# Handoff for OMP — Deploy Poliklinik Walid to a live host

> **Status: BUILT + DEPLOYED LIVE** on `poliklinikdrwalid.com` (IONOS Managed WP, parent theme
> **Astra** 4.14.2). Theme `walid-child` + plugin `walid-cpts` active; ACF + 5 field groups synced.
> Remaining work is **live config + real content** (below). Read `project-context.md` +
> `docs/00-project-brief.md` for the "why". Deep detail: `docs/DEPLOY-IONOS.md`, `docs/UPDATING.md`,
> `docs/CONTENT-CHECKLIST.md`, `docs/GOOGLE-REVIEWS.md`.

---

## ★ DO THIS NEXT (live config) — ✅ COMPLETED 31 Oct 2026

> **Status: DONE.** All five operations below were executed on the live site via **wp-admin UI**.
> Result: `/about/` and `/international-patients/` are live (200), both About and Contact pages
> carry their templates, the **Primary** menu exists with all 7 items, and rewrites are flushed.
> Details + evidence: `2026-10-31__walid__astra-deploy__report__README.md` §3b.
> The two corrections below are what a future agent needs to know; the rest of this section is
> the original instruction, kept for reference.

### Correction 1 — `wp eval-file` is not reachable on this host
```bash
wp eval-file finish-setup.php      # NOT USABLE — needs SSH
```
IONOS Managed WP here gives no SSH shell to the operator, so `wp eval-file` cannot run. SFTP
credentials live in the IONOS panel and should not be handled by an agent. **Use wp-admin UI
instead** — it reaches the identical end state:

| Script operation | wp-admin equivalent |
|---|---|
| create pages + assign templates | Pages → Add New; Page → Template in the sidebar |
| static front page | Settings → Reading |
| Post-name permalinks | Settings → Permalinks |
| build + assign Primary menu | Appearance → Menus |
| flush rewrites | Settings → Permalinks → **Save Changes** |

### Correction 2 — Astra's menu locations are not `menu-1`
The script sets `nav_menu_locations['menu-1']`. That key is **not registered** on this install.
Astra registers: `primary`, `secondary_menu`, `mobile_menu`, `loggedin_account_menu`,
`footer_menu`. Assign the Primary menu to **`primary`** and **`mobile_menu`** (the latter is what
the mobile header actually renders).

### Known blocker found and fixed during execution
The **Extendify** plugin ("Extendify WordPress Onboarding and AI Assistant") auto-opens a
full-screen "Design Library" modal over every new-page editor. `#editor-canvas` never renders
behind it and clicks are intercepted, so **no page can be created** while it is active. It was
**deactivated** (not deleted; one click to reverse). Any future reproduction of this build on a
host with Extendify bundled must account for it.

### Original instruction (for reference)
```bash
wp eval-file finish-setup.php      # upload bin/finish-setup.php first, or run from the repo copy
```
It is **idempotent** and does all of this:
- creates **Home / About / International Patients / Contact** pages + assigns their templates
- sets the **static front page** (Home) and **Post-name permalinks**
- builds the **Primary menu** (Home · Services · Branches · Doctors · About · International ·
  Contact) and assigns it to Astra's location
- **flushes rewrites** (fixes the `/about`, `/international-patients`, `/procedures/<slug>` 404s)

### Still open: `/procedures/<slug>/` resolves only once content exists
The rewrite rules are correct and flushed, but `/procedures/xanthelasma-treatment/` remains 404
because **zero procedure records exist** (WP admin → Procedures reports "All (0)"). This is not a
routing bug — the CPT archive and singe templates are in place and were verified rendering. It
resolves as soon as a Procedure post is created with that slug. A CPT permalink cannot be
verified against a record that does not exist.

### Then, in order
1. **Confirm ACF is active** (hard dependency — the theme reads content via `get_field()`; a
   safety shim now prevents a white screen, but with ACF off the CPT content is blank).
2. **Enter real content** via the CMS — `docs/CONTENT-CHECKLIST.md` (10 branches, doctors,
   services + procedures, reviews). The local sample seeder (`bin/seed-sample-content.php`) is
   LOCAL ONLY — do not run it on live.
3. **Swap the official logo** at `wp-content/themes/walid-child/assets/logo.jpg` (same filename).
4. **Optional:** Google Places key for live reviews (`docs/GOOGLE-REVIEWS.md`); Rank Math sitemap
   → Google Search Console.
5. Run the **pre-launch checklist** (§4) before announcing.

> Updating later (small vs big changes): see `docs/UPDATING.md`. Content = edit in wp-admin;
> code = deploy changed theme/plugin files, test on staging first.

---

## 0. What exists in this repo (the deliverable)

Only our code is tracked; WordPress core/db/uploads are created on the host.

```
wp-content/themes/walid-child/      ← the theme (navy brand, all templates)
  ├── style.css, functions.php, theme.json
  ├── front-page.php                ← homepage (11 sections)
  ├── archive-service.php / archive-branch.php / archive-doctor.php
  ├── single-branch.php / single-service.php / single-doctor.php
  ├── page-governance.php (About) / page-contact.php / page-international.php
  ├── inc/        helpers.php, seo.php, patterns.php, google-reviews.php
  ├── acf-json/   4 field groups (auto-register, no manual field setup)
  └── assets/     css, js, img (placeholders)
wp-content/plugins/walid-cpts/      ← CPTs: Branch, Service, Doctor, Review + taxonomies
bin/                                ← provision.sh, set-palette.php, seed-sample-content.php
docker-compose.yml                  ← reference environment (PHP 8.2 + MariaDB + WP-CLI)
```

Verified build target: **WordPress 7.x / PHP 8.2+**. Parent theme **Astra**. Plugins:
**Advanced Custom Fields**, **Rank Math** (SEO). No page builder, no multilingual plugin.

> **Theme note (31 Oct 2026).** The child theme was authored against **Kadence** but the live site
> runs **Astra** (+ Spectra blocks). The theme had zero `kadence_*` API calls — the only coupling
> was the `Template:` header and one enqueue handle — so it was ported to Astra:
> `style.css` → `Template: astra`, `functions.php` → `astra-parent` handle, `bin/set-palette.php`
> now writes `astra-settings[global-color-palette]` (+ Spectra), `bin/provision.sh` installs
> `astra`. `get_template_directory_uri()` resolves the parent automatically, so no Kadence install
> is required. Do **not** reintroduce a Kadence dependency.

---

## 1. Deploy method — choose A (recommended)

### Option A — Fresh install on host, enter content there (recommended)
No database to migrate; real content is entered on the live site via the CMS. Cleanest.

**Steps:**
1. **Host prep**: PHP 8.2+, MySQL/MariaDB, HTTPS (Let's Encrypt). Point the domain. Confirm SSL
   BEFORE launch (healthcare site).
2. **Install WordPress** (host one-click or manual). Strong admin password; enable login limiting.
3. **Install + activate the parent theme and plugins** (WP-CLI shown; admin UI works too):
   ```bash
   wp theme install astra
   wp plugin install advanced-custom-fields --activate
   wp plugin install seo-by-rank-math --activate
   ```
4. **Upload our code** (SFTP / git / host file manager):
   - `wp-content/themes/walid-child/`   (includes `acf-json/` → fields auto-register)
   - `wp-content/plugins/walid-cpts/`
5. **Activate ours**:
   ```bash
   wp theme activate walid-child
   wp plugin activate walid-cpts
   ```
6. **Set the brand palette** (so Astra renders navy). Upload `bin/set-palette.php`, then:
   ```bash
   wp eval-file set-palette.php
   ```
   (Or set the 9 Astra Global Palette swatches by hand to the values in
   `docs/07-design-system.md` §6: navy #232B8F, green #1E8E66, gold #C9A227, etc.)
7. **Static homepage**: create a page titled "Home", then
   `wp option update show_on_front page` and `wp option update page_on_front <home_page_id>`
   (or Settings → Reading). `front-page.php` renders automatically on the front page.
8. **Permalinks = Post name**: `wp rewrite structure '/%postname%/' --hard && wp rewrite flush --hard`
   (gives `/services/...`, `/branches/...`, `/doctors/...`).
9. **Create the key pages** (template is chosen via each page's Template attribute, or set
   `_wp_page_template` meta):
   | Page title | Slug | Template |
   |---|---|---|
   | About | `about` | `page-governance.php` |
   | Contact | `contact` | `page-contact.php` |
   | International Patients | `international-patients` | `page-international.php` |
10. **Primary menu**: create a menu `Primary` with Home · Services · Branches · Doctors · About ·
    International · Contact and assign it to Astra's primary location. (Services/Branches/Doctors
    point to the CPT archive URLs `/services/`, `/branches/`, `/doctors/`.)

> A scripted version of steps 3–8 exists in `bin/provision.sh` (written for the Docker wpcli
> container; adapt paths/`--allow-root` for the host).

> **Host = IONOS.** A step-by-step IONOS runbook (panel specifics: DB host, SFTP/SSH, PHP
> version, SSL, staging, Managed-WP vs Web-Hosting paths) is in **`docs/DEPLOY-IONOS.md`**.
> Use that for the actual deploy; the steps below are the host-agnostic version.

### Option B — Migrate the local DB (only if real content was entered locally)
See `docs/DEPLOY.md` §"Option B". Involves `wp db export/import`, uploads tarball, and a careful
`wp search-replace 'http://localhost:8080' 'https://DOMAIN' --precise --recount`. Prefer A.

---

## 2. Enter content (CMS — owner/consultant supplies the data)

> A fill-in-the-blanks sheet mapping every CMS field is in **`docs/CONTENT-CHECKLIST.md`** — use
> it to gather the 10 branches, doctors, services, and reviews before typing them into wp-admin.


All content is entered via wp-admin forms (that is the CMS payoff). Nothing is hardcoded.

- **Branches** (×10): title, address, opening hours, phone, WhatsApp, region (Central / North /
  Other), "provides minor surgery" toggle, photos, Google Place ID (for live reviews), map.
  - Minor-surgery branches: Ampang (Central, flagship); Jalan Baru/Seberang Perai, Tasek Gelugor,
    Sungai Petani (North). Others (Kuala Kangsar, Parit Buntar, …) = general practice.
- **Services**: assign Pillar (Minor Surgery / Aesthetics / Antenatal & Women's Health / General
  Medicine), pillar-weight, short description, procedures (one per line → drives the "show more"
  list), WhatsApp routing, lead specialist, offered-at branches.
- **Doctors**: name, role/credential, qualifications, photo, bio, branches, lead-specialist-for.
- **Reviews** (optional/curated): quote, author, rating, source, **permission toggle ON** before
  it ever shows. (Live Google reviews are the other path, see §3.)

> There is a **local-only** sample seeder (`bin/seed-sample-content.php`) that creates placeholder
> branches/services/doctors/reviews for preview. **Do NOT run it on production** — it is for the
> local Docker preview only. Enter real content on the host.

---

## 3. Live Google reviews (optional, needs owner key) — see docs/GOOGLE-REVIEWS.md

1. Owner creates a Google Cloud API key with **Places API (New)** enabled (+ billing on).
2. Add to `wp-config.php`: `define( 'WALID_GOOGLE_PLACES_KEY', 'the-key' );`
3. Put each branch's **Place ID** in the branch's "Google Place ID" field.
Result: branch pages show the live rating + up to 5 reviews (cached 12h), else fall back to
curated CPT reviews, else a "Read reviews on Google" link. Cost is tiny due to caching.

---

## 4. Pre-launch checklist (verify on the host)

- [ ] HTTPS active; http→https redirect.
- [ ] Static homepage set; permalinks = Post name; `/branches/...` resolve; no 404s in nav.
- [ ] `walid-child` active, `walid-cpts` active, ACF + Rank Math active. No page builder.
- [ ] Astra palette = navy/green/gold; Fraunces + Inter load.
- [ ] CPTs visible in admin; ACF fields show on each; relationships save (e.g. Service → lead Doctor).
- [ ] Floating WhatsApp on every page; both numbers correct and routing right
      (general 014-252 1684 · minor-surgery 017-549 7593).
- [ ] Every social icon links (TikTok/FB/IG/Google). No empty hrefs.
- [ ] Reviews render ONLY where permission is ON (or via a valid Google Place ID).
- [ ] No content behind `[confirm]` / `[TBD]` / `[permission pending]` is published.
- [ ] Branch JSON-LD validates (Rich Results Test). Rank Math titles/meta/sitemap set; submit
      sitemap to Google Search Console.
- [ ] Official logo swapped at `wp-content/themes/walid-child/assets/logo.svg` (currently a
      faithful recreation).
- [ ] Lighthouse + accessibility spot check (focus states, alt text, one h1, color contrast).
- [ ] Backups scheduled (UpdraftPlus or host); auto-updates plan agreed.
- [ ] Google Business Profile linked per branch; NAP consistent with branch pages.

---

## 5. Hard rules (do not break — from the brief)

- WhatsApp-only conversion. No forms/booking engine.
- English-only content at launch. No translation plugins (architecture is i18n-ready).
- Copy: **no em-dashes**; avoid "not a..., not a...".
- Do NOT reintroduce: care-path motif, emergency bar, 3-step process, pervasive disclaimers.
  Compliance lives in the footer + the About/Governance page only.
- Navy `#232B8F` brand, gold `#C9A227`, green `#1E8E66` CTAs. Do not revert to teal.
- All custom code stays in `walid-child` + `walid-cpts`. Never edit the Astra parent.
- Nothing fake published: honor every `[confirm]` / `[TBD]` / `[permission pending]` flag.

---

## 6. Owner-blocked items (collect before/at launch — see docs/08-owner-decisions.md)

Official logo file + exact hex · Dr Anis exact credential · the 4th pillar · aesthetics launch
scope · named-review permissions + source URLs · full 10-branch dataset (addresses/hours/phones/
Place IDs) · confirm current social follower counts · real TikTok/IG proof-wall video URLs ·
(optional) Google Places API key.

---

## Updating after launch
How to make content vs code changes (small and big) safely once live is in **`docs/UPDATING.md`**.
Short version: content = edit in wp-admin (no deploy); code = change in the repo, deploy the
changed theme/plugin files via SFTP, test on staging first. Content and code update separately,
so neither risks the other (DB/uploads are never in git).

## 7. When done

Update the status trackers and push: the "Where we are" block in
`.kiro/steering/project-context.md`, the table in `README.md`, and the progress table in
`project-context.md`. Record host/access details (not secrets) in `docs/08-owner-decisions.md`.
