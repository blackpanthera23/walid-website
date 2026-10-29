# Handoff for OMP (Oh My Pi)

> Comprehensive brief for the OMP agent to apply the WordPress-side work. Read
> `project-context.md` and `docs/00-project-brief.md` first; this file is the task list.

---

## Context in one paragraph

We are building the Poliklinik Walid corporate healthcare website. Strategy, content model,
design system, and a rendered homepage prototype are DONE and committed to this repo
(`blackpanthera23/walid-website`). Your job is **Phase 4 onward: stand up WordPress and apply
the build** on the actual host/local environment, because Kiro Web cannot click inside WordPress
admin or run a local WP. The repo is the source of truth and the spec.

## What is already done (do not redo)

- `/docs/00`–`/docs/12`: full strategy (brief, journey, flow, sitemap, content model, source
  facts, design system, owner decisions, value prop, proof strategy, pillars/specialists,
  homepage wireframe + copy).
- `/prototype/index.html` + `styles.css` + `assets/logo.svg`: the rendered homepage, navy brand,
  Fraunces + Inter. **This is the visual + build spec.** Reuse its CSS variables verbatim.
- `.kiro/steering/project-context.md`: auto-loading context for Kiro sessions.

## Your tasks (in order)

### Task 1 — Environment
- [ ] Stand up WordPress. Prefer **local first** (LocalWP or Docker) to iterate safely, then
      promote to the host. Confirm PHP 8.2+ and current WordPress.
- [ ] Record access details in `docs/08-owner-decisions.md` (URLs, host, admin owner, backups).

### Task 2 — Base theme + plugins
- [ ] Install **Kadence** parent theme.
- [ ] Install **ACF** (Advanced Custom Fields).
- [ ] Install an SEO plugin (**Rank Math** or Yoast). Do NOT install a page builder.
- [ ] Do NOT install any multilingual plugin yet (English-only launch; stay i18n-ready).

### Task 3 — Child theme + brand tokens
- [ ] Create child theme `walid-child`.
- [ ] Map the navy palette into Kadence Global Palette + `theme.json` using the exact values in
      `docs/07-design-system.md` §2 and §6. Fonts: Fraunces (headings), Inter (body), with
      system fallbacks. Keep font loading non-render-blocking.
- [ ] Port the CSS variables from `prototype/styles.css` `:root` into the child theme so the
      look matches the prototype 1:1.

### Task 4 — Custom post types + fields (from docs/05 + docs/11)
- [ ] Register CPTs: **Branch**, **Service**, **Doctor**, **Review**.
- [ ] Taxonomies: Branch **Region** (Central / North / Other) + a "provides minor surgery"
      toggle; Service **Pillar** (Minor Surgery / Aesthetics / Antenatal / Pillar-4-TBD /
      General) + pillar-weight.
- [ ] Relationships: Service ↔ lead Doctor (Dr Anis → Antenatal); Service ↔ Branches; Doctor ↔ Branches.
- [ ] Keep content in fields (not hardcoded) so it stays translatable later.

### Task 5 — Homepage + templates
- [ ] Rebuild the `/prototype` homepage as Gutenberg patterns, section for section
      (see `docs/12-homepage-wireframe.md`). Minor surgery must stay visually dominant.
- [ ] Build Branch / Service / Doctor single templates that pull from the CPTs.
- [ ] Wire the two WhatsApp numbers; floating WhatsApp button on every page; minor-surgery pages
      route to the minor-surgery line.

### Task 6 — Content + SEO + launch prep
- [ ] Load the 10 branches, services, doctors, and curated reviews (pending owner data/permissions).
- [ ] Branch pages optimised for local search (they are the SEO engine). Set up Google Business Profile links.
- [ ] Every social icon links (TikTok, FB, IG, YouTube, Google). No empty hrefs.
- [ ] Performance pass (lazy-load social embeds), accessibility pass (WCAG AA, focus states, alt text).

## Hard rules (do not break)

- WhatsApp-only conversion. No forms, no booking engine.
- English-only content at launch. No translation plugins.
- Copy: **no em-dashes**; avoid "not a..., not a...".
- Do NOT reintroduce: care-path motif, emergency bar, 3-step process, pervasive disclaimers.
  Compliance lives in the footer + one "About/Governance" page.
- Navy `#232B8F` brand, gold `#C9A227` accent, green `#1E8E66` CTAs. Do not revert to teal.
- Nothing fake published: respect every `[confirm]` / `[TBD]` / `[permission pending]` flag.

## When you finish a task

- Commit with a clear message; update the "Where we are" list in
  `.kiro/steering/project-context.md`, the status table in `README.md`, and the progress table
  in `project-context.md`. Push. That keeps every agent in sync.

## Open items blocking full completion (owner)

Official logo file + exact hex · Dr Anis credential · 4th pillar · aesthetics launch scope ·
named-review permissions · full 10-branch dataset · confirm current social counts.
See `docs/08-owner-decisions.md`.
