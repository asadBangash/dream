<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Tables where name (or code) is unique per branch, not globally. */
    private array $composites = [
        'sections' => ['branch_id', 'name'],
        'classes' => ['branch_id', 'name'],
        'departments' => ['branch_id', 'name'],
        'designations' => ['branch_id', 'name'],
        'shifts' => ['branch_id', 'name'],
        'exam_types' => ['branch_id', 'name'],
        'fees_types' => ['branch_id', 'name'],
        'fees_groups' => ['branch_id', 'name'],
        'student_categories' => ['branch_id', 'name'],
        'class_rooms' => ['branch_id', 'room_no'],
        'question_groups' => ['branch_id', 'name'],
        'account_heads' => ['branch_id', 'name'],
        'books' => ['branch_id', 'name'],
        'incomes' => ['branch_id', 'name'],
        'expenses' => ['branch_id', 'name'],
        'id_cards' => ['branch_id', 'title'],
        'sessions' => ['branch_id', 'name'],
        'students' => ['branch_id', 'admission_no'],
        'staff' => ['branch_id', 'staff_id'],
    ];

    private array $tripleComposites = [
        'subjects' => ['branch_id', 'name', 'type'],
    ];

    public function up(): void
    {
        foreach ($this->composites as $table => $columns) {
            if (! Schema::hasTable($table)) {
                continue;
            }
            foreach ($columns as $column) {
                if (! Schema::hasColumn($table, $column)) {
                    continue 2;
                }
            }

            $index = $table . '_' . implode('_', $columns) . '_unique';

            try {
                Schema::table($table, function (Blueprint $blueprint) use ($columns, $index) {
                    $blueprint->unique($columns, $index);
                });
            } catch (\Throwable $e) {
                // Skip if duplicates exist within a branch; validation still enforces scope.
            }
        }

        foreach ($this->tripleComposites as $table => $columns) {
            if (! Schema::hasTable($table)) {
                continue;
            }
            $index = $table . '_' . implode('_', $columns) . '_unique';
            try {
                Schema::table($table, function (Blueprint $blueprint) use ($columns, $index) {
                    $blueprint->unique($columns, $index);
                });
            } catch (\Throwable $e) {
            }
        }
    }

    public function down(): void
    {
        foreach ($this->composites as $table => $columns) {
            if (! Schema::hasTable($table)) {
                continue;
            }
            $index = $table . '_' . implode('_', $columns) . '_unique';
            try {
                Schema::table($table, function (Blueprint $blueprint) use ($index) {
                    $blueprint->dropUnique($index);
                });
            } catch (\Throwable $e) {
            }
        }
    }
};
