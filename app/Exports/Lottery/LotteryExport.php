<?php

namespace App\Exports\Lottery;

use App\Models\Lottery\Grade;
use App\Models\Lottery\Lottery;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Sheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class LotteryExport implements WithMapping, Responsable, WithHeadings, FromCollection, WithEvents, ShouldAutoSize
{
    use \Maatwebsite\Excel\Concerns\Exportable;

    public $req;
    public $length;

    public function __construct(Request $request)
    {
        $this->req = $request;
    }

    public function headings(): array
    {
        return [
            'الدرجة الوظيفية',
            'القسم',
            'الجهة/الوزارة',
            'العدد',
            'النوع',
            'الاجراء بواسطة',
        ];
    }

    public function map($row): array
    {
        return [
            $row->selected_grade,
            $row->lottery_department->name,
            $row->lottery_ministry->name,
            $row->total,
            $row->type_name,
            optional($row->manager)->name,

        ];
    }

    public function collection()
    {
        $rows = Lottery::query()
            ->with(['lottery_department', 'lottery_ministry', 'manager'])
            ->search($this->req)
            ->latest()
            ->get();

        $this->length = $rows->count() + 1;

        return $rows;
    }

    public function drawings()
    {
        return new Drawing();
    }

    public function registerEvents(): array
    {
        Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
            $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
        });
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:F1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold('bold')->setSize(12);
                $event->sheet->styleCells(
                    "A1:F$this->length",
                    [
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        ],

                    ]
                );
            },
        ];
    }
}
