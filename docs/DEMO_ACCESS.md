# Dream Tuition Academy — Demo access (local)

Set `APP_DEMO=true` in `.env`, then:

```bash
php artisan app:setup --fresh
php artisan storage:link
php artisan optimize:clear
```

**Demo password (all accounts below):** `123456`

**Login URL (all roles):** `{APP_URL}/login` (local: `http://dream.test/login`)

| Portal | Email | After login |
|--------|-------|-------------|
| Super Admin | `superadmin@example.com` | Admin dashboard |
| Boys Branch Admin | `boysadmin@example.com` | Admin dashboard (Boys data only) |
| Girls Branch Admin | `girlsadmin@example.com` | Admin dashboard (Girls data only) |
| Boys Student | `boys.student@example.com` | `/student-panel-dashboard` |
| Girls Student | `girls.student@example.com` | `/student-panel-dashboard` |
| Boys Staff (Teacher) | `boys.teacher@example.com` | Admin dashboard (teacher permissions) |
| Girls Staff (Teacher) | `girls.teacher@example.com` | Admin dashboard (teacher permissions) |

Verify branch isolation:

```bash
php artisan demo:verify-branch-isolation
```

## Production

- **Empty database:** `composer install --no-dev`, configure `.env`, then `php artisan app:setup` with `APP_DEMO=true` only if you want demo data on production.
- **Existing live data:** do **not** run `app:setup --fresh` or `migrate:fresh`. Add branches/users manually or run targeted seeders after backup.

Safe on production (non-destructive): `php artisan migrate`, `php artisan config:cache`, `php artisan route:cache`, `php artisan view:cache`.
