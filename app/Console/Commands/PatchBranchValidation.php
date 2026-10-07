<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * Documents branch-scoped FormRequest classes updated for MultiBranch.
 * Run demo:verify-branch-isolation after seeding demo data.
 */
class PatchBranchValidation extends Command
{
    protected $signature = 'branch:validation-status';

    protected $description = 'List branch-scoped validation coverage (unique per branch_id)';

    public function handle(): int
    {
        $this->info('Branch-scoped unique validation uses App\\Rules\\BranchUnique + branchIdValidationRules().');
        $this->line('Super Admin: branch picker <x-branch-field /> on create forms.');
        $this->line('Branch Admin: branch_id merged by EnforceBranchScope middleware.');

        return self::SUCCESS;
    }
}
