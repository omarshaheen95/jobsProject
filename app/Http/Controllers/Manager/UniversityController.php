<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\UniversityRequest;
use App\Models\University;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UniversityController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:universities management');
    }

    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $rows = University::query()->latest();
            return DataTables::make($rows)
                ->escapeColumns([])
                ->addColumn('status', function ($row){
                    return $row->status;
                })
                ->addColumn('actions', function ($row){
                    $edit_url = route('manager.university.edit', $row->id);
                    return view('manager.settings.actions_buttons', compact('row', 'edit_url'));
                })->make();
        }
        $title = 'عرض الجامعات';
        return view('manager.university.index', compact('title'));
    }

    public function create()
    {
        $title = 'إضافة جامعة';
        return view('manager.university.edit', compact('title'));
    }

    public function store(UniversityRequest $request)
    {
        $data = $request->validated();
        $data['active'] = $request->get('active', false);
        University::query()->create($data);
        return $this->redirectWith(false, 'manager.university.index', 'تم الإضافة بنجاح');
    }

    public function edit($id)
    {
        $title = 'تعديل الجامعة';
        $university = University::query()->findOrFail($id);
        return view('manager.university.edit', compact('university', 'title'));
    }

    public function update(UniversityRequest $request, $id)
    {
        $data = $request->validated();
        $data['active'] = $request->get('active', false);
        $university = University::query()->findOrFail($id);
        $university->update($data);
        return $this->redirectWith(false, 'manager.university.index', 'تم التعديل بنجاح');
    }

    public function destroy($id)
    {
        $ministry = University::query()->findOrFail($id);
        $ministry->delete();
        return $this->redirectWith(true, null, 'تم الحذف بنجاح');
    }
}
