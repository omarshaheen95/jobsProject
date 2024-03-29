<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\PositionRequest;
use App\Models\Position;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PositionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:positions management');
    }

    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $rows = Position::query()->search($request)->latest();
            return DataTables::make($rows)
                ->escapeColumns([])
                ->addColumn('status', function ($row){
                    return $row->status;
                })
                ->addColumn('actions', function ($row){
                    $edit_url = route('manager.position.edit', $row->id);
                    return view('manager.settings.actions_buttons', compact('row', 'edit_url'));
                })->make();
        }
        $title = 'عرض العناوين الوظيفية';
        return view('manager.position.index', compact('title'));
    }

    public function create()
    {
        $title = 'إضافة عنوان وظيفي';
        return view('manager.position.edit', compact('title'));
    }

    public function store(PositionRequest $request)
    {
        $data = $request->validated();
        $data['active'] = $request->get('active', false);
        Position::query()->create($data);
        return $this->redirectWith(false, 'manager.position.index', 'تم الإضافة بنجاح');
    }

    public function edit($id)
    {
        $title = 'تعديل العنوان الوظيفي';
        $position = Position::query()->findOrFail($id);
        return view('manager.position.edit', compact('position', 'title'));
    }

    public function update(PositionRequest $request, $id)
    {
        $data = $request->validated();
        $data['active'] = $request->get('active', false);
        $position = Position::query()->findOrFail($id);
        $position->update($data);
        return $this->redirectWith(false, 'manager.position.index', 'تم التعديل بنجاح');
    }

    public function destroy($id)
    {
        $position = Position::query()->findOrFail($id);
        $position->delete();
        return $this->redirectWith(true, null, 'تم الحذف بنجاح');
    }
}
