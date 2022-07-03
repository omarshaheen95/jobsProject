<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\GovernorateRequest;
use App\Models\Governorate;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class GovernorateController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:governorates management');
    }

    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $rows = Governorate::query()->search($request)->latest();
            return DataTables::make($rows)
                ->escapeColumns([])
                ->addColumn('status', function ($row){
                    return $row->status;
                })
                ->addColumn('actions', function ($row){
                    $edit_url = route('manager.governorate.edit', $row->id);
                    return view('manager.settings.actions_buttons', compact('row', 'edit_url'));
                })->make();
        }
        $title = 'عرض المحافظات';
        return view('manager.governorate.index', compact('title'));
    }

    public function create()
    {
        $title = 'إضافة محافظة';
        return view('manager.governorate.edit', compact('title'));
    }

    public function store(GovernorateRequest $request)
    {
        $data = $request->validated();
        $data['active'] = $request->get('active', false);
        Governorate::query()->create($data);
        return $this->redirectWith(false, 'manager.governorate.index', 'تم الإضافة بنجاح');
    }

    public function edit($id)
    {
        $title = 'تعديل المحافظة';
        $governorate = Governorate::query()->findOrFail($id);
        return view('manager.governorate.edit', compact('governorate', 'title'));
    }

    public function update(GovernorateRequest $request, $id)
    {
        $data = $request->validated();
        $data['active'] = $request->get('active', false);
        $governorate = Governorate::query()->findOrFail($id);
        $governorate->update($data);
        return $this->redirectWith(false, 'manager.governorate.index', 'تم التعديل بنجاح');
    }

    public function destroy($id)
    {
        $governorate = Governorate::query()->findOrFail($id);
        $governorate->delete();
        return $this->redirectWith(true, null, 'تم الحذف بنجاح');
    }
}
