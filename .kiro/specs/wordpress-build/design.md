# Design — Poliklinik Walid WordPress Build

> How we will satisfy `requirements.md`. Grounded in the committed strategy (`/docs`) and the
> rendered prototype (`/prototype`). Decisions here are reproducible for any agent (IDE/OMP/Web).

## Overview

We build on the Option C hybrid: **Astra** parent theme + native **Gutenberg**, with a
**`walid-child`** child theme holding the custom code (CPTs, fields, templates, CSS). The local
environment is **Docker Compose** (WordPress + MariaDB + WP-CLI), so the stack is identical for
every contributor and can be verified by actually booting it. Provisioning (plugins, theme
activation, CPT setup) is scripted via WP-CLI so nothing depends on manual admin clicks.

```
Docker Compose
├── wordpress (php 8.2+, apache)   → http://localhost:8080
├── db (mariadb)                   → internal
└── wp-cli (one-shot/console)      → provisioning + checks
        │
        └── wp-content/
            ├── themes/astra            (parent, installed via WP-CLI)
            ├── themes/walid-child        (OUR CODE — committed to repo)
            └── plugins/walid-cpts        (optional MU/plugin for CPTs, committed)
```

## Environment design (Req 1)

- `docker-compose.yml` defines three services: `wordpress`, `db`, and a `wpcli` service for
  commands. A named volume persists the DB; `wp-content/themes/walid-child` (and the CPT plugin)
  are **bind-mounted from the repo** so edits are live and version-controlled.
- WordPress core files and uploads are NOT committed (git-ignored); only our theme/plugin code is.
- `.env.example` documents the few env vars (DB name/user/pass, site URL/port). A real `.env`
  is git-ignored.
- A short `prototype`-independent README section (or `docs/DEV.md`) documents: `docker compose up`,
  the URL, and how to run WP-CLI (`docker compose run --rm wpcli wp ...`).

**Rationale:** Docker over LocalWP because an agent can run and verify it headlessly; LocalWP is
GUI-only. It also gives OMP the exact same environment.

## Provisioning design (Req 2)

A scripted sequence (WP-CLI), runnable repeatably:
1. Core install (title, admin user, URL) if not installed.
2. `wp theme install astra --activate` then activate `walid-child`.
3. `wp plugin install advanced-custom-fields --activate`.
4. `wp plugin install seo-by-rank-math --activate` (or Yoast).
5. Explicitly do NOT install page builders or multilingual plugins.

Captured in a `bin/provision.sh` (or documented WP-CLI block) committed to the repo so it is
reproducible and hand-off friendly.

## Theme + tokens design (Req 3)

- `walid-child/style.css` (header + imports), `functions.php` (enqueue, setup), and
  `theme.json` carrying the palette + font-family settings.
- Port `prototype/styles.css :root` variables into a child-theme stylesheet; mirror the same
  values in `theme.json` `settings.color.palette` so block editor color choices match the brand.
- Fonts loaded via `wp_enqueue_style` from a self-hosted or Google Fonts source, `display=swap`,
  preconnect. Fraunces for headings, Inter for body, with system fallbacks.
- Verify visually that a basic page matches prototype colors/typography.

## CPT + fields design (Req 4)

Registered in a committed plugin `walid-cpts` (preferred over functions.php so data survives a
theme switch):

| CPT | Key fields | Taxonomy | Relationships |
|---|---|---|---|
| **Branch** | address, hours, phone(s), map embed, photos, WhatsApp line | Region (Central/North/Other) + `provides_minor_surgery` flag | ↔ Services, ↔ Doctors |
| **Service** | summary, body, price-from, pillar-weight | Pillar (Minor Surgery/Aesthetics/Antenatal/Pillar-4-TBD/General) | ↔ lead Doctor, ↔ Branches |
| **Doctor** | name, credential, bio, photo, `lead_specialist_for` | — | ↔ Services, ↔ Branches |
| **Review** | quote, author, rating, source, source URL, permission flag | — | optional ↔ Service/Branch |

- Fields via **ACF** field groups. Export ACF JSON into the repo (`walid-child/acf-json/`) so
  field definitions are version-controlled and auto-sync on other installs.
- All strings output through i18n functions with the `walid` text domain.

**Rationale:** CPTs in a plugin (not the theme) = content model independent of theme; ACF local
JSON = reproducible fields without manual admin setup.

## Templates design (Req 5)

- **Homepage:** built section-by-section from `docs/12` + `/prototype`. Prefer native block
  patterns registered by the child theme (`register_block_pattern`) so staff can edit, with the
  custom look driven by the ported CSS. Dynamic sections (pillars, branch network, specialist,
  reviews) pull from the CPTs via query loops / template parts.
- **Singulars:** `single-branch.php`, `single-service.php`, `single-doctor.php` template parts
  rendering CPT fields, matching prototype styling.
- **WhatsApp:** a reusable template part for the floating button; the number is chosen by
  context (minor-surgery service/branch → minor-surgery line; else general line). Numbers come
  from a theme option / constants, not scattered literals.
- **Social icons:** a single `footer` partial with real hrefs sourced from a config array.

## Content / SEO / launch design (Req 6)

- Branch pages: `LocalBusiness`/`MedicalClinic` schema (JSON-LD) per branch using CPT fields;
  clean slugs (`/branches/ampang`). Rank Math handles titles/meta/sitemap.
- Social config array with verified hrefs (TikTok, FB, IG, YouTube, Google).
- Performance: lazy-load TikTok/IG embeds (facade pattern), enqueue only what's needed.
- Accessibility: semantic landmarks, focus-visible states, alt text on all media, color-contrast
  checked against the navy/gold/green palette.
- Flag guard: templates render nothing for fields still marked `[confirm]`/`[TBD]`/`[permission pending]`.

## Testing / verification strategy

- **Env:** boot the stack, assert HTTP 200 on the homepage, `wp core version` via WP-CLI.
- **Theme:** `wp theme list` shows `walid-child` active; a test page shows navy/Fraunces.
- **CPTs:** `wp post-type list` / `wp taxonomy list` show the new types; create a sample Branch
  and confirm it renders via its template.
- **Templates:** manual visual check against `/prototype` for the homepage and one of each singular.
- Each task states what was verified vs assumed. A written file is not a working feature.

## Risks / notes

- Agent cannot click in WP admin GUI → everything provisioned via WP-CLI + committed code/JSON.
- Owner-blocked content (logo, branch data, review permissions, Dr Anis credential, 4th pillar)
  is built with safe placeholders behind flags; nothing fake is published.
- Keep Astra as parent; all edits in `walid-child` so parent updates don't clobber work.
