# Poliklinik Walid — Proof & Social Content Strategy

> Walid's biggest differentiator is earned social proof at scale. The website must **pull this
> in**, not ignore it. English-first. Copy rules per `09-value-proposition.md`.

---

## 1. The proof assets (owner-confirmed figures)

| Channel | Figure | Handle / source | Role on site |
|---|---|---|---|
| **TikTok** | 561K followers, 8.4M likes (Dec 2025) | `@poliklinikwalidofficial` | Flagship proof + real procedure content |
| **Facebook** | 119K followers | `facebook.com/profile.php?id=100080089330356` (page `poliklinikwalidpage`) | Proof rail + community |
| **Instagram** | 30.8K followers | `instagram.com/drwalidutagha` | Visual grid, before/after style content |
| **Google** | 4.9 from 1,098 reviews (Ampang) | Google Business Profile | Reviews block (stat + quotes) |

> Confirm counts are current before publishing (socials change). Use rounded, honest figures.

---

## 2. How proof appears across the site

### Hero proof rail (every entry point sees it)
A single restrained line of earned numbers, stated as fact, not boast:

> `561K on TikTok · 119K on Facebook · 4.9★ from 1,098 Google reviews`

Keep it calm and corporate (small rail, not giant monument numbers, per design system).

### Proof / content wall (home + relevant pages)
- **Embedded TikToks** of real (consented) procedures and patient stories. This is the single
  highest-impact block: it is the content that earned the 561K and it converts.
- **Instagram grid** (latest posts) for visual texture.
- **Google review wall**: the 4.9 stat headline plus a few curated, permission-cleared quotes.

### Footer
- Social icons with correct, working links (TikTok, FB, IG, YouTube, Google profile).
- (Old audit found empty social `href`s on a prior build. Do not repeat. Every icon links.)

---

## 3. Consistency rule (one brand across every surface)

Whatever a visitor saw on TikTok must be reinforced on the site, in WhatsApp, and at the clinic.
Every surface carries the same three signals:

1. **Surgeon-led** (specialist, MMC-registered).
2. **Day-care, worth it** (hospital-grade care at clinic speed and price; the smart choice).
3. **Loved at scale** (561K / 119K / 30.8K / 1,098 reviews).

No surface may feel cheaper or more generic than the TikTok that brought the patient in.

---

## 4. Technical approach (WordPress)
- TikTok: official embed blocks or a lightweight feed plugin; lazy-load so it does not slow the page.
- Instagram: a performant feed block/plugin (avoid heavyweight ones that hurt Core Web Vitals).
- Google reviews: pull via a reviews plugin or curate manually as a `Review` CPT (see
  `05-content-model.md`); manual curation is safer for permissions.
- Performance: all social embeds lazy-loaded; never render-blocking (branch pages live on SEO).

---

## 5. Permissions / compliance (do before publishing)
- Patient-facing procedure videos/photos: written consent on file.
- Named Google reviews: permission + exact source URLs (see `08-owner-decisions.md`).
- Follower/review counts: use current, honest, rounded numbers.

---

## 6. Open questions
1. TikTok on site: curated hand-picked videos, or an auto-pulling feed?
2. Instagram grid: live feed plugin, or static curated images (faster, more control)?
3. Google reviews: live plugin, or manually curated `Review` CPT (recommended for permissions)?
