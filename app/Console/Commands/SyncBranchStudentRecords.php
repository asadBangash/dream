<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SyncBranchStudentRecords extends Command
{
    protected $signature = 'branch:sync-students {--dry-run : Show counts only}';

    protected $description = 'Align students.branch_id with users and session_class_students (fixes Super Admin branch filter)';

    public function handle(): int
    {
        if (! hasModule('MultiBranch')) {
            $this->warn('MultiBranch module is not enabled.');

            return self::SUCCESS;
        }

        $dry = (bool) $this->option('dry-run');

        $userFix = 0;
        if (Schema::hasTable('students') && Schema::hasTable('users')) {
            $userFix = DB::table('students as s')
                ->join('users as u', 'u.id', '=', 's.user_id')
                ->whereColumn('s.branch_id', '!=', 'u.branch_id')
                ->count();

            if (! $dry && $userFix > 0) {
                DB::statement('
                    UPDATE students s
                    INNER JOIN users u ON u.id = s.user_id
                    SET s.branch_id = u.branch_id
                    WHERE s.branch_id != u.branch_id OR s.branch_id IS NULL
                ');
            }
        }

        $sessionFix = 0;
        if (Schema::hasTable('session_class_students') && Schema::hasTable('students')) {
            $sessionFix = DB::table('session_class_students as scs')
                ->join('students as s', 's.id', '=', 'scs.student_id')
                ->whereColumn('scs.branch_id', '!=', 's.branch_id')
                ->count();

            if (! $dry && $sessionFix > 0) {
                DB::statement('
                    UPDATE session_class_students scs
                    INNER JOIN students s ON s.id = scs.student_id
                    SET scs.branch_id = s.branch_id
                    WHERE scs.branch_id != s.branch_id OR scs.branch_id IS NULL
                ');
            }
        }

        $this->table(['Fix', 'Rows'], [
            ['students.branch_id ← users.branch_id', $userFix],
            ['session_class_students.branch_id ← students.branch_id', $sessionFix],
        ]);

        if ($dry) {
            $this->info('Dry run only. Re-run without --dry-run to apply.');
        } else {
            $this->info('Sync complete.');
        }

        return self::SUCCESS;
    }
}
