<?php

namespace App\Services\Fees;

use App\Models\Fees\FeesAssignChildren;
use App\Models\Session;
use App\Models\StudentInfo\SessionClassStudent;
use App\Models\StudentInfo\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class FeeSlipService
{
    public function studentIdsForBulk(?int $classId, ?int $sectionId, ?int $studentId = null): array
    {
        if ($studentId) {
            return [$studentId];
        }

        $query = SessionClassStudent::query()
            ->where('session_id', setting('session'));

        if ($classId) {
            $query->where('classes_id', $classId);
        }
        if ($sectionId) {
            $query->where('section_id', $sectionId);
        }

        return $query->pluck('student_id')->unique()->values()->all();
    }

    public function buildSlip(int $studentId, ?array $assignChildIds = null, ?string $paymentDate = null): array
    {
        $student = Student::with(['parent', 'sessionStudentDetails.class', 'sessionStudentDetails.section'])
            ->findOrFail($studentId);

        $assigned = $this->assignedFees($studentId, $assignChildIds);

        $lines = [];
        $totalDue = 0;
        $totalPaid = 0;

        foreach ($assigned as $item) {
            $payable = $this->payableAmount($item);
            $paid = $item->fees_collect_count > 0 ? (float) ($item->feesCollect?->amount ?? 0) : 0;
            $remaining = max(0, $payable - $paid);

            $dueDate = $item->feesMaster?->due_date;
            $monthLabel = $dueDate ? date('F Y', strtotime($dueDate)) : date('F Y');

            $lines[] = [
                'description' => ($item->feesMaster?->type?->name ?? 'Fee') . ' — ' . $monthLabel,
                'amount'      => $payable,
                'paid'        => $paid,
                'remaining'   => $remaining,
            ];

            $totalDue += $payable;
            $totalPaid += $paid;
        }

        $totalRemaining = max(0, $totalDue - $totalPaid);
        $status = $totalRemaining <= 0 ? 'Paid' : ($totalPaid > 0 ? 'Partial' : 'Pending');

        $session = Session::find(setting('session'));
        $classStudent = $student->sessionStudentDetails;

        return [
            'reference'     => $this->referenceNumber($student),
            'period_label'  => date('F Y', strtotime($paymentDate ?? 'now')),
            'academy_name'  => setting('application_name') ?: config('app.name'),
            'tagline'       => setting('address') ?: '',
            'logo_url'      => globalAsset(setting('light_logo'), '154X38.webp'),
            'student'       => [
                'name'          => trim($student->first_name . ' ' . $student->last_name),
                'admission_no'  => $student->admission_no,
                'class'         => $classStudent?->class?->name ?? '—',
                'section'       => $classStudent?->section?->name ?? '',
                'father_name'   => $student->parent?->guardian_name ?? $student->parent?->father_name ?? '—',
                'phone'         => $student->mobile ?? $student->parent?->guardian_mobile ?? '—',
                'session_year'  => $session?->name ?? date('Y'),
            ],
            'lines'         => $lines,
            'total_due'     => $totalDue,
            'total_paid'    => $totalPaid,
            'total_remaining' => $totalRemaining,
            'status'        => $status,
            'payment_date'  => $paymentDate ? dateFormat($paymentDate) : '—',
            'currency'      => setting('currency_symbol') ?: 'Rs.',
            'footer_note'   => 'This is a computer generated fee slip of ' . (setting('application_name') ?: config('app.name')) . '. Please keep it for your record.',
        ];
    }

    /** @return Collection<int, FeesAssignChildren> */
    public function assignedFees(int $studentId, ?array $assignChildIds = null): Collection
    {
        $query = FeesAssignChildren::withCount('feesCollect')
            ->with(['feesMaster.type', 'feesMaster.group', 'feesCollect', 'feesDiscount'])
            ->where('student_id', $studentId)
            ->whereHas('feesAssign', fn ($q) => $q->where('session_id', setting('session')));

        if ($assignChildIds) {
            $query->whereIn('id', $assignChildIds);
        }

        return $query->get();
    }

    public function buildMany(array $studentIds, ?array $assignChildIds = null): array
    {
        $slips = [];
        foreach ($studentIds as $studentId) {
            $slips[] = $this->buildSlip((int) $studentId, $assignChildIds);
        }

        return $slips;
    }

    public function excelRows(array $studentIds): array
    {
        $rows = [];
        foreach ($studentIds as $studentId) {
            $slip = $this->buildSlip((int) $studentId);
            foreach ($slip['lines'] as $line) {
                $rows[] = [
                    $slip['reference'],
                    $slip['student']['name'],
                    $slip['student']['admission_no'],
                    $slip['student']['class'],
                    $line['description'],
                    $line['amount'],
                    $line['paid'],
                    $line['remaining'],
                    $slip['status'],
                    $slip['payment_date'],
                ];
            }
        }

        return $rows;
    }

    public function parseAssignIds(Request $request): ?array
    {
        $raw = $request->query('assign_ids') ?? $request->query('fees_assign_childrens');
        if (! $raw) {
            return null;
        }

        if (is_array($raw)) {
            return array_filter(array_map('intval', $raw));
        }

        return array_filter(array_map('intval', explode(',', (string) $raw)));
    }

    protected function payableAmount(FeesAssignChildren $item): float
    {
        $amount = (float) ($item->feesMaster?->amount ?? 0);
        $discount = calculateDiscount($amount, $item->feesDiscount?->discount_percentage ?? 0);
        $tax = calculateTax($amount);
        $fine = 0;
        if ($item->feesMaster?->due_date && date('Y-m-d') > $item->feesMaster->due_date && $item->fees_collect_count == 0) {
            $fine = (float) ($item->feesMaster->fine_amount ?? 0);
        }

        return $amount + $tax + $fine - $discount;
    }

    protected function referenceNumber(Student $student): string
    {
        $code = preg_replace('/[^A-Za-z0-9\-]/', '', (string) $student->admission_no) ?: ('STU' . $student->id);

        return 'GR-' . date('Ym') . '-' . strtoupper($code);
    }
}
