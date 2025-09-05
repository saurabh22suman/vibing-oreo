#!/usr/bin/env bash
# Setup local Laravel project and merge scaffold (runs locally - requires php & composer)
set -e
ROOT=$(pwd)
PROJECT_DIR="$ROOT/laravel_project"

if [ -d "$PROJECT_DIR" ]; then
  echo "Project directory $PROJECT_DIR already exists. Aborting to avoid overwrite." >&2
  exit 1
fi

composer create-project laravel/laravel "$PROJECT_DIR" --prefer-dist
cd "$PROJECT_DIR"

# Copy scaffold contents into project
rsync -a --exclude vendor --exclude node_modules "$ROOT/scaffold/" .

# Ensure .env and key
cp .env.example .env
php artisan key:generate

# Use SQLite for quick local setup
touch database/database.sqlite
sed -i "s/DB_CONNECTION=.*/DB_CONNECTION=sqlite/" .env
sed -i "s/DB_DATABASE=.*/DB_DATABASE=database\/database.sqlite/" .env || true

composer install
php artisan migrate --seed
php artisan storage:link

echo "Setup complete. Run: php artisan serve --host=127.0.0.1 --port=8000"
