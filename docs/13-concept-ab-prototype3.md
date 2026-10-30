# Concept AB — "Prototype 3" (homepage blend spec)

> **For the Kiro IDE agent.** Build a third homepage concept that blends Concept B's calm/airy
> aesthetic with Concept A's conversion strengths. English-first, navy brand, WhatsApp-only.
> Respects all locked decisions in `docs/00-project-brief.md` and `.kiro/steering`.
>
> **Scope:** build as a standalone static prototype at `/prototype-v3/` first (like the others,
> so it can be compared without touching the live theme). Do NOT change `front-page.php` yet.
> After owner sign-off on `/prototype-v3/`, a follow-up task ports it into the live theme.

---

## 1. The intent

Concept B looks better (premium-accessible reads as calm + spacious). Concept A converts better
(proof rail high up, two-hub clarity, strong CTAs). **Prototype 3 = B's look + A's substance.**

- Take from **B**: the soft/organic hero panel with floating gold+navy accent dots, generous
  whitespace, thin-underline service row, the calmer rhythm and lighter composition.
- Keep from **A**: the proof rail (561K / 119K / 4.9·1,098) high in the hero, the value strip,
  the two-hub branch clarity, the specialist (Dr Anis) block, the reviews stat+quotes, the
  international strip, persistent WhatsApp.
- Do NOT reintroduce (locked-removed): teal palette, "care starts with assessment" tone, 3-step
  treatment process, emergency 999 bar, pervasive disclaimers, em-dashes, "not a..., not a...".

## 2. Brand + type (unchanged, reuse tokens)

Navy `#232B8F`, deep navy `#161B5E`, gold `#C9A227`, action green `#1E8E66`, WhatsApp `#25D366`,
canvas `#F8F9FC`. Fraunces (headings) + Inter (body). Reuse the CSS variables from
`prototype/styles.css` `:root` and the theme's `brand.css` so it maps 1:1 to Astra later.
Real logo: `prototype-v2/assets/logo.svg` (copy into `prototype-v3/assets/`).

## 3. Section stack (top to bottom)

```
0. HEADER (sticky)  logo + nav + WhatsApp (B's lighter header)
1. HERO (from B)    soft organic panel + floating gold/navy accent dots
                    LEFT: eyebrow, headline, subline, 2 CTAs
                    + PROOF RAIL inside/under the hero  ← bring from A
                    RIGHT: the organic panel (hero image placeholder sits inside it)
2. VALUE STRIP (from A)  Day-care · Hospital-grade · The smart choice (3 calm cards)
3. SERVICES ROW (from B) thin-underline row, but 4 pillars:
                    Minor Surgery (lead) · Aesthetics · Antenatal · General Medicine
                    Minor Surgery gets a subtle emphasis (gold underline / "specialty" tag)
4. SPECIALIST (from A)   Dr Anis, expertise-first (need -> specialist -> action)
5. PROOF WALL (from A)    TikTok/IG embeds, calmer spacing per B
6. BRANCH NETWORK (from A) two-hub: Central (Ampang) + North (3) + "GP across the network"
7. REVIEWS (from A)       4.9 / 1,098 stat + 3 curated quotes (permission-gated)
8. INTERNATIONAL (from A) flags + one calm line + placeholder photo
9. FINAL CTA              one confident line + WhatsApp
10. FOOTER                deep navy, working socials, MMC + PDPA + reg 1466692-A
+ floating WhatsApp button (persistent)
```

## 4. Section detail

### 1. Hero (the signature blend)
- Layout: two columns on desktop, stacked on mobile (hero panel first on mobile).
- LEFT column:
  - eyebrow: `Walid Healthcare Group`
  - headline (Fraunces, large): `Hospital-grade minor surgery, done in a day.`
  - subline: `Surgeon-led day-care care across our Central and Northern centres. The smart choice hundreds of thousands already trust.`
  - CTAs: `[WhatsApp us]` (green/WA) + `[Explore services]` (ghost navy)
  - **proof rail directly under the CTAs** (bring from A), stated as calm facts:
    `561K on TikTok · 119K on Facebook · 4.9 from 1,098 Google reviews`
- RIGHT column: **B's organic hero panel** — a large soft-rounded (asymmetric radius) navy
  gradient panel with 2 to 3 floating accent dots (one gold, one light-navy), a subtle shadow,
  and the hero image placeholder (`placeholder-hero.svg`) sitting inside it. This is the calm,
  premium signature of Concept B. No full-bleed photo wall.
- Plenty of whitespace around the hero (B's airiness). No emergency bar above it.

### 2. Value strip
Three calm cards (A's content, B's spacing): Day-care surgery / Hospital-grade care / The smart
choice, each one short line. Light surface, soft borders, generous padding.

### 3. Services row (B's thin-underline style, 4 pillars)
- A horizontal row of pillars separated by thin rules/underlines (B's look), NOT heavy icon cards.
- Four: **Minor Surgery** (lead, subtle gold underline + small "Our specialty" tag), Aesthetics,
  Antenatal & Women's Health, General Medicine.
- Each links to its `/services/#pillar` or service page. Keep it light and scannable.

### 4. Specialist (Dr Anis, expertise-first)
Headline the need, then the named specialist as proof, then WhatsApp. Photo = placeholder-doctor.
`Antenatal care, led by a dedicated specialist.` -> `Led by Dr Anis, [confirm credential].`

### 5. Proof wall
TikTok/IG facade embeds (reuse the existing lazy-facade from the theme). Calmer spacing than A.

### 6. Branch network (two-hub, keep A's clarity)
Two columns: CENTRAL (Ampang) and NORTH (Jalan Baru/Seberang Perai, Tasek Gelugor, Sungai
Petani), plus a line: "General practice across the full network." `[Find a branch]`.

### 7. Reviews
`4.9 / 1,098` stat headline + 3 curated quotes, each flagged `[permission pending]` until consent.

### 8. International
Flags 🇸🇩 🇸🇬 🇮🇩 🇧🇳 + one calm line + the international placeholder photo. Soft strip.

### 9–10. Final CTA + footer
Confident one-liner + WhatsApp. Deep-navy footer: working social links (no empty hrefs),
MMC-registered, PDPA 2010, Walid Healthcare Group Sdn. Bhd. (1466692-A).

## 5. Motion (reuse existing, keep subtle)
Reuse `reveal.js` scroll-reveal + the `enhance.css` hover micro-interactions. All gated by
`prefers-reduced-motion`. Keep it calmer than A (B is airy): gentle fade/rise, slightly longer
easing. No parallax, autoplay, or counters.

## 6. Acceptance criteria
- [ ] `/prototype-v3/index.html` + `styles.css` + `assets/logo.svg` committed; opens standalone.
- [ ] Hero uses B's organic panel + floating accent dots AND A's proof rail together.
- [ ] 4-pillar thin-underline services row, Minor Surgery visually led.
- [ ] Value strip, specialist, proof wall, two-hub branches, reviews, international, final CTA, footer all present.
- [ ] Navy + gold only (no teal). Fraunces + Inter. Floating WhatsApp persists.
- [ ] No emergency bar, no 3-step, no care-path tone, no em-dashes, no empty social hrefs.
- [ ] Responsive (desktop / tablet / mobile); hero panel stacks first on mobile.
- [ ] `prefers-reduced-motion` respected.
- [ ] Does NOT modify the live `front-page.php` (standalone prototype only).

## 7. Follow-up (after owner picks the winner)
Separate task: port the chosen concept into the live theme `front-page.php` + section CSS,
wiring the dynamic CPT content (pillars, branches by region, specialist, reviews) as the live
homepage already does. Keep the prototype as the visual reference.

## 8. Open items (unchanged, owner)
Official logo file · Dr Anis credential · 4th pillar · aesthetics scope · review permissions ·
real TikTok/IG embed URLs · confirm social counts.
