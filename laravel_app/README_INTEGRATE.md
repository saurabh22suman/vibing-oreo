Integration guide — Personal App Showcase Scaffold

Goal: integrate this scaffold into a real Laravel project.

Prerequisites:
- PHP 8.1+ and extensions
- Composer
- A web server (or use `php artisan serve`)
- Optional: Node.js if you want to build custom assets (not required; scaffold uses CDN)

Steps:

1) Create a new Laravel project (or use existing):

   composer create-project laravel/laravel my-showcase
   cd my-showcase

2) Copy scaffold files into your project root, merging into the Laravel structure.
   For example, from this repo root run a copy script, or manually copy the following folders/files:
   - app/Models/AppItem.php -> app/Models/
   - app/Http/Controllers/* -> app/Http/Controllers/
   - database/migrations/* -> database/migrations/
   - database/seeders/AppsTableSeeder.php -> database/seeders/
   - routes/web.php -> routes/web.php (merge or append)
   - resources/views/* -> resources/views/
   - public/assets/* -> public/assets/

3) Install composer dependencies and run migrations:

   composer install
   cp .env.example .env
   php artisan key:generate
   php artisan migrate --seed
   php artisan storage:link

4) Add authentication for the admin panel (recommended):

   # Laravel Breeze example
   composer require laravel/breeze --dev
   php artisan breeze:install
   npm install && npm run dev   # optional, for frontend auth scaffolding
   php artisan migrate

   The admin routes in the scaffold expect the `auth` middleware to be present.

5) Serve locally:

   php artisan serve

6) Deployment notes:
- Configure a production database in `.env` and run migrations there.
- Use a production webserver like nginx + php-fpm.
- Use queue workers, caching, and an object storage for images for scale.

If you want, I can also create a full composer-driven Laravel project here (it requires Composer and PHP available on this machine); tell me and I'll scaffold and attempt to run migrations.
