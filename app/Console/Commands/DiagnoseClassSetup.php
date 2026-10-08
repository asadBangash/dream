<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class DiagnoseClassSetup extends Command
{
    protected $signature = 'branch:diagnose-class-setup {email : Admin user email (e.g. dawood@gmail.com)}';

    protected $description = 'Check branch_id, schema, and session context for Class Setup failures';

    public function handle(): int
    {
        $user = User::where('email', $this->argument('email'))->first();
        if (! $user) {
            $this->error('User not found.');

            return self::FAILURE;
        }

        $this->table(['Key', 'Value'], [
            ['MultiBranch module', hasModule('MultiBranch') ? 'yes' : 'no'],
            ['User role_id', (string) $user->role_id],
            ['User branch_id', (string) ($user->branch_id ?? 'null')],
            ['Active session (setting)', (string) (setting('session') ?? 'null')],
            ['class_setups.branch_id column', Schema::hasColumn('class_setups', 'branch_id') ? 'yes' : 'no'],
            ['class_setup_childrens.branch_id column', Schema::hasColumn('class_setup_childrens', 'branch_id') ? 'yes' : 'no'],
        ]);

        if (hasModule('MultiBranch') && (int) ($user->branch_id ?? 0) < 1 && ! isSuperAdmin()) {
            $this->warn('This account has no branch_id. Assign a branch in Multi Branch → Edit branch → Branch Admin.');
        }

        if (! setting('session')) {
            $this->warn('No active session in settings. Set the current session in Academic → Session.');
        }

        if (hasModule('MultiBranch') && ! Schema::hasColumn('class_setups', 'branch_id')) {
            $this->warn('Run migrations on live: php artisan migrate --force');
        }

        return self::SUCCESS;
    }
}
