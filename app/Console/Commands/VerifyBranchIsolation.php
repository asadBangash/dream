<?php

namespace App\Console\Commands;

use App\Models\Academic\Section;
use App\Models\StudentInfo\Student;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Rules\BranchUnique;

class VerifyBranchIsolation extends Command
{
    protected $signature = 'demo:verify-branch-isolation';

    protected $description = 'Verify MultiBranch query isolation and per-branch uniqueness';

    public function handle(): int
    {
        $boysAdmin = User::withoutGlobalScopes()->where('email', 'boysadmin@example.com')->first();
        $girlsAdmin = User::withoutGlobalScopes()->where('email', 'girlsadmin@example.com')->first();
        $superAdmin = User::withoutGlobalScopes()->where('role_id', 1)->orderBy('id')->first();

        if (! $boysAdmin || ! $girlsAdmin || ! $superAdmin) {
            $this->warn('Demo branch admins not found; running limited checks with super admin only.');
            $boysAdmin = $girlsAdmin = null;
        }

        $rows = [];

        if ($boysAdmin && $girlsAdmin) {
            $boysBranchId = $boysAdmin->branch_id;
            $girlsBranchId = $girlsAdmin->branch_id;

            Auth::login($boysAdmin);
            $boysVisible = Student::count();
            $crossGirl = Student::withoutGlobalScopes()->where('branch_id', $girlsBranchId)->first();
            $crossAccess = $crossGirl ? (bool) Student::find($crossGirl->id) : true;
            Auth::logout();

            Auth::login($girlsAdmin);
            $girlsVisible = Student::count();
            $crossBoy = Student::withoutGlobalScopes()->where('branch_id', $boysBranchId)->first();
            $crossAccessGirls = $crossBoy ? (bool) Student::find($crossBoy->id) : true;
            Auth::logout();

            $rows[] = ['Boys admin blocked from girls student', $crossAccess ? 'FAIL' : 'PASS'];
            $rows[] = ['Girls admin blocked from boys student', $crossAccessGirls ? 'FAIL' : 'PASS'];
            $rows[] = ['Boys admin student count', (string) $boysVisible];
            $rows[] = ['Girls admin student count', (string) $girlsVisible];
        }

        Auth::login($superAdmin);
        session()->forget('active_branch_id');
        $superVisibleAll = Student::count();
        $totalStudents = Student::withoutGlobalScopes()->count();
        $rows[] = ['Super admin (all branches) students', "{$superVisibleAll} / {$totalStudents}"];
        Auth::logout();

        $sectionName = 'BranchIsoTest_' . time();
        if ($boysAdmin && $girlsAdmin) {
            Section::withoutGlobalScopes()->create([
                'name' => $sectionName,
                'status' => 1,
                'branch_id' => $boysAdmin->branch_id,
            ]);
            Section::withoutGlobalScopes()->create([
                'name' => $sectionName,
                'status' => 1,
                'branch_id' => $girlsAdmin->branch_id,
            ]);
            $dupCount = Section::withoutGlobalScopes()->where('name', $sectionName)->count();
            $rows[] = ['Same section name in two branches', $dupCount === 2 ? 'PASS' : 'FAIL'];

            Auth::login($boysAdmin);
            $validator = Validator::make(
                ['name' => $sectionName],
                ['name' => [new BranchUnique('sections', 'name')]]
            );
            Auth::logout();
            $rows[] = ['BranchUnique blocks duplicate in same branch', $validator->fails() ? 'PASS' : 'FAIL'];
        }

        $this->table(['Check', 'Result'], $rows);

        $failed = collect($rows)->contains(fn ($r) => $r[1] === 'FAIL');

        return $failed ? self::FAILURE : self::SUCCESS;
    }
}
