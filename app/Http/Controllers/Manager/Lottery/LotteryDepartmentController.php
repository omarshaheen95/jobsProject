<?php

namespace App\Http\Controllers\Manager\Lottery;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\LotteryDepartmentRequest;
use App\Models\Lottery\LotteryDepartment;
use App\Models\Lottery\LotteryMinistry;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LotteryDepartmentController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('permission:ministries management');
//    }

    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $rows = LotteryDepartment::query()
                ->with(['lottery_ministry'])
                ->search($request)
                ->latest();
            return DataTables::make($rows)
                ->escapeColumns([])
                ->addColumn('status', function ($row){
                    return $row->governor ? 'قسم حاكم':'قسم عام';
                })
                ->addColumn('actions', function ($row){
                    $edit_url = route('manager.department.edit', $row->id);
                    return view('manager.settings.actions_buttons', compact('row', 'edit_url'));
                })->make();
        }
        $title = 'عرض الأقسام';
        $ministries = LotteryMinistry::query()->get();
        return view('manager.lottery_department.index', compact('title', 'ministries'));
    }

    public function create()
    {
        $title = 'إضافة قسم';
        $ministries = LotteryMinistry::query()->get();
        return view('manager.lottery_department.edit', compact('title', 'ministries'));
    }

    public function store(LotteryDepartmentRequest $request)
    {
        $data = $request->validated();
        $data['governor'] = $request->get('governor', false);
        LotteryDepartment::query()->create($data);
        return $this->redirectWith(false, 'manager.department.index', 'تم الإضافة بنجاح');
    }

    public function edit($id)
    {
        $title = 'تعديل القسم';
        $department = LotteryDepartment::query()->findOrFail($id);
        $ministries = LotteryMinistry::query()->get();
        return view('manager.lottery_department.edit', compact('department', 'title', 'ministries'));
    }

    public function update(LotteryDepartmentRequest $request, $id)
    {
        $data = $request->validated();
        $data['governor'] = $request->get('governor', false);
        $department = LotteryDepartment::query()->findOrFail($id);
        $department->update($data);
        return $this->redirectWith(false, 'manager.department.index', 'تم التعديل بنجاح');
    }

    public function destroy($id)
    {
        $department = LotteryDepartment::query()->findOrFail($id);
        $department->delete();
        return $this->redirectWith(true, null, 'تم الحذف بنجاح');
    }
}
