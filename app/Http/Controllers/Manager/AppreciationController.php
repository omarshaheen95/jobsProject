<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\AppreciationRequest;
use App\Models\Appreciation;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AppreciationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:appreciations management');
    }

    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $rows = Appreciation::query()->search($request)->latest();
            return DataTables::make($rows)
                ->escapeColumns([])
                ->addColumn('status', function ($row){
                    return $row->status;
                })
                ->addColumn('actions', function ($row){
                    $edit_url = route('manager.degree.edit', $row->id);
                    return view('manager.settings.actions_buttons', compact('row', 'edit_url'));
                })->make();
        }
        $title = 'عرض التقديرات';
        return view('manager.appreciation.index', compact('title'));
    }

    public function create()
    {
        $title = 'إضافة تقدير';
        return view('manager.appreciation.edit', compact('title'));
    }

    public function store(AppreciationRequest $request)
    {
        $data = $request->validated();
        $data['active'] = $request->get('active', false);
        Appreciation::query()->create($data);
        return $this->redirectWith(false, 'manager.appreciation.index', 'تم الإضافة بنجاح');
    }

    public function edit($id)
    {
        $title = 'تعديل التقدير';
        $appreciation = Appreciation::query()->findOrFail($id);
        return view('manager.appreciation.edit', compact('appreciation', 'title'));
    }

    public function update(AppreciationRequest $request, $id)
    {
        $data = $request->validated();
        $data['active'] = $request->get('active', false);
        $appreciation = Appreciation::query()->findOrFail($id);
        $appreciation->update($data);
        return $this->redirectWith(false, 'manager.appreciation.index', 'تم التعديل بنجاح');
    }

    public function destroy($id)
    {
        $appreciation = Appreciation::query()->findOrFail($id);
        $appreciation->delete();
        return $this->redirectWith(true, null, 'تم الحذف بنجاح');
    }
}
