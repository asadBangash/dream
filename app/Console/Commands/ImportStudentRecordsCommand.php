<?php

namespace App\Console\Commands;

use App\Services\StudentInfo\StudentRecordsImportMapper;
use App\Services\StudentInfo\StudentRecordsImportService;
use Illuminate\Console\Command;

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
        if (! is_file($file)) {
            $this->error('File not found: ' . $file);

            return self::FAILURE;
        }

        $sessionId = (int) ($this->option('session') ?: setting('session'));
        if ($sessionId < 1) {
            $this->error('No active session. Set settings session or pass --session=');

            return self::FAILURE;
        }

        $mapper = new StudentRecordsImportMapper($sessionId);
        $service = new StudentRecordsImportService($mapper);

        $dryRun = (bool) $this->option('dry-run');
        if ($dryRun) {
            $this->warn('DRY RUN — no database changes will be made.');
        }

        $this->info('Session id: ' . $sessionId);
        $this->info('Branch map (gender => id): ' . json_encode($mapper->branchSummary()));
        $this->newLine();

        $stats = $service->importFromFile($file, $dryRun);

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

        if (($stats['skipped'] ?? 0) > 0 && ($stats['would_import'] ?? $stats['boys_imported'] ?? 0) >= 0) {
            $this->newLine();
            $this->comment('Rows without guardian phone are skipped by design (see list above).');
        }

        return empty($stats['errors']) && ($stats['failed'] ?? 0) === 0 ? self::SUCCESS : self::FAILURE;
    }
}
