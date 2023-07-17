<?php

namespace App\Exports;

use App\Models\Lottery\Applicant;
use App\Models\Lottery\Grade;
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

class ApplicantExport implements WithMapping, Responsable, WithHeadings, FromCollection, WithEvents, ShouldAutoSize
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
            'الاسم',
            'المعدل',
            'التسلسل',
            'الكود',
            'سنة التخرج',
            'الجامعة',
            'الكلية',
            'القسم',
            'الشهادة',
            'الدرجة الوظيفية',
            'نوع الدراسة',
            'الموبايل',
            'الجنس',
            'المحافظة',
        ];
    }

    public function map($row): array
    {
        return [
            $row->name,
            $row->average,
            $row->sequencing,
            $row->code,
            $row->graduation_year,
            $row->lottery_university->name,
            $row->lottery_college->name,
            $row->lottery_department->name,
            $row->lottery_degree->name,
            $row->selected_grade,
            $row->study_type,
            $row->mobile,
            $row->gender,
            $row->lottery_governorate->name,

        ];
    }

    public function collection()
    {
        $rows = Applicant::query()
            ->with(['lottery_degree', 'lottery_university', 'lottery_college', 'lottery_department', 'lottery_governorate'])
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
                $cellRange = 'A1:O1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold('bold')->setSize(12);
                $event->sheet->styleCells(
                    "A1:O$this->length",
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
