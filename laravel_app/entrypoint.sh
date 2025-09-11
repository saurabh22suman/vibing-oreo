#!/usr/bin/env bash
set -e

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

# run migrations and seeders
echo "Running migrations and seeders"
php artisan migrate --force || true
php artisan db:seed --class=DatabaseSeeder --no-interaction || true

# start the dev server
php artisan serve --host=0.0.0.0 --port=8000
