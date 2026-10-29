# Poliklinik Walid — Project Brief

> The single source of truth for this website project. Every other document in `/docs`
> builds on the decisions locked here. If something contradicts this file, this file wins.

---

## 1. What we're building

A **corporate healthcare-group website** for Poliklinik Walid — a Malaysian general-practice
and day-care minor-surgery group with a branch network. The site replaces the current
placeholder site at `poliklinikdrwalid.com`.

We are presenting an **established organisation with reach**, not a single anxious-patient
clinic. The feeling a visitor should leave with: *"this is a real, well-run healthcare group."*

---

## 2. Locked decisions

| Decision | Choice |
|---|---|
| **Official domain** | `poliklinikdrwalid.com` (all current UI/UX/content = placeholder, ignore it) |
| **Tone** | Corporate, confident, premium-but-human — like a regional healthcare group |
| **Primary language** | English-first |
| **Conversion channel** | **WhatsApp only** — no forms, no booking engine, no sign-up |
| **Branch network** | 10 branches (data owned by the consultant) |
| **Content ownership** | The marketing consultant writes all copy |
| **Build target** | WordPress as a CMS (self-hosted) |
| **Role** | External marketing consultant → clean handover matters |

---

## 3. Explicitly OUT (do not add these)

- ❌ "Care Path" journey (share concern → assessment → explanation)
- ❌ Emergency 999 bar in the site chrome
- ❌ 3-step treatment-process section
- ❌ Pervasive medical-precaution / disclaimer flagging
- ❌ "Requires clinical review / pending HQ verify" notes bleeding into the UI
- ❌ Anxious, symptom-led, reassurance-heavy tone

## 4. Explicitly IN

- ✅ Corporate, scale-led first impression (branches · doctors · panels)
- ✅ The **Services × Branches × Doctors** navigation triangle
- ✅ One calm, persistent **WhatsApp** call-to-action everywhere
- ✅ Credibility as *fact* (reviews stat, accreditation) rather than caution
- ✅ Compliance/privacy contained to the **footer + one dedicated page** only

---

## 5. The organisation (facts to build on)

Sourced from the current placeholder site — **to be confirmed by the consultant.**

- **Scale:** 10 branches (Northern Malaysia + Klang Valley / KL), ~18 doctors, 20+ registered panels.
- **Flagship branch:** Ampang — *No 1, Ground Floor, Block 2, City Garden Commercial Centre,
  Taman Nirwana, 68000 Ampang Jaya, Selangor.*
- **Service pillars:** General Medicine · Minor Surgery · Women's & Family Health.
- **Social proof:** 4.9 / 5 from 1,098 Google reviews (Ampang branch).
- **WhatsApp channels:** General 014-252 1684 · Minor surgery 017-549 7593.

---

## 6. Document map (`/docs`)

| File | Purpose |
|---|---|
| `00-project-brief.md` | This file — the locked decisions |
| `01-references.md` | Benchmark sites + the design north-star |
| `02-customer-journey.md` | How a visitor moves from arrive → contact (emotional + behavioural) |
| `03-patient-flow.md` | The behavioural flow map + WhatsApp routing |
| `04-sitemap.md` | Page hierarchy + navigation |
| `05-content-model.md` | WordPress CMS structure (custom post types + fields) |

*(Selling / service detail pages and wireframes come later, once this foundation is signed off.)*

---

## 7. Confirmed positioning decisions

1. **Hero lean = Network / reach**, with an important nuance:
   > **"A healthcare group with reach — with a specialist hub for minor surgery."**

   Minor surgery is concentrated at the main clinic (Ampang), with ~3 branches supporting;
   the rest of the network provides general practice & family health. So we sell *reach and
   access* for the group, but present minor surgery as a **center-of-excellence / hub**, not
   something uniformly available everywhere. This avoids the trust break of implying every
   branch does surgery, and is a stronger corporate story (centers-of-excellence model).

2. **Reviews = stat + curated quotes.** Headline `4.9 / 5 · 1,098 reviews` + a few selected
   quotes. → The **Review** CPT is IN.

3. **Corporate story = three credibility pillars:**
   - **Qualified doctors** (MMC-registered, trained team)
   - **Efficiency** (day-care, assess-and-treat, run like an organised group)
   - **Strong reviews** (the 4.9 / 1,098 social proof as proof of consistency)

## 8. Internationalization (i18n)

**Decision: English-only at launch.** Build and ship in English now.

But the clinic serves international patients (Sudan, Singapore, Indonesia, Brunei) for branding
purposes, so we **architect for multilingual from day one** — without translating yet:

- **Translation-ready CMS:** all CPT fields and theme strings structured so a multilingual
  plugin (Polylang/WPML) can be added later with no rebuild.
- **URL pattern reserved:** plan for `/en/ · /ms/ · /ar/` subdirectory structure even though
  only English ships now (avoids a painful retrofit / redirect mess later).
- **"International Patients" page (English):** this carries the international *branding* now —
  "patients travel from Sudan, Singapore, Indonesia & Brunei," travel/logistics help,
  international proof. Branding is done by content, not translation.
- **Future language set (when added):** English (P0) · Bahasa Malaysia (P1, also covers
  Indonesia + Brunei) · Arabic (P2, Sudan/Gulf — note: **RTL**, needs theme support).

**Rule:** do not translate or add language plugins now. Just don't block the door.

## 9. Still-open decisions

- **"Our team" depth** — full doctor roster, or leadership / selected seniors only?
- **WhatsApp routing** — auto-switch to the minor-surgery line by page, or always general?
