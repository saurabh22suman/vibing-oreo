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
