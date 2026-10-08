# Multi-branch data isolation

## Architecture

| Layer | Mechanism |
|-------|-----------|
| **Query filter** | `BaseModel` global scope uses `effectiveBranchScopeId()` |
| **Super Admin filter** | Header switcher → session `active_branch_id` (`null` / `all` = no filter) |
| **Branch Admin** | `users.branch_id` only; no switcher |
| **HTTP writes** | `EnforceBranchScope` merges `branch_id` for branch admins; pre-fills from session for Super Admin |
| **Validation** | `App\Rules\BranchUnique` + `branchIdValidationRules()` on create forms |
| **Forms** | `<x-branch-field />` for Super Admin; hidden inject from header in `master.blade.php` fallback |
| **Save guard** | `authorizeBranchId()` on `BaseModel::saving` |

## Helpers

- `effectiveBranchScopeId()` — current list/create scope
- `superAdminActiveBranchId()` — session branch filter (Super Admin)
- `branchIdForPersist($request)` — branch to store on new records
- `branchIdValidationRules(true)` — `branch_id` required on create for Super Admin
- `resolveBranchIdForValidation($recordId, $table)` — scoped unique checks

## Super Admin

1. Use header **All Branches** to see everything, or pick a branch to filter lists.
2. On **create** forms, pick **Branch** (or rely on header selection + auto hidden field).
3. Records are stored with the chosen `branch_id` only.

## Branch Admin

- No branch picker; middleware sets `branch_id` automatically.
- Cannot view/edit other branches (global scope + 403 on tampered `branch_id`).

## Per-branch uniqueness

Names/codes are unique **within** a branch (e.g. Section A in Branch 1 and Branch 2).

Use in FormRequests:

```php
use App\Rules\BranchUnique;

'name' => ['required', new BranchUnique('sections', 'name')],
// update:
'name' => ['required', new BranchUnique('sections', 'name', (int) $this->route('id'))],
// with extra column (subjects):
new BranchUnique('subjects', 'name', null, null, ['type' => $this->input('type')]),
```

Add `<x-branch-field />` after `@csrf` on create views for Super Admin.

## Commands

```bash
php artisan demo:verify-branch-isolation
php artisan branch:sync-students          # fix live rows after branch filter issues
php artisan migrate --path=database/migrations/tenant/2026_10_07_120000_add_branch_composite_unique_indexes.php
```

### Super Admin sees students on “All Branches” but not when filtering

The student list reads `session_class_students`. Run `php artisan branch:sync-students` on the server after deploying the latest code so `students` and `session_class_students` `branch_id` values match the student user’s branch.

## Extending to more modules

1. Ensure model extends `BaseModel` and table has `branch_id`.
2. Replace `unique:table,column` with `BranchUnique` in Store/Update requests.
3. Add `branchIdValidationRules()` to Store requests.
4. Add `<x-branch-field />` to create blade (optional if header inject is enough).
5. Set `branch_id` on related `User` rows when not using `BaseModel`.
