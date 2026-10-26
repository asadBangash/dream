<?php

namespace App\Http\Controllers\Fees;

use App\Exports\FeeSlipsExport;
use App\Http\Controllers\Controller;
use App\Services\Fees\FeeSlipService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class FeeSlipController extends Controller
{
    public function __construct(private FeeSlipService $slips)
    {
        $this->middleware(function ($request, $next) {
            if (! hasPermission('fees_collect_read') && ! hasPermission('report_fees_collection_read')) {
                abort(403);
            }

            return $next($request);
        });
    }

    public function studentPrint(Request $request, int $student)
    {
        $slip = $this->slips->buildSlip(
            $student,
            $this->slips->parseAssignIds($request),
            $request->query('payment_date')
        );

        return view('backend.fees.slip.print', compact('slip'));
    }

    public function studentPdf(Request $request, int $student)
    {
        $slip = $this->slips->buildSlip(
            $student,
            $this->slips->parseAssignIds($request),
            $request->query('payment_date')
        );

        $pdf = PDF::loadView('backend.fees.slip.pdf', compact('slip'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('fee-slip-' . $student . '-' . date('Y-m-d') . '.pdf');
    }

    public function studentExcel(Request $request, int $student)
    {
        $rows = $this->slips->excelRows([$student]);

        return Excel::download(new FeeSlipsExport($rows), 'fee-slip-' . $student . '.xlsx');
    }

    public function bulkPrint(Request $request)
    {
        $studentIds = $this->resolveStudentIds($request);
        $assignIds = $this->slips->parseAssignIds($request);
        $slips = $this->slips->buildMany($studentIds, $assignIds);

        return view('backend.fees.slip.print-bulk', compact('slips'));
    }

    public function bulkPdf(Request $request)
    {
        $studentIds = $this->resolveStudentIds($request);
        $assignIds = $this->slips->parseAssignIds($request);
        $slips = $this->slips->buildMany($studentIds, $assignIds);

        $pdf = PDF::loadView('backend.fees.slip.pdf-bulk', compact('slips'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('fee-slips-' . date('Y-m-d') . '.pdf');
    }

    public function bulkExcel(Request $request)
    {
        $studentIds = $this->resolveStudentIds($request);
        $rows = $this->slips->excelRows($studentIds);

        return Excel::download(new FeeSlipsExport($rows), 'fee-slips-' . date('Y-m-d') . '.xlsx');
    }

    protected function resolveStudentIds(Request $request): array
    {
        $ids = $this->slips->studentIdsForBulk(
            $request->integer('class') ?: null,
            $request->integer('section') ?: null,
            $request->integer('student') ?: null
        );

        abort_if(count($ids) === 0, 404, 'No students found for export.');

        return $ids;
    }
}
