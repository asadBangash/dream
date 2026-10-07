<?php


namespace App\Models;


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class BaseModel extends Model
{
    protected static function boot()
    {
        parent::boot();

        if (hasModule('MultiBranch')) {
            static::addGlobalScope('branch_id', function (Builder $builder) {
                if (! auth()->check()) {
                    return;
                }

                $table = $builder->getQuery()->from;
                $branchId = effectiveBranchScopeId();

                if ($branchId && Schema::hasColumn($table, 'branch_id')) {
                    $builder->where("{$table}.branch_id", $branchId);
                }
            });

            static::creating(function ($model) {
                if (! auth()->check()) {
                    return;
                }

                $table = $model->getTable();
                if (! Schema::hasColumn($table, 'branch_id')) {
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
                if (! auth()->check() || ! Schema::hasColumn($model->getTable(), 'branch_id')) {
                    return;
                }

                if ($model->branch_id) {
                    authorizeBranchId((int) $model->branch_id);
                }
            });
        }
    }
}
