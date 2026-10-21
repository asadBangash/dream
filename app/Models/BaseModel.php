<?php


namespace App\Models;


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class BaseModel extends Model
{
    /** System / lookup tables: shared across branches (not filtered by branch_id). */
    protected static array $branchScopeExcludedTables = [
        'roles',
        'settings',
        'genders',
        'gender_translates',
        'talent_test_applications',
        'online_admissions',
        'sessions',
        'session_translates',
        'classes',
        'class_translates',
        'sections',
        'section_translates',
        'class_section_translates',
        'shifts',
        'shift_translates',
        'subjects',
        'class_setups',
        'class_setup_childrens',
        'subject_assigns',
        'subject_assign_childrens',
        'time_schedules',
        'class_rooms',
        'events',
    ];

    protected static function boot()
    {
        parent::boot();

        if (hasModule('MultiBranch')) {
            static::addGlobalScope('branch_id', function (Builder $builder) {
                if (! auth()->check()) {
                    return;
                }

                $table = $builder->getQuery()->from;
                if (in_array($table, static::$branchScopeExcludedTables, true)) {
                    return;
                }

                $branchId = effectiveBranchScopeId();

                if (! $branchId || ! Schema::hasColumn($table, 'branch_id')) {
                    return;
                }

                if ($table === 'session_class_students') {
                    $builder->whereHas('student', function (Builder $query) use ($branchId) {
                        $query->withoutGlobalScopes()->where('branch_id', $branchId);
                    });

                    return;
                }

                $builder->where(function (Builder $scoped) use ($table, $branchId) {
                    $scoped->where("{$table}.branch_id", $branchId)
                        ->orWhereNull("{$table}.branch_id")
                        ->orWhere("{$table}.branch_id", 0);
                });
            });

            static::creating(function ($model) {
                if (! auth()->check()) {
                    return;
                }

                $table = $model->getTable();
                if (in_array($table, static::$branchScopeExcludedTables, true)
                    || ! Schema::hasColumn($table, 'branch_id')) {
                    return;
                }

                if ($model->branch_id === null || $model->branch_id === '') {
                    applyRequestBranchToModel($model);
                }
            });

            static::saving(function ($model) {
                $table = $model->getTable();
                if (! auth()->check()
                    || in_array($table, static::$branchScopeExcludedTables, true)
                    || ! Schema::hasColumn($table, 'branch_id')) {
                    return;
                }

                if ($model->branch_id) {
                    authorizeBranchId((int) $model->branch_id);
                }
            });
        }
    }
}
