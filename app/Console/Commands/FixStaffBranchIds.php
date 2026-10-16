<?php

namespace App\Console\Commands;

use App\Enums\RoleEnum;
use App\Models\Staff\Staff;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixStaffBranchIds extends Command
{
    protected $signature = 'academy:fix-staff-branches';

    protected $description = 'Assign a real branch to staff/users with branch_id 0 (fixes teacher login 403)';

    public function handle(): int
    {
        if (! hasModule('MultiBranch')) {
            $this->info('MultiBranch is disabled; nothing to do.');

            return self::SUCCESS;
        }

        $branchId = defaultOperationalBranchId();
        $this->line("Using branch id: {$branchId}");

        $staffUserIds = Staff::withoutGlobalScopes()->pluck('user_id')->filter()->all();

        $userQuery = User::query()->where(function ($q) {
            $q->whereNull('branch_id')->orWhere('branch_id', 0);
        });

        if ($staffUserIds !== []) {
            $userQuery->whereIn('id', $staffUserIds);
        } else {
            $userQuery->whereIn('role_id', [
                RoleEnum::TEACHER,
                RoleEnum::STAFF,
                RoleEnum::ADMIN,
                RoleEnum::ACCOUNTING,
            ]);
        }

        $userIds = $userQuery->pluck('id')->all();
        $usersFixed = DB::table('users')->whereIn('id', $userIds)->update(['branch_id' => $branchId]);

        $staffFixed = Staff::withoutGlobalScopes()
            ->where(function ($q) {
                $q->whereNull('branch_id')->orWhere('branch_id', 0);
            })
            ->update(['branch_id' => $branchId]);

        $this->info("Updated users: {$usersFixed}, staff rows: {$staffFixed}");

        return self::SUCCESS;
    }
}
