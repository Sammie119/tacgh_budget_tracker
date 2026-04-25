<?php

namespace App\Exports;

use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class UtilisationReportExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithColumnFormatting
{
    public function __construct(public string $header) {}

    public function headings(): array
    {
        return [
            [strtoupper($this->header)],
            [
                '#',
                'Category',
                'Budget Entry',
                'Department',
                'Amt. Allocated',
                'Amt. Spent',
                'Amt. Remaining',
                'Utilisation (%)',
                'Status',
            ],
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1    => ['font' => ['bold' => true]],
            2    => ['font' => ['bold' => true]],
            'A1' => ['font' => ['size' => 16]],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 6,
            'B' => 22,
            'C' => 30,
            'D' => 22,
            'E' => 16,
            'F' => 16,
            'G' => 16,
            'H' => 16,
            'I' => 14,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'F' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'G' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

    public function collection()
    {
        return Cache::get('utilisation_report', collect());
    }
}
