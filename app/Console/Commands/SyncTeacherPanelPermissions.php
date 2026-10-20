<?php

namespace App\Console\Commands;

use App\Enums\RoleEnum;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;

class SyncTeacherPanelPermissions extends Command
{
    protected $signature = 'academy:sync-teacher-panel-permissions';

    protected $description = 'Grant Teacher role lecture upload and exam notification permissions';

    public function handle(): int
    {
        $keywords = [
            'teacher_lecture' => [
                'read' => 'teacher_lecture_read',
                'create' => 'teacher_lecture_create',
                'update' => 'teacher_lecture_update',
                'delete' => 'teacher_lecture_delete',
            ],
            'teacher_exam_notification' => [
                'read' => 'teacher_exam_notification_read',
                'create' => 'teacher_exam_notification_create',
            ],
        ];

        foreach ($keywords as $attribute => $map) {
            Permission::query()->firstOrCreate(
                ['attribute' => $attribute],
                ['keywords' => $map]
            );
        }

        $grant = array_values(array_merge(...array_values($keywords)));

        $role = Role::find(RoleEnum::TEACHER);
        if ($role) {
            $merged = array_values(array_unique(array_merge($role->permissions ?? [], $grant)));
            $role->permissions = $merged;
            $role->save();
            User::query()->where('role_id', RoleEnum::TEACHER)->each(function (User $user) use ($merged) {
                $user->permissions = $merged;
                $user->save();
            });
            $this->info('Teacher role and users updated.');
        } else {
            $this->warn('Teacher role not found.');
        }

        return self::SUCCESS;
    }
}
