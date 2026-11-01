<?php

namespace App\Services\StudentInfo;

use App\Services\StudentInfo\Concerns\PersistsBranchOnImport;
use App\Models\Role;
use App\Models\StudentInfo\ParentGuardian;
use App\Models\StudentInfo\SessionClassStudent;
use App\Models\StudentInfo\Student;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Throwable;

class StudentRecordsImportService
{
    use PersistsBranchOnImport;

    public function __construct(
        private readonly StudentRecordsImportMapper $mapper
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function importFromFile(string $absolutePath, bool $dryRun = false): array
    {
        $stats = $this->emptyStats();

        if (! is_file($absolutePath)) {
            $stats['errors'][] = 'File not found: ' . $absolutePath;

            return $stats;
        }

        try {
            $reader = IOFactory::load($absolutePath);
        } catch (Throwable $e) {
            $stats['errors'][] = 'Could not read Excel file: ' . $e->getMessage()
                . ' (ensure vendor/ is deployed: composer install --no-dev)';

            return $stats;
        }

        $sheet = $reader->getSheetByName('Combined Master');
        if (! $sheet) {
            $stats['errors'][] = 'Sheet "Combined Master" not found in workbook';

            return $stats;
        }

        $highest = (int) $sheet->getHighestRow();
        $stats['branches'] = $this->mapper->branchSummary();
        $stats['session_id'] = $this->mapper->sessionId();

        /** @var array<string, int> $parentCache phone => parent_guardian_id */
        $parentCache = [];

        for ($rowNum = 2; $rowNum <= $highest; $rowNum++) {
            $stats['rows_processed']++;

            $raw = $this->readRow($sheet, $rowNum);
            if ($this->isEmptyRow($raw)) {
                $stats['rows_empty']++;
                continue;
            }

            $mapped = $this->mapper->mapRow($raw, $rowNum);
            if ($mapped['ok'] === false) {
                $stats['skipped']++;
                $stats['skipped_details'][] = ['row' => $rowNum, 'reason' => $mapped['reason'], 'name' => trim(($raw['first_name'] ?? '') . ' ' . ($raw['last_name'] ?? ''))];
                continue;
            }

            $data = $mapped['data'];

            if ($this->studentAlreadyImported($data['import_code'], $data['branch_id'], $data['roll_no'])) {
                $stats['duplicates']++;
                $stats['skipped_details'][] = ['row' => $rowNum, 'reason' => 'Already imported (student_code)', 'name' => $data['first_name'] . ' ' . $data['last_name']];
                continue;
            }

            if ($dryRun) {
                $stats[$data['gender_key'] === 'boy' ? 'boys_valid' : 'girls_valid']++;
                $stats['would_import']++;
                continue;
            }

            try {
                DB::transaction(function () use ($data, &$stats, &$parentCache) {
                    $parentId = $this->resolveParent($data, $stats, $parentCache);
                    $this->createStudent($data, $parentId, $stats);
                });
            } catch (\Throwable $e) {
                $stats['failed']++;
                $stats['failed_details'][] = [
                    'row' => $data['excel_row'],
                    'name' => $data['first_name'] . ' ' . $data['last_name'],
                    'reason' => $e->getMessage(),
                ];
            }
        }

        return $stats;
    }

    /**
     * @return array<string, mixed>
     */
    private function emptyStats(): array
    {
        return [
            'rows_processed' => 0,
            'rows_empty' => 0,
            'would_import' => 0,
            'boys_valid' => 0,
            'girls_valid' => 0,
            'boys_imported' => 0,
            'girls_imported' => 0,
            'parents_created' => 0,
            'parents_reused' => 0,
            'skipped' => 0,
            'duplicates' => 0,
            'failed' => 0,
            'skipped_details' => [],
            'failed_details' => [],
            'errors' => [],
        ];
    }

    /**
     * @return array<string, string>
     */
    private function readRow($sheet, int $rowNum): array
    {
        return [
            'sno' => trim((string) $sheet->getCellByColumnAndRow(1, $rowNum)->getFormattedValue()),
            'student_name' => trim((string) $sheet->getCellByColumnAndRow(2, $rowNum)->getFormattedValue()),
            'branch_gender' => trim((string) $sheet->getCellByColumnAndRow(3, $rowNum)->getFormattedValue()),
            'roll_no' => trim((string) $sheet->getCellByColumnAndRow(4, $rowNum)->getFormattedValue()),
            'first_name' => trim((string) $sheet->getCellByColumnAndRow(5, $rowNum)->getFormattedValue()),
            'last_name' => trim((string) $sheet->getCellByColumnAndRow(6, $rowNum)->getFormattedValue()),
            'department' => trim((string) $sheet->getCellByColumnAndRow(7, $rowNum)->getFormattedValue()),
            'class' => trim((string) $sheet->getCellByColumnAndRow(8, $rowNum)->getFormattedValue()),
            'section' => trim((string) $sheet->getCellByColumnAndRow(9, $rowNum)->getFormattedValue()),
            'dob' => trim((string) $sheet->getCellByColumnAndRow(10, $rowNum)->getFormattedValue()),
            'admission_date' => trim((string) $sheet->getCellByColumnAndRow(11, $rowNum)->getFormattedValue()),
            'father_name' => trim((string) $sheet->getCellByColumnAndRow(12, $rowNum)->getFormattedValue()),
            'guardian_contact' => trim((string) $sheet->getCellByColumnAndRow(13, $rowNum)->getFormattedValue()),
            'status' => trim((string) $sheet->getCellByColumnAndRow(14, $rowNum)->getFormattedValue()),
            'source_row' => trim((string) $sheet->getCellByColumnAndRow(16, $rowNum)->getFormattedValue()),
        ];
    }

    /**
     * @param  array<string, string>  $row
     */
    private function isEmptyRow(array $row): bool
    {
        return ($row['first_name'] ?? '') === '' && ($row['student_name'] ?? '') === '';
    }

    private function studentAlreadyImported(string $importCode, int $branchId, ?string $rollNo): bool
    {
        // Idempotency: only student_code (from Excel source row). Roll numbers may repeat across classes.
        return Student::query()->withoutGlobalScopes()->where('student_code', $importCode)->exists();
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  array<string, int>  $parentCache
     */
    private function resolveParent(array $data, array &$stats, array &$parentCache): int
    {
        $phoneKey = $data['guardian_mobile'];

        if (isset($parentCache[$phoneKey])) {
            $stats['parents_reused']++;

            return $parentCache[$phoneKey];
        }

        $existing = $this->findParentByPhone($phoneKey, (int) $data['branch_id']);
        if ($existing) {
            $parentCache[$phoneKey] = $existing;
            $stats['parents_reused']++;

            return $existing;
        }

        $role = Role::find(7);
        if (! $role) {
            throw new \RuntimeException('Guardian role (id=7) not found');
        }

        $username = $this->uniqueUsername('guardian_' . substr($phoneKey, -10));

        $user = new User();
        $user->name = $data['guardian_name'];
        $user->email = null;
        $user->phone = $data['guardian_mobile_display'] ?: $phoneKey;
        $user->password = Hash::make('123456');
        $user->email_verified_at = now();
        $user->role_id = $role->id;
        $user->permissions = $role->permissions;
        $user->username = $username;
        $user->uuid = (string) Str::uuid();
        $this->applyBranchId($user, (int) $data['branch_id']);
        $user->save();

        $guardian = new ParentGuardian();
        $guardian->user_id = $user->id;
        $guardian->father_name = $data['father_name'] ?: $data['guardian_name'];
        $guardian->father_mobile = $data['guardian_mobile_display'] ?: $phoneKey;
        $guardian->guardian_name = $data['guardian_name'];
        $guardian->guardian_mobile = $data['guardian_mobile_display'] ?: $phoneKey;
        $guardian->guardian_relation = 'Father';
        $guardian->status = 1;
        $this->applyBranchId($guardian, (int) $data['branch_id']);
        $guardian->save();

        $parentCache[$phoneKey] = $guardian->id;
        $stats['parents_created']++;

        return $guardian->id;
    }

    private function findParentByPhone(string $normalizedPhone, int $branchId): ?int
    {
        $query = ParentGuardian::query()->withoutGlobalScopes();

        if ($this->usesBranchColumns()) {
            $query->where(function ($q) use ($branchId) {
                $q->where('branch_id', $branchId)->orWhereNull('branch_id')->orWhere('branch_id', 0);
            });
        }

        $candidates = $query->get(['id', 'guardian_mobile', 'father_mobile']);

        foreach ($candidates as $row) {
            foreach (['guardian_mobile', 'father_mobile'] as $col) {
                $digits = preg_replace('/\D+/', '', (string) $row->{$col}) ?? '';
                if ($digits !== '' && ($digits === $normalizedPhone || str_ends_with($digits, substr($normalizedPhone, -10)))) {
                    return (int) $row->id;
                }
            }
        }

        return null;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function createStudent(array $data, int $parentId, array &$stats): void
    {
        $role = Role::find(6);
        if (! $role) {
            throw new \RuntimeException('Student role (id=6) not found');
        }

        $branchId = (int) $data['branch_id'];
        $admissionNo = $this->nextAdmissionNo($branchId);
        $username = $this->uniqueUsername('std_' . $branchId . '_' . ($data['roll_no'] ?: $admissionNo));

        $user = new User();
        $user->name = trim($data['first_name'] . ' ' . $data['last_name']);
        $user->email = null;
        $user->phone = null;
        $user->admission_no = $admissionNo;
        $user->password = Hash::make('123456');
        $user->email_verified_at = now();
        $user->role_id = $role->id;
        $user->permissions = $role->permissions;
        $user->date_of_birth = $data['dob'];
        $user->username = $username;
        $user->uuid = (string) Str::uuid();
        $this->applyBranchId($user, $branchId);
        $user->save();

        $student = new Student();
        $student->user_id = $user->id;
        $student->first_name = $data['first_name'];
        $student->last_name = $data['last_name'];
        $student->admission_no = $admissionNo;
        $student->roll_no = is_numeric($data['roll_no'] ?? null) ? (int) $data['roll_no'] : $data['roll_no'];
        $student->dob = $data['dob'];
        $student->admission_date = $data['admission_date'];
        $student->gender_id = $data['gender_id'];
        $student->department_id = $data['department_id'] ?: null;
        $student->parent_guardian_id = $parentId;
        $student->status = $data['status'];
        $student->student_code = $data['import_code'];
        $student->emergency_contact = $data['guardian_mobile_display'] ?: $data['guardian_mobile'];
        $this->applyBranchId($student, $branchId);
        $student->save();

        $sessionClass = new SessionClassStudent();
        $sessionClass->session_id = $this->mapper->sessionId();
        $sessionClass->classes_id = $data['class_id'];
        $sessionClass->section_id = $data['section_id'];
        $sessionClass->student_id = $student->id;
        $sessionClass->roll = $data['roll_no'];
        $this->applyBranchId($sessionClass, $branchId);
        $sessionClass->save();

        if ($data['gender_key'] === 'boy') {
            $stats['boys_imported']++;
        } else {
            $stats['girls_imported']++;
        }
    }

    private function nextAdmissionNo(int $branchId): string
    {
        $query = Student::query()->withoutGlobalScopes()->whereNotNull('admission_no');
        if ($this->usesBranchColumns()) {
            $query->where('branch_id', $branchId);
        }

        $maxNumeric = $query->pluck('admission_no')
            ->filter(static fn ($no) => $no !== '' && is_numeric($no))
            ->map(static fn ($no) => (int) $no)
            ->max();

        return (string) (($maxNumeric ?? 0) + 1);
    }

    private function uniqueUsername(string $base): string
    {
        $base = Str::lower(preg_replace('/[^a-zA-Z0-9_]/', '_', $base) ?? 'user');
        $candidate = $base;
        $i = 0;
        while (User::query()->where('username', $candidate)->exists()) {
            $i++;
            $candidate = $base . '_' . $i;
        }

        return $candidate;
    }
}
