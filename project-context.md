# Poliklinik Walid Website — Project Context & Handoff

> **Purpose:** single-file context so any agent or tool (Kiro IDE, Kiro Web, OMP, Claude) can
> pick up this project without the chat history. Committed to git on purpose. Keep it current.
>
> **Reading order:** `docs/00-project-brief.md` → this file → `.kiro/steering/project-context.md`
> → the specific `/docs` file for your task.

---

## 1. Goal

Build a **corporate healthcare-group website** for **Poliklinik Walid** (Walid Healthcare Group
Sdn. Bhd., reg **1466692-A**) to replace the placeholder at `poliklinikdrwalid.com`.

Positioning: **smart-value / premium-accessible**. Surgeon-led **day-care minor surgery** is the
hero offering; **aesthetics** and **antenatal/women's health** are rising pillars; general
practice runs across a 10-branch network. The site leads with earned social proof and converts
to a single WhatsApp tap.

## 2. Stack & tooling

| Layer | Choice |
|---|---|
| CMS | WordPress (self-hosted) |
| Parent theme | **Astra** (free) |
| Editor | Native **Gutenberg** + core blocks + Spectra (only where core is insufficient) |
| Custom code | **Child theme** (CPT registration, custom CSS, page templates) |
| Custom fields | **ACF** (Advanced Custom Fields) |
| Page builder | **None** (no Elementor/Divi) |
| Fonts | Fraunces (serif headings) + Inter (body), system fallbacks |
| Prototype | Plain HTML/CSS in `/prototype` (the visual + build spec) |
| Repo / CI | GitHub `blackpanthera23/walid-website` |

## 3. Key decisions (the "why")

- **Corporate, not anxious-clinic.** Lead with scale + proof; it is a group with reach.
- **Hero + rising pillars.** Minor surgery earned the audience (561K TikTok, 1,098 reviews), so
  it leads; aesthetics/antenatal ride its credibility rather than being equal columns.
- **Two-hub surgical model.** Minor surgery is concentrated: Central = Ampang; North = Jalan
  Baru (Seberang Perai), Tasek Gelugor, Sungai Petani. Others = general practice. This is more
  credible (centres of excellence) and avoids the trust break of implying every branch operates.
- **Expertise-first specialists.** Headline the need (service), then introduce the named doctor
  (e.g. Dr Anis → antenatal) as the proof. Figure-first only for personally-famous doctors.
- **WhatsApp-only.** Matches the Malaysian market and the existing 4.9/1,098-review funnel.
- **English-only at launch, i18n-ready.** Architect for MS/AR later; translate nothing now.
- **Navy brand** (`#232B8F`) from the real logo + gold accent; green for CTAs.
- **Copy rules:** no em-dashes; no "not a..., not a...".
- **Removed:** care-path, emergency bar, 3-step, pervasive disclaimers (compliance → footer + 1 page).

## 4. Current progress

| Phase | Status | Notes |
|---|---|---|
| 1. Strategy docs | ✅ | `docs/00`–`docs/11` |
| 2. Homepage wireframe + copy | ✅ | `docs/12`, approved by owner |
| 3. Rendered prototype | ✅ | `/prototype/index.html` + `styles.css`, navy, branded logo |
| 4. Stand up WordPress | ✅ | Docker (`docker-compose.yml`); Astra + ACF + Rank Math; verified |
| 5. Child theme + CPTs | ✅ | theme + navy palette; `walid-cpts` + ACF fields (acf-json/) |
| 6. Templates | ✅ | `front-page.php` + Branch/Service/Doctor singles; WA + footer |
| 7. Port theme Kadence→Astra | ✅ | 31 Oct 2026: matches the host; zero Kadence APIs used |
| 8. Deployed LIVE | ✅ | poliklinikdrwalid.com (IONOS); walid-child + walid-cpts active, ACF synced |
| 9. Live config | 🔄 | run `bin/finish-setup.php` (pages/menu/permalinks) |
| 10. Real content + launch | ⬜ | owner: `docs/CONTENT-CHECKLIST.md` + logo + Google key |

**Local dev:** WordPress runs via Docker — see `docs/DEV.md`. The spec at
`.kiro/specs/wordpress-build/` (requirements → design → tasks) drove the build; all 10 tasks done
and verified. Remaining before launch is owner-supplied content, not code (see §7 open items).

## 5. Repository map

```
walid-website/
├── README.md                     living status tracker
├── project-context.md            THIS FILE (handoff)
├── .kiro/steering/project-context.md   auto-loaded steering (Kiro)
├── docs/                         00 brief → 12 homepage wireframe (strategy source of truth)
└── prototype/                    rendered homepage (HTML/CSS) + assets/logo.svg
```
Full `/docs` index is in `README.md`.

## 6. What's next (for the agent picking this up)

**Phase 4 — stand up WordPress.** Recommended path:
1. Local dev first (LocalWP or Docker) to iterate safely before touching the live host.
2. Install **Astra** parent theme + **ACF**.
3. Create a **child theme** (`walid-child`). Map the navy palette into `theme.json` /
   Astra Global Palette using the values in `docs/07-design-system.md`.

> **Status (31 Oct 2026): phases 1–6 are done and phase 4/5 are live on IONOS.** This block is
> kept as the original plan of record. What remains is **deployment + owner content**, not code —
> see `HANDOFF-OMP.md` §1 and `docs/DEPLOY-IONOS.md`.
4. Register CPTs (Branch, Service, Doctor, Review) + ACF field groups per `docs/05-content-model.md`.
5. Rebuild the `/prototype` homepage as Gutenberg patterns; wire pillars/branches/specialist/
   reviews to the CPTs.

The HTML/CSS in `/prototype` is the authoritative visual spec. Reuse its CSS variables.

## 7. Open confirmations (owner / consultant to resolve)

- Official **logo file** (PNG/SVG) + exact brand hex (prototype uses a faithful navy recreation).
- **Dr Anis** exact credential/title.
- The **4th pillar** (placeholder reserved everywhere).
- **Aesthetics** launch scope (detail now vs brand-now-detail-later).
- **Named-review permissions** + source URLs; permission to show 4.9/1,098.
- Full **10-branch dataset** (address, hours, phone, services, map) — see `docs/08-owner-decisions.md`.
- Confirm current **social follower counts** before publishing.

## 8. Conventions

- Decisions go into `/docs` (not just chat). Update this file + `README.md` on meaningful progress.
- Branch policy: work on the session branch if one is set; never commit straight to `main` unless
  that is the active branch. Open PRs into `main`.
- Every social icon must link (a prior build shipped empty hrefs — do not repeat).
