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
| 3. Visual direction (HTML/CSS prototype) | 🔄 Doing next |
| 4. Stand up WordPress (local/hosting) | ⬜ Not started |
| 5. Child theme + CPTs (code) | ⬜ Not started |
| 6. Homepage + templates | ⬜ Not started |
| 7. Content, SEO, launch | ⬜ Not started |

**Last updated:** 2026-10-29 · homepage wireframe approved; building the rendered prototype next.

---

## 🧭 Core decisions (summary)

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
