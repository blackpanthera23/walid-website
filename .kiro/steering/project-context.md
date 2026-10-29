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
- **Build stack:** WordPress + **Kadence** parent theme + **Gutenberg** blocks + a **child theme**
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
- ✅ Phase 1–2: strategy docs `docs/00`–`docs/12` + homepage wireframe (approved).
- ✅ Phase 3: rendered HTML/CSS homepage prototype in `/prototype` (navy, Fraunces+Inter).
- ✅ Phase 4: WordPress stood up locally via Docker (`docker-compose.yml`, `bin/provision.sh`,
  `docs/DEV.md`). Kadence + ACF + Rank Math installed; `walid-child` active. Verified booting.
- ✅ Phase 5: `walid-child` + navy `theme.json` + Kadence palette (navy/green/gold). CPT plugin
  `walid-cpts` (Branch/Service/Doctor/Review) + Region/Pillar taxonomies + ACF local-JSON fields.
- ✅ Phase 6: `front-page.php` (all 11 homepage sections, CPT-driven with draft fallback) +
  `single-branch/service/doctor.php`. Floating WhatsApp (context-routed) + brand footer.
- ✅ Phase 7 (code): SEO/schema (MedicalClinic per branch, Org aggregateRating), a11y (skip link,
  focus, one h1, alt text), perf (non-render-blocking fonts). PLUS full site: Service/Branch/
  Doctor archives + singulars, About/Governance, International Patients, Contact pages, primary
  nav, data-driven proof wall, block patterns, sample seeder (`bin/`), deploy guide (`docs/DEPLOY.md`).
- 🔄 Remaining (owner, not code): 10 branch records, doctor bios/photos, review permissions,
  official logo, Dr Anis credential, 4th pillar, real proof-wall video URLs, then launch to a host.

## Build workflow (Kiro IDE)
- Local WP runs via Docker (`docs/DEV.md`). Spec drives the build:
  `.kiro/specs/wordpress-build/` (requirements → design → tasks). ALL 10 tasks done + verified.
- `.kiro/steering/build-conventions.md` loads when editing code (PHP/CSS/JSON).
- To see it: `docker compose up -d` then open http://localhost:8080.

## Ground truth / gotchas
- The `/prototype` is the visual + build SPEC. CSS variables map 1:1 to the Kadence Global Palette.
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
