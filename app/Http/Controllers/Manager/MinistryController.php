<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\MinistryRequest;
use App\Models\Ministry;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MinistryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $search = $request->get('search', false);
            $rows = Ministry::query()
                ->when($search, function(Builder $query) use($search){
                    $query->where('name', 'like', '%'.$search.'%');
                })
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
        $title = 'عرض الوزارات';
        return view('manager.ministry.index', compact('title'));
    }

    public function create()
    {
        $title = 'إضافة وزارة';
        return view('manager.ministry.edit', compact('title'));
    }

    public function store(MinistryRequest $request)
    {
        $data = $request->validated();
        $data['active'] = $request->get('active', false);
        Ministry::query()->create($data);
        return $this->redirectWith(false, 'manager.ministry.index', 'تم الإضافة بنجاح');
    }

    public function edit($id)
    {
        $title = 'تعديل الوزارة';
        $ministry = Ministry::query()->findOrFail($id);
        return view('manager.ministry.edit', compact('ministry', 'title'));
    }

    public function update(MinistryRequest $request, $id)
    {
        $data = $request->validated();
        $data['active'] = $request->get('active', false);
        $ministry = Ministry::query()->findOrFail($id);
        $ministry->update($data);
        return $this->redirectWith(false, 'manager.ministry.index', 'تم التعديل بنجاح');
    }

    public function destroy($id)
    {
        $ministry = Ministry::query()->findOrFail($id);
        $ministry->delete();
        return $this->redirectWith(true, null, 'تم الحذف بنجاح');
    }
}
