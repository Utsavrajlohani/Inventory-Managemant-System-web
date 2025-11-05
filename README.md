# Mini-Project (Laravel)

This repository is a small Laravel application (project skeleton with products, sales, suppliers, and reporting). This README explains how to set up and run the project on Windows using the Command Prompt (cmd).

## Prerequisites

- PHP 8.1+ (or the version required by `composer.json`)
- Composer (https://getcomposer.org)
- A database (MySQL, MariaDB, PostgreSQL — configure in `.env`)
- Git (optional)

This project was developed for a standard Laravel workflow. The repo includes migrations and seeders under `database/migrations` and `database/seeders`.

## Quick setup (Windows Command Prompt - cmd)

Open a Command Prompt (cmd) in the project root (`Mini-Project\inventory-management-system`) and run:

```bat
REM install PHP dependencies
composer install

REM copy env and generate app key
copy .env.example .env
php artisan key:generate

REM create the database and set DB settings in .env before migrating
REM then run migrations and seeders
php artisan migrate --seed

REM create storage symlink for public files (may require Administrator privileges)
php artisan storage:link

REM compile frontend assets for development
npm run dev

REM run the app (defaults to http://127.0.0.1:8000)
php artisan serve
```

If you prefer a production JS build:

```bat
npm run build
```

## Running tests

Run the Laravel test suite from Command Prompt:

```bat
php artisan test
```

## Useful artisan / project scripts

- `php artisan migrate` — run migrations
- `php artisan migrate:fresh --seed` — reset DB and reseed
- `php artisan storage:link` — make storage publicly available
- `php artisan tinker` — interactive REPL

There is a `scripts/` directory with helper PHP scripts (for DB checks and population). See files such as `scripts/populate_user_ids.php` and `scripts/check_columns.php`.

## Environment notes

- Ensure `.env` DB settings (DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD) match your DB.
- On Windows, if you encounter permission issues, run Command Prompt as Administrator for commands that create links (e.g., `storage:link`) or enable Developer Mode to allow symlinks without elevation.

## Troubleshooting

- If configuration caching causes stale settings:

```bat
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear
```

- Composer memory issues on CI or low-memory environments:

```bat
php -d memory_limit=-1 C:\path\to\composer.phar install
```

(Adjust `C:\path\to\composer.phar` to your composer location.)

## Notes and next steps

- Routes are defined in `routes/web.php` and `routes/auth.php`.
- App models live under `app/Models/` (e.g., `Product.php`, `Sale.php`, `Supplier.php`, `User.php`).
- Migrations are under `database/migrations/` — new migrations from Nov 2025 are included in this repo.

If you'd like, I can:
- Add a minimal `docker-compose.yml` for a local DB and PHP environment.
- Add contributor / development guidelines.
- Run a quick validation (e.g., `php artisan --version`) in the workspace if you want automated verification.

---

If you want the README expanded with screenshots, API docs, or examples for specific flows (products, sales, reports), tell me which parts to expand and I will update it.
# Mini-Project (Laravel)

This repository is a small Laravel application (project skeleton with products, sales, suppliers, and reporting). This README explains how to set up and run the project on Windows using PowerShell.

## Prerequisites

- PHP 8.1+ (or the version required by `composer.json`)
- Composer (https://getcomposer.org)
- Node.js 16+ and npm (or pnpm/yarn)
- A database (MySQL, MariaDB, PostgreSQL — configure in `.env`)
- Git (optional)

This project was developed for a standard Laravel workflow. The repo includes migrations and seeders under `database/migrations` and `database/seeders`.

"# Inventory-Managemant-System-web" 
