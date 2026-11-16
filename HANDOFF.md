# Poliklinik Walid website: full handoff

**Last updated:** 16 Nov 2026 · **Live:** https://poliklinikdrwalid.com runs theme **walid-child 0.4.7** (commit `f3e4fce`)
on **Astra 4.14.3**, deployed 16 Nov 2026 and verified, with content imported. **Repo:** `github.com/blackpanthera23/walid-website`, branch `main`.

This is the single entry point for anyone (person or agent) taking over the site. It replaces `HANDOFF-OMP.md`
and the `docs/DEPLOY-BATCH-*.md` manifests, which describe older states. Deeper detail lives in the files
listed in section 14.

---

## 1. What the site is

A corporate website for **Poliklinik Walid** (Walid Healthcare Group Sdn. Bhd., reg. **1466692-A**), a Malaysian
group of 10 clinics. Surgeon-led day-care **minor surgery** is the lead service, with **aesthetics** and
**antenatal / women's health** (led by Dr Anis) as growing pillars, plus general practice across the network.

Non-negotiables (full list in `.kiro/steering/project-context.md` and `docs/00-project-brief.md`):

| Rule | Detail |
|---|---|
| Conversion | **WhatsApp only.** General 014-252 1684, minor surgery 017-549 7593. No forms, no online booking. |
| Language | English only at launch; strings are translatable for MS/AR later. No translation plugin. |
| Brand | Navy `#232B8F`, gold `#C9A227` (accent), green `#1E8E66` (CTAs), WhatsApp green `#25D366`. Fonts Fraunces (headings) + Inter (body). |
| Copy | No em-dashes. Avoid the "not a..., not a..." construction. Corporate, premium-accessible tone. |
| Removed, do not bring back | Care-path motif, emergency bar, numbered 3-step process, medical disclaimers on every page (compliance lives in the footer and the About page). |
| Imagery | No AI-generated people, doctors, patients or clinic scenes. No graphic surgery. Abstract brand art is fine. Doctor photos must be real. |
| Proof | Stats are owner-confirmed: TikTok 561K, Facebook 119K, Instagram 30.8K, Google 4.9 from 1,098 reviews. Named review quotes need the patient's permission. |

## 2. Current state (16 Nov 2026)

| Area | State |
|---|---|
| Theme code | ✅ Live = repo `main` (0.4.7). Nothing pending. |
| Live content | ✅ Imported 16 Nov via Tools > Walid content: 6 branches (address, phone, hours, Google rating from each Google Maps listing), 16 published services + Radiology as a draft, 2 doctors, the Xanthelasma procedure page, 10 real Google reviews. Branches 7 to 10 and doctor photos are still missing. |
| Live config | ✅ Static front page, post-name permalinks, Primary menu in Astra `primary` + `mobile_menu`, logo and "WhatsApp The Clinic" button in the header. |
| Local site | ✅ http://localhost:8080 on Astra, with sample content (local only). |
| Launch | ⏳ Blocked on real content and owner confirmations (section 11). |

What visitors see today: every page is filled. The homepage reviews row shows 10 Google reviews; `/services/` has
the pillar panels with the 6 Minor Surgery category cards; `/branches/` lists 6 branches by region with their
Google rating and hours; `/doctors/` lists Dr Walid and Dr Anis (placeholder avatars until real photos).

## 3. Architecture

```
WordPress (IONOS Managed WP)          Local: Docker (docker-compose.yml)
├── Parent theme: Astra 4.14.3        same
├── Child theme: walid-child          bind-mounted from the repo
│   └── all design, templates, logic
├── Plugin: walid-cpts                bind-mounted from the repo
│   └── post types + taxonomies
└── Plugin: Advanced Custom Fields    field groups load from walid-child/acf-json (no manual setup)
```

- **Parent = Astra on both live and local** (decided 16 Nov; local used Kadence before). The child owns the look.
  `inc/parent-compat.php` stops Astra's saved settings from changing it: it forces the brand palette, turns the
  transparent header off, and gives our views Astra's full-width layout with no sidebar. Without it, live showed
  a green palette and the menu overlapped the homepage headline.
- **No page builder.** Templates are PHP files in the child theme; content comes from custom post types + ACF.
- **ACF is required.** `functions.php` has a shim so the site degrades instead of crashing if ACF is off.
- **Other plugins on live:** Spectra blocks, Starter Templates (astra-sites), **SureCookie** (cookie banner),
  **LatePoint** (a booking plugin; see section 12).

### Template map

| URL | Template |
|---|---|
| `/` | `front-page.php` (+ `template-parts/home-map.php`), styles `assets/css/home.css`, script `assets/js/home.js` |
| `/services/` | `archive-service.php` (pillar panels, 6 Minor Surgery category cards, video strip) |
| `/services/<slug>/` | `single-service.php` (photo hero, procedures, where we perform, day-care stats, videos, testimonials, promise, FAQ) |
| `/branches/`, `/branches/<slug>/` | `archive-branch.php`, `single-branch.php` |
| `/doctors/`, `/doctors/<slug>/` | `archive-doctor.php`, `single-doctor.php` |
| `/procedures/<slug>/` | `single-procedure.php` + `procedure.css` |
| `/about/` | page with template `page-governance.php` |
| `/international-patients/` | page with template `page-international.php` |
| `/contact/` | page with template `page-contact.php` |

### Code map (`wp-content/themes/walid-child/`)

| File | What it does |
|---|---|
| `style.css` | Theme header. **`Version:` busts every CSS/JS cache**; bump it on every release. |
| `functions.php` | Enqueues, WhatsApp numbers (`WALID_WA_GENERAL`, `WALID_WA_MINOR_SURGERY`), brand footer, floating WhatsApp button, self-hosted font loading, ACF shim, motion flag. |
| `inc/helpers.php` | Shared helpers: stats, WhatsApp links, socials, reviews, countries + flags, photos, video strip, parent footer removal, sample-content switch. |
| `inc/parent-compat.php` | Astra overrides (palette, header, layout). |
| `inc/seo.php` | MedicalClinic schema per branch, Organization schema with rating, skip link. |
| `inc/google-reviews.php` | Live Google reviews per branch (needs an API key, section 11). |
| `inc/wa-tracking.php` + `assets/js/wa-track.js` | First-party WhatsApp click counter, no cookies or personal data. Report: wp-admin > Tools > WhatsApp clicks. |
| `inc/content-import.php` + `inc/content-data.php` | Content importer (wp-admin > Tools > Walid content): creates the bundled branches, services, doctors, procedure and reviews if missing, never changes existing posts, and can undo what it created. Also `wp walid import` / `wp walid undo` locally. |
| `inc/patterns.php` | Block patterns for the editor. |
| `acf-json/` | The 5 field groups (branch, doctor, procedure, review, service). |
| `assets/css/` | `brand.css` (tokens, footer, contrast, Astra fixes, video strip), `home.css`, `single.css`, `archive.css`, `procedure.css`, `enhance.css`, `motion.css` (inner-page motion). `homepage.css` is the old homepage and is no longer loaded. |
| `assets/js/` | `home.js` (homepage motion, counters, marquees), `motion.js` (inner pages), `reveal.js`, `services.js` (show-more toggles), `wa-track.js`. |
| `assets/fonts/` | Fraunces + Inter, self-hosted variable woff2 (SIL OFL). |
| `assets/img/` | See section 6. |

## 4. Content model (walid-cpts plugin + ACF)

| Type | URL base | Key fields |
|---|---|---|
| **Branch** | `/branches/` | full name, flagship, provides minor surgery, address, hours (repeater), phone, branch WhatsApp, map embed, Google Place ID, photos, services, doctors. Taxonomy **Region**: `Central (Klang Valley)`, `North (Penang / Kedah)`, `Other`. |
| **Service** | `/services/` | pillar weight, WhatsApp routing (general / minor surgery), short description, image, procedures (one per line, `Name \| one-line explainer`), lead doctor, branches. Taxonomy **Pillar**: `Minor Surgery`, `Aesthetics`, `Antenatal & Women's Health`, `General Medicine`. |
| **Doctor** | `/doctors/` | role, leadership flag, qualifications, photo, bio, branches, lead-specialist-for (services). |
| **Procedure** | `/procedures/` | summary, image, parent service, WhatsApp routing, what it is, note, methods (repeater), what to expect (repeater), questions, branches. |
| **Review** | not public | quote, author, rating, source, source URL, **permission** (must be on to show), branch. Extra meta (not in the form): `review_pillar` (pillar name, for pillar-tailored testimonials), `review_international` (1 = shown first on International Patients). |

Names matter in two places: the pillar and region **term names** above are matched by text, and the Minor
Surgery service must have the slug `minor-surgery` for the homepage tile and hero photo to link to it.
Field-by-field entry guide: `docs/CONTENT-CHECKLIST.md`. Procedure page spec: `docs/14-procedure-pages.md`.

## 5. Automatic and conditional behaviour

| Behaviour | Rule |
|---|---|
| Sample content | Sample review quotes, the illustrative day-care figures (92% / 70%) and placeholder doctor copy render **only when `WP_DEBUG` is on** (`walid_show_samples()`). Live has it off, so it never publishes invented reviews or numbers. |
| Reviews | Shown only for Review posts with **permission** on, ordered by the Order field. Branch pages show only that branch's reviews. Branch rating badges use a Google Maps snapshot stored on each branch (`branch_google_rating`, `_count`, `_name` post meta, 16 Nov 2026); with a Google key + Place ID, live Google data replaces it. |
| Day-care donuts | Hidden on live until real figures are set in `walid_daycare_stats()` (`inc/helpers.php`). |
| Specialist band (home) | Appears only when the antenatal service's lead doctor has a **real photo** and role. |
| Service hero image | Minor Surgery pillar: the surgeon photo. Others: the service's own image, else the pillar's navy/gold texture. Never the placeholder label. |
| Branch hero image | First branch photo, else the neutral clinic still. |
| WhatsApp routing | Minor-surgery services and branches route to 017-549 7593; everything else to 014-252 1684. |
| Video strip | 4 Shorts from Dr Walid's YouTube (`walid_video_items()`), on `/services/` and Minor Surgery. Thumbnails are self-hosted; the YouTube player (privacy-enhanced) loads only when tapped. |
| Motion | All motion respects reduced-motion settings; content shows anyway if JavaScript fails. |
| Parent footer | Astra's "Powered by Astra" bar is removed; the brand footer carries the legal line. |

## 6. Design system and assets

- Tokens live in `assets/css/brand.css` (`:root`) and `theme.json`. Pillar accents: Minor Surgery soft blue,
  Aesthetics mauve, Antenatal rose, General Medicine teal (`.walid-minor`, `.walid-aesthetic`, `.walid-antenatal`, `.walid-general`).
- Contrast: inner-page headings are navy; small gold text uses `--gold-700 #8A6A0F`. The brand gold `#C9A227` is
  only 2.4:1 on white, so keep it for rules, icons and large accents, not small text.
- Fonts are self-hosted on purpose: the SureCookie banner blocks Google Fonts until consent, which made first-time
  visitors see Georgia and Arial.

| Asset folder | Contents | Source / rules |
|---|---|---|
| `img/cards/` (8) | Navy/gold abstract textures for service cards | Generated on Magnific (715 credits, logged in `docs/CREDIT-LEDGER.csv`) |
| `img/photos/` (4) | `surgeon-bright` (home hero), `consult` ("Talk to us"), `surgeon-dark` (International), `surgeon-loupe` (Minor Surgery hero) | Owner-supplied stock, all captioned "illustrative image". **Check licences** (section 11). |
| `img/flags/` (32) | Country flags | Public domain (flagcdn), self-hosted because emoji flags show as letters on Windows |
| `img/videos/` (4) | YouTube thumbnails | Cropped from Dr Walid's channel |
| `img/home/clinic.webp` | Neutral waiting-room still | Branch hero fallback |
| `img/placeholder-*.svg` | Placeholders | Still used for doctor photos and procedure images until real ones exist |
| `assets/logo.jpg` | Real logo | The live header logo is set separately in Astra's Customizer |

The country list for the flag strip and the International page is `walid_international_countries()` in `inc/helpers.php`.

## 7. Developer reference

**Filters:** `walid_stats`, `walid_home_hero_image`, `walid_service_hero_image`, `walid_branch_count` (default 10),
`walid_international_countries`, `walid_video_items`, `walid_proof_videos`, `walid_daycare_stats`, `walid_show_sample_content`.

**Conventions** (also in `.kiro/steering/build-conventions.md`): PHP 8.2+, WordPress coding standards, prefix
`walid_`, escape on output, i18n-wrap strings with the `walid` text domain, no em-dashes in copy, every social
icon needs a real link, bump `Version:` in `style.css` on every release.

## 8. Run it locally

```bash
docker compose up -d                                   # WordPress at http://localhost:8080
docker compose run --rm wpcli wp <command>             # WP-CLI
python3 -m http.server 8090                            # from the repo root: prototypes + docs-viewer.html on :8090
```

- Local runs with `WP_DEBUG` on, so sample reviews and figures appear there and nowhere else.
- Sample content: `docker compose run --rm wpcli wp eval-file /scripts/seed-sample-content.php` (add `-- --purge`
  to remove). **Never run it on live.**
- Lint PHP inside the container (the Mac has no PHP): `docker compose exec -T wordpress php -l /var/www/html/wp-content/themes/walid-child/<file>`.
- Kadence is still installed locally but inactive. Nothing uses it.
- Full setup notes: `docs/DEV.md`.

## 9. Deploy

There is no SSH on IONOS, so WP-CLI cannot run on live. Deploy the theme as a zip; no SFTP needed.

1. Bump `Version:` in `style.css`, commit, push.
2. Build the zip from the commit (uploads only tracked files, so stray working-tree files never ship):
   `git archive --format=zip --prefix=walid-child/ -o dist/walid-child-<version>.zip HEAD:wp-content/themes/walid-child`
3. Test it on a clean Astra install if the change touches PHP (a throwaway Docker stack on port 8095 was used for 0.4.x).
4. wp-admin > Appearance > Themes > Add New Theme > Upload Theme > choose the zip > **Replace installed with uploaded**.
5. Purge any cache, then check the pages in section 10.

- **Rollback:** upload the previous version's zip the same way. `dist/walid-child-0.1.0-rollback.zip` is a
  byte-verified copy of the pre-16-Nov live theme; rebuild any version from git with step 2. `dist/` is not in git.
- Menus, pages, the logo and header settings live in the database and are not touched by a theme upload.
- The `walid-cpts` plugin and the ACF field groups have not changed since the first live deploy. If they change,
  deploy the plugin the same way (Plugins > Add New > Upload) and save Settings > Permalinks once.
- **Credentials** (SFTP, database, wp-admin) live only in the IONOS panel. Non-secret: SFTP host
  `access-5021078157.webspace-host.com`, port 22, user `su703680`; database `dbs15968559` (MariaDB 10.11).
  Never put a password in the repo or the docs.

## 10. Post-deploy check (what was verified on 16 Nov)

- All public pages return 200 with no PHP errors: `/`, `/services/`, `/branches/`, `/doctors/`, `/about/`,
  `/international-patients/`, `/contact/`, `/procedures/`.
- No `[confirm ...]` or `[permission pending]` text, no "Powered by Astra".
- Solid header, navy palette (`--ast-global-color-0: #232B8F`), Fraunces + Inter served from the theme.
- Header "WhatsApp The Clinic" button is WhatsApp green.
- Phone width: menu opens, nothing scrolls sideways.

## 11. Owner to-do (blocks launch)

**Content (wp-admin, no code):**
- [ ] Branches 7 to 10 (names unknown) and branch photos. The 6 existing branches got their address, phone and hours from Google Maps on 16 Nov; check them.
- [ ] **HQ question:** the site calls Ampang the flagship HQ, but Google Maps lists "Poliklinik Walid Jalan Baru (HQ)". Confirm which is right.
- [ ] Services under the right pillars; the Minor Surgery service with slug `minor-surgery`.
- [ ] Dr Walid and Dr Anis: exact credentials, **real photos** (Dr Anis's photo turns on the homepage specialist band). Roles are set to "Principal doctor, minor surgery" and "Antenatal & women's health" until confirmed.
- [ ] The 10 Google reviews were published on 16 Nov at the owner's request (first name + initial, linked to Google). They are all from the Ampang listing; add reviews from the other branches the same way (Reviews > Add New, tick permission).
- [ ] Procedure pages (Xanthelasma is the worked example; real clips exist in `assets/proc/`, not yet used).

**Confirmations:**
- [ ] Day-care figures (same-day %, local anaesthetic %) if they should be shown.
- [ ] Minor Surgery category grouping on `/services/` (set in `archive-service.php`).
- [ ] The 4th pillar (still undefined) and the aesthetics launch scope.
- [ ] WhatsApp numbers and the 1466692-A registration number (both already used site-wide).

**Accounts and licences:**
- [ ] **Change the wp-admin password.** It was shared in chat on 16 Nov to run the deploy.
- [ ] Stock photo licences: free Freepik licences require an attribution credit. The home hero file's metadata says
  "veterinarian surgery"; the Minor Surgery hero was a dental photo (patient cropped out). Swap either if needed.
- [ ] Google Places API key + Place ID per branch for live reviews (`docs/GOOGLE-REVIEWS.md`).
- [ ] A WordPress core update (7.1.4) is offered in wp-admin; take a backup first.

## 12. Known issues and decisions waiting

| Item | Note |
|---|---|
| **LatePoint booking plugin is active on live** | Conflicts with the WhatsApp-only rule. It is not linked anywhere by the theme. Owner to decide: deactivate, or keep for internal use. Not changed. |
| Cookie banner covers part of the hero on phones | SureCookie's position and layout are plugin settings (wp-admin > SureCookie). |
| Homepage tiles for Aesthetics, Antenatal, General link to `/services/` | They have no dedicated pages yet. |
| Branch count "10" is fixed text | Filter `walid_branch_count` once the real count is confirmed. Only 6 branches exist on the site. |
| Review count | The homepage says "4.9 from 1,130 Google reviews" (Ampang's listing). Across the 6 Google listings there are about 4,380 reviews averaging 4.8, an option if you want a group-wide figure. |
| Click tracking counts only `wa.me` links | The header button uses `wasap.my`, so its clicks are not counted. Change the button link to `https://wa.me/60142521684` in Astra's header settings, or extend `wa-track.js`. |
| Tested on Astra 4.14.3 only | After an Astra update, re-check the header, footer and full-width layout. |
| Old docs | `HANDOFF-OMP.md`, `docs/DEPLOY-BATCH-*.md`, `docs/DEPLOY-IONOS.md` and `docs/DEPLOY.md` describe the SFTP era; `*.bak.kadence-port` files are pre-Astra copies. Kept for history; this file wins where they disagree. |
| Leftovers | `bin/set-palette.php` writes a palette Astra reads off by one slot (harmless: `parent-compat.php` overrides it). Empty `side/` folder at the repo root. `assets/css/homepage.css` and the `walid_category_icon()` helper are unused. |
| One supplied photo not used | `group-surgeons-are-performing-surgery-hospital.jpg` is tagged AI-generated in its metadata. |

## 13. Working on this repo (people and agents)

- Several agents (Kiro, OMP) and the owner share one working tree. **Stage only the files you changed**
  (`git add <path>`, never `git add -A`), and run `git branch --show-current` before committing.
- The repo is for Dr Walid / Poliklinik Walid only. Unrelated side projects go elsewhere.
- Log every paid image or video generation in `docs/CREDIT-LEDGER.csv`, and get the owner's explicit go-ahead first.
- Never put patient data (for example Remedi exports) in prompts, the repo or the site.
- Keep decisions in `/docs` and the "Where we are" section of `.kiro/steering/project-context.md`, not only in chat.

## 14. Document index

| Need | Read |
|---|---|
| Why the site is built this way | `docs/00-project-brief.md`, `docs/09-value-proposition.md` |
| Brand rules and status, auto-loaded for agents | `.kiro/steering/project-context.md` |
| Sitemap, wireframe, content model | `docs/04-sitemap.md`, `docs/12-homepage-wireframe.md`, `docs/05-content-model.md` |
| Design tokens | `docs/07-design-system.md` (tokens now live in `brand.css`) |
| Owner decisions and open questions | `docs/08-owner-decisions.md` |
| Entering content | `docs/CONTENT-CHECKLIST.md`, `docs/UPDATING.md` |
| Procedure pages | `docs/14-procedure-pages.md` |
| Google reviews | `docs/GOOGLE-REVIEWS.md` |
| Image generation rules and prompts | `docs/HIGGSFIELD-OMP-GUIDE.md` |
| Last deploy (0.4.4 guide; 0.4.6 followed the same steps) | `docs/DEPLOY-0.4.4.md` |
| Rendered docs in a browser | http://localhost:8090/docs-viewer.html |

## 15. Version history

| Version | Date | What |
|---|---|---|
| 0.1.0 | 31 Oct | First live deploy, Concept AB design, ported Kadence to Astra. Live until 16 Nov. |
| 0.2.x | 1 to 2 Nov | Pillar colours, services rework, category cards, generated card art, flag grid, FAQ. |
| 0.3.x | 6 to 15 Nov | Stats count-up, video strip, footer credit removal, responsive fixes. |
| 0.4.0 to 0.4.4 | 6 to 16 Nov | Concept 4 homepage, motion layer, WhatsApp click tracking, International section, photos, contrast, Astra compatibility. |
| 0.4.5 | 16 Nov | Sample content only in development. **Deployed.** |
| 0.4.6 | 16 Nov | Self-hosted fonts, header WhatsApp button colour. Deployed. |
| 0.4.7 | 16 Nov | Content importer, branch ratings and hours, 10 Google reviews, review count 1,130. **Deployed + content imported, current.** |
