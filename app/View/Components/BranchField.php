<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Modules\MultiBranch\Entities\Branch;

class BranchField extends Component
{
    /** Existing record branch (edit forms). */
    public function __construct(public ?int $recordBranchId = null) {}

    public function render(): View
    {
        $branches = collect();
        $lockedBranch = null;
        $showDropdown = hasModule('MultiBranch') && isSuperAdmin();
        $showLocked = hasModule('MultiBranch') && isBranchAdmin();

        if ($showDropdown && \Schema::hasTable('branches')) {
            $branches = Branch::query()->where('status', \App\Enums\Status::ACTIVE)->pluck('name', 'id');
        }

        if ($showLocked && \Schema::hasTable('branches')) {
            $lockedBranch = Branch::query()->find((int) auth()->user()->branch_id);
        }

        $selected = old('branch_id', $this->recordBranchId ?? superAdminActiveBranchId());

        return view('components.branch-field', [
            'branches' => $branches,
            'showDropdown' => $showDropdown && $branches->isNotEmpty(),
            'showLocked' => $showLocked && $lockedBranch,
            'lockedBranch' => $lockedBranch,
            'selected' => $selected,
        ]);
    }
}
