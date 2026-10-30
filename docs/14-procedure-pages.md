# Procedure pages (per-treatment, AB style)

> Build individual treatment pages (e.g. Xanthelasma, Lipoma, Ganglion cyst) on the model of the
> live `poliklinikdrwalid.com/xanthelasma-treatment/` page, rendered in the Concept AB look.
> Trust-first, English, WhatsApp-only. Does NOT reintroduce the removed site-wide care-path/3-step
> motif — this is per-procedure patient education, not an anxious funnel.

## 1. The page anatomy (from the reference page)

A consistent 4-section structure per procedure:

```
HERO            procedure name + one-line summary + WhatsApp CTA (routes to minor-surgery line)
01 · WHAT IT IS    plain-language explanation + an honest "why it matters" note box
02 · METHODS       numbered method cards (01/02/03...), "a doctor decides" framing
03 · WHAT TO EXPECT numbered journey: assessment -> method & consent -> procedure -> aftercare
04 · QUESTIONS      a checklist of questions worth asking at the consultation
CTA             WhatsApp the minor surgery team
```

Voice: calm, honest, assessment-first. Cosmetic/functional framing is fine; never alarmist.

## 2. Data model — a `procedure` CPT

Register a **Procedure** CPT (in `walid-cpts`) so staff add a treatment page by filling a form.

| Field | Type | Notes |
|---|---|---|
| Title | post title | e.g. "Xanthelasma treatment" |
| Summary | text | one-line tagline under the H1 |
| What it is | WYSIWYG | section 01 body |
| Why it matters note | textarea | the highlighted callout box (optional) |
| Methods | repeater | each: number(auto), name, body |
| What to expect | repeater | each: step name, body (assessment/consent/procedure/aftercare) |
| Questions | textarea | one question per line |
| Parent service | post_object -> service | link to "Minor Surgery" (for breadcrumb + routing) |
| Offered at branches | relationship -> branch | which surgical centres |
| WhatsApp routing | select | default minor_surgery |
| Image | image | hero/organic-panel photo (placeholder until supplied) |

Taxonomy: reuse nothing new; relate to the parent Service + Branches.
URL: `/procedures/xanthelasma-treatment/` (or `/treatments/...` — pick one; spec uses `procedures`).

## 3. Template — `single-procedure.php` (AB look)

- Hero: organic panel + the procedure image (placeholder fallback), H1 = title, summary line,
  WhatsApp CTA (minor-surgery line), small "part of Minor Surgery" link to the parent service.
- Section 01: numbered eyebrow `01 · WHAT IT IS`, body, and the "why it matters" note box
  (gold-tinted callout).
- Section 02: `02 · METHODS` — numbered method cards (reuse the smooth card craft), each with
  a big ghost number, name, body. "A doctor decides after examining it" line.
- Section 03: `03 · WHAT TO EXPECT` — numbered step list (NOT the old site-wide 3-step chrome;
  this is in-page procedure info).
- Section 04: `04 · QUESTIONS WORTH ASKING` — checklist with gold ticks.
- Final CTA: WhatsApp the minor surgery team. Scroll-reveal + reduced-motion as elsewhere.
- Styles in `assets/css/procedure.css`, enqueued on `is_singular('procedure')`.

## 4. How procedures relate to /services

- The Minor Surgery service page lists its procedures (the `service_procedures` field stays as the
  quick list). Where a procedure has its own page, link the list item to that page.
- `/services/` short descriptions: add a one-line explainer per procedure (see §6).

## 5. Build order
1. Register `procedure` CPT + ACF fields (walid-cpts + acf-json).
2. `single-procedure.php` + `procedure.css` (AB look).
3. Seed **Xanthelasma** as the complete worked example (content from the reference page).
4. Later: add Lipoma, Ganglion cyst, etc. (owner fills the form per procedure).

## 6. /services short explainers (one line each, calm)
Lipoma — a fatty lump a doctor needs to assess. · Sebaceous/ganglion cyst — a fluid-filled lump
under the skin. · Mole / skin tag — a skin growth checked and removed. · Wart — a viral skin
growth. · Keloid — an overgrown scar. · Xanthelasma — yellow cholesterol deposits on the eyelid.
(Full list filled per procedure; keep each to one honest line, no em-dashes.)

## 7. Acceptance
- [ ] `procedure` CPT + fields register; `/procedures/xanthelasma-treatment/` renders all 4 sections.
- [ ] AB look (organic hero panel, smooth cards, gold ticks); WhatsApp routes to minor-surgery line.
- [ ] Minor Surgery service page links its procedures to their pages where they exist.
- [ ] No em-dashes; no care-path/3-step chrome reintroduced; reduced-motion respected.
