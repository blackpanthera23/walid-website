# Requirements — Poliklinik Walid WordPress Build

> Spec for Phase 4+ of the Poliklinik Walid website: standing up WordPress and building the
> theme/CMS from the approved strategy + prototype. Strategy source of truth: `/docs/00`–`/docs/12`.
> Visual + build spec: `/prototype`. This spec is executable task-by-task (see `tasks.md`).

## Introduction

Phases 1–3 (strategy, wireframe, rendered prototype) are complete and committed. This spec
covers turning that into a working, locally-runnable WordPress site: a reproducible environment,
a child theme on Kadence, the custom post types and fields, and the homepage + singular
templates rebuilt from the prototype. Conversion is WhatsApp-only; content is English-only at
launch but architected to add languages later.

## Requirement 1 — Reproducible local WordPress environment

**User story:** As a developer/agent (Kiro IDE, OMP), I want a reproducible local WordPress
environment in the repo, so that anyone can boot the identical stack and verify the build.

### Acceptance criteria
1. WHEN a developer runs `docker compose up`, THEN WordPress SHALL be reachable on a local port
   with PHP 8.2+ and a MariaDB/MySQL database.
2. WHEN the stack starts, THEN WP-CLI SHALL be available to run commands against the install.
3. The environment configuration SHALL live in the repo (`docker-compose.yml`), WHILE
   machine-specific secrets/overrides SHALL be git-ignored.
4. WHEN a fresh developer boots the stack, THEN documentation SHALL state how to start it,
   reach it, and run WP-CLI.

## Requirement 2 — Base theme and plugins

**User story:** As the site owner, I want a lightweight, SEO-friendly foundation, so the
corporate site loads fast and stays maintainable.

### Acceptance criteria
1. The Kadence parent theme SHALL be installed and the `walid-child` child theme active.
2. ACF SHALL be installed for custom fields.
3. An SEO plugin (Rank Math or Yoast) SHALL be installed.
4. NO page builder (Elementor/Divi) and NO multilingual plugin SHALL be installed at launch.
5. Theme/plugin provisioning SHALL be scriptable (WP-CLI) so it is reproducible, not manual-only.

## Requirement 3 — Brand tokens in the theme

**User story:** As the owner, I want the live theme to match the approved navy prototype exactly.

### Acceptance criteria
1. The navy palette (`#232B8F`), gold accent (`#C9A227`), green CTA (`#1E8E66`), WhatsApp green
   (`#25D366`) SHALL be mapped into `theme.json` / the Kadence Global Palette.
2. Fraunces (headings) + Inter (body) SHALL load with system fallbacks, non-render-blocking.
3. The CSS variables from `prototype/styles.css` `:root` SHALL be ported into the child theme so
   the rendered look matches the prototype 1:1.

## Requirement 4 — Custom post types and fields

**User story:** As clinic staff, I want to manage branches, services, doctors, and reviews
through CMS forms, so I can maintain the site without a developer.

### Acceptance criteria
1. CPTs SHALL be registered in code: **Branch**, **Service**, **Doctor**, **Review**.
2. Branch SHALL have a **Region** taxonomy (Central / North / Other) and a "provides minor
   surgery" flag.
3. Service SHALL have a **Pillar** taxonomy (Minor Surgery / Aesthetics / Antenatal /
   Pillar-4-TBD / General) and a pillar-weight field.
4. Relationships SHALL exist: Service ↔ lead Doctor (Dr Anis → Antenatal); Service ↔ Branches;
   Doctor ↔ Branches.
5. All displayed content SHALL live in fields (not hardcoded), keeping it translatable later.

## Requirement 5 — Homepage and singular templates

**User story:** As a visitor, I want a homepage and branch/service/doctor pages that match the
approved design and lead me to WhatsApp.

### Acceptance criteria
1. The homepage SHALL rebuild the `/prototype` sections (see `docs/12`), WITH minor surgery
   visually dominant and aesthetics/antenatal as rising pillars.
2. Single templates for Branch, Service, and Doctor SHALL render from their CPT fields.
3. A floating WhatsApp button SHALL appear on every page; minor-surgery pages SHALL route to the
   minor-surgery line, others to the general line.
4. The specialist block SHALL follow the expertise-first pattern (need → named doctor → action).
5. Every social icon SHALL have a real `href`. No empty links.

## Requirement 6 — Content, SEO, and launch readiness

**User story:** As the owner, I want branch pages optimized for local search and the site ready
to launch once content is supplied.

### Acceptance criteria
1. Branch pages SHALL be structured for local SEO (per-location pages, schema where applicable).
2. Social links (TikTok, FB, IG, YouTube, Google) SHALL be wired and verified.
3. A performance pass (lazy-load embeds) and accessibility pass (WCAG AA targets, focus states,
   alt text) SHALL be completed.
4. Content behind `[confirm]` / `[TBD]` / `[permission pending]` flags SHALL NOT be published.

## Out of scope (launch)
- Online booking / forms (WhatsApp only).
- Translations / multilingual plugin (architect only).
- Reintroducing care-path, emergency bar, 3-step, or pervasive disclaimers.
