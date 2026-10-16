<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FixSubjectAssignBranches extends Command
{
    protected $signature = 'academy:fix-subject-assign-branches';

    protected $description = 'Set subject assign rows to shared branch (0) so all teachers see central assignments';

    public function handle(): int
    {
        if (! hasModule('MultiBranch')) {
            $this->info('MultiBranch is disabled; nothing to do.');

            return self::SUCCESS;
        }

        foreach (['subject_assigns', 'subject_assign_childrens'] as $table) {
            if (! Schema::hasTable($table) || ! Schema::hasColumn($table, 'branch_id')) {
                continue;
            }
            $count = DB::table($table)->where('branch_id', '!=', 0)->update(['branch_id' => 0]);
            $this->line("{$table}: normalized {$count} row(s) to branch_id 0");
        }

        $this->info('Done. Teachers should see subjects after re-selecting class/section on homework.');

        return self::SUCCESS;
    }
}
