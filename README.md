# Poliklinik Walid — Website

Corporate healthcare-group website for **Poliklinik Walid** (Walid Healthcare Group Sdn. Bhd.,
1466692-A), a Malaysian specialist group: surgeon-led day-care **minor surgery**, with rising
pillars in **aesthetics** and **antenatal/women's health**, plus general practice across a
10-branch network.

> **Direction:** Corporate, English-first, WhatsApp-only conversion, built on WordPress (Kadence
> + Gutenberg + a child theme). This repo is the **planning + code source of truth**; manual
> WordPress steps are applied on the owner's side (e.g. via OMP).

---

## 📍 Project status

| Phase | Status |
|---|---|
| 1. Strategy & planning docs | ✅ Done |
| 2. Homepage wireframe + copy | ✅ Done (approved) |
| 3. Visual direction (HTML/CSS prototype) | ✅ Done (`/prototype`) |
| 4. Stand up WordPress (local, Docker) | ✅ Done (verified booting) |
| 5. Child theme + CPTs (code) | ✅ Done (theme, navy tokens, CPTs, ACF fields) |
| 6. Homepage + templates | ✅ Done (front-page + Branch/Service/Doctor singles) |
| 7. Content, SEO, launch | 🔄 Code done (schema/a11y/perf); awaiting owner content |

**Last updated:** 2026-10-29 · full WordPress build complete locally via the
`.kiro/specs/wordpress-build` spec (all 10 tasks). Theme `walid-child` renders the navy homepage
+ CPT-driven Branch/Service/Doctor pages, WhatsApp routing, real social footer, MedicalClinic/Org
schema, and an accessibility pass. Remaining work is owner-supplied content (see open items).

### Run it locally
See `docs/DEV.md`. In short: `docker compose up -d` then
`docker compose run --rm wpcli bash /scripts/provision.sh`; site at `http://localhost:8080`.

### Preview with sample content (local only)
`docker compose run --rm wpcli wp eval-file /scripts/seed-sample-content.php` seeds placeholder
branches/doctor/services/review so the homepage renders fully populated. Remove with the same
command plus `-- --purge`. Never seed on production.

### Deploying to a host
See `docs/DEPLOY.md` (fresh-install path recommended; DB-migration path documented too).

### View the prototype
`/prototype/index.html` is a self-contained homepage (open in any browser).
To publish it as a live link: repo **Settings → Pages → Source: Deploy from branch → `main` / root**,
then open `https://blackpanthera23.github.io/walid-website/prototype/`.

---

## 🧭 Core decisions (summary)

- **Brand color:** deep royal **navy** `#232B8F` (from the real logo), gold accent, green for CTAs.
- **Fonts:** Fraunces (serif headings) + Inter (body).
- **Positioning:** smart-value / premium-accessible. Surgeon-led day-care surgery. Hospital-grade
  care at clinic speed and price. "The smart choice."
- **Pillars:** hero = **Minor Surgery**; rising = **Aesthetics**, **Antenatal (Dr Anis)**,
  **[Pillar 4 TBD]**; base = general practice.
- **Minor-surgery geography (two hubs):** Central = Ampang · North = Jalan Baru (Seberang Perai),
  Tasek Gelugor, Sungai Petani. Other branches = general practice.
- **Proof (lead differentiator):** TikTok 561K · Facebook 119K · Instagram 30.8K · Google 4.9
  (1,098 reviews).
- **Language:** English-only at launch; architected for multilingual (MS/AR) later.
- **Conversion:** WhatsApp only (general + minor-surgery lines). No forms/booking.
- **Removed:** care-path motif, emergency bar, 3-step section, pervasive disclaimers.
- **Copy rules:** no em-dashes; avoid "not a..., not a..." construction.
- **Build:** Kadence + Gutenberg + child theme + ACF. No page builder.

---

## 📚 Documentation (`/docs`)

| File | Purpose |
|---|---|
| `00-project-brief.md` | **Single source of truth** — all locked decisions |
| `01-references.md` | Benchmark sites (Nuffield / London Clinic / Cleveland) + north-star |
| `02-customer-journey.md` | Cross-touchpoint journey (TikTok→review→web→WhatsApp→clinic) + on-site arc |
| `03-patient-flow.md` | Behavioural flow map + WhatsApp routing |
| `04-sitemap.md` | Corporate page hierarchy (+ International Patients page) |
| `05-content-model.md` | WordPress CMS structure (CPTs + fields) |
| `06-source-facts.md` | Verified facts, ops data, two-hub branch truth |
| `07-design-system.md` | Palette (elevated from the teal logo), type, tokens |
| `08-owner-decisions.md` | Client confirmation checklist |
| `09-value-proposition.md` | The "why Walid" layer: positioning, distinction, value language, medical tourism |
| `10-proof-and-content.md` | How TikTok/FB/IG/Google proof powers the site |
| `11-pillars-and-specialists.md` | Hero + rising pillars, two-hub geography, specialist display pattern |
| `12-homepage-wireframe.md` | Section-by-section homepage blueprint + draft copy |

---

## 🤝 Context for other agents / tools (read these first)

| File | For |
|---|---|
| `project-context.md` | Full handoff: goal, stack, decisions, progress. Any agent/tool. |
| `.kiro/steering/project-context.md` | Auto-loads in every Kiro session (IDE + Web). |
| `HANDOFF-OMP.md` | Step-by-step WordPress build task list for OMP. |

> **Switching to Kiro IDE for the build phase is recommended** (real editor, terminal, run
> WordPress locally). The steering file loads automatically when the repo opens, so no context
> is lost in the switch.

## 🛠 Build approach (Option C — hybrid)

Lightweight theme (Kadence) + native block editor for pages + a **child theme** for the custom
parts (CPTs: Branch / Service / Doctor / Review; custom CSS; page templates). Clinic staff
maintain content via CMS forms; developer code lives here and is applied on the WordPress side.

---

## ⏭️ Next step

Build a **rendered HTML/CSS homepage prototype** from `12-homepage-wireframe.md`, using the
elevated teal design tokens (CSS variables → Kadence). It doubles as the WordPress build spec.

## 🔖 Open items

- Repo visibility: set to **private** if desired (owner action).
- Supply **official logo files + exact brand hex** to lock the palette precisely.
- Confirm: Dr Anis credential · 4th pillar · aesthetics launch scope · named-review permissions.
