<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AssignStudentBranchesFromClass extends Command
{
    protected $signature = 'branch:fix-student-branches {--force : Apply changes}';

    protected $description = 'Set students/users/session_class_students branch_id from enrolled class (live data fix)';

    public function handle(): int
    {
        if (! $this->option('force')) {
            $this->warn('Run with --force to apply.');

            return self::FAILURE;
        }

        if (! hasModule('MultiBranch')) {
            return self::SUCCESS;
        }

        foreach ([
            'UPDATE students s
                INNER JOIN session_class_students scs ON scs.student_id = s.id
                INNER JOIN classes c ON c.id = scs.classes_id
                SET s.branch_id = c.branch_id
                WHERE c.branch_id IS NOT NULL AND (s.branch_id IS NULL OR s.branch_id != c.branch_id)',
            'UPDATE users u
                INNER JOIN students s ON s.user_id = u.id
                SET u.branch_id = s.branch_id
                WHERE u.branch_id IS NULL OR u.branch_id != s.branch_id',
            'UPDATE session_class_students scs
                INNER JOIN students s ON s.id = scs.student_id
                SET scs.branch_id = s.branch_id
                WHERE scs.branch_id IS NULL OR scs.branch_id != s.branch_id',
        ] as $sql) {
            if (Schema::hasTable('students')) {
                DB::statement($sql);
            }
        }

        $this->info('Student branch IDs aligned to class branch. Test Super Admin branch switch on /student');

        return self::SUCCESS;
    }
}
