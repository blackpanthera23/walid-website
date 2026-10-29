# Poliklinik Walid — Design System (starting point)

> **Anchored on the real Poliklinik Walid brand (teal/green logo), then elevated** for a
> corporate healthcare-group look. English-first. See `00-project-brief.md` for locked rules.
> This is a *starting point* to refine, not a final brand guide.

---

## 1. Principle

Start from what patients already recognise — the clinic's **teal/green** brand — and make it
look like an established **healthcare group**, not a single clinic. The move is: keep the
familiar hue, raise the craft (deeper, more confident primary; warmer neutrals; disciplined
accent; generous space). Calm, premium, trustworthy — "corporate healthcare," not "hospital
template."

---

## 2. Color palette (elevated from the logo)

### Brand anchor
The Poliklinik Walid logo reads as a **teal-green**. Prior builds used `#0F5B5C` (ops) and
`#103F46` (live). We unify and elevate to a single confident primary + a supporting scale.

| Role | Token | Hex | Use |
|---|---|---|---|
| **Primary / Brand teal** | `--brand-700` | `#0E4F4C` | Headings, primary surfaces, logo lockup |
| Primary deep | `--brand-800` | `#0A3B39` | Dark sections, footer, high-contrast headings |
| Primary mid | `--brand-600` | `#15726C` | Links, secondary brand surfaces |
| **Action green** | `--accent-600` | `#1E8E66` | Primary CTAs, confirmed/positive states |
| Action green hover | `--accent-700` | `#176F50` | CTA hover/active |
| **WhatsApp green** | `--wa` | `#25D366` | WhatsApp button only (platform-recognisable) |
| **Warm accent (clay)** | `--clay-500` | `#C2674B` | Sparingly — selected/highlight, never alarms |
| Soft brand surface | `--brand-050` | `#E9F1EF` | Section backgrounds, cards |

### Neutrals (warm, not clinical-cold)
| Role | Token | Hex |
|---|---|---|
| Warm white (canvas) | `--bg` | `#F7F6F2` |
| White (surfaces) | `--surface` | `#FFFFFF` |
| Ink (body) | `--ink` | `#17201F` |
| Muted (secondary) | `--muted` | `#5A6763` |
| Rule (borders) | `--rule` | `#D5DED9` |

**Discipline:** max **3 brand colors + neutrals** active at once. WhatsApp green is reserved
exclusively for the WhatsApp action so it reads as "the familiar button," not decoration.

### Why these choices
- **Deeper, unified teal (`#0E4F4C`):** more premium/corporate than the brighter logo teal,
  still unmistakably the same brand.
- **Distinct action green:** separates "brand" from "do this" — cleaner conversion.
- **Warm neutrals:** avoid the cold, sterile hospital-portal feel; signal "trusted, human group."
- **Clay used sparingly:** one warm human accent; never for warnings (no alarm tone — per brief).

---

## 3. Typography

| Role | Stack | Notes |
|---|---|---|
| **Headings** | `"Fraunces", Georgia, "Times New Roman", serif` | A refined serif = authority + warmth, more premium than default serif. Fallback to system serif keeps it WordPress-safe. |
| **Body / UI** | `"Inter", system-ui, Arial, sans-serif` | Highly legible on low-end mobile; corporate-clean. |
| Small labels | `ui-monospace, "SF Mono", monospace` | Sparingly, for small meta labels only. |

- Base body: **16px minimum** (accessibility + mobile).
- Headline scale: generous, confident (corporate sites breathe — don't crowd).
- Buttons/form controls: **44px minimum** touch target.
- Optional web fonts (Fraunces/Inter) are self-hosted or via a performant provider; **always
  ship a system fallback** so there's no render-blocking dependency.

---

## 4. Composition & tone
- **Mobile-first.** Most traffic is mobile.
- **Generous whitespace** — the single biggest lever for a "corporate/premium" feel.
- **Real photography** (clinic exteriors, teams, facilities) over abstract graphics — *when the
  client supplies consented photos.* Until then, use restrained brand-colored compositions, not
  fake stock doctors or AI people.
- Hero: confident **network/reach** proposition + one calm CTA (not a full-bleed image wall).
- Fact rail (10 branches · doctors · panels) as **restrained stats**, not giant monument numbers.
- **No** emergency bar, care-path motif, or 3-step section (per brief).

---

## 5. Motion
Minimal. Hover / focus / menu / accordion states only. No scroll animations, parallax, autoplay,
or counters. Respect `prefers-reduced-motion`.

---

## 6. WordPress / Kadence fit
- Map every token above into **Kadence Global Palette** + `theme.json` (CSS variables map 1:1).
- Sections become **Gutenberg patterns**; no page-builder runtime dependency.
- Vanilla CSS variables in the child theme so the palette is swappable in one place.

### Kadence Global Palette mapping (starting values)
```
Palette 1  Brand teal      #0E4F4C
Palette 2  Action green    #1E8E66
Palette 3  Clay accent     #C2674B
Palette 4  Ink             #17201F
Palette 5  Muted           #5A6763
Palette 6  Rule            #D5DED9
Palette 7  Soft surface    #E9F1EF
Palette 8  Warm white      #F7F6F2
Palette 9  White           #FFFFFF
```

---

## 7. Accessibility
- All text/background pairings must pass **WCAG AA** (4.5:1 body, 3:1 large text). Teal `#0E4F4C`
  on warm white and white on teal both pass; verify any clay pairing before use.
- Visible focus states. Keyboard-navigable menus/accordions. Alt text on all imagery.

---

## 8. Open questions
1. Do you have the **official logo files + exact brand hex**? If so, I'll re-anchor the palette
   to the exact values (this doc is an elevated estimate from the live site + logo).
2. OK to use web fonts (Fraunces/Inter), or keep strictly to system fonts for max performance?
3. Any existing brand assets (letterhead, flyers, uniform colors) I should match?
