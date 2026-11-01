<?php

namespace App\Services\StudentInfo\Concerns;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

trait PersistsBranchOnImport
{
    protected function usesBranchColumns(): bool
    {
        static $resolved;

        if ($resolved !== null) {
            return $resolved;
        }

        $resolved = Schema::hasTable('branches')
            && Schema::hasColumn('students', 'branch_id')
            && DB::table('branches')->exists();

        return $resolved;
    }

    protected function applyBranchId(object $model, int $branchId): void
    {
        if ($this->usesBranchColumns()) {
            $model->branch_id = $branchId;
        }
    }
}
