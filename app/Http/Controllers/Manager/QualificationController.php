<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\QualificationRequest;
use App\Models\Qualification;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class QualificationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $rows = Qualification::query()->latest();
            return DataTables::make($rows)
                ->escapeColumns([])
                ->addColumn('status', function ($row){
                    return $row->status;
                })
                ->addColumn('actions', function ($row){
                    $edit_url = route('manager.qualification.edit', $row->id);
                    return view('manager.settings.actions_buttons', compact('row', 'edit_url'));
                })->make();
        }
        $title = 'عرض المؤهلات';
        return view('manager.qualification.index', compact('title'));
    }

    public function create()
    {
        $title = 'إضافة مؤهل';
        return view('manager.qualification.edit', compact('title'));
    }

    public function store(QualificationRequest $request)
    {
        $data = $request->validated();
        $data['active'] = $request->get('active', false);
        Qualification::query()->create($data);
        return $this->redirectWith(false, 'manager.qualification.index', 'تم الإضافة بنجاح');
    }

    public function edit($id)
    {
        $title = 'تعديل المؤهل';
        $qualification = Qualification::query()->findOrFail($id);
        return view('manager.qualification.edit', compact('qualification', 'title'));
    }

    public function update(QualificationRequest $request, $id)
    {
        $data = $request->validated();
        $data['active'] = $request->get('active', false);
        $qualification = Qualification::query()->findOrFail($id);
        $qualification->update($data);
        return $this->redirectWith(false, 'manager.qualification.index', 'تم التعديل بنجاح');
    }

    public function destroy($id)
    {
        $qualification = Qualification::query()->findOrFail($id);
        $qualification->delete();
        return $this->redirectWith(true, null, 'تم الحذف بنجاح');
    }
}
