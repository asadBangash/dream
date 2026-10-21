<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FixEventBranches extends Command
{
    protected $signature = 'academy:fix-event-branches';

    protected $description = 'Set events to shared branch (0) so all students see admin-created events';

    public function handle(): int
    {
        if (! Schema::hasTable('events') || ! Schema::hasColumn('events', 'branch_id')) {
            $this->info('No branch_id on events table; scope exclusion is enough.');

            return self::SUCCESS;
        }

        $count = DB::table('events')->where('branch_id', '!=', 0)->update(['branch_id' => 0]);
        $this->info("Updated {$count} event(s) to branch_id 0.");

        return self::SUCCESS;
    }
}
