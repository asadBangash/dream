<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Modules\MultiBranch\Entities\Branch;

class BranchField extends Component
{
    public function render(): View
    {
        $branches = collect();
        $show = hasModule('MultiBranch') && isSuperAdmin();

        if ($show && \Schema::hasTable('branches')) {
            $branches = Branch::query()->where('status', \App\Enums\Status::ACTIVE)->pluck('name', 'id');
        }

        $selected = old('branch_id', superAdminActiveBranchId());

        return view('components.branch-field', compact('branches', 'show', 'selected'));
    }
}
