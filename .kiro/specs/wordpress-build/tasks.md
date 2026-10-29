# Tasks — Poliklinik Walid WordPress Build

> Execute in order. Each task maps to acceptance criteria in `requirements.md`. Check a box when
> done, commit, and update the status trackers (README / project-context / steering "Where we are").

- [x] 1. Reproducible local WordPress environment (Docker)
  - Create `docker-compose.yml` (wordpress php 8.2+, mariadb, wp-cli service).
  - Bind-mount `wp-content/themes/walid-child` and the CPT plugin from the repo.
  - Add `.env.example`; git-ignore `.env`, WordPress core, uploads, and the DB volume.
  - Document start/URL/WP-CLI usage in `docs/DEV.md` (or README section).
  - Verify: `docker compose up` boots, homepage returns 200, `wp core version` works.
  - _Requirements: 1.1, 1.2, 1.3, 1.4_

- [x] 2. Provision base theme + plugins (scripted)
  - Add `bin/provision.sh` using WP-CLI: core install, `kadence` install+activate, activate
    `walid-child`, install+activate ACF, install+activate Rank Math.
  - Explicitly skip page builders and multilingual plugins.
  - Verify: `wp theme list` shows kadence + walid-child; `wp plugin list` shows ACF + Rank Math.
  - _Requirements: 2.1, 2.2, 2.3, 2.4, 2.5_

- [x] 3. Scaffold `walid-child` child theme
  - Create `style.css` header (Template: kadence), `functions.php`, `theme.json`, `screenshot`.
  - Enqueue child stylesheet; set up text domain `walid`.
  - Verify: theme activates with no errors; a test page renders.
  - _Requirements: 2.1, 3.3_

- [x] 4. Brand tokens: palette + fonts (match prototype 1:1)
  - Port `prototype/styles.css :root` variables into the child theme CSS.
  - Mirror palette in `theme.json` (navy #232B8F, gold #C9A227, green #1E8E66, WhatsApp #25D366).
  - Load Fraunces (headings) + Inter (body), non-render-blocking, with system fallbacks.
  - Verify: a page shows correct navy/gold/green + Fraunces/Inter matching `/prototype`.
  - _Requirements: 3.1, 3.2, 3.3_

- [x] 5. CPT plugin `walid-cpts` (register types + taxonomies)
  - Register Branch, Service, Doctor, Review CPTs (in a committed plugin, not the theme).
  - Register Region taxonomy (Central/North/Other) + Pillar taxonomy
    (Minor Surgery/Aesthetics/Antenatal/Pillar-4-TBD/General).
  - Add the Branch `provides_minor_surgery` flag and Service `pillar-weight`.
  - Verify: `wp post-type list` and `wp taxonomy list` show the new types.
  - _Requirements: 4.1, 4.2, 4.3_

- [x] 6. ACF fields + relationships (version-controlled)
  - Create ACF field groups for each CPT per `design.md` table; store as local JSON in
    `walid-child/acf-json/`.
  - Wire relationships: Service ↔ lead Doctor, Service ↔ Branches, Doctor ↔ Branches.
  - Verify: fields appear on each CPT; a sample Service can link a lead Doctor.
  - _Requirements: 4.4, 4.5_

- [x] 7. Homepage rebuild from the prototype
  - Recreate the `/prototype` sections (per `docs/12`) as block patterns / template parts.
  - Minor surgery visually dominant; aesthetics/antenatal as rising pillars; specialist block
    expertise-first; proof rail + reviews + branch network + international strip.
  - Dynamic sections query the CPTs.
  - Verify: homepage visually matches `/prototype`; dynamic sections render sample CPT data.
  - _Requirements: 5.1, 5.4_

- [x] 8. Singular templates: Branch / Service / Doctor
  - `single-branch.php`, `single-service.php`, `single-doctor.php` rendering CPT fields,
    styled to match the prototype.
  - Verify: a sample post of each type renders correctly via its template.
  - _Requirements: 5.2_

- [ ] 9. WhatsApp conversion + social footer
  - Floating WhatsApp button on every page; context routing (minor-surgery vs general line)
    from a single config, not scattered literals.
  - Footer with real social hrefs (TikTok, FB, IG, YouTube, Google). No empty links.
  - Verify: button appears site-wide and routes correctly; every social icon links.
  - _Requirements: 5.3, 5.5, 6.2_

- [ ] 10. SEO, performance, accessibility pass
  - JSON-LD schema for branches (LocalBusiness/MedicalClinic); clean slugs; Rank Math titles/meta/sitemap.
  - Lazy-load social embeds (facade). Accessibility: landmarks, focus states, alt text,
    contrast check on navy/gold/green.
  - Flag guard: nothing behind `[confirm]`/`[TBD]`/`[permission pending]` renders.
  - Verify: Lighthouse/aXe spot check; schema validates; flagged content hidden.
  - _Requirements: 6.1, 6.2, 6.3, 6.4_

## Owner-blocked (cannot complete until supplied — track in docs/08)
Official logo file + exact hex · Dr Anis credential · 4th pillar · aesthetics launch scope ·
named-review permissions + source URLs · full 10-branch dataset · confirm current social counts.
