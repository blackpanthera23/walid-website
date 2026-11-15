# Deploy theme 0.4.4 to poliklinikdrwalid.com (replaces the live theme)

Live runs **walid-child 0.1.0** on **Astra** (checked 16 Nov: `style.css?ver=0.1.0`, brand.css and homepage.css
byte-identical to commit `69c6a23`). This upload replaces it with **0.4.4** (commit `93abab5`), which contains
everything built since: the Concept 4 homepage, the International section, the photos, the services/branches
rework, the YouTube strip, contrast fixes and the Astra compatibility layer. It supersedes
`DEPLOY-BATCH-UI-POLISH.md` and `DEPLOY-BATCH-HOME-V4.md`; no file-by-file SFTP is needed.

The `walid-cpts` plugin and the ACF field groups have not changed since live, so only the theme is uploaded.

## Files
| File | Purpose | SHA-256 |
|---|---|---|
| `dist/walid-child-0.4.4.zip` | the new theme | `b4573f6844a8dc2771537f09e1eee7f6780e2b5f3ebedcb0a8a3a13aa22d6f5b` |
| `dist/walid-child-0.1.0-rollback.zip` | exact copy of what is live now | `2453546cfc4bcce359795ff09f0db187eab02cb5a5960b4d0da39c4c74c685c8` |

Both are built with `git archive` from the commits above (`dist/` is not in git; rebuild with
`git archive --format=zip --prefix=walid-child/ -o dist/walid-child-0.4.4.zip 93abab5:wp-content/themes/walid-child`).

## Tested
- Installed from the zip onto a clean WordPress with Astra 4.14.3 + ACF + walid-cpts: every page 200, no PHP
  warnings with WP_DEBUG on, no "Powered by Astra" line, brand palette applied.
- Same test with live's saved Astra settings copied in (transparent header on, the green starter palette): the
  theme still renders the solid header and the navy/gold palette.
- Local site (localhost:8080) now runs on Astra too, like live. 11 pages x 3 widths (1440/768/390): no
  horizontal overflow.

## Steps (wp-admin, about 5 minutes, no SFTP needed)
1. **Back up first.** IONOS panel > your WordPress > Backups (or create a staging copy). Keep
   `dist/walid-child-0.1.0-rollback.zip` at hand as a second way back.
2. wp-admin > **Appearance > Themes > Add New Theme > Upload Theme**.
3. Choose `walid-child-0.4.4.zip` > **Install Now**.
4. WordPress says the theme is already installed. Click **Replace active with uploaded**.
5. If a cache plugin or IONOS caching is on, purge it. Hard-refresh the browser (Cmd/Ctrl + Shift + R).

Nothing else changes: menus (`primary` / `mobile_menu`), pages, the logo and the header WhatsApp button live in
the database and stay as they are.

## Check on live after upload
- `/`: solid white header (menu no longer overlaps the headline), surgeon photo in the arch, "Talk to us"
  consultation photo, **International patients** section with the 32-country flag strip, no "Powered by Astra".
- `/services/`: six Minor Surgery category cards, "See it explained" videos play when tapped.
- `/services/minor-surgery/`: surgeon photo hero; `/services/ent/`: navy/gold texture, no "placeholder" text.
- `/international-patients/`: photo + flag grid. `/about/`, `/contact/`, `/doctors/`, a branch page: load normally.
- Phone: open the menu, links work; nothing scrolls sideways.

## Rollback
Repeat steps 2-4 with `walid-child-0.1.0-rollback.zip`, or restore the IONOS backup.

## Behaviour on live that differs from local (by design)
- WP_DEBUG is off on live, so **sample review quotes do not show**. The reviews row appears only once reviews
  with permission are added (Reviews > edit > "permission" on).
- The antenatal specialist band appears only once Dr Anis has a real photo in her doctor profile.

## Images (owner-supplied stock, all labelled "illustrative image")
Before launch, confirm the licence for each in your stock account (Freepik-style files: the free licence requires
an attribution credit; a premium download does not).
- `photos/surgeon-bright.webp` (homepage hero): file metadata describes it as **veterinary** surgery, though nothing
  in the frame shows that. Replace if that matters to you.
- `photos/surgeon-loupe.webp` (Minor Surgery hero): originally a **dental** surgery photo; cropped so the patient's
  mouth is out of frame.
- `photos/consult.webp` ("Talk to us"), `photos/surgeon-dark.webp` (International; a real camera photo).
- Not used: `group-surgeons-are-performing-surgery-hospital.jpg`. Its metadata marks it as **AI-generated**
  (IPTC DigitalSourceType = trainedAlgorithmicMedia), which conflicts with the no-fake-clinic-imagery rule.
