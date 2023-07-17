<?php

namespace App\Exports\Lottery;

use App\Models\Lottery\Grade;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Sheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class GradeDiscriminationExport implements WithMapping, Responsable, WithHeadings, FromCollection, WithEvents, ShouldAutoSize
{
    use \Maatwebsite\Excel\Concerns\Exportable;

    public $req;
    public $length;
    public $type;
    public $top;
    public $governor;

    public function __construct(Request $request, $type, $top = 0, $governor = 0)
    {
        $this->req = $request;
        $this->type = $type;
        $this->top = $top;
        $this->governor = $governor;
    }

    public function headings(): array
    {
        return [
            'القسم',
            'الدرجة',
            'العدد',
            'الوزارة / الجهة تسمية موحدة',
        ];
    }

    public function map($row): array
    {
        return [
            $row->lottery_department->name,
            $row->grade_required,
            $row->sum_total_required,
            $row->lottery_ministry->name,

        ];
    }

    public function collection()
    {
        $grade = $this->req->get('grade', false);

        $rows = Grade::query()
            ->whereHas('lottery_ministry', function (Builder $query) {
                $query->when($this->type == 1, function (Builder $q) {
                    $q->where('discrimination', 1);
                })->when($this->type == 0, function (Builder $q) {
                    $q->where('discrimination', 0);
                })->when($this->top == 1, function (Builder $q) {
                    $q->where('top', 1);
                });
            })
            ->when($this->top == 1, function (Builder $query) use ($grade) {
                $query
                    ->whereHas('departmentApplicants', function (Builder $query) use ($grade) {
                        $query
                            ->when($grade, function (Builder $query) use ($grade) {
                                $query->where('selected_grade', $grade);
                            })
                            ->whereNull('lottery_ministry_id')
                            ->where('sequencing', 1);
                    });
            })
            ->whereHas('lottery_department', function (Builder $query) use ($grade) {
                $query->where('governor', 0);
            })
            ->select(['lottery_department_id', 'lottery_ministry_id', 'grade_required', DB::raw('SUM( total_required ) AS sum_total_required')])
            ->with(['lottery_department', 'lottery_ministry'])
            ->groupBy(['lottery_department_id', 'lottery_ministry_id', 'grade_required'])
            ->orderBy('sum_total_required', 'desc')
            ->search($this->req)
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
                $cellRange = 'A1:D1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold('bold')->setSize(12);
                $event->sheet->styleCells(
                    "A1:D$this->length",
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
