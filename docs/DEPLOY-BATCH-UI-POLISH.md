# Deploy batch — UI polish (antenatal rose, pillar tones, transitions, copy, robustness)

> **For OMP.** This is a single, self-contained deploy of theme changes that have stacked up in
> the repo since the last live sync. Everything here is in `main` (through commit `54a27a3`) and
> verified on local Docker (`http://localhost:8080`). It is **code only** — no database/content
> changes, so nothing in wp-admin needs touching. Deploy = SFTP upload the files below, then
> cache-bust. Theme version is already bumped to **0.1.7** for that.

## Why this batch exists
A run of UI/UX polish landed in the repo but was never pushed to live. Deploying them all at once
avoids a per-change SFTP trip. No content, menus, pages, or plugins change.

## What changed (plain English)
- **Antenatal rose accent** — Dr Anis / women's-health gets a rose palette (home specialist block,
  the Antenatal pillar on `/services/`, and the antenatal service page).
- **Per-pillar soft-tone panels on `/services/`** — Minor Surgery navy, Aesthetics mauve,
  Antenatal rose, General Medicine teal.
- **Warm scroll-in transition** into the homepage specialist section (neutral background, rose
  accents + a soft tint that fades in as you scroll — the heavy background wash was reverted).
- **`/services/<pillar>/` procedures grid** — consistent alignment between each procedure name
  and its description.
- **About + International Patients copy** — the `[confirm ...]` placeholder lines were replaced
  with publishable default copy.
- **Robustness (no visible change)** — ACF safety shim (no white screen if ACF is ever off) and
  centralized proof stats via `walid_stats()`.

## Files to upload (SFTP → same paths under `wp-content/themes/walid-child/`)
```
wp-content/themes/walid-child/style.css                    # version bump 0.1.7 (cache-bust)
wp-content/themes/walid-child/functions.php                # ACF shim wiring
wp-content/themes/walid-child/front-page.php               # specialist section transition markup
wp-content/themes/walid-child/single-service.php           # procedures grid alignment
wp-content/themes/walid-child/archive-service.php          # per-pillar tinted panels
wp-content/themes/walid-child/page-governance.php          # About copy (no [confirm])
wp-content/themes/walid-child/page-international.php        # International copy (no [confirm])
wp-content/themes/walid-child/inc/helpers.php              # walid_stats() + ACF shim helpers
wp-content/themes/walid-child/inc/seo.php                  # stats via walid_stats()
wp-content/themes/walid-child/assets/css/brand.css         # accent palettes + pillar tones
wp-content/themes/walid-child/assets/css/homepage.css      # specialist transition styles
wp-content/themes/walid-child/assets/css/single.css        # procedures grid, antenatal page
wp-content/themes/walid-child/assets/css/archive.css       # pillar-tinted panel styles
```
13 files. Overwrite the live copies; do not rename.

## After upload — cache-bust (required)
The CSS is enqueued with the theme version as the query string, so bumping `style.css` to 0.1.7
busts browser cache automatically once that file is uploaded. Then:
1. If a caching/optimizer plugin is active (e.g. host cache, WP Rocket, Autoptimize), **purge all
   cache**.
2. Hard-refresh a browser (Cmd/Ctrl + Shift + R) on these pages to confirm.

## Verify on live (same as local)
- `/` — scroll to the **"Meet the specialist" / Dr Anis** block: rose accents, a soft tint fading
  in on scroll, neutral (not washed) background.
- `/services/` — the four pillar panels each carry their own tone (navy / mauve / rose / teal).
- `/services/minor-surgery/` — in "Procedures we perform", each name lines up cleanly above its
  description across the grid.
- `/about/` and `/international-patients/` — no `[confirm ...]` text anywhere on the page.
- Any page — renders normally (ACF shim is invisible when ACF is on, which it is).

## Rollback
These are additive theme-file edits; Astra and the DB are untouched. To revert, re-upload the
previous version of any file from git history (`git show <prev-commit>:<path>`), or check out
`de4151d^` for the pre-batch state of the changed files.

## Not in this batch (still owner-blocked, do not wait on them)
Real content (branches/doctors/procedures/reviews), official logo swap, Google Places key, Rank
Math sitemap. See `HANDOFF-OMP.md` and `docs/CONTENT-CHECKLIST.md`.
