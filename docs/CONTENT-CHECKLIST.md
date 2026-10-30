# Content entry checklist — Poliklinik Walid

> Fill-in sheet for loading the real content into the CMS (wp-admin). Fields here map 1:1 to the
> ACF fields on each custom post type, so you can gather everything offline, then type it in once.
> Copy rules apply to anything public-facing: **no em-dashes**, English, no "not a..., not a...".
>
> How to use: fill the blanks below (or in a copy of this file), then enter each record in
> wp-admin → Branches / Doctors / Services / Reviews. Nothing behind a `[confirm]` flag should be
> published until verified.

---

## 0. Group-wide facts (confirm once)

- [ ] Legal entity + reg no: **Walid Healthcare Group Sdn. Bhd. (1466692-A)** — confirm correct
- [ ] Official **logo file** (SVG preferred, or high-res PNG) → replaces
      `wp-content/themes/walid-child/assets/logo.jpg`
- [ ] WhatsApp numbers: general **014-252 1684** · minor surgery **017-549 7593** — confirm
- [ ] Current social counts (for display): TikTok ____ · Facebook ____ · Instagram ____
- [ ] Google rating + count to show (e.g. 4.9 / 1,098) — confirm + permission
- [ ] The **4th service pillar** — what is it? ________________
- [ ] Aesthetics launch scope: brand-now / full detail now? ________________

---

## 1. Branches (×10)  → wp-admin → Branches → Add New

Repeat this block for every branch. Minor-surgery branches: Ampang (Central); Jalan Baru,
Tasek Gelugor, Sungai Petani (North). Others = general practice.

### Branch 1 — Ampang (flagship) [known]
- [ ] Title: `Poliklinik Walid Ampang`
- [ ] Region (pick one): **Central (Klang Valley)** / North (Penang-Kedah) / Other
- [ ] Provides minor surgery? **Yes**
- [ ] Flagship? **Yes**
- [ ] Full address: ______________________________________________
- [ ] Opening hours (per day/range): ______________________________
- [ ] Phone: ______________  · Branch WhatsApp (digits, optional): ______________
- [ ] Google Place ID (for live reviews): ______________  (how: docs/GOOGLE-REVIEWS.md)
- [ ] Google Maps link/embed: ______________
- [ ] Photos (consented): ____ files
- [ ] Short intro (1-2 lines): ____________________________________

### Branch 2 — Jalan Baru (Seberang Perai) [minor surgery]
- [ ] Title · Region = **North** · Provides minor surgery = **Yes** · Flagship = No
- [ ] Address / hours / phone / WhatsApp / Place ID / map / photos / intro: __________

### Branch 3 — Tasek Gelugor [minor surgery, North]
- [ ] Title · Region = North · Minor surgery = Yes · address/hours/phone/Place ID/map/photos: ____

### Branch 4 — Sungai Petani [minor surgery, North]
- [ ] Title · Region = North · Minor surgery = Yes · address/hours/phone/Place ID/map/photos: ____

### Branch 5 — Kuala Kangsar [GP, Other]
- [ ] Title · Region = Other · Minor surgery = No · address/hours/phone/Place ID/map/photos: ____

### Branch 6 — Parit Buntar [GP, Other]
- [ ] Title · Region = Other · Minor surgery = No · address/hours/phone/Place ID/map/photos: ____

### Branches 7–10 — [names to confirm]
- [ ] Branch 7: name ______ · region ______ · minor surgery? ______ · address/hours/phone/…
- [ ] Branch 8: ______
- [ ] Branch 9: ______
- [ ] Branch 10: ______

> Per-branch fields (all): title · region · provides-minor-surgery toggle · flagship toggle ·
> address · opening hours (repeater) · phone · WhatsApp · Google Place ID · map · photos ·
> services offered here (relationship) · doctors at this branch (relationship) · intro content.

---

## 2. Doctors  → wp-admin → Doctors → Add New

Display pattern is expertise-first, so role/credential matters. Photos must be consented.

### Dr Walid Utagha [known — minor surgery lead]
- [ ] Name: `Dr Walid Utagha`
- [ ] Role/title: ______________ (e.g. Minor Surgery Specialist) — **[confirm exact credential]**
- [ ] Qualifications (MMC reg etc.): ______________
- [ ] Photo (consented): ____
- [ ] Short bio (corporate, no em-dashes): ____________________________________
- [ ] Branch(es): ______________
- [ ] Lead specialist for (service): **Minor Surgery**
- [ ] Leadership? Yes

### Dr Anis [known — antenatal lead]
- [ ] Name: `Dr Anis`
- [ ] Role/title: ______________ **[confirm exact O&G credential]**
- [ ] Qualifications / Photo / Bio: ______________
- [ ] Branch(es): ______________
- [ ] Lead specialist for: **Antenatal & Women's Health**

### Other doctors (repeat per doctor)
- [ ] Name ______ · role ______ · quals ______ · photo ______ · bio ______ · branches ______ ·
      lead-for (if any) ______
- [ ] ... (18 trained doctors total — add those the clinic wants profiled)

---

## 3. Services  → wp-admin → Services → Add New

Each service: pillar + weight + short description + procedures list + routing + lead doctor +
branches. The procedures list (one per line) drives the "see more" list and the single-page grid.

| Service | Pillar | Lead doctor | WhatsApp line | Status |
|---|---|---|---|---|
| Minor Surgery | Minor Surgery (HERO) | Dr Walid | minor-surgery | [known] |
| Antenatal Care | Antenatal & Women's Health | Dr Anis | general | [known] |
| Wellness & Aesthetic | Aesthetics | ____ | general | confirm scope |
| General practice services (ENT, physio, immunisation, etc.) | General Medicine | ____ | general | [known list] |

Per service to confirm:
- [ ] Short description (1-2 lines, no em-dashes)
- [ ] Procedures (one per line) — confirm wording per service
- [ ] Price shown? (default: pricing after assessment, no public price) — confirm
- [ ] Service image (consented)
- [ ] Offered at which branches (relationship)

---

## 4. Reviews  → wp-admin → Reviews → Add New  (OR use live Google reviews)

Two options (can combine):
- **Live Google reviews** — set the API key + each branch's Place ID (docs/GOOGLE-REVIEWS.md).
  Shows the branch's real rating + up to 5 reviews automatically. No manual entry.
- **Curated Review CPT** — hand-pick quotes. Each needs the **permission toggle ON** before it shows.

Per curated review:
- [ ] Quote (exact, or translated to English) · Reviewer name · Rating (1-5) · Source (Google) ·
      Source URL · **Permission to publish? Yes/No** · Branch

Known (from the Wix site, permission pending):
- [ ] Nur Namira Mohamad Rosli — baby circumcision, friendly staff — **confirm consent + URL**
- [ ] Sara Sofea — treated well and courteously — **confirm consent + URL**

---

## 5. Proof wall videos (homepage)  → optional

- [ ] Real TikTok/Instagram video URLs for the 3 proof-wall slots (currently link to profiles).
      Provide the specific post URLs and I/OMP wire them in.

---

## 6. Pages (one-time, already templated)

- [ ] About / Governance — corporate story + MMC/PDPA (edit the page or accept the default copy)
- [ ] International Patients — accept default or add travel guidance
- [ ] Contact — WhatsApp-only (already built)

---

## Done when
Every branch, the profiled doctors, all services (with procedures), and either live-Google or
permitted curated reviews are entered; the official logo is swapped in; no `[confirm]` /
`[permission pending]` content remains published. Then run the pre-launch checklist in
`HANDOFF-OMP.md` §4.
