# Updating the site (after it is live)

> How to change things once `poliklinikdrwalid.com` is live on IONOS. The golden rule:
> **content lives in the database/CMS; code lives in git (theme + plugin).** They update
> separately, so changing one never risks the other.

## What is NOT in git (lives only on the server)
WordPress core · the database (all branches, doctors, services, reviews, pages, settings) ·
`wp-content/uploads` (all images). You can redeploy the theme/plugin any number of times without
touching this. **This is why updates are safe.**

## What IS in git (the only things you deploy)
```
wp-content/themes/walid-child/     (design, templates, CSS, JS, acf-json field defs)
wp-content/plugins/walid-cpts/     (the Branch/Service/Doctor/Review/Procedure content model)
```

---

## Two kinds of change

### A. Content change → NO deploy. Just edit in wp-admin on the live site.
Examples: add/edit a branch, doctor, service, procedure page, review; change hours/phone/photos;
fix a typo in CMS text; add a procedure explainer; set a Google Place ID.
→ Log into wp-admin, edit, Update. Done. Zero risk, nothing to upload.

### B. Code change → deploy the changed file(s) via SFTP.
Examples: design/layout tweaks, CSS/colour changes, new section in a template, a new field, new
functionality, a new CPT.
→ The change is made in this repo, committed, then the changed files are uploaded to the server.

---

## Small change vs big change (both are code changes, same tools)

| | Small | Big |
|---|---|---|
| Example | tweak CSS colour, fix spacing, edit template copy | new CPT, new ACF field, new section type, redesign |
| Files to upload | usually 1 (e.g. a `.css`) | several (template + CSS + maybe plugin/acf-json) |
| Extra admin step | none (hard-refresh / purge cache) | sometimes: Permalinks→Save (new URLs), nothing for ACF JSON (auto-syncs) |
| Risk | low | medium → test on **staging** first |

The mechanism is identical: overwrite the changed files via SFTP. "Big" just means more files and
a bit more care.

---

## The safe update workflow (recommended)

1. **Make the change in the repo** (local Docker), verify at `localhost:8080`, commit, push.
   (If an agent/dev does this, you just pull the latest.)
2. **Deploy to IONOS staging first** (Managed WordPress has a staging site). Upload the changed
   files there via SFTP, or pull via SSH if available.
3. **Verify on staging** (the page you changed + a quick click-through).
4. **Promote staging → live.**
5. If something looks wrong after going live: revert to the previous git commit and re-upload the
   files. Content is untouched because it is not in git.

### Minimal deploy (no staging, small fix)
For a one-file CSS tweak you are confident in: SFTP-upload just that one file to
`wp-content/themes/walid-child/assets/css/…`, then purge IONOS cache / hard-refresh. That is the
whole update.

---

## Specific update recipes

- **Change a colour / spacing / look:** edit the relevant file in
  `walid-child/assets/css/` (brand.css = tokens; homepage.css / single.css / archive.css /
  procedure.css / enhance.css = sections). Upload that file. Purge cache.
- **Edit template copy/markup:** edit the `.php` template (e.g. `front-page.php`,
  `single-procedure.php`). Upload it.
- **Add a new ACF field:** add/export the field; the JSON lands in `walid-child/acf-json/`.
  Upload that JSON file → the field appears automatically (ACF local JSON auto-registers). No
  manual admin field setup.
- **Add a new CPT or change a slug:** edit `walid-cpts/walid-cpts.php`, upload it, then in
  wp-admin go Settings → Permalinks → Save (flushes rewrite rules so new URLs resolve).
- **New procedure/branch/doctor page:** that is CONTENT → just add it in wp-admin. No deploy.
- **Swap the logo:** replace `walid-child/assets/logo.jpg` (same filename) via SFTP. Done.
- **Update a plugin (Kadence/ACF/Rank Math):** normal wp-admin → Plugins → Update. Our code does
  not change.

---

## Versioning / rollback
- Every change is a git commit on `blackpanthera23/walid-website`. That is your version history.
- To roll back: check out the previous commit's version of the changed file(s) and re-upload them.
- Bump the theme `Version:` in `style.css` (and plugin `Version:`) on meaningful releases so you
  can tell what is deployed. Cache-busting uses the theme version, so bumping it also forces
  browsers to reload CSS/JS.

## Golden rules
- Never edit code directly on the live server (changes get lost + untracked). Edit in the repo,
  deploy. (One exception: a genuine emergency one-line fix — then back-port it to git immediately.)
- Never put the DB or uploads in git. Never commit secrets (API keys, passwords).
- Test big changes on staging. Keep a backup before any big deploy (IONOS auto-backups + a manual
  one before big releases).
