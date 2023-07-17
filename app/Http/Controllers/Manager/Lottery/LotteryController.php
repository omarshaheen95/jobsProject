<?php

namespace App\Http\Controllers\Manager\Lottery;

use App\Exports\Lottery\LotteryExport;
use App\Http\Controllers\Controller;
use App\Models\Lottery\Applicant;
use App\Models\Lottery\Grade;
use App\Models\Lottery\Lottery;
use App\Models\Lottery\LotteryDepartment;
use App\Models\Lottery\LotteryMinistry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class LotteryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:lotteries management')->only(['index', 'updateMinistryApplicants']);
        $this->middleware('permission:lotteries histories management')->only(['lotteriesHistory', 'lotteryDelete', 'lotteryExport']);

        $this->middleware('permission:discrimination lotteries management')->only(['updateDiscriminationMinistry']);
        $this->middleware('permission:top lotteries management')->only(['updateTopMinistry']);
        $this->middleware('permission:governor lotteries management')->only(['updateGovernor']);

    }

    public function index(Request $request)
    {
        $expand = true;
        if(config('settings.RUN-LOTTERY') != 1)
        {
            return redirect()->route('manager.home')->with('m-class', 'error')->with('message', 'عملية القرعة غير متاحة');
        }
        $title = 'القرعة';
        $selected_grades = Grade::query()->orderBy('grade_required')->get()->pluck('grade_required')->unique()->toArray();
        return view('manager.lottery.index', compact('title', 'expand', 'selected_grades'));
    }

    public function updateMinistryApplicants(Request $request)
    {
        $request->validate([
            'selected_grade' => 'required',
            'selected_department' => 'required',
            'selected_ministry' => 'required',
            'selected_applicants' => 'required|array',
        ]);
        $lottery = new Lottery();
        $lottery->selected_grade = $request->get('selected_grade');
        $lottery->lottery_department_id = $request->get('selected_department');
        $lottery->lottery_ministry_id = $request->get('selected_ministry');
        $lottery->total = count($request->get('selected_applicants'));
        $lottery->type = 'general';
        $lottery->save();



        Applicant::query()->whereIn('id', $request->get('selected_applicants'))->update([
            'lottery_ministry_id' => $request->get('selected_ministry'),
            'lottery_id' => $lottery->id,

        ]);

        return $this->sendResponse(null);
    }

    public function updateDiscriminationMinistry(Request $request)
    {
        $request->validate([
            'selected_grade' => 'required',
            'selected_department' => 'required',
            'selected_ministry' => 'required',
            'selected_applicants' => 'required|array',
        ]);
        $lottery = new Lottery();
        $lottery->selected_grade = $request->get('selected_grade');
        $lottery->lottery_department_id = $request->get('selected_department');
        $lottery->lottery_ministry_id = $request->get('selected_ministry');
        $lottery->total = count($request->get('selected_applicants'));
        $lottery->type = 'discrimination';

        $lottery->save();

        Applicant::query()->whereIn('id', $request->get('selected_applicants'))->update([
            'lottery_ministry_id' => $request->get('selected_ministry'),
            'lottery_id' => $lottery->id,

        ]);

        return redirect()->route('manager.grade.discrimination')->with('m-class', 'success')->with('message', 'تم اعتماد النتائج بنجاح');
    }

    public function updateTopMinistry(Request $request)
    {
        $request->validate([
            'selected_grade' => 'required',
            'selected_department' => 'required',
            'selected_ministry' => 'required',
            'selected_applicants' => 'required|array',
        ]);
        $lottery = new Lottery();
        $lottery->selected_grade = $request->get('selected_grade');
        $lottery->lottery_department_id = $request->get('selected_department');
        $lottery->lottery_ministry_id = $request->get('selected_ministry');
        $lottery->total = count($request->get('selected_applicants'));
        $lottery->type = 'top';

        $lottery->save();

        Applicant::query()->whereIn('id', $request->get('selected_applicants'))->update([
            'lottery_ministry_id' => $request->get('selected_ministry'),
            'lottery_id' => $lottery->id,

        ]);

        return redirect()->route('manager.grade.top')->with('m-class', 'success')->with('message', 'تم اعتماد النتائج بنجاح');
    }

    public function updateGovernor(Request $request)
    {
        $request->validate([
            'selected_grade' => 'required',
            'selected_department' => 'required',
            'selected_ministry' => 'required',
            'selected_applicants' => 'required|array',
        ]);
        $lottery = new Lottery();
        $lottery->selected_grade = $request->get('selected_grade');
        $lottery->lottery_department_id = $request->get('selected_department');
        $lottery->lottery_ministry_id = $request->get('selected_ministry');
        $lottery->total = count($request->get('selected_applicants'));
        $lottery->type = 'governor';

        $lottery->save();

        Applicant::query()->whereIn('id', $request->get('selected_applicants'))->update([
            'lottery_ministry_id' => $request->get('selected_ministry'),
             'lottery_id' => $lottery->id,
        ]);

        return redirect()->route('manager.grade.governor')->with('m-class', 'success')->with('message', 'تم اعتماد النتائج بنجاح');
    }

    public function lotteriesHistory(Request $request)
    {
        if ($request->ajax()) {
            $rows = Lottery::query()
                ->with(['lottery_department', 'lottery_ministry', 'manager'])
                ->search($request)
                ->latest();
            return DataTables::make($rows)
                ->escapeColumns([])
                ->addColumn('actions', function ($row){
                    return view('manager.settings.actions_buttons', compact('row', ));
                })
                ->make();
        }
        $title = 'سجل القرعات المسجلة';
        $departments = LotteryDepartment::query()->get();
        $ministries = LotteryMinistry::query()->get();
        $selected_grades = Grade::query()->orderBy('grade_required')->get()->pluck('grade_required')->unique()->toArray();
        return view('manager.lottery.history', compact('title', 'departments', 'selected_grades', 'ministries'));

    }

    public function lotteryDelete(Request $request, $id)
    {
        $lottery = Lottery::query()->findOrFail($id);
        DB::transaction(function() use($lottery){
            Applicant::query()->where('lottery_id', $lottery->id)->update([
                'lottery_id' => null,
                'lottery_ministry_id' => null,
            ]);
            $lottery->delete();
        });
        return redirect()->route('manager.lottery.history')->with('m-class', 'success')->with('message', 'تم التراجع عن اعتماد النتائج بنجاح');
    }

    public function lotteryExport(Request $request)
    {
        return (new LotteryExport($request))
            ->download('سجل القرعات المسجلة.xlsx');
    }
}
