<?php

namespace App\Console\Commands;

use App\Services\StudentInfo\StudentRecordsImportMapper;
use App\Services\StudentInfo\StudentRecordsImportService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Throwable;

class ImportStudentRecordsCommand extends Command
{
    protected $signature = 'students:import-records
                            {file? : Path to Student_Records.xlsx (default: project root)}
                            {--dry-run : Validate and report without writing to the database}
                            {--session= : Override active session id (default: settings session)}';

    protected $description = 'Import students and guardians from Student_Records.xlsx (Combined Master sheet)';

    public function handle(): int
    {
        $file = $this->argument('file') ?: base_path('Student_Records.xlsx');
        $file = str_starts_with($file, DIRECTORY_SEPARATOR) || preg_match('#^[A-Za-z]:\\\\#', $file)
            ? $file
            : base_path($file);

        if (! is_file($file)) {
            $this->error('File not found: ' . $file);
            $this->line('Upload Student_Records.xlsx to the project root or pass the full path:');
            $this->line('  php artisan students:import-records /home/user/Student_Records.xlsx');

            return self::FAILURE;
        }

        $sessionId = (int) ($this->option('session') ?: setting('session'));
        if ($sessionId < 1) {
            $this->error('No active session. Set General Settings → session, or run:');
            $this->line('  php artisan students:import-records --session=1');

            return self::FAILURE;
        }

        if ($message = $this->preflight($sessionId)) {
            $this->error($message);

            return self::FAILURE;
        }

        $mapper = new StudentRecordsImportMapper($sessionId);
        $service = new StudentRecordsImportService($mapper);

        $dryRun = (bool) $this->option('dry-run');
        if ($dryRun) {
            $this->warn('DRY RUN — no database changes will be made.');
        }

        $sessionName = DB::table('sessions')->where('id', $sessionId)->value('name');
        $this->info('Session: ' . $sessionName . ' (id ' . $sessionId . ')');
        $this->info('Excel file: ' . $file);
        $this->info('Branch map (gender => id): ' . json_encode($mapper->branchSummary()));
        $this->newLine();

        try {
            $stats = $service->importFromFile($file, $dryRun);
        } catch (Throwable $e) {
            $this->error('Import crashed: ' . $e->getMessage());
            $this->line($e->getFile() . ':' . $e->getLine());

            return self::FAILURE;
        }

        foreach ($stats['errors'] ?? [] as $error) {
            $this->error($error);
        }

        $this->table(
            ['Metric', 'Count'],
            [
                ['Rows processed', $stats['rows_processed'] ?? 0],
                ['Empty rows', $stats['rows_empty'] ?? 0],
                $dryRun ? ['Would import', $stats['would_import'] ?? 0] : ['Students imported (boys)', $stats['boys_imported'] ?? 0],
                $dryRun ? ['Would import (boys)', $stats['boys_valid'] ?? 0] : ['Students imported (girls)', $stats['girls_imported'] ?? 0],
                $dryRun ? ['Would import (girls)', $stats['girls_valid'] ?? 0] : ['Parents created', $stats['parents_created'] ?? 0],
                $dryRun ? ['—', '—'] : ['Parents reused', $stats['parents_reused'] ?? 0],
                ['Skipped (validation)', $stats['skipped'] ?? 0],
                ['Duplicates (already in DB)', $stats['duplicates'] ?? 0],
                ['Failed (rolled back row)', $stats['failed'] ?? 0],
            ]
        );

        if (! empty($stats['skipped_details'])) {
            $this->newLine();
            $this->warn('Skipped rows (first 25):');
            foreach (array_slice($stats['skipped_details'], 0, 25) as $item) {
                $this->line("  Row {$item['row']}: {$item['name']} — {$item['reason']}");
            }
            if (count($stats['skipped_details']) > 25) {
                $this->line('  ... and ' . (count($stats['skipped_details']) - 25) . ' more');
            }
        }

        if (! empty($stats['failed_details'])) {
            $this->newLine();
            $this->error('Failed rows:');
            foreach ($stats['failed_details'] as $item) {
                $this->line("  Row {$item['row']}: {$item['name']} — {$item['reason']}");
            }
        }

        if ($dryRun && ($stats['would_import'] ?? 0) > 0) {
            $this->newLine();
            $this->info('Dry run OK. Run without --dry-run to import.');
        }

        return empty($stats['errors']) && ($stats['failed'] ?? 0) === 0 ? self::SUCCESS : self::FAILURE;
    }

    private function preflight(int $sessionId): ?string
    {
        if (! class_exists(IOFactory::class)) {
            return 'PhpSpreadsheet is missing. On the server run: composer install --no-dev --optimize-autoloader';
        }

        if (! Schema::hasTable('students')) {
            return 'students table not found. Run migrations: php artisan migrate --force';
        }

        if (! Schema::hasColumn('students', 'student_code')) {
            return 'Column students.student_code is missing. Run tenant migrations (e.g. 2024_08_30_151926_add_columns_to_students_table).';
        }

        if (! DB::table('sessions')->where('id', $sessionId)->exists()) {
            return "Session id {$sessionId} does not exist. Use --session= with a valid sessions.id (check admin header session name).";
        }

        if (! $this->roleExists(6) || ! $this->roleExists(7)) {
            return 'Student role (id=6) or Guardian role (id=7) missing. Seed roles before importing.';
        }

        if (Schema::hasTable('branches')) {
            $names = DB::table('branches')->pluck('name', 'id')->all();
            $hasBoy = false;
            $hasGirl = false;
            foreach ($names as $name) {
                $lower = strtolower((string) $name);
                $hasBoy = $hasBoy || str_contains($lower, 'boy');
                $hasGirl = $hasGirl || str_contains($lower, 'girl');
            }
            if (! $hasBoy || ! $hasGirl) {
                return 'Could not find Boys Branch and Girls Branch in branches table. Found: ' . json_encode($names);
            }
        }

        $setupCount = Schema::hasTable('class_setups')
            ? DB::table('class_setups')->where('session_id', $sessionId)->count()
            : 0;
        if ($setupCount === 0) {
            return "No class setup for session id {$sessionId}. Create Class Setup in admin for that session before importing.";
        }

        return null;
    }

    private function roleExists(int $id): bool
    {
        return Schema::hasTable('roles') && DB::table('roles')->where('id', $id)->exists();
    }
}
