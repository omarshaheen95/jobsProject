<?php

namespace App\Exports;

use App\Models\JobOffer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Sheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class JobOfferExport implements WithMapping,Responsable,WithHeadings,FromCollection,WithEvents,ShouldAutoSize
{
    use Exportable;
    public $req;
    public $length;

    public function __construct(Request $request)
    {
        $this->req = $request;
    }

    public function headings(): array
    {
        return [
            'رقم الاعلان الوظيفي',
            'الاسم',
            'العنوان الوظيفي',
            'التخصص',
            'الجنس',
            'ذوي السجٌاء السياسيين ؟',
            'ذوي الجرحى',
            'ذوي الشهداء',
            'بداية التقديم',
            'نهاية التقديم',
            'تاريخ النشر',
        ];
    }

    public function map($row): array
    {
        return [
            $row->job_uuid,
            $row->name,
            $row->position->name,
            $row->degree->name,
            $row->gender_name,
            $row->family_of_prisoners_name,
            $row->injured_people_name,
            $row->family_of_martyrs_name,
            $row->start_at,
            $row->end_at,
            Carbon::parse($row->publish_at)->format('Y-m-d H:i'),
        ];
    }

    public function collection()
    {
        $rows = JobOffer::query()->with(['position', 'degree'])
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
                $cellRange = 'A1:U1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold('bold')->setSize(12);
                $event->sheet->styleCells(
                    "A1:U$this->length",
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
