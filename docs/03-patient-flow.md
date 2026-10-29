# Poliklinik Walid — Patient Flow

> The **behavioural** flow (what the user does), not a clinical pathway.
> Corporate, non-linear, WhatsApp-only. See `00-project-brief.md` for locked rules.

---

## Entry points (every page is a possible entry)

| Source | Likely intent | Lands on |
|---|---|---|
| Google search ("klinik [area]", "lipoma removal", "pregnancy scan [area]") | Specific service near them | Service or Branch page |
| Google Maps / Business Profile | Wants location & hours | Branch page |
| Direct / word of mouth | Knows the brand | Home or Contact |
| Social (TikTok / FB / IG) | Discovery | Home |
| Ad / campaign link | Campaign-specific | Landing page (built later) |

**Implication:** every page must stand alone — the WhatsApp action and branch/network context
must be reachable from anywhere, never gated behind a homepage sequence.

---

## The core flow

```
                    ┌─────────────────────────┐
   Entry (any page) │  Arrive on the site      │
                    └───────────┬─────────────┘
                                ▼
                 ┌──────────────────────────────┐
                 │  Understand the organisation   │
                 │  "An established healthcare    │
                 │   group — 10 branches, trained │
                 │   doctors, a network you can   │
                 │   rely on."                    │
                 └───────────────┬────────────────┘
                                 │
          ┌──────────────────────┼──────────────────────┐
          ▼                      ▼                       ▼
 ┌─────────────────┐   ┌──────────────────┐    ┌──────────────────┐
 │ Explore SERVICES │   │ Find a BRANCH     │    │ Meet the DOCTORS  │
 │ (what we offer)  │   │ (nearest to me)   │    │ (who I'd see)      │
 └────────┬─────────┘   └─────────┬────────┘    └─────────┬────────┘
          │                       │                       │
          └───────────────────────┼───────────────────────┘
                                   ▼
                     ┌───────────────────────────┐
                     │  Decide to make contact     │
                     │  (persistent WhatsApp CTA)  │
                     └──────────────┬──────────────┘
                                    ▼
                     ┌───────────────────────────┐
                     │  Tap WhatsApp               │
                     │  (routed: general vs        │
                     │   minor-surgery enquiry)    │
                     └──────────────┬──────────────┘
                                    ▼
                     ┌───────────────────────────┐
                     │  Clinic team responds       │
                     │  → arranges the visit        │
                     └───────────────────────────┘
```

### Principles
1. **No forced sequence** — visitor self-selects Services, Branches, or Doctors (the triangle).
2. **Network-first identity** — scale is established first; it replaces cautious framing as the
   trust mechanism.
3. **One conversion action, always present** — a persistent WhatsApp button. No forms.
4. **Branch is the pivot** — availability differs by location, so Branch is where intent becomes
   contact. Every Service links to "find a branch."

---

## WhatsApp routing

| Channel | Number | For |
|---|---|---|
| General enquiries | 014-252 1684 | Services, branches, general questions |
| Minor surgery enquiries | 017-549 7593 | Minor-surgery-specific questions |

- Default floating button → **General**.
- On a minor-surgery page → button routes to the **Minor surgery** line.
- Pre-fill the message with light context where possible:
  `Hi, I'm enquiring about [service] at [branch].`

---

## Deliberately left out
- No emergency 999 bar in the chrome (at most, one quiet footer line if legally required).
- No step-by-step clinical pathway before contact.
- No heavy disclaimers interrupting the flow.
- No booking form / scheduler — WhatsApp is the only path.

---

## Open questions
1. Floating button: auto-switch to the minor-surgery line by page, or always default to general?
2. A lightweight "choose your branch" step before WhatsApp opens, or one-tap to general?
3. Any single legally-required emergency/disclaimer line to keep (→ footer)?
