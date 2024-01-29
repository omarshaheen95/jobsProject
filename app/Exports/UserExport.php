<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Builder;
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

class UserExport implements WithMapping,Responsable,WithHeadings,FromCollection,WithEvents,ShouldAutoSize
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
            'من فئة ذوي السجٌاء السياسيين',
            'من فئة ذوي الجرحى',
            'من فئة ذوي الشهداء',
        ];
    }

    public function map($user): array
    {
        return [
            $user->userInfo->uid,
            $user->userInfo->full_name,
            $user->userInfo->mobile,
            $user->userInfo->phone,
            $user->userInfo->gender_name,
            $user->userInfo->dob,
            \Carbon\Carbon::parse($user->userInfo->dob)->age,
            $user->userInfo->marital_status_name,
            $user->userInfo->number_of_children,
            $user->userInfo->number_of_employees,
            $user->userInfo->scholarship_student ? 'نعم':'لا',
            $user->userInfo->top_ten_students ? 'نعم':'لا',
            $user->userInfo->birthGovernorate->name,
            $user->userInfo->governorate->name,
            $user->userInfo->address,
            $user->userInfo->unemployed ? 'نعم':'لا',
            $user->userInfo->work_nonGovernmental_org ? 'نعم':'لا',
            $user->userInfo->registered_unemployed_ministry ? 'نعم':'لا',
            $user->userInfo->family_of_prisoners ? 'نعم':'لا',
            $user->userInfo->injured_people ? 'نعم':'لا',
            $user->userInfo->family_of_martyrs ? 'نعم':'لا',
        ];
    }

    public function collection()
    {
        $users = User::query()->with(['userInfo', 'userInfo.birthGovernorate', 'userInfo.governorate'])
            ->search($this->req)
            ->latest()
            ->get();

        $this->length = $users->count() + 1;

        return $users;
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
