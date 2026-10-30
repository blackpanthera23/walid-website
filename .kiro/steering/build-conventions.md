---
inclusion: fileMatch
fileMatchPattern: '**/*.{php,css,js,json,yml,yaml}'
---

# Build conventions (loads when editing code)

> Scoped steering for the WordPress build phase. The always-on brand/strategy rules live in
> `project-context.md` (steering). This file covers HOW to write the code.

## WordPress / PHP
- Target **PHP 8.2+** and current WordPress. Follow WordPress coding standards (spacing,
  `snake_case` functions, prefixed with `walid_`).
- All theme code goes in the **`walid-child`** child theme. Never edit the Astra parent.
- Register CPTs/taxonomies/fields in code (child theme or a small MU-plugin), not by clicking
  in admin, so everything is version-controlled and reproducible for OMP.
- Enqueue assets properly (`wp_enqueue_style/script`), fonts non-render-blocking.
- Escape on output (`esc_html`, `esc_attr`, `esc_url`), sanitize on input. i18n-wrap
  user-facing strings with `__()`/`esc_html__()` and the `walid` text domain (translatable later,
  not translated now).

## CSS
- Port the CSS variables from `prototype/styles.css` `:root` verbatim; map them to the Astra
  Global Palette / `theme.json`. Navy `#232B8F`, gold `#C9A227`, green `#1E8E66`, WhatsApp `#25D366`.
- Mobile-first. Keep the look 1:1 with `/prototype`.

## Docker / local env
- WordPress runs via the repo `docker-compose.yml` (WordPress + MariaDB + WP-CLI). Keep it
  reproducible; do not hardcode machine-specific paths. Secrets/local overrides stay out of git.

## Copy inside code/templates
- Respect the global copy rules: NO em-dashes; avoid "not a..., not a...". English-only.
- Every social icon MUST have a real `href` (a prior build shipped empty ones).
- Never publish content behind a `[confirm]` / `[TBD]` / `[permission pending]` flag.

## Verify before claiming done
- Run the container and confirm WordPress boots; activate the theme; confirm CPTs register.
- State what was verified vs not. A file written is not the same as a feature working.
