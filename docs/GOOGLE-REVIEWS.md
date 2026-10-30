# Live Google reviews (per branch)

Branch pages can show live Google reviews + the branch's real rating, pulled from the Google
Places API and cached. It is **off by default** and degrades gracefully: with no key, branch
pages use curated CPT reviews, then a "Read reviews on Google" link.

## What it does / its limits
- Shows the branch's **overall rating + total count** and **up to 5 reviews** (Google's API hard
  limit, you cannot pull all 1,098 via the API).
- Results are **cached for 12 hours** (transient) for speed and to stay within quota. Google's
  terms disallow long-term storage, so we do not persist them.
- Falls back automatically: live Google → curated CPT reviews → "Read reviews on Google" link.

## Setup (3 steps)

### 1. Get a Google API key
1. Go to the Google Cloud Console → create/select a project.
2. Enable the **Places API (New)**.
3. Create an **API key**. Restrict it: Application restriction = none or your server IP;
   API restriction = Places API (New). (Billing must be enabled; Google gives a monthly credit.)

### 2. Add the key to wp-config.php (never commit it)
Add above the "stop editing" line in `wp-config.php` on the host:
```php
define( 'WALID_GOOGLE_PLACES_KEY', 'your-api-key-here' );
```
Locally (Docker), add it to `wp-content` via the container, or temporarily:
```bash
docker compose run --rm wpcli wp config set WALID_GOOGLE_PLACES_KEY 'your-key' --type=constant
```

### 3. Add each branch's Place ID
1. Find it with the Place ID Finder:
   https://developers.google.com/maps/documentation/places/web-service/place-id
   (search the branch, copy the `ChIJ...` ID).
2. In wp-admin → Branches → edit a branch → **Google Place ID** field → paste → update.

That's it. The branch page shows live reviews within 12h (or immediately after a cache flush).

## Maintenance
- Flush the cache after changing keys/Place IDs:
  ```bash
  docker compose run --rm wpcli wp eval 'walid_flush_google_reviews();'
  ```
- If reviews stop showing, check: key valid + Places API (New) enabled + billing on + Place ID
  correct. On failure the code caches an empty result for 1h and falls back to CPT reviews.

## Cost note
The Places API is pay-per-call but **caching makes this tiny**: at most one call per branch per
12h. With ~10 branches that is ~20 calls/day, well within Google's free monthly credit.

## Attribution
Google requires attribution when showing their reviews. The template labels them "Live from
Google" and links to the branch's Google listing. Keep that.
