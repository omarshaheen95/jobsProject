<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\DegreeRequest;
use App\Models\Degree;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DegreeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $rows = Degree::query()->search($request)->latest();
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
        $title = 'عرض التخصصات';
        return view('manager.degree.index', compact('title'));
    }

    public function create()
    {
        $title = 'إضافة تخصص';
        return view('manager.degree.edit', compact('title'));
    }

    public function store(DegreeRequest $request)
    {
        $data = $request->validated();
        $data['active'] = $request->get('active', false);
        Degree::query()->create($data);
        return $this->redirectWith(false, 'manager.degree.index', 'تم الإضافة بنجاح');
    }

    public function edit($id)
    {
        $title = 'تعديل التخصص';
        $degree = Degree::query()->findOrFail($id);
        return view('manager.degree.edit', compact('degree', 'title'));
    }

    public function update(DegreeRequest $request, $id)
    {
        $data = $request->validated();
        $data['active'] = $request->get('active', false);
        $degree = Degree::query()->findOrFail($id);
        $degree->update($data);
        return $this->redirectWith(false, 'manager.degree.index', 'تم التعديل بنجاح');
    }

    public function destroy($id)
    {
        $degree = Degree::query()->findOrFail($id);
        $degree->delete();
        return $this->redirectWith(true, null, 'تم الحذف بنجاح');
    }
}
