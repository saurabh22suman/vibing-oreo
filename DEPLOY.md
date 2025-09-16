Dokploy / Dokku deployment notes

This project contains a Laravel app in `laravel_app/`. The repo includes a Dockerfile and an example `dokploy.yml` inside `laravel_app/` to help deploy to Dokku or use Dokploy.

Quick steps (Dokku/Dokploy)

1. Ensure your VPS has Dokku and dokploy configured according to your provider.
2. Push the repo to your dokku remote or use Dokploy tooling and point it to the `laravel_app/` Dockerfile.

Example (dokploy):
- Set `app` in `laravel_app/dokploy.yml` to your Dokku app name.
- Configure the environment variables in the dokploy file or via Dokku's `config:set`.
- Dokploy will build using the Dockerfile and run the `release.commands` to migrate and seed.

Notes
- The `Dockerfile` provided builds a PHP-FPM image and expects you to run it behind a webserver (nginx) or use Dokku's web container handling.
- For production, ensure you set `APP_KEY`, use secure DB credentials, and set `APP_DEBUG=false`.
- If you want a `dokku`-native Dockerfile (CMD starts server), I can change the Dockerfile to run `php artisan serve` directly.

## Production Notes

- Set `APP_URL` to your `https://` domain and ensure proxies are trusted via `TRUSTED_PROXIES`.
- Default production setup favors SQLite for simplicity: `DB_CONNECTION=sqlite` and `DB_DATABASE=/var/www/html/database/database.sqlite`.
- Ensure the database directory persists (via volume) or that your entrypoint creates the file before migrations.

### Temporary admin magic-link login

If locked out of the admin, enable a one-time, env-gated magic link:

1. Set env and redeploy:
	- `ADMIN_MAGIC_TOKEN=<strong-random-token>`
	- Optional: `ADMIN_MAGIC_TOKEN_TTL=10` (minutes, single-use cooldown)
2. Open: `https://YOUR_DOMAIN/admin/magic?token=<strong-random-token>`
3. You’ll be logged in as `ADMIN_EMAIL` and redirected to the admin dashboard.
4. Immediately remove `ADMIN_MAGIC_TOKEN` and redeploy to disable the route.

Notes:
- The route exists only when `ADMIN_MAGIC_TOKEN` is set.
- The token is marked used for the TTL to limit replay.
