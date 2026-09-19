<?php

namespace App\Console\Commands;

use App\Enums\RoleEnum;
use App\Models\StudentInfo\Student;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class VerifyBranchIsolation extends Command
{
    protected $signature = 'demo:verify-branch-isolation';

    protected $description = 'Verify MultiBranch data isolation for demo branch admins';

    public function handle(): int
    {
        $boysAdmin = User::where('email', 'boysadmin@example.com')->first();
        $girlsAdmin = User::where('email', 'girlsadmin@example.com')->first();
        $superAdmin = User::where('email', 'superadmin@example.com')->first();

        if (! $boysAdmin || ! $girlsAdmin || ! $superAdmin) {
            $this->error('Demo users missing. Run APP_DEMO=true php artisan app:setup --fresh');

            return self::FAILURE;
        }

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

        Auth::login($superAdmin);
        $superVisible = Student::count();
        Auth::logout();

        $totalStudents = Student::withoutGlobalScopes()->count();

        $this->table(['Check', 'Result'], [
            ['Boys admin student count', $boysVisible],
            ['Girls admin student count', $girlsVisible],
            ['Super admin student count', $superVisible],
            ['Total students in DB', $totalStudents],
            ['Boys admin blocked from girls student ID', $crossAccess ? 'FAIL' : 'PASS'],
            ['Girls admin blocked from boys student ID', $crossAccessGirls ? 'FAIL' : 'PASS'],
            ['Super admin sees all students', $superVisible === $totalStudents ? 'PASS' : 'FAIL'],
        ]);

        $failed = $crossAccess || $crossAccessGirls || $superVisible !== $totalStudents;

        return $failed ? self::FAILURE : self::SUCCESS;
    }
}
