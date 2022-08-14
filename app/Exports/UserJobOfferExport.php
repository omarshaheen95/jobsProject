<?php

namespace App\Exports;

use App\Models\User;
use App\Models\UserJobOffer;
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

class UserJobOfferExport implements WithMapping,Responsable,WithHeadings,FromCollection,WithEvents,ShouldAutoSize
{
    use Exportable;
    public $req;
    public $id;
    public $length;

    public function __construct(Request $request, $id)
    {
        $this->req = $request;
        $this->id = $id;
    }

    public function headings(): array
    {
        return [
            'حالة الطلب',
            'تاريخ تقديم الطلب',
            'مكان المقابلة',
            'تاريخ المقابلة',
            'رقم الهوية',
            'الإسم كاملا',
            'الموبايل',
            'الهاتف',
            'الجنس',
            'تاريخ الميلاد',
            'العمر',
            'الحالة الإجتماعية',
            'عدد الأبناء',
            'عدد الموظفين في العائلة',
            'فئة الطلاب المبتعثين',
            'فئة الطلاب 10 الأوائل',
            'مكان الميلاد',
            'المحافظة الحالية',
            'العنوان',
            'يعمل في القطاع الخاص',
            'يعمل في منظمات غير حكومية',
            'مسجل عاطل عن العمل في الوزارة',
            'من فئة ذوي الأسرى',
            'من فئة ذوي الجرحى',
            'من فئة ذوي الشهداء',
            'درجة التقديم',
        ];
    }

    public function map($row): array
    {
        return [
            $row->status_name,
            $row->created_at->format('Y-m-d H:i'),
            optional($row->interview)->interview_place,
            optional($row->interview)->interview_date,
            $row->user->userInfo->uid,
            $row->user->userInfo->full_name,
            $row->user->userInfo->mobile,
            $row->user->userInfo->phone,
            $row->user->userInfo->gender_name,
            $row->user->userInfo->dob,
            \Carbon\Carbon::parse($row->user->userInfo->dob)->age,
            $row->user->userInfo->marital_status_name,
            $row->user->userInfo->number_of_children,
            $row->user->userInfo->number_of_employees,
            $row->user->userInfo->scholarship_student ? 'نعم':'لا',
            $row->user->userInfo->top_ten_students ? 'نعم':'لا',
            $row->user->userInfo->birthGovernorate->name,
            $row->user->userInfo->governorate->name,
            $row->user->userInfo->address,
            $row->user->userInfo->unemployed ? 'نعم':'لا',
            $row->user->userInfo->work_nonGovernmental_org ? 'نعم':'لا',
            $row->user->userInfo->registered_unemployed_ministry ? 'نعم':'لا',
            $row->user->userInfo->family_of_prisoners ? 'نعم':'لا',
            $row->user->userInfo->injured_people ? 'نعم':'لا',
            $row->user->userInfo->family_of_martyrs ? 'نعم':'لا',
            $row->total_mark,
        ];
    }

    public function collection()
    {
        $rows = UserJobOffer::query()->has('user')->where('job_offer_id', $this->id)
            ->with(['user', 'user.userInfo', 'interview'])
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
                $cellRange = 'A1:Z1';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold('bold')->setSize(12);
                $event->sheet->styleCells(
                    "A1:Z$this->length",
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
