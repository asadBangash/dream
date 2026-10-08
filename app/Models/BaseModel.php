<?php


namespace App\Models;


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class BaseModel extends Model
{
    /** System tables: shared across branches (roles default branch_id = 1). */
    protected static array $branchScopeExcludedTables = [
        'roles',
        'settings',
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
                    $builder->where(function (Builder $outer) use ($branchId) {
                        $outer->whereHas('student', function (Builder $query) use ($branchId) {
                            $query->withoutGlobalScopes()->where('branch_id', $branchId);
                        })->orWhereHas('class', function (Builder $query) use ($branchId) {
                            $query->withoutGlobalScopes()->where('branch_id', $branchId);
                        });
                    });

                    return;
                }

                $builder->where("{$table}.branch_id", $branchId);
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

                if (empty($model->branch_id)) {
                    $branchId = request()->input('branch_id') ?: effectiveBranchScopeId();
                    if ($branchId) {
                        $model->branch_id = (int) $branchId;
                    }
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
