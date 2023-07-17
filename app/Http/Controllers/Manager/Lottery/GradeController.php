<?php

namespace App\Http\Controllers\Manager\Lottery;

use App\Exports\GradeExport;
use App\Exports\Lottery\GradeDiscriminationExport;
use App\Exports\Lottery\GradeGovernorExport;
use App\Http\Controllers\Controller;
use App\Imports\GradeImport;
use App\Jobs\GradeImportJob;
use App\Jobs\ImportExcelFileJob;
use App\Models\ExcelFile;
use App\Models\Lottery\Applicant;
use App\Models\Lottery\Grade;
use App\Models\Lottery\LotteryDegree;
use App\Models\Lottery\LotteryDepartment;
use App\Models\Lottery\LotteryMinistry;
use App\Models\Lottery\LotteryPosition;
use App\Models\Lottery\LotteryUniversity;
use App\Models\UserExcelFile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class GradeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:grades management')
            ->only(['index', 'gradesGeneral', 'gradesGeneralLottery', 'create', 'edit', 'gradeImport', 'gradeExport', 'gradeGeneralExport']);

        $this->middleware('permission:discrimination lotteries management')
            ->only(['gradesDiscrimination', 'gradesDiscriminationLottery', 'gradeDiscriminationExport']);

        $this->middleware('permission:top lotteries management')
            ->only(['gradesTop', 'gradesTopLottery', 'gradeTopExport']);

        $this->middleware('permission:governor lotteries management')
            ->only(['governorGrades', 'governorGradesApprove', 'gradesGovernorLottery', 'gradeGovernorExport']);

    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $rows = Grade::query()
                ->with(['lottery_degree', 'lottery_university', 'lottery_college', 'lottery_department', 'lottery_position', 'lottery_ministry'])
                ->search($request)
                ->latest();
            return DataTables::make($rows)
                ->escapeColumns([])
                ->make();
        }
        $title = 'سجل الدرجات المستحدثة';
        $degrees = LotteryDegree::query()->get();
        $universities = LotteryUniversity::query()->get();
        $positions = LotteryPosition::query()->get();
        $ministries = LotteryMinistry::query()->get();
        $selected_grades = Grade::query()->orderBy('grade_required')->get()->pluck('grade_required')->unique()->toArray();
        return view('manager.grade.index', compact('title', 'degrees', 'universities', 'ministries', 'positions', 'selected_grades'));
    }

    public function gradesDiscrimination(Request $request)
    {
        if ($request->ajax()) {
            $rows = Grade::query()
                ->whereHas('lottery_ministry', function (Builder $query) {
                    $query->where('discrimination', 1);
                })
                ->select(['lottery_department_id', 'lottery_ministry_id', 'grade_required', DB::raw('SUM( total_required ) AS sum_total_required')])
                ->with(['lottery_department', 'lottery_ministry'])
                ->groupBy(['lottery_department_id', 'lottery_ministry_id', 'grade_required'])
                ->orderBy('sum_total_required', 'desc')
                ->search($request);
            return DataTables::make($rows)
                ->escapeColumns([])
                ->addColumn('actions', function ($row) {
                    $lottery_url = route('manager.grade.discrimination.lottery', [
                        'ministry' => $row->lottery_ministry_id,
                        'department' => $row->lottery_department_id,
                        'grade' => $row->grade_required,
                    ]);
                    return view('manager.settings.actions_buttons', compact('row', 'lottery_url'));
                })
                ->make();
        }
        $title = '';
        $ministries = LotteryMinistry::query()->where('discrimination', 1)->get();
        $selected_grades = Grade::query()->orderBy('grade_required')->get()->pluck('grade_required')->unique()->toArray();
        return view('manager.grade.discrimination', compact('title', 'ministries', 'selected_grades'));
    }

    public function gradesTop(Request $request)
    {
        if ($request->ajax()) {
            $grade = $request->get('grade', false);
            $rows = Grade::query()
                ->whereHas('lottery_ministry', function (Builder $query) {
                    $query->where('top', 1);
                })
                ->whereHas('departmentApplicants', function (Builder $query) use ($grade) {
                    $query->when($grade, function (Builder $query) use ($grade) {
                        $query->where('selected_grade', $grade);
                    })
                        ->whereRelation('lottery_degree', 'name', 'like', '%بكالوريوس%')
                        ->whereNull('lottery_ministry_id')
                        ->where('sequencing', 1);
                })
                ->with(['lottery_department', 'lottery_ministry'])
                ->select(['lottery_department_id', 'lottery_ministry_id', 'grade_required', DB::raw('SUM( total_required ) AS sum_total_required')])
                ->groupBy(['lottery_department_id', 'lottery_ministry_id', 'grade_required'])
                ->orderBy('sum_total_required', 'desc')
                ->search($request);
            return DataTables::make($rows)
                ->escapeColumns([])
                ->addColumn('actions', function ($row) {
                    $lottery_url = route('manager.grade.top.lottery', [
                        'ministry' => $row->lottery_ministry_id,
                        'department' => $row->lottery_department_id,
                        'grade' => $row->grade_required,
                    ]);
                    return view('manager.settings.actions_buttons', compact('row', 'lottery_url'));
                })
                ->make();
        }
        $title = '';
        $ministries = LotteryMinistry::query()->where('discrimination', 1)->where('top', 1)->get();
        $selected_grades = Applicant::query()->where('sequencing', 1)->orderBy('selected_grade')->get()->pluck('selected_grade')->unique()->toArray();
        return view('manager.grade.top', compact('title', 'ministries', 'selected_grades'));
    }

    public function gradesDiscriminationLottery(Request $request)
    {
        $request->validate([
            'department' => 'required',
            'ministry' => 'required',
            'grade' => 'required',
        ], [
            'department.required' => 'يرجى اختيار بيانات صحيحة',
            'ministry.required' => 'يرجى اختيار بيانات صحيحة',
            'grade.required' => 'يرجى اختيار بيانات صحيحة',
        ]);
        $row = Grade::query()
            ->whereHas('lottery_ministry', function (Builder $query) {
                $query->where('discrimination', 1);
            })
            ->select(['lottery_department_id', 'lottery_ministry_id', 'grade_required', DB::raw('SUM( total_required ) AS sum_total_required')])
            ->with(['lottery_department', 'lottery_ministry'])
            ->groupBy(['lottery_department_id', 'lottery_ministry_id', 'grade_required'])
            ->orderBy('sum_total_required', 'desc')
            ->search($request)
            ->first();

        if (!$row) {
            return redirect()->route('manager.grade.discrimination')->with('message', 'يرجى اختيار بيانات صحيحة')->with('m-class', 'error');
        }

        $title = "استثناء " . $row->lottery_ministry->name;

        $old_applicants = Applicant::query()
            ->where('lottery_department_id', $request->get('department'))
            ->where('selected_grade', $request->get('grade'))
            ->where('lottery_ministry_id', $request->get('ministry'))
            ->count();

        $applicants = Applicant::query()
            ->when(!is_null($row->lottery_ministry->lottery_governorate_id), function(Builder $query) use($row){
                $query->where('lottery_governorate_id', $row->lottery_ministry->lottery_governorate_id);
            })
            ->where('lottery_department_id', $request->get('department'))
            ->where('lottery_department_id', $request->get('department'))
            ->where('selected_grade', $request->get('grade'))
            ->whereNull('lottery_ministry_id')
            ->inRandomOrder()
            ->inRandomOrder()
            ->inRandomOrder()
            ->get();

        $total_needs = $row->sum_total_required - $old_applicants;
//        dd($total_needs);

        $expand = true;
        $count = 1;

        return view('manager.grade.lottery', compact('title', 'row', 'applicants', 'old_applicants', 'expand', 'total_needs', 'count'));
    }

    public function gradesTopLottery(Request $request)
    {
        $request->validate([
            'department' => 'required',
            'ministry' => 'required',
            'grade' => 'required',
        ], [
            'department.required' => 'يرجى اختيار بيانات صحيحة',
            'ministry.required' => 'يرجى اختيار بيانات صحيحة',
            'grade.required' => 'يرجى اختيار بيانات صحيحة',
        ]);
        $row = Grade::query()
            ->whereHas('lottery_ministry', function (Builder $query) {
                $query->where('discrimination', 1);
                $query->where('top', 1);
            })
            ->select(['lottery_department_id', 'lottery_ministry_id', 'grade_required', DB::raw('SUM( total_required ) AS sum_total_required')])
            ->with(['lottery_department', 'lottery_ministry'])
            ->groupBy(['lottery_department_id', 'lottery_ministry_id', 'grade_required'])
            ->orderBy('sum_total_required', 'desc')
            ->search($request)
            ->firstOrFail();

        if (!$row) {
            return redirect()->route('manager.grade.top')->with('message', 'يرجى اختيار بيانات صحيحة')->with('m-class', 'error');
        }

        $title = "استثناءالأوائل " . $row->lottery_ministry->name;

        $old_applicants = Applicant::query()
            ->where('lottery_department_id', $request->get('department'))
            ->where('selected_grade', $request->get('grade'))
            ->where('lottery_ministry_id', $request->get('ministry'))
            ->count();

        $applicants = Applicant::query()
            ->where('lottery_department_id', $request->get('department'))
//            ->where('selected_grade', 7)
            ->where('selected_grade', $request->get('grade'))
            ->whereRelation('lottery_degree', 'name', 'like', '%بكالوريوس%')
            ->whereNull('lottery_ministry_id')
            ->where('sequencing', 1)
            ->inRandomOrder()
            ->inRandomOrder()
            ->inRandomOrder()
            ->get();


        $total_needs = $row->sum_total_required - $old_applicants;

        $expand = true;
        $count = 1;

        $route = route('manager.lottery.update-top-ministry');
        return view('manager.grade.lottery', compact('title', 'row', 'applicants', 'old_applicants', 'expand', 'total_needs', 'count', 'route'));
    }

    public function gradesGeneral(Request $request)
    {
        if ($request->ajax()) {
            $rows = Grade::query()
                ->whereHas('lottery_ministry', function (Builder $query) {
                    $query->where('discrimination', 0);
                })
                ->whereHas('lottery_department', function(Builder $query){
                    $query->where('governor', 0);
                })
                ->select(['lottery_department_id', 'lottery_ministry_id', 'grade_required', DB::raw('SUM( total_required ) AS sum_total_required')])
                ->with(['lottery_department', 'lottery_ministry'])
                ->groupBy(['lottery_department_id', 'lottery_ministry_id', 'grade_required'])
                ->orderBy('sum_total_required', 'desc')
                ->search($request);
            return DataTables::make($rows)
                ->escapeColumns([])
                ->addColumn('actions', function ($row) {
                    $lottery_url = route('manager.grade.general.lottery', [
                        'ministry' => $row->lottery_ministry_id,
                        'department' => $row->lottery_department_id,
                        'grade' => $row->grade_required,
                    ]);
                    return view('manager.settings.actions_buttons', compact('row', 'lottery_url'));
                })
                ->make();
        }
        $title = '';
        $ministries = LotteryMinistry::query()->get();
        $selected_grades = Grade::query()->orderBy('grade_required')->get()->pluck('grade_required')->unique()->toArray();
        return view('manager.grade.general', compact('title', 'ministries', 'selected_grades'));
    }

    public function gradesGeneralLottery(Request $request)
    {
        $request->validate([
            'department' => 'required',
            'ministry' => 'required',
            'grade' => 'required',
        ], [
            'department.required' => 'يرجى اختيار بيانات صحيحة',
            'ministry.required' => 'يرجى اختيار بيانات صحيحة',
            'grade.required' => 'يرجى اختيار بيانات صحيحة',
        ]);
        $row = Grade::query()
            ->whereHas('lottery_ministry', function (Builder $query) {
                $query->where('discrimination', 0);
            })
            ->select(['lottery_department_id', 'lottery_ministry_id', 'grade_required', DB::raw('SUM( total_required ) AS sum_total_required')])
            ->with(['lottery_department', 'lottery_ministry'])
            ->groupBy(['lottery_department_id', 'lottery_ministry_id', 'grade_required'])
            ->orderBy('sum_total_required', 'desc')
            ->search($request)
            ->first();

        if (!$row) {
            return redirect()->route('manager.grade.general')->with('message', 'يرجى اختيار بيانات صحيحة')->with('m-class', 'error');
        }

        $title = "استثناءالأوائل " . $row->lottery_ministry->name;

        $old_applicants = Applicant::query()
            ->where('lottery_department_id', $request->get('department'))
            ->where('selected_grade', $request->get('grade'))
            ->where('lottery_ministry_id', $request->get('ministry'))
            ->count();

        $applicants = Applicant::query()
            ->where('lottery_department_id', $request->get('department'))
//            ->where('selected_grade', 7)
            ->where('selected_grade', $request->get('grade'))
            ->whereNull('lottery_ministry_id')
            ->where('sequencing', 1)
            ->inRandomOrder()
            ->inRandomOrder()
            ->inRandomOrder()
            ->count();


        $total_needs = $row->sum_total_required - $old_applicants;

        $expand = true;
        $count = 1;

        $route = route('manager.lottery.update-top-ministry');
        return view('manager.grade.lottery_general', compact('title', 'row', 'applicants', 'old_applicants', 'expand', 'total_needs', 'count', 'route'));
    }

    public function create()
    {
        $title = 'استيراد درجات مستحدثة';
        return view('manager.grade.edit', compact('title'));
    }

    public function edit()
    {
        $title = 'استيراد درجات مستحدثة';
        return view('manager.grade.edit', compact('title'));
    }

    public function gradeImport(Request $request)
    {
        $request->validate([
            'file' => 'required',
        ]);

        $file = uploadFile($request->file('file'), 'excel_files');
        $excel_file = ExcelFile::query()->create([
            'file' => $file['path'],
            'file_name' => $file['file_name'],
            'type' => 'grades',
        ]);

        dispatch(new ImportExcelFileJob($excel_file));
        return redirect()->route('manager.grade.index')->with('message', 'تم رفع الملف بنجاح وجاري الاستيراد');

    }

    public function gradeExport(Request $request)
    {
        return (new GradeExport($request))
            ->download('الدرجات المستحدثة.xlsx');

    }

    public function gradeDiscriminationExport(Request $request)
    {
        return (new GradeDiscriminationExport($request, 1))
            ->download('الدرجات المستحدثة(الاستثناءات).xlsx');

    }

    public function gradeTopExport(Request $request)
    {
        return (new GradeDiscriminationExport($request, 1, 1))
            ->download('الدرجات المستحدثة(الأوائل).xlsx');

    }

    public function gradeGeneralExport(Request $request)
    {
        return (new GradeDiscriminationExport($request, 0))
            ->download('الدرجات المستحدثة(العامة).xlsx');

    }

    public function gradeGovernorExport(Request $request)
    {
        return (new GradeGovernorExport($request))
            ->download('الدرجات المستحدثة(الأقسام الحاكمة).xlsx');

    }

    public function governorGrades(Request $request)
    {
        if ($request->ajax()) {
            $rows = Grade::query()
                ->with(['lottery_department', 'lottery_ministry'])
               ->whereHas('lottery_department', function(Builder $query){
                   $query->where('governor', 1);
               })
                ->search($request);
            return DataTables::make($rows)
                ->escapeColumns([])
                ->addColumn('actions', function ($row) {
                    $lottery_url = route('manager.grade.governor.lottery', [
                        'ministry' => $row->lottery_ministry_id,
                        'department' => $row->lottery_department_id,
                        'grade' => $row->grade_required,
                    ]);
                    return view('manager.settings.actions_buttons', compact('row', 'lottery_url'));
                })
                ->addColumn('available', function ($row) {
                       return Applicant::query()->whereNull('lottery_ministry_id')
                           ->where('lottery_department_id', $row->lottery_department_id)
                           ->where('selected_grade', $row->grade_required)
                           ->count();
                })
                ->addColumn('used', function ($row) {
                    return Applicant::query()
                        ->where('lottery_ministry_id', $row->lottery_ministry_id)
                        ->where('lottery_department_id', $row->lottery_department_id)
                        ->where('selected_grade', $row->grade_required)
                        ->count();
                })
                ->make();
        }
        $title = '';
        $ministries = LotteryMinistry::query()->get();
        $selected_grades = Grade::query()->orderBy('grade_required')->get()->pluck('grade_required')->unique()->toArray();
        return view('manager.grade.governor', compact('title', 'ministries', 'selected_grades'));
    }

    public function governorGradesApprove()
    {
        $departments = Grade::query()
            ->select([DB::raw('COUNT(*) as c'), 'lottery_department_id'])
            ->groupBy(['lottery_department_id',])
            ->having('c' ,1)
            ->get()
            ->pluck('lottery_department_id')->toArray();

        LotteryDepartment::query()->whereNotIn('id', $departments)->update([
            'governor' => 0
        ]);
        LotteryDepartment::query()->whereIn('id', $departments)->update([
            'governor' => 1
        ]);

        return redirect()->route('manager.grade.governor')->with('message', 'تم إعتماد درجات الأقسام الحاكمة بنجاح');
    }

    public function gradesGovernorLottery(Request $request)
    {
        $request->validate([
            'department' => 'required',
            'ministry' => 'required',
            'grade' => 'required',
        ], [
            'department.required' => 'يرجى اختيار بيانات صحيحة',
            'ministry.required' => 'يرجى اختيار بيانات صحيحة',
            'grade.required' => 'يرجى اختيار بيانات صحيحة',
        ]);
        $row = Grade::query()
            ->has('lottery_department')
            ->select(['lottery_department_id', 'lottery_ministry_id', 'grade_required', DB::raw('SUM( total_required ) AS sum_total_required')])
            ->with(['lottery_department', 'lottery_ministry'])
            ->groupBy(['lottery_department_id', 'lottery_ministry_id', 'grade_required'])
            ->orderBy('sum_total_required', 'desc')
            ->search($request)
            ->firstOrFail();

        if (!$row) {
            return redirect()->route('manager.grade.top')->with('message', 'يرجى اختيار بيانات صحيحة')->with('m-class', 'error');
        }

        $title = "استثناء الأقسام الحاكمة " . $row->lottery_department->name;

        $old_applicants = Applicant::query()
            ->where('lottery_department_id', $request->get('department'))
            ->where('selected_grade', $request->get('grade'))
            ->where('lottery_ministry_id', $request->get('ministry'))
            ->count();

        $applicants = Applicant::query()
            ->where('lottery_department_id', $request->get('department'))
            ->where('selected_grade', $request->get('grade'))
            ->whereNull('lottery_ministry_id')
            ->inRandomOrder()
            ->inRandomOrder()
            ->inRandomOrder()
            ->get();


        $total_needs = $row->sum_total_required - $old_applicants;

        $expand = true;
        $count = 1;

        $route = route('manager.lottery.update-governor');
        return view('manager.grade.governor_lottery', compact('title', 'row', 'applicants', 'old_applicants', 'expand', 'total_needs', 'count', 'route'));
    }


}
