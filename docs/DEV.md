# Local development (WordPress via Docker)

Reproducible local WordPress for the Poliklinik Walid build. Only our code is version-controlled
(`wp-content/themes/walid-child` + `wp-content/plugins/walid-cpts`); WordPress core, uploads, and
the database live in Docker volumes and are not committed.

## Prerequisites
- Docker (with Compose). Nothing else needed — PHP/MySQL/WP-CLI all run in containers.

## Start
```bash
cp .env.example .env        # first time only; adjust ports/creds if you like
docker compose up -d        # boots wordpress + db
```
Site: http://localhost:8080 (or your `WP_PORT`).

## Provision (first run)
Installs WordPress core, the Kadence parent theme, ACF, and Rank Math; activates our child theme
and CPT plugin. Safe to re-run.
```bash
docker compose run --rm wpcli bash /scripts/provision.sh
```

## Run WP-CLI
```bash
docker compose run --rm wpcli wp <command> --allow-root
# examples:
docker compose run --rm wpcli wp core version --allow-root
docker compose run --rm wpcli wp theme list --allow-root
docker compose run --rm wpcli wp post-type list --allow-root
```

## Stop / reset
```bash
docker compose down           # stop, keep data
docker compose down -v        # stop and DELETE the db + core volumes (fresh start)
```

## Notes
- Edit theme/plugin files in the repo — changes are live-mounted into the container.
- `wp-content/themes/walid-child` and `wp-content/plugins/walid-cpts` are the only tracked paths
  under `wp-content/`; `acf-json/` (field definitions) is also tracked.
- This mirrors the environment OMP/other agents should use, so the build is identical everywhere.
