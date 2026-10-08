<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DiagnoseStudentBranches extends Command
{
    protected $signature = 'branch:diagnose-students';

    protected $description = 'Show branch_id on students, users, classes (for filter debugging)';

    public function handle(): int
    {
        if (! Schema::hasTable('students')) {
            $this->error('students table missing');

            return self::FAILURE;
        }

        $rows = DB::table('students as s')
            ->leftJoin('users as u', 'u.id', '=', 's.user_id')
            ->leftJoin('session_class_students as scs', 'scs.student_id', '=', 's.id')
            ->leftJoin('classes as c', 'c.id', '=', 'scs.classes_id')
            ->leftJoin('branches as b', 'b.id', '=', 's.branch_id')
            ->leftJoin('branches as cb', 'cb.id', '=', 'c.branch_id')
            ->select([
                's.id',
                's.first_name',
                's.last_name',
                's.branch_id as student_branch',
                'b.name as student_branch_name',
                'u.branch_id as user_branch',
                'c.name as class_name',
                'c.branch_id as class_branch',
                'cb.name as class_branch_name',
                'scs.branch_id as scs_branch',
            ])
            ->limit(50)
            ->get();

        if ($rows->isEmpty()) {
            $this->warn('No students in database.');

            return self::SUCCESS;
        }

        $this->table(
            ['ID', 'Name', 'St.branch', 'Branch name', 'User br', 'Class', 'Cls br', 'Cls branch', 'SCS br'],
            $rows->map(fn ($r) => [
                $r->id,
                trim($r->first_name . ' ' . $r->last_name),
                $r->student_branch,
                $r->student_branch_name ?? '-',
                $r->user_branch,
                $r->class_name ?? '-',
                $r->class_branch ?? '-',
                $r->class_branch_name ?? '-',
                $r->scs_branch ?? '-',
            ])->all()
        );

        $this->line('Branches:');
        DB::table('branches')->select('id', 'name')->orderBy('id')->get()->each(function ($b) {
            $this->line("  {$b->id} = {$b->name}");
        });

        return self::SUCCESS;
    }
}
