# Poliklinik Walid — Website

Corporate healthcare-group website for **Poliklinik Walid** (Walid Healthcare Group Sdn. Bhd.),
a Malaysian general-practice and minor-surgery group with a 10-branch network.

> **Direction:** Corporate, English-first, WhatsApp-only conversion, built on WordPress (Kadence
> + Gutenberg + a child theme). This repo is the **planning + code source of truth**; manual
> WordPress steps are applied on the owner's side (e.g. via OMP).

## Status
Phase 1 — **Strategy & planning** (this `/docs` set). Code (child theme, CPTs, templates) comes next.

## Documentation (`/docs`)

| File | Purpose |
|---|---|
| `00-project-brief.md` | **Single source of truth** — all locked decisions |
| `01-references.md` | Benchmark sites (Nuffield / London Clinic / Cleveland) + the design north-star |
| `02-customer-journey.md` | Emotional + behavioural journey (arrive → contact) |
| `03-patient-flow.md` | Behavioural flow map + WhatsApp routing |
| `04-sitemap.md` | Corporate page hierarchy |
| `05-content-model.md` | WordPress CMS structure (custom post types + fields) |
| `06-source-facts.md` | Verified facts, ops data, branch truth |
| `07-design-system.md` | Palette (elevated from the real teal logo), type, tokens |
| `08-owner-decisions.md` | Client confirmation checklist |

## Core decisions (summary)
- **Tone:** corporate healthcare group — scale/network first, not anxious-clinic.
- **Hero:** network/reach **+ specialist minor-surgery hub** (surgery concentrated at Ampang + 2 support branches).
- **Language:** English-only at launch; architected for multilingual (MS/AR) later.
- **Conversion:** WhatsApp only (general + minor-surgery lines). No forms/booking.
- **Removed:** care-path motif, emergency bar, 3-step section, pervasive disclaimers.
- **Build:** Kadence + Gutenberg + child theme + ACF. No page builder.

## Build approach (Option C — hybrid)
Lightweight theme (Kadence) + native block editor for pages + a **child theme** for the custom
parts (CPTs: Branch / Service / Doctor / Review; custom CSS; page templates). Clinic staff
maintain content via CMS forms; developer code lives here and is applied on the WordPress side.

## Next steps
1. ✅ Strategy docs (this set)
2. Homepage wireframe + hero/story copy
3. Visual direction (palette → Kadence)
4. Stand up WordPress (local or hosting)
5. Child theme + CPTs (code in this repo)
6. Homepage + templates
7. Content, SEO, launch
