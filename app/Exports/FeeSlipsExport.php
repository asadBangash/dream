<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class FeeSlipsExport implements FromArray, WithHeadings, WithTitle
{
    public function __construct(private array $rows) {}

    public function array(): array
    {
        return $this->rows;
    }

    public function headings(): array
    {
        return [
            'Slip Ref',
            'Student Name',
            'Student ID',
            'Class',
            'Description',
            'Amount',
            'Paid',
            'Remaining',
            'Status',
            'Payment Date',
        ];
    }

    public function title(): string
    {
        return 'Fee Slips';
    }
}
