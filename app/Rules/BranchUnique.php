<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BranchUnique implements ValidationRule
{
    public function __construct(
        protected string $table,
        protected string $column,
        protected ?int $ignoreId = null,
        protected ?int $branchId = null,
        protected array $where = []
    ) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! hasModule('MultiBranch') || ! Schema::hasTable($this->table)) {
            return;
        }

        if (! Schema::hasColumn($this->table, 'branch_id')) {
            $exists = DB::table($this->table)
                ->where($this->column, $value)
                ->when($this->ignoreId, fn ($q) => $q->where('id', '!=', $this->ignoreId))
                ->exists();

            if ($exists) {
                $fail(__('validation.unique'));
            }

            return;
        }

        $branchId = $this->branchId ?? resolveBranchIdForValidation($this->ignoreId, $this->table);

        if ($branchId < 1) {
            $fail(___('branch.select_branch'));

            return;
        }

        $query = DB::table($this->table)
            ->where($this->column, $value)
            ->where('branch_id', $branchId);

        foreach ($this->where as $col => $val) {
            $query->where($col, $val);
        }

        if ($this->ignoreId) {
            $query->where('id', '!=', $this->ignoreId);
        }

        if ($query->exists()) {
            $fail(__('validation.unique'));
        }
    }
}
