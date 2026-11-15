---
inclusion: always
---

# Poliklinik Walid Website — Project Context (steering)

> This steering file auto-loads every session in Kiro (IDE or Web). It is the shared brain for
> ALL agents (Kiro IDE, Kiro Web, OMP). Read it first. Full detail lives in `/docs` and
> `project-context.md`. If anything here conflicts with `docs/00-project-brief.md`, the brief wins.

## What we're building
A **corporate healthcare-group website** for **Poliklinik Walid** (Walid Healthcare Group Sdn.
Bhd., reg **1466692-A**): surgeon-led day-care **minor surgery** (hero), with rising pillars in
**aesthetics** and **antenatal/women's health** (specialist Dr Anis), plus general practice
across a 10-branch network. Replaces the placeholder at `poliklinikdrwalid.com`.

## Non-negotiable decisions
- **Tone:** corporate, premium-accessible, smart-value. Scale/proof first, not anxious-clinic.
- **Language:** English-only at launch; architected for multilingual (MS/AR) later. Do NOT add
  translation plugins now, but keep strings translatable + field-based content.
- **Conversion:** WhatsApp ONLY (general 014-252 1684 · minor-surgery 017-549 7593). No forms/booking.
- **Brand color:** deep royal **navy `#232B8F`** (from the real logo) + **gold `#C9A227`** accent
  + **green `#1E8E66`** for CTAs + WhatsApp green `#25D366`. Fonts: **Fraunces** (headings) + **Inter** (body).
- **Copy rules:** NO em-dashes. Avoid the "not a..., not a..." construction.
- **REMOVED (do not reintroduce):** care-path motif, emergency bar, 3-step process, pervasive
  medical disclaimers. Compliance lives in the footer + one "About/Governance" page only.
- **Build stack:** WordPress + **Astra** parent theme + **Gutenberg** blocks + a **child theme**
  (custom CPTs/CSS/templates) + **ACF**. NO page builder (Elementor/Divi).

## Content model (CPTs — see docs/05)
- **Branch** (×10): region = Central (Klang Valley) / North (Penang-Kedah) / Other;
  "provides minor surgery" toggle. Minor surgery hubs: Ampang (Central); Jalan Baru/Seberang
  Perai, Tasek Gelugor, Sungai Petani (North). Others = general practice.
- **Service**: pillar (Minor Surgery=hero / Aesthetics / Antenatal / Pillar-4-TBD / General) +
  pillar-weight + lead-specialist relationship.
- **Doctor**: lead-specialist-for relationship (Dr Anis → Antenatal). Display pattern =
  EXPERTISE FIRST, figure as proof.
- **Review**: curated Google reviews (stat + quotes). Needs permission before publishing.

## Proof assets (lead differentiator — owner-confirmed, verify counts before publishing)
TikTok 561K · Facebook 119K · Instagram 30.8K · Google 4.9 from 1,098 reviews.

## Where we are (update this as work progresses)
- ✅ Strategy docs `docs/00`–`docs/12` + homepage wireframe (approved).
- ✅ Prototypes: `/prototype` (Concept A) + `/prototype-v2` (Concept B, calm/airy).
- ✅ WordPress build COMPLETE + verified locally via Docker (`docs/DEV.md`). `walid-child` theme +
  navy `theme.json`/Astra palette; CPT plugin `walid-cpts` (Branch/Service/Doctor/Review) +
  Region/Pillar taxonomies + ACF local-JSON; `front-page.php` (all homepage sections, CPT-driven
  with draft fallback) + `single-branch/service/doctor.php` + archives; About/Governance,
  International Patients, Contact pages; primary nav; context-routed WhatsApp + brand footer;
  premium services list; per-branch reviews; Google Places integration (awaits key); SEO/schema
  (MedicalClinic per branch, Org aggregateRating); a11y + perf pass; motion; placeholders; block
  patterns; sample seeder (`bin/`); deploy guide (`docs/DEPLOY.md`). Runs at `http://localhost:8080`.
- ✅ Concept AB "Prototype 3" built at `/prototype-v3/` (per `docs/13`): Concept B's calm/airy look
  + Concept A's substance; premium footer (CTA band, social buttons with counts, two-column bottom).
- ✅ **DECISION (owner): Concept AB is the chosen direction for the WHOLE website.** Not just the
  homepage — align all pages (archives, singles, About/Contact/International) to the AB aesthetic:
  airy whitespace, organic rounded panels + floating accent dots, smooth rounded cards, calmer
  motion, navy+gold. Reuse `/prototype-v3` as the visual reference.
- ✅ AB PORTED LIVE: `homepage.css` rewritten to the AB/Prototype 3 look (organic hero panel +
  floating dots, airy whitespace, smooth cards); `front-page.php` hero wrapped in the panel.
  Archive cards adopted the premium card craft (light + a dark navy FEATURED variant for the
  hero service), inspired by the "Deep Blue Nights" card MINUS e-commerce (no cart/price/scarcity).
  Service single has a styled procedures grid + animated donut stat charts.
- ✅ Inner single/page templates aligned to AB (airy spacing, organic photo panels).
- ✅ Per-treatment **Procedure** pages (CPT + single-procedure.php, AB look); Xanthelasma seeded.
  Service `/services/` list shows `Name | explainer` one-liners. Service single has procedures
  grid + donut stat charts.
- ✅ DEPLOYED LIVE on **poliklinikdrwalid.com** (IONOS Managed WP). Parent theme switched
  **Kadence → Astra** (host has Astra; we use zero Kadence APIs, so the look is unchanged; all
  design lives in the child theme). walid-child + walid-cpts active; ACF + 5 field groups synced.
- ✅ CONCEPT 4 PORTED TO WORDPRESS (2 Nov, theme 0.4.0, local only, NOT deployed): `front-page.php` now renders the
  Concept 4 homepage using `assets/css/home.css` (all classes `wh-` prefixed) + `assets/js/home.js` +
  `template-parts/home-map.php`. Data-driven: `walid_stats()`, branches by region, permitted reviews (sample quotes
  only under WP_DEBUG), WhatsApp routing; specialist band renders only with a real doctor photo. Old `homepage.css`
  and the site-wide `motion.css/js` are NOT loaded on the front page. Deploy list: `docs/DEPLOY-BATCH-HOME-V4.md`.
- Earlier prototype note: Concept 4 "editorial" prototype at `/prototype-v4/` (served on :8090, homepage only). Different layout language from AB: arch hero frame, light Fraunces headlines, "who we are" + counters,
  "The Walid standard" (4 commitments, deliberately NOT numbered steps), icon tile services grid (pillar accents,
  WhatsApp stays green), CTA banner, reviews marquee, real-geometry branch map (Natural Earth 50m, public domain),
  dark footer. Full motion set, reduced-motion safe. Uses sample review quotes (flagged "Sample") and the neutral
  waiting-room still; hero VIDEO stays off per the settled decision. Awaiting owner pick before any port to WP.
- ✅ MOTION SYSTEM (2 Nov): `assets/css/motion.css` + `assets/js/motion.js` (+ `walid_motion_flag()` head
  script in functions.php). CSS/JS only, no libraries, no AI media. Word-by-word hero headline and
  sequenced hero text (home, service, procedure), scroll reveals for headings/CTAs, true card stagger,
  procedure step connectors that draw, scroll progress bar, header depth, button sweep, FAQ smooth open,
  WhatsApp FAB entrance, subtle scroll-driven parallax, page crossfade (progressive). Fully gated by
  `prefers-reduced-motion`; auto-falls back to visible content if JS fails. Verified in headless Chrome
  (home, service, procedure, reduced-motion, scroll-to-bottom). Not yet checked on real touch devices or Safari.
- ✅ Robustness: ACF safety shim (no white screen if ACF off); proof stats centralized in
  `walid_stats()` (helpers.php) and marked owner-confirmed in docs/08.
- ✅ LIVE CONFIG DONE (31 Oct, OMP via wp-admin UI since no SSH): About + International Patients
  pages created with templates, Contact template set, Primary 7-item menu assigned (Astra uses
  `primary`/`mobile_menu`, NOT `menu-1`), rewrites flushed. `/about/` + `/international-patients/`
  verified 200. Extendify plugin deactivated (it auto-opened a modal that blocked the page editor).
  Note: `wp eval-file finish-setup.php` is NOT runnable on this host (no SSH) — use wp-admin UI;
  the script now uses correct Astra menu keys for any future host.
- ⬜ THEN: real content via `docs/CONTENT-CHECKLIST.md` + official logo + Google key + launch.
  Still live but UNVERIFIED-flagged: 561K/119K/4.9-1,098 stats (owner-confirmed per docs/08) and
  `[confirm ...]` placeholder lines on About/International (owner to replace with real copy).
  Rollback: Astra is intact (Appearance → Themes → Astra). Updating guide: `docs/UPDATING.md`.

- ✅ WHATSAPP CLICK TRACKING (10 Nov, local only, NOT deployed): `inc/wa-tracking.php` + `assets/js/wa-track.js`.
  First-party counters (line, placement, page path), no cookies/PII; report at wp-admin Tools > WhatsApp clicks;
  also fires `walid_wa_click` to dataLayer/gtag if present. Deploy: add those 2 files + functions.php require.
- ✅ CREDIT LEDGER: log every paid-gen spend (Higgsfield/Magnific) in `docs/CREDIT-LEDGER.csv`. Never put patient
  data (Remedi exports) in prompts, mem0, the repo or the site; only aggregate stats are public.

- ✅ THEME 0.4.6 DEPLOYED LIVE (16 Nov, verified). Full handoff: `HANDOFF.md` at the repo root. Deploy = theme-zip upload
  in wp-admin (HANDOFF.md section 9). Live content is still EMPTY (0 branches/services/doctors/reviews). Local 8080 now runs on ASTRA like live (Kadence inactive); `inc/parent-compat.php`
  forces the brand palette, a solid header and Astra's full-width layout over parent DB settings. Includes everything above plus
  International section on the homepage (32-country flag strip, self-hosted flags in `assets/img/flags/`), owner-supplied
  stock photos in `assets/img/photos/` (home hero, "Talk to us" banner, International section + page, Minor Surgery hero;
  all labelled "illustrative image"), service/branch heroes no longer show the placeholder SVG label, inner-page h1-h3
  navy and small gold text darkened for WCAG contrast, parent footer credit removed, "See it explained" YouTube strip.
  One supplied photo was NOT used: it is tagged AI-generated (IPTC trainedAlgorithmicMedia), which breaks the
  no-fake-clinic-imagery rule.

## Build workflow (Kiro IDE)
- Local WP runs via Docker (`docs/DEV.md`). Spec drives the build:
  `.kiro/specs/wordpress-build/` (requirements → design → tasks). ALL 10 tasks done + verified.
- `.kiro/steering/build-conventions.md` loads when editing code (PHP/CSS/JSON).
- To see it: `docker compose up -d` then open http://localhost:8080.

## Ground truth / gotchas
- The `/prototype` is the visual + build SPEC. CSS variables map 1:1 to the Astra Global Palette.
- Logo: `/prototype/assets/logo.svg` is a faithful recreation. Swap for the official file when supplied.
- A prior build left EMPTY social `href`s — every social icon MUST link. Don't repeat.
- Reg number confirmed **1466692-A** (ops repo wrongly had 1476692-A).
- Open confirmations (owner): Dr Anis exact credential · the 4th pillar · aesthetics launch scope ·
  named-review permissions · official logo file + exact hex · all 10 branch details.

## For any agent picking this up
1. Read `docs/00-project-brief.md`, then this file, then `project-context.md`.
2. Keep the repo as the source of truth — write decisions into `/docs`, not just chat.
3. Update the "Where we are" section above and `README.md` status table on meaningful progress.
4. Respect the copy rules and the removed-items list in every piece of content.
