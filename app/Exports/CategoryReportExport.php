<?php

namespace App\Exports;

use App\Models\Category;
use App\Models\VWBudgetEntry;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class CategoryReportExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithColumnFormatting
{
    public function __construct(public $header)
    {
        $this->header = $header;
    }

    public function headings():array{
        $category = strtoupper($this->header);
        return [
            [
                $category
            ],
            [
                'Date',
                'Budget Entry',
                'Department',
                'Amt. Allocated',
                'Amt. Requested',
                'Amt. Spent',
                'Variance',
                'Percentage (%)',
            ]
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
            2    => ['font' => ['bold' => true]],

            // Styling a specific cell by coordinate.
            'A1' => ['font' => ['size' => 16]],
            // 'B2' => ['font' => ['italic' => true]],

            // // Styling an entire column.
            // 'C'  => ['font' => ['size' => 16]],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 30,
            'C' => 23,
            'D' => 14,
            'E' => 14,
            'F' => 14,
            'G' => 14,
        ];
    }

    public function columnFormats(): array
    {
        return [
            // 'D' => NumberFormat::FORMAT_NUMBER,
            'D' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'F' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'G' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Cache::get('category_report');
    }
}

