<?php

namespace Database\Seeders\Demo;

use App\Models\Staff\Department;
use App\Models\Staff\Designation;
use Illuminate\Database\Seeder;

class DemoOrganizationSeeder extends Seeder
{
    private array $departments = [
        'Computer Science',
        'Mathematics',
        'English',
        'Science',
        'Urdu',
        'Islamic Studies',
    ];

    private array $designations = [
        'Principal',
        'Vice Principal',
        'Teacher',
        'Senior Teacher',
        'Junior Teacher',
        'Accountant',
        'Clerk',
        'Librarian',
        'Administrator',
        'Lab Assistant',
    ];

    /** @var array<int, array<string, int>> branchId => [name => id] */
    public static array $departmentsByBranch = [];

    /** @var array<int, array<string, int>> branchId => [name => id] */
    public static array $designationsByBranch = [];

    public function run(): void
    {
        foreach (DemoContext::branches() as $branchId => $branchName) {
            foreach ($this->departments as $name) {
                $row = new Department();
                $row->name = $name;
                $row->branch_id = $branchId;
                $row->save();
                self::$departmentsByBranch[$branchId][$name] = $row->id;
            }

            foreach ($this->designations as $name) {
                $row = new Designation();
                $row->name = $name;
                $row->branch_id = $branchId;
                $row->save();
                self::$designationsByBranch[$branchId][$name] = $row->id;
            }
        }
    }
}
