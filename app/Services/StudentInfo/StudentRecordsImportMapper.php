<?php

namespace App\Services\StudentInfo;

use App\Enums\Status;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StudentRecordsImportMapper
{
    /** @var array<string, int> */
    private array $branchesByGender = [];

    /** @var array<string, int> */
    private array $departmentsByName = [];

    /** @var array<string, int> */
    private array $classesByName = [];

    /** @var array<string, int> */
    private array $sectionsByName = [];

    /** @var array<int, array<int, true>> class_id => [ section_id => true ] */
    private array $allowedSectionsByClass = [];

    private int $sessionId;

    public function __construct(int $sessionId)
    {
        $this->sessionId = $sessionId;
        $this->loadLookups();
    }

    public function sessionId(): int
    {
        return $this->sessionId;
    }

    private function loadLookups(): void
    {
        if (! \Illuminate\Support\Facades\Schema::hasTable('branches')) {
            return;
        }

        foreach (DB::table('branches')->get(['id', 'name']) as $branch) {
            $name = Str::lower(trim((string) $branch->name));
            if (Str::contains($name, 'boy')) {
                $this->branchesByGender['boy'] = (int) $branch->id;
            }
            if (Str::contains($name, 'girl')) {
                $this->branchesByGender['girl'] = (int) $branch->id;
            }
        }

        foreach (DB::table('departments')->get(['id', 'name']) as $row) {
            $this->departmentsByName[Str::lower(trim($row->name))] = (int) $row->id;
        }

        foreach (DB::table('classes')->get(['id', 'name']) as $row) {
            $this->classesByName[Str::lower(trim($row->name))] = (int) $row->id;
        }

        foreach (DB::table('sections')->get(['id', 'name']) as $row) {
            $this->sectionsByName[Str::lower(trim($row->name))] = (int) $row->id;
        }

        $setups = DB::table('class_setups')
            ->where('session_id', $this->sessionId)
            ->get(['id', 'classes_id']);

        foreach ($setups as $setup) {
            $classId = (int) $setup->classes_id;
            $sectionIds = DB::table('class_setup_childrens')
                ->where('class_setup_id', $setup->id)
                ->pluck('section_id');

            foreach ($sectionIds as $sectionId) {
                $this->allowedSectionsByClass[$classId][(int) $sectionId] = true;
            }
        }
    }

    public function branchSummary(): array
    {
        return $this->branchesByGender;
    }

    /**
     * @param  array<string, mixed>  $row
     * @return array{ok: true, data: array<string, mixed>}|array{ok: false, reason: string}
     */
    public function mapRow(array $row, int $excelRowNumber): array
    {
        $firstName = trim((string) ($row['first_name'] ?? ''));
        $lastName = trim((string) ($row['last_name'] ?? ''));
        if ($firstName === '') {
            return ['ok' => false, 'reason' => 'Missing first name'];
        }

        $genderKey = $this->normalizeGenderKey((string) ($row['branch_gender'] ?? ''));
        if ($genderKey === null) {
            return ['ok' => false, 'reason' => 'Invalid or missing Branch / Gender: ' . ($row['branch_gender'] ?? '')];
        }

        $branchId = $this->branchesByGender[$genderKey] ?? null;
        if (! $branchId) {
            return ['ok' => false, 'reason' => "No {$genderKey} branch found in database (expected Boys Branch / Girls Branch)"];
        }

        $departmentLabel = (string) ($row['department'] ?? '');
        $departmentId = $this->resolveDepartmentId($departmentLabel);

        $classSection = $this->resolveClassAndSection(
            $departmentLabel,
            (string) ($row['class'] ?? ''),
            (string) ($row['section'] ?? ''),
            $departmentId ?? 0
        );
        if ($classSection === null) {
            return [
                'ok' => false,
                'reason' => 'Could not map class/section for department "' . $departmentLabel
                    . '", class "' . ($row['class'] ?? '') . '", section "' . ($row['section'] ?? '') . '"',
            ];
        }

        [$classId, $sectionId] = $classSection;

        if ($departmentId === null) {
            $departmentId = $this->inferDepartmentId($departmentLabel, $classId);
        }

        if (empty($this->allowedSectionsByClass[$classId][$sectionId])) {
            return [
                'ok' => false,
                'reason' => "Section id {$sectionId} is not assigned to class id {$classId} for session {$this->sessionId}",
            ];
        }

        $rollNo = trim((string) ($row['roll_no'] ?? ''));
        $guardianMobile = $this->normalizePhone((string) ($row['guardian_contact'] ?? ''));
        if ($guardianMobile === '') {
            return ['ok' => false, 'reason' => 'Missing guardian / contact phone'];
        }

        $fatherName = trim((string) ($row['father_name'] ?? ''));
        $guardianName = $fatherName !== '' ? $fatherName : trim($firstName . ' ' . $lastName . ' Guardian');

        $genderId = $genderKey === 'boy' ? 1 : 2;

        $status = $this->mapStatus((string) ($row['status'] ?? ''));

        $importCode = $this->importCode($row, $excelRowNumber);

        return [
            'ok' => true,
            'data' => [
                'excel_row' => $excelRowNumber,
                'import_code' => $importCode,
                'branch_id' => $branchId,
                'gender_key' => $genderKey,
                'gender_id' => $genderId,
                'department_id' => $departmentId,
                'class_id' => $classId,
                'section_id' => $sectionId,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'roll_no' => $rollNo !== '' ? $rollNo : null,
                'dob' => $this->parseDate((string) ($row['dob'] ?? '')),
                'admission_date' => $this->parseDate((string) ($row['admission_date'] ?? '')) ?? now()->toDateString(),
                'father_name' => $fatherName,
                'guardian_name' => $guardianName,
                'guardian_mobile' => $guardianMobile,
                'guardian_mobile_display' => trim((string) ($row['guardian_contact'] ?? '')),
                'status' => $status,
            ],
        ];
    }

    private function importCode(array $row, int $excelRowNumber): string
    {
        // Always use sheet row: "Source Row" in the workbook repeats across students.
        return 'excel-combined-row-' . $excelRowNumber;
    }

    private function normalizeGenderKey(string $value): ?string
    {
        $v = Str::lower(trim($value));
        if (in_array($v, ['boy', 'boys', 'male', 'm'], true)) {
            return 'boy';
        }
        if (in_array($v, ['girl', 'girls', 'female', 'f'], true)) {
            return 'girl';
        }

        return null;
    }

    public function normalizePhone(string $phone): string
    {
        $digits = preg_replace('/\D+/', '', $phone) ?? '';

        return strlen($digits) >= 7 ? $digits : '';
    }

    private function resolveDepartmentId(string $name): ?int
    {
        $key = Str::lower(trim($name));
        if ($key === '') {
            return null;
        }

        if (isset($this->departmentsByName[$key])) {
            return $this->departmentsByName[$key];
        }

        $aliases = [
            'english language' => ['english language', 'english', 'language', 'languages'],
            'cit' => ['it & diploma programs', 'it & diploma', 'diploma', 'it'],
            'dit' => ['it & diploma programs', 'it & diploma', 'diploma', 'it'],
            'tuition classes' => ['school tuition', 'tuition', 'school'],
            'tuition' => ['school tuition', 'tuition', 'school'],
        ];

        if (isset($aliases[$key])) {
            foreach ($aliases[$key] as $hint) {
                $id = $this->departmentIdByNameHint($hint);
                if ($id !== null) {
                    return $id;
                }
            }
        }

        foreach ($this->departmentsByName as $deptName => $id) {
            if (Str::contains($deptName, $key) || Str::contains($key, $deptName)) {
                return $id;
            }
        }

        return $this->departmentIdByExcelLabel($key);
    }

    private function departmentIdByExcelLabel(string $excelKey): ?int
    {
        $rules = [
            ['english', 'language', 'languages'],
            ['cit', 'dit', 'diploma', 'it &', 'it '],
            ['tuition', 'school'],
        ];

        if (Str::contains($excelKey, 'english') || Str::contains($excelKey, 'language')) {
            return $this->departmentIdByNameHints(['english', 'language', 'languages']);
        }
        if (in_array($excelKey, ['cit', 'dit'], true) || Str::contains($excelKey, 'it program')) {
            return $this->departmentIdByNameHints(['diploma', 'it &', 'it ']);
        }
        if (Str::contains($excelKey, 'tuition') || Str::contains($excelKey, 'school')) {
            return $this->departmentIdByNameHints(['tuition', 'school']);
        }

        return null;
    }

    /**
     * @param  list<string>  $hints
     */
    private function departmentIdByNameHints(array $hints): ?int
    {
        foreach ($this->departmentsByName as $deptName => $id) {
            foreach ($hints as $hint) {
                if (Str::contains($deptName, $hint)) {
                    return $id;
                }
            }
        }

        return null;
    }

    private function departmentIdByNameHint(string $hint): ?int
    {
        return $this->departmentIdByNameHints([$hint]);
    }

    private function inferDepartmentId(string $departmentLabel, int $classId): ?int
    {
        $className = array_search($classId, $this->classesByName, true);
        if (is_string($className)) {
            if (Str::contains($className, 'english')) {
                return $this->departmentIdByNameHints(['english', 'language', 'languages']);
            }
            if (in_array($className, ['cit', 'dit'], true)) {
                return $this->departmentIdByNameHints(['diploma', 'it']);
            }
            if (Str::startsWith($className, 'class ') || in_array($className, ['prep', 'pg', 'nursery'], true)) {
                return $this->departmentIdByNameHints(['tuition', 'school']);
            }
        }

        return $this->resolveDepartmentId($departmentLabel);
    }

    /**
     * @return array{0: int, 1: int}|null
     */
    private function resolveClassAndSection(string $department, string $classLabel, string $sectionLabel, int $departmentId): ?array
    {
        $deptKey = Str::lower(trim($department));
        $classKey = Str::lower(trim(str_replace(['  ', '-'], ' ', $classLabel)));
        $classKey = preg_replace('/\s+/', ' ', $classKey) ?? $classKey;
        $sectionKey = Str::upper(trim($sectionLabel));

        $englishClassId = $this->classesByName['english language'] ?? null;

        if (in_array($classKey, ['active class', 'activeclass', 'active'], true)
            || ($deptKey === 'english language' && $englishClassId)) {
            $classId = $englishClassId;
            $sectionMap = ['A' => 'active 1', 'B' => 'active 2', 'C' => 'active 3'];
            $sectionName = $sectionMap[$sectionKey] ?? 'active 1';

            return $this->pair($classId, $sectionName);
        }

        if ($deptKey === 'cit' || ($classKey === 'it programs' && $deptKey === 'cit')) {
            return $this->mapItClassSection('cit', $sectionKey);
        }

        if ($deptKey === 'dit' || ($classKey === 'it programs' && $deptKey === 'dit')) {
            return $this->mapItClassSection('dit', $sectionKey);
        }

        if ($classKey === 'it programs') {
            return $this->mapItClassSection('cit', $sectionKey);
        }

        if ($deptKey === 'tuition classes' || $departmentId === ($this->departmentsByName['school tuition'] ?? -1)) {
            if ($classKey === 'prep') {
                return $this->pairByClassName('prep', 'general');
            }
            if (in_array($classKey, ['k.g', 'kg', 'k g'], true)) {
                return $this->pairByClassName('pg', 'general');
            }
            if (is_numeric($classKey)) {
                $grade = (int) $classKey;
                if ($grade >= 1 && $grade <= 12) {
                    $className = 'class ' . $grade;

                    return $this->pairByClassName($className, 'general');
                }
            }
        }

        return null;
    }

    /**
     * @return array{0: int, 1: int}|null
     */
    private function mapItClassSection(string $program, string $sectionKey): ?array
    {
        $className = $program === 'dit' ? 'dit' : 'cit';
        $sectionName = match ($sectionKey) {
            '1ST', '1' => 'semester 1 (6 months)',
            '2ND', '2' => 'semester 2 (6 months)',
            default => 'semester 1 (6 months)',
        };

        return $this->pairByClassName($className, $sectionName);
    }

    /**
     * @return array{0: int, 1: int}|null
     */
    private function pair(?int $classId, string $sectionName): ?array
    {
        if (! $classId) {
            return null;
        }
        $sectionId = $this->sectionsByName[Str::lower(trim($sectionName))] ?? null;
        if (! $sectionId) {
            return null;
        }

        return [(int) $classId, (int) $sectionId];
    }

    /**
     * @return array{0: int, 1: int}|null
     */
    private function pairByClassName(string $className, string $sectionName): ?array
    {
        $classId = $this->classesByName[Str::lower(trim($className))] ?? null;

        return $this->pair($classId, $sectionName);
    }

    private function mapStatus(string $status): int
    {
        $key = Str::upper(trim($status));
        if ($key === 'NOT ACTIVE') {
            return Status::INACTIVE;
        }

        return Status::ACTIVE;
    }

    public function parseDate(string $value): ?string
    {
        $value = trim(str_replace('\\', '/', $value));
        if ($value === '' || preg_match('/^0+\/0+\/\d{4}$/', $value)) {
            return null;
        }

        $formats = ['d/m/Y', 'm/d/Y', 'd-m-Y', 'Y-m-d', 'n/j/Y'];
        foreach ($formats as $format) {
            $dt = \DateTime::createFromFormat($format, $value);
            if ($dt instanceof \DateTime) {
                $errors = \DateTime::getLastErrors();
                if (($errors['warning_count'] ?? 0) === 0 && ($errors['error_count'] ?? 0) === 0) {
                    return $dt->format('Y-m-d');
                }
            }
        }

        $ts = strtotime($value);

        return $ts ? date('Y-m-d', $ts) : null;
    }
}
