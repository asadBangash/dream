# The Dream Tuition Academy — Setup & Deployment

Laravel 12 school management system for The Dream Tuition Academy, Peshawar, Pakistan (single-school mode).

## Requirements

- PHP 8.2+
- MySQL 8+
- Composer
- Node.js & npm (for frontend assets)

## Local Setup (Laragon)

1. Clone/copy the project to `D:\laragon\www\dream` (or your Laragon `www` folder).
2. Copy environment file and configure:
   ```bash
   copy .env.example .env
   php artisan key:generate
   ```
3. Create a fresh MySQL database (example: `dream`).
4. Update `.env` database settings:
   ```
   APP_NAME="The Dream Tuition Academy"
   APP_DOMAIN=dream.test
   DB_DATABASE=dream
   DB_USERNAME=root
   DB_PASSWORD=
   APP_URL=http://dream.test
   APP_SAAS=false
   APP_DEMO=false
   ```
5. Install dependencies:
   ```bash
   composer install
   npm install && npm run build
   ```
6. Initialize the database (migrations + essential seeders):
   ```bash
   php artisan app:setup --fresh
   ```
   For an existing database without wiping tables, omit `--fresh`:
   ```bash
   php artisan app:setup
   ```
7. Link storage and clear caches:
   ```bash
   php artisan storage:link
   php artisan optimize:clear
   ```
8. Point Laragon virtual host to `public/` (e.g. `http://dream.test`).

### Default Admin Login

After seeding (with `APP_DEMO=false`):

- **Email:** `superadmin@dream.test` (or `superadmin@` + your `APP_DOMAIN`)
- **Password:** `123456`

Change this password immediately after first login.

## Production Deployment

1. Deploy code from GitHub to the server.
2. Copy `.env.example` to `.env` and set production values (`APP_ENV=production`, `APP_DEBUG=false`, database, mail, etc.).
3. Run:
   ```bash
   composer install --no-dev --optimize-autoloader
   php artisan key:generate
   php artisan app:setup
   php artisan storage:link
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```
4. Set web server document root to `public/`.
5. Ensure `storage/` and `bootstrap/cache/` are writable.

**Do not import the bundled SQL dumps.** The schema is created entirely from Laravel migrations.

## Shared Hosting (no exec / proc_open / symlinks)

Hostinger and similar hosts often disable `exec()`, `proc_open`, and PHP `symlink()`.
You do **not** need `php artisan storage:link` if you follow this workflow.

### 1. Composer (skip post-install scripts)

```bash
composer install --no-dev --optimize-autoloader --no-scripts
php artisan package:discover --ansi
```

If `package:discover` also fails, run `composer install` on your **local PC** and upload
the whole project including `vendor/` and `bootstrap/cache/packages.php` + `services.php`.

### 2. `.env` for shared hosting

```env
FILESYSTEM_DISK=local
STORAGE_DIRECT_PUBLIC=true
APP_ENV=production
APP_DEBUG=false
APP_NAME="The Dream Tuition Academy"
APP_DOMAIN=yourdomain.com
APP_URL=https://yourdomain.com
```

`STORAGE_DIRECT_PUBLIC=true` stores public files in `public/storage/` directly — no symlink.

### 3. Create folders (instead of storage:link)

```bash
php scripts/create-storage-dirs.php
```

This only uses `mkdir()` — no exec, no symlinks.

### 4. Database setup from your local PC

On Laragon, temporarily point `.env` to the **live database**, then run:

```bash
php artisan app:setup --fresh
```

Restore local DB settings afterward. This avoids running migrations on the restricted server.

Alternatively, if `php artisan migrate` works on the server (it often does even when
`storage:link` fails), run:

```bash
php artisan app:setup --fresh
```

### 5. APP_KEY without artisan (if needed)

Local:

```bash
php artisan key:generate --show
```

Copy the output into the server `.env` as `APP_KEY=base64:...`

### 6. Permissions

Ensure these are writable (775 or 755 depending on host):

- `storage/`
- `bootstrap/cache/`
- `public/storage/`
- `public/backend/uploads/`

### 7. Do NOT run on shared hosting

| Command | Alternative |
|---------|-------------|
| `php artisan storage:link` | Set `STORAGE_DIRECT_PUBLIC=true` + run `scripts/create-storage-dirs.php` |
| `composer update` | Never on server; use `composer install` from lock file |
| Shell symlink `ln -s` | Not needed with `STORAGE_DIRECT_PUBLIC=true` |

## Notes

- The web installer at `/install` is bypassed once migrations have run and the `users` table exists.
- Set `APP_DEMO=false` to avoid demo/sample student and staff data during seeding.
- Disabled modules (e.g. `VehicleTracker`) are skipped automatically during setup.
- Default seeded settings use **PKR**, **Asia/Karachi** timezone, and **Peshawar** address — adjust in Admin → Settings after login.
