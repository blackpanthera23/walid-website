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
- 🔄 DEPLOY: host is **IONOS "Hosting for WordPress Grow"** (Managed WordPress), domain
  **poliklinikdrwalid.com** (replace-in-place). Step-by-step in `docs/DEPLOY-IONOS.md` (SFTP host
  access-5021078157.webspace-host.com, DB dbs15968559 MariaDB 10.11). OMP/owner runs it; back up +
  prefer staging first. Secrets stay in the IONOS panel, never in git.
- ⬜ THEN: owner content (10 branches, doctors, real photos) + official logo + Google key + launch.

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
