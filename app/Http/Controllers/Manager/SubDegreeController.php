<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\SubDegreeRequest;
use App\Models\Degree;
use App\Models\SubDegree;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SubDegreeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $rows = SubDegree::query()->with(['degree'])->search($request)->latest();
            return DataTables::make($rows)
                ->escapeColumns([])
                ->addColumn('status', function ($row){
                    return $row->status;
                })
                ->addColumn('actions', function ($row){
                    $edit_url = route('manager.sub_degree.edit', $row->id);
                    return view('manager.settings.actions_buttons', compact('row', 'edit_url'));
                })->make();
        }
        $title = 'عرض التخصصات الدقيقة';
        return view('manager.sub_degree.index', compact('title'));
    }

    public function create()
    {
        $title = 'إضافة تخصص دقيق';
        $degrees = Degree::query()->get();
        return view('manager.sub_degree.edit', compact('title', 'degrees'));
    }

    public function store(SubDegreeRequest $request)
    {
        $data = $request->validated();
        $data['active'] = $request->get('active', false);
        SubDegree::query()->create($data);
        return $this->redirectWith(false, 'manager.sub_degree.index', 'تم الإضافة بنجاح');
    }

    public function edit($id)
    {
        $title = 'تعديل التخصص الدقيق';
        $sub_degree = SubDegree::query()->findOrFail($id);
        $degrees = Degree::query()->get();
        return view('manager.sub_degree.edit', compact('sub_degree', 'title', 'degrees'));
    }

    public function update(SubDegreeRequest $request, $id)
    {
        $data = $request->validated();
        $data['active'] = $request->get('active', false);
        $sub_degree = SubDegree::query()->findOrFail($id);
        $sub_degree->update($data);
        return $this->redirectWith(false, 'manager.sub_degree.index', 'تم التعديل بنجاح');
    }

    public function destroy($id)
    {
        $sub_degree = SubDegree::query()->findOrFail($id);
        $sub_degree->delete();
        return $this->redirectWith(true, null, 'تم الحذف بنجاح');
    }
}
