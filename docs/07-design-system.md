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

## 2. Color palette (anchored on the real navy logo)

### Brand anchor
The real Poliklinik Walid logo is a **deep royal / navy blue** circular emblem with white
Arabic calligraphy. Navy is an excellent corporate-trust anchor (institutional, premium,
trustworthy), and the Arabic calligraphy is a brand asset that ties naturally to the
international / medical-tourism audience (Sudan, Gulf). We build the palette on navy, with a
restrained **gold** accent for premium heritage warmth and a distinct **green** for actions.

| Role | Token | Hex | Use |
|---|---|---|---|
| **Primary / Brand navy** | `--brand-700` | `#232B8F` | Headings, primary surfaces, logo lockup |
| Primary deep | `--brand-900` | `#161B5E` | Dark sections, footer, high-contrast headings |
| Primary mid | `--brand-500` | `#3A43B0` | Links, hover, secondary brand surfaces |
| Soft brand surface | `--brand-050` | `#EEF0FB` | Section backgrounds, cards |
| **Gold accent** | `--gold-500` | `#C9A227` | Premium accent, selected/highlight, dividers (sparingly) |
| Gold soft | `--gold-100` | `#F6EFD6` | Subtle accent surfaces |
| **Action green** | `--accent-600` | `#1E8E66` | Primary CTAs, confirmed/positive states |
| Action green hover | `--accent-700` | `#176F50` | CTA hover/active |
| **WhatsApp green** | `--wa` | `#25D366` | WhatsApp button only (platform-recognisable) |

### Neutrals (clean, flatter navy)
| Role | Token | Hex |
|---|---|---|
| Canvas (off-white) | `--bg` | `#F8F9FC` |
| White (surfaces) | `--surface` | `#FFFFFF` |
| Ink (body) | `--ink` | `#1A1D2E` |
| Muted (secondary) | `--muted` | `#5B607A` |
| Rule (borders) | `--rule` | `#DDE0EC` |

**Discipline:** navy leads; gold is a *restrained* premium accent; green means "do this";
WhatsApp green is reserved exclusively for the WhatsApp action. Max 3 brand colors + neutrals active.

### Why these choices
- **Navy `#232B8F` (elevated from the logo):** institutional trust + premium. The strongest
  possible corporate anchor, and faithful to the real brand.
- **Gold accent:** classic navy pairing; adds premium heritage warmth that echoes the logo's
  Arabic calligraphy and flatters the international audience. Used sparingly, never as alarm.
- **Distinct action green:** separates "brand navy" from "do this" so CTAs pop against navy.
- **Clean cool-neutral whites:** flatter navy (warm whites muddy it); still soft, not clinical.

### Logo usage
- The emblem is a circular monogram with no Latin wordmark. Pair it with a typeset
  "Poliklinik Walid" wordmark (Fraunces) in the header for legibility across audiences.
- Keep clear space around the emblem; place on white or `--brand-050`, never on busy photos.
- The Arabic calligraphy is a brand asset; treat the international/heritage feel as intentional.

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

## 6. WordPress / Astra fit
- Map every token above into **Astra Global Palette** + `theme.json` (CSS variables map 1:1).
- Sections become **Gutenberg patterns**; no page-builder runtime dependency.
- Vanilla CSS variables in the child theme so the palette is swappable in one place.

### Astra global palette mapping (navy-anchored)
```
Palette 1  Brand navy      #232B8F
Palette 2  Action green    #1E8E66
Palette 3  Gold accent     #C9A227
Palette 4  Ink             #1A1D2E
Palette 5  Muted           #5B607A
Palette 6  Rule            #DDE0EC
Palette 7  Soft surface    #EEF0FB
Palette 8  Canvas off-white #F8F9FC
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
