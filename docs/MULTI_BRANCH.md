# Multi-branch access model

## Roles

| Role | Access |
|------|--------|
| **Super Admin** (role 1) | All branches; branch switcher in header; can manage branches |
| **Branch Admin** (role 2 + `branch_id`) | Own branch only; no switcher |

## Super Admin branch switcher

Header: **All Branches** or a specific branch. Selection is stored in session (`active_branch_id`), not by changing the user record.

## Clean production database

```bash
APP_DEMO=false
php artisan app:setup --fresh
```

Creates super admin (`superadmin@<APP_DOMAIN>` / `123456` by default) and **Main Campus** branch.

## Remove demo data from an existing DB

```bash
php artisan demo:purge --force
php artisan db:seed --class=BranchBootstrapSeeder
```

## QA test data (optional)

```bash
php artisan db:seed --class=BranchIsolationTestSeeder
php artisan demo:verify-branch-isolation
```

## Assign branch admin when creating a branch

Super Admin → Branches → Create → **Assign existing staff/admin** or create new credentials.
