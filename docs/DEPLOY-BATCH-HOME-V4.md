# Deploy batch: Homepage Concept 4 + motion layer (theme 0.4.0)

> **Superseded (16 Nov 2026).** Read [`HANDOFF.md`](../HANDOFF.md) at the repo root for the current state, deploy method
> and to-do list. This file describes an older stage and is kept for history.


Not deployed yet. Verified locally on http://localhost:8080 (desktop, mobile, reduced motion).

## What changes on live
- **Homepage (`/`) redesigned** to the Concept 4 editorial layout: arch hero with word-by-word headline,
  "who we are" with counting stats, "The Walid standard", icon-tile services grid, CTA banner,
  rating + reviews marquee, branch list with a map, closing CTA. The theme's own header, footer and floating
  WhatsApp button are unchanged.
- **Inner pages** (services, branches, doctors, procedures, about, international) get the subtler motion layer
  (`motion.css` / `motion.js`): hero text sequence, scroll reveals, stagger, FAQ open/close, progress bar.
- Fonts now also load Fraunces 300/400 and Inter 300 (the light weights the new design uses).

## Files to upload (paths under `wp-content/themes/walid-child/`)
```
style.css                          # version 0.4.0 (cache-bust)
functions.php                      # enqueue home.css/home.js on the front page, motion flag, font weights
front-page.php                     # new homepage template
template-parts/home-map.php        # NEW folder: branch map partial
assets/css/home.css                # NEW
assets/js/home.js                  # NEW
assets/img/home/clinic.webp        # NEW folder: hero still (placeholder until real photography)
assets/css/motion.css              # NEW (inner pages)
assets/js/motion.js                # NEW (inner pages)
assets/css/enhance.css             # comment only
```
Already part of the 0.3.2 batch and reused here: `assets/img/cards/{skin,aesthetics,antenatal,injection,others}.webp`.
`assets/css/homepage.css` is no longer loaded; leave it on the server or delete it.

## After upload
1. Purge any host or plugin cache, then hard-refresh (Cmd/Ctrl + Shift + R).
2. Check `/` on a phone-width window and desktop, and `/services/minor-surgery/` for the inner-page motion.

## Before launch (content, not code)
- **Reviews:** the marquee shows only reviews with `review_permission` set. Sample quotes appear only when
  `WP_DEBUG` is on, so production shows real permitted reviews or hides the row. Add permitted reviews.
- **Hero image:** swap `assets/img/home/clinic.webp` for real consented photography, or override with the
  `walid_home_hero_image` filter.
- **Specialist band:** appears automatically once the antenatal lead doctor has a real `doctor_photo` and
  `doctor_role` filled in. Nothing shows until then, by design.
- **Branch count** on the stats row is `10` (filter: `walid_branch_count`). Confirm all ten branches and names.
- **Aesthetics** tile copy is deliberately generic until the launch scope is confirmed.
