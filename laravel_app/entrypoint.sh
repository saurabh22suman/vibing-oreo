#!/usr/bin/env bash
set -e

DB_CONNECTION_ENV=${DB_CONNECTION:-}

if [[ "$DB_CONNECTION_ENV" == "sqlite" ]]; then
  echo "Using SQLite; skipping MySQL wait."
  # Ensure sqlite database file exists
  DB_PATH=${DB_DATABASE:-/var/www/html/database/database.sqlite}
  if [[ ! -f "$DB_PATH" ]]; then
    echo "Creating SQLite database at $DB_PATH"
    mkdir -p "$(dirname "$DB_PATH")"
    touch "$DB_PATH"
    chown -R www-data:www-data "$(dirname "$DB_PATH")"
  fi
else
  # wait-for-db: try until mysql is available
  host="${DB_HOST:-db}"
  port="${DB_PORT:-3306}"

  echo "Waiting for DB at $host:$port..."
  for i in {1..30}; do
    if nc -z "$host" "$port" >/dev/null 2>&1; then
      echo "DB is up"
      break
    fi
    echo "Waiting for DB... ($i)"
    sleep 2
  done
fi

# Install PHP dependencies if vendor is missing
if [[ ! -d vendor ]]; then
  echo "Installing Composer dependencies"
  composer install --no-interaction || true
fi

# run migrations and seeders
echo "Running migrations and seeders"
php artisan migrate --force || true
php artisan db:seed --class=DatabaseSeeder --no-interaction || true

# ensure storage symlink
if [[ ! -e public/storage ]]; then
  php artisan storage:link || true
fi

# start the dev server
php artisan serve --host=0.0.0.0 --port=8000
