# Poliklinik Walid — WordPress Content Model

> How the site is structured as a **CMS**, so non-technical staff can maintain 10 branches,
> services, and doctors by filling forms — not building pages. See `00-project-brief.md`.

---

## Custom Post Types (CPTs)

### 1. Branch  (`branch`)
The network. One entry per branch → auto-generates a branch page.

| Field | Type | Notes |
|---|---|---|
| Branch name | text | e.g. "Poliklinik Walid Ampang" |
| Slug / URL | auto | `/branches/ampang` |
| Address | text (multi-line) | Full address |
| State / region | select | Northern Malaysia / Klang Valley etc. — for filtering |
| Opening hours | repeater | Day → hours |
| Phone / WhatsApp | text | Branch contact (falls back to group lines) |
| Map embed / coords | text | Google Maps |
| Services offered here | relationship → Service | Availability differs by branch |
| Photos | gallery | Real branch photography |
| Is flagship? | toggle | Highlights Ampang |

### 2. Service  (`service`)
The capability catalogue.

| Field | Type | Notes |
|---|---|---|
| Service name | text | e.g. "Minor Surgery" |
| Pillar | select | General Medicine / Minor Surgery / Women's & Family Health |
| Short description | textarea | For overview cards |
| Detail content | WYSIWYG | Selling copy — later phase |
| Icon / image | media | |
| Offered at branches | relationship → Branch | Mirrors Branch field |
| WhatsApp routing | select | General vs Minor-surgery line |

### 3. Doctor  (`doctor`)
The people / credibility layer.

| Field | Type | Notes |
|---|---|---|
| Name | text | |
| Role / title | text | e.g. "O&G Doctor" |
| Qualifications | text | MMC registration etc. |
| Photo | media | |
| Branch(es) | relationship → Branch | |
| Bio | textarea | Short, corporate |
| Is leadership? | toggle | For "leadership only" display option |

### 4. Review  (`review`)  *(optional — depends on reviews decision)*
Curated Google reviews, if we show quotes as well as the headline stat.

| Field | Type | Notes |
|---|---|---|
| Quote | textarea | |
| Reviewer name | text | |
| Source | text | "Google review" |
| Branch | relationship → Branch | |
| Rating | number | |

---

## Taxonomies

- **Region** (for Branches): Northern Malaysia · Klang Valley / KL — powers branch filtering.
- **Pillar** (for Services): General Medicine · Minor Surgery · Women's & Family Health.

---

## Global / site options (ACF options page or theme settings)

- Group stats: branch count, doctor count, panel count (shown on Home).
- Reviews headline stat: `4.9 / 5 · 1,098 reviews`.
- WhatsApp numbers: general + minor-surgery.
- Footer compliance lines: MMC, PDPA 2010, (optional emergency line).

---

## The CMS payoff
When branch #8's details are confirmed, staff just fill the **Branch** form — no page building,
no developer. Services and Doctors relate to Branches, so everything stays connected. This is
why WordPress-as-CMS (not just a page builder) is the right call for a 10-branch group.

---

## i18n readiness (English ships now — see brief §8)

Build English-only, but keep the door open so languages add later with no rebuild:
- Put all user-facing theme strings through `__()` / `_e()` (text domain) — never hardcode.
- Keep CPT content in fields (not baked into templates) so a plugin can translate per-field.
- Reserve the `/en/` URL base conceptually; don't hardcode language-free permalinks that would
  clash with a future `/ms/`, `/ar/`.
- Do **not** install Polylang/WPML yet. Just don't do anything that blocks them.

## Recommended plugins (lean)
- **ACF (Advanced Custom Fields)** — the custom fields above.
- **CPT UI** or register CPTs in the child theme's `functions.php`.
- **Rank Math** / Yoast — SEO (branch pages = local search engine).
- **Astra / Kadence / GeneratePress** — lightweight corporate base theme + child theme.

## Open questions
1. Show a **Review** CPT (quotes), or just the headline stat from site options?
2. Doctor profiles as individual pages, or a single index?
3. Bilingual later (Polylang/WPML)? Affects CPT + URL setup — decide before build.
