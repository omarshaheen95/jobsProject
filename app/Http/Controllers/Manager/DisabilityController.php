<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\DisabilityRequest;
use App\Models\Disability;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DisabilityController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $rows = Disability::query()->search($request)->latest();
            return DataTables::make($rows)
                ->escapeColumns([])
                ->addColumn('status', function ($row){
                    return $row->status;
                })
                ->addColumn('actions', function ($row){
                    $edit_url = route('manager.disability.edit', $row->id);
                    return view('manager.settings.actions_buttons', compact('row', 'edit_url'));
                })->make();
        }
        $title = 'عرض الاعاقات';
        return view('manager.disability.index', compact('title'));
    }

    public function create()
    {
        $title = 'إضافة إعاقة';
        return view('manager.disability.edit', compact('title'));
    }

    public function store(DisabilityRequest $request)
    {
        $data = $request->validated();
        $data['active'] = $request->get('active', false);
        Disability::query()->create($data);
        return $this->redirectWith(false, 'manager.disability.index', 'تم الإضافة بنجاح');
    }

    public function edit($id)
    {
        $title = 'تعديل الاعاقة';
        $disability = Disability::query()->findOrFail($id);
        return view('manager.disability.edit', compact('disability', 'title'));
    }

    public function update(DisabilityRequest $request, $id)
    {
        $data = $request->validated();
        $data['active'] = $request->get('active', false);
        $disability = Disability::query()->findOrFail($id);
        $disability->update($data);
        return $this->redirectWith(false, 'manager.disability.index', 'تم التعديل بنجاح');
    }

    public function destroy($id)
    {
        $disability = Disability::query()->findOrFail($id);
        $disability->delete();
        return $this->redirectWith(true, null, 'تم الحذف بنجاح');
    }
}
