<?php

namespace App\Http\Controllers\Manager\Lottery;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\LotteryMinistryRequest;
use App\Http\Requests\Manager\MinistryRequest;
use App\Models\Lottery\LotteryGovernorate;
use App\Models\Lottery\LotteryMinistry;
use App\Models\Ministry;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LotteryMinistryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:lotteries ministries management');
    }

    public function index(Request $request)
    {
        if ($request->ajax())
        {

            $rows = LotteryMinistry::query()
                ->search($request)
                ->latest();
            return DataTables::make($rows)
                ->escapeColumns([])
                ->addColumn('status', function ($row){
                    return $row->status;
                })
                ->addColumn('actions', function ($row){
                    $edit_url = route('manager.ministry.edit', $row->id);
                    return view('manager.settings.actions_buttons', compact('row', 'edit_url'));
                })->make();
        }
        $title = 'عرض الجهات / الوزارات';
        return view('manager.lottery_ministry.index', compact('title'));
    }

    public function create()
    {
        $title = 'إضافة وزارة / جهة';
        $governorates = LotteryGovernorate::query()->get();
        return view('manager.lottery_ministry.edit', compact('title', 'governorates'));
    }

    public function store(LotteryMinistryRequest $request)
    {
        $data = $request->validated();
        $data['discrimination'] = $request->get('discrimination', false);
        $data['top'] = $request->get('top', false);
        LotteryMinistry::query()->create($data);
        return $this->redirectWith(false, 'manager.ministry.index', 'تم الإضافة بنجاح');
    }

    public function edit($id)
    {
        $title = 'تعديل وزارة / جهة';
        $ministry = LotteryMinistry::query()->findOrFail($id);
        $governorates = LotteryGovernorate::query()->get();
        return view('manager.lottery_ministry.edit', compact('ministry', 'title', 'governorates'));
    }

    public function update(LotteryMinistryRequest $request, $id)
    {
        $data = $request->validated();
        $data['discrimination'] = $request->get('discrimination', false);
        $data['top'] = $request->get('top', false);
        $ministry = LotteryMinistry::query()->findOrFail($id);
        $ministry->update($data);
        return $this->redirectWith(false, 'manager.ministry.index', 'تم التعديل بنجاح');
    }

    public function destroy($id)
    {
        $ministry = LotteryMinistry::query()->findOrFail($id);
        $ministry->delete();
        return $this->redirectWith(true, null, 'تم الحذف بنجاح');
    }
}
