# Deploy batch — UI polish (accents, pillar/region tones, heroes, copy, robustness)

> **For OMP.** This is a single, self-contained deploy of all theme changes that have stacked up
> in the repo since the last live sync (the Astra port). Everything here is in `main` (through
> commit `b455546`) and verified on local Docker (`http://localhost:8080`). It is **code only** —
> no database/content changes, so nothing in wp-admin needs touching. Deploy = SFTP upload the
> files below, then cache-bust. Theme version is already bumped to **0.2.5** for that.

## Why this batch exists
A long run of UI/UX polish landed in the repo across many commits but was never pushed to live.
Deploying them all at once avoids a per-change SFTP trip. No content, menus, pages, or plugins
change — only theme files.

## What changed (plain English)
- **Antenatal rose accent** — Dr Anis / women's-health gets a rose palette (home specialist block,
  the Antenatal pillar on `/services/`, and the antenatal service page).
- **Per-pillar soft-tone panels on `/services/`** — Minor Surgery blue, Aesthetics mauve,
  Antenatal rose, General Medicine teal. Minor Surgery blue was softened (was too dark).
- **Per-pillar themed service pages** — each service single (hero overlay, accents, promise band)
  follows its pillar colour: ENT / men's health etc. render teal, aesthetics mauve, antenatal rose,
  minor surgery navy.
- **Warm scroll-in transition** into the homepage specialist section (neutral background, rose
  accents + a soft tint that fades in on scroll).
- **Service single page rebuild** — photo-as-background hero (no more floating blob); a
  "Where we perform" branch section; "Why day-care surgery" stats moved under it with an added
  benefits paragraph; 3 pillar-tailored testimonials; a brand-promise band; procedures shown as
  compact A–Z chips (name + description on hover).
- **Services archive** — featured navy Minor Surgery card text fixed for contrast (white title +
  light body); 5 Minor Surgery category cards (Skin & Subcutaneous Tissue, Wound Care & Trauma
  Repair, Nail & Minor Dermatological Surgeries, Therapeutic & Joint Injections, Minor
  Gynaecological & Urological Procedures).
- **Locations pages aligned to Services** — Branches archive region sections are now tinted
  soft-tone panels (Central navy, North teal, Other mauve); single-branch uses the same
  photo-as-background hero + per-branch accent (surgical = navy, general = teal).
- **Doctors** — archive lists Dr Walid first and centres the "View profile" button; Dr Walid's
  profile is richer (areas of focus, "how we care for you", proof stats, at-a-glance sidebar).
- **Footer** — Services column now lists the 4 pillars; a new Branches column lists branches.
- **International page** — testimonials section with clear scroll-in motion.
- **About page** — the "Our philosophy" mission/values copy + motto added.
- **Copy** — `[confirm ...]` placeholder lines on About + International replaced with publishable
  copy.
- **Robustness (no visible change)** — ACF safety shim (no white screen if ACF is ever off) and
  centralized proof stats via `walid_stats()`.

## Files to upload (17 — SFTP, same paths under `wp-content/themes/walid-child/`)
```
wp-content/themes/walid-child/style.css                    # version bump 0.2.5 (cache-bust)
wp-content/themes/walid-child/functions.php                # footer pillars+branches, ACF shim
wp-content/themes/walid-child/front-page.php               # specialist section transition
wp-content/themes/walid-child/archive-service.php          # pillar panels, Minor-Surgery category cards
wp-content/themes/walid-child/single-service.php           # hero, where-we-perform, stats, testimonials, chips
wp-content/themes/walid-child/archive-branch.php           # tinted per-region panels
wp-content/themes/walid-child/single-branch.php            # photo-as-background hero + accent
wp-content/themes/walid-child/archive-doctor.php           # Dr Walid first, centred button
wp-content/themes/walid-child/single-doctor.php            # richer doctor profile
wp-content/themes/walid-child/page-governance.php          # About philosophy copy (no [confirm])
wp-content/themes/walid-child/page-international.php        # testimonials motion, copy (no [confirm])
wp-content/themes/walid-child/inc/helpers.php              # walid_stats(), pillar reviews, ACF shim
wp-content/themes/walid-child/inc/seo.php                  # stats via walid_stats()
wp-content/themes/walid-child/assets/css/brand.css         # accent palettes + softened minor blue + footer grid
wp-content/themes/walid-child/assets/css/homepage.css      # specialist transition styles
wp-content/themes/walid-child/assets/css/single.css        # service/branch/doctor hero, chips, testimonials
wp-content/themes/walid-child/assets/css/archive.css       # pillar/region panels, category + testimonial styles
```
Overwrite the live copies; do not rename. If uploading whole folders is easier, pushing the
entire `wp-content/themes/walid-child/` directory is safe — these 17 are the only files that
changed since the Astra port, but the rest are identical to live.

## After upload — cache-bust (required)
The CSS and JS are enqueued with the theme version as a query string, so bumping `style.css` to
0.2.5 busts browser cache automatically once that file is uploaded. Then:
1. If a caching/optimizer plugin is active (host cache, WP Rocket, Autoptimize, etc.), **purge all
   cache**.
2. Hard-refresh a browser (Cmd/Ctrl + Shift + R) on the pages below to confirm.

## Verify on live (quick pass)
- `/` — the **Dr Anis specialist** block: rose accents, soft tint fading in on scroll, neutral bg.
- `/services/` — four pillar panels in their own tones (blue / mauve / rose / teal); the featured
  navy **Minor Surgery** card reads clearly (white title, light text); **5 category cards** appear.
- `/services/minor-surgery/` — background-photo hero; procedures are compact A–Z chips; the
  "Why day-care surgery" stats sit under "Where we perform" with the benefits paragraph; 3
  testimonials; navy promise band.
- `/services/ent/` (or any General Medicine service) — header/accents are **teal**.
- `/branches/` — region sections are tinted panels (Central navy, North teal, Other mauve).
- a single branch (e.g. `/branches/jalan-baru/`) — background-photo hero; surgical hubs navy,
  general branches teal.
- `/doctors/` — **Dr Walid** is first; "View profile" button centred.
- `/doctors/dr-walid/` — richer profile (areas of focus, how we care, proof stats, at-a-glance).
- `/about/` — "Our philosophy" section + motto; no `[confirm ...]` text.
- `/international-patients/` — testimonials animate in on scroll; no `[confirm ...]` text.
- footer (any page) — **Services** column lists 4 pillars; **Branches** column lists branches.

## Rollback
These are additive theme-file edits; Astra and the DB are untouched. To revert a single file,
re-upload its previous version from git history (`git show <prev-commit>:<path>`). To revert the
whole batch, check out the changed files at `701a475^` (the state just before this stack began)
and re-upload them.

## Still-flagged after this deploy (owner to resolve, not code)
- Illustrative stat line on `/services/<pillar>/` carries `[confirm with clinic]`.
- Minor Surgery category list + descriptions carry `[confirm with clinic]`.
- Testimonials across service/international pages are sample quotes marked `[permission pending]`
  until real review permissions exist.
- Dr Walid credential line / category exactness still owner-confirmed.

## Not in this batch (still owner-blocked, do not wait on them)
Real content (branches/doctors/procedures/reviews via `docs/CONTENT-CHECKLIST.md`), official logo
swap, Google Places key, Rank Math sitemap. See `HANDOFF-OMP.md`.
