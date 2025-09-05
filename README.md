Vibing Oreo — Personal App Showcase

This repository was created to showcase the apps I built. It's a lightweight Laravel scaffold (Blade views + small client-side enhancements) intended for local development and quick demos.

Highlights
- Simple, mobile-first Blade templates for a public gallery of apps.
- Auth-protected admin area with CRUD for app entries.
- SQLite-ready seeders with example data (10+ demo apps) and an admin user.
- Playful UI touches (sparkles, Oreo graphic, ripple effect) added for demo polish.

Quick start (Docker)

Option A — docker compose (recommended for dev stack)
1. Copy `.env.example` to `.env` and edit if you want different DB credentials:

```bash
cp .env.example .env
```

2. Start the app and a MySQL service with Docker Compose:

```bash
docker compose up --build
```

3. Visit http://127.0.0.1:8000

Option B — single-container quick run (no DB service, uses SQLite or local DB)
```bash
cd /e/Github/showcase_v1/laravel_app
docker run --rm -p 8000:8000 -v E:/Github/showcase_v1/laravel_app:/app -w /app php:8.2-cli \
	bash -lc "composer install --no-interaction || true; php artisan serve --host=0.0.0.0 --port=8000"
```

If you started with `docker compose up`, the compose file will run migrations and seeders automatically (it uses the MySQL service configured in `docker-compose.yml`).

Seeded admin credentials (development only)
- Email: admin@example.com
- Password: password

File map (top-level)
- `app/` — controllers, models, middleware
- `database/` — migrations & seeders (includes AppsTableSeeder)
- `resources/views/` — Blade templates (layout, home, admin)
- `public/assets/` — images, small JS/CSS used by the demo

Notes and next steps
- Tailwind is included via CDN for the demo; for production, install Tailwind via PostCSS or the CLI.
- If you want, I can add a short `docker-compose.yml`, a small RequestTimer middleware for dev profiling, or expand this README with deploy steps.

License
- MIT

If you'd like additional sections (deploy, compose file, or local dev shortcuts), tell me which and I'll add them.
