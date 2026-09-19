<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{

    protected function getAllTableNames()
    {
        $tables = DB::select('SHOW TABLES');
        $tableNames = [];

        foreach ($tables as $table) {
            $tableNames[] = array_values((array) $table)[0];
        }

        return $tableNames;
    }

    /**
     * Run the migrations.
     */

    public function up(): void
    {
        $tables = $this->getAllTableNames();
        Log::info("all Tables", $tables);
        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $blueprint) use ($tableName) {
                if (!Schema::hasColumn($tableName, 'branch_id')) {
                    $blueprint->unsignedBigInteger('branch_id')->default(1);
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = $this->getAllTableNames();

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $blueprint) use ($tableName) {
                if (Schema::hasColumn($tableName, 'branch_id')) {
                    $blueprint->dropColumn('branch_id');
                }
            });
        }
    }
};
