<?php

namespace App\Http\Controllers\Manager\Lottery;

use App\Exports\ApplicantExport;
use App\Http\Controllers\Controller;
use App\Imports\ApplicantImport;
use App\Jobs\ImportExcelFileJob;
use App\Models\ExcelFile;
use App\Models\Lottery\Applicant;
use App\Models\Lottery\LotteryDegree;
use App\Models\Lottery\LotteryDepartment;
use App\Models\Lottery\LotteryGovernorate;
use App\Models\Lottery\LotteryMinistry;
use App\Models\Lottery\LotteryUniversity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class ApplicantController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:applicants management');
    }

    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $rows = Applicant::query()
                ->with(['lottery_degree', 'lottery_university', 'lottery_college', 'lottery_department', 'lottery_governorate', 'lottery_ministry'])
                ->search($request)
                ->latest();
            return DataTables::make($rows)
                ->escapeColumns([])
                ->make();
        }
        $title = 'عرض المتقدمين';
        $degrees = LotteryDegree::query()->get();
        $universities = LotteryUniversity::query()->get();
        $governorates = LotteryGovernorate::query()->get();
        $ministries = LotteryMinistry::query()->get();

        $sequencing = Applicant::query()->select(['sequencing'])->groupBy(['sequencing'])->get()->pluck('sequencing')->toArray();
        $selected_grades = Applicant::query()->select(['selected_grade'])->groupBy(['selected_grade'])->get()->pluck('selected_grade')->toArray();
        return view('manager.applicant.index', compact('title', 'degrees', 'universities', 'governorates', 'sequencing', 'selected_grades', 'ministries'));
    }

    public function create()
    {
        $title = 'استيراد متقدمين';
        return view('manager.applicant.edit', compact('title'));
    }

    public function edit()
    {
        $title = 'استيراد متقدمين';
        return view('manager.applicant.edit', compact('title'));
    }

    public function applicantImport(Request $request)
    {
        $request->validate([
            'file' => 'required',
        ]);

        $request->validate([
            'file' => 'required',
        ]);

        $file = uploadFile($request->file('file'), 'excel_files');
        $excel_file = ExcelFile::query()->create([
            'file' => $file['path'],
            'file_name' => $file['file_name'],
            'type' => 'applicants',
        ]);
        dispatch(new ImportExcelFileJob($excel_file));
        return redirect()->route('manager.applicant.index')->with('message', 'تم رفع الملف بنجاح وجاري الاستيراد');

    }

    public function applicantExport(Request $request)
    {
        return (new ApplicantExport($request))
            ->download('المتقدمين.xlsx');

    }
}
