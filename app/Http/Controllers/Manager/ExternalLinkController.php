<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\ExternalLinkRequest;
use App\Models\ExternalLink;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ExternalLinkController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:external links management');
    }

    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $rows = ExternalLink::query()->search($request)->latest();
            return DataTables::make($rows)
                ->escapeColumns([])
                ->addColumn('status', function ($row){
                    return $row->status;
                })
                ->addColumn('actions', function ($row){
                    $edit_url = route('manager.external-link.edit', $row->id);
                    return view('manager.settings.actions_buttons', compact('row', 'edit_url'));
                })->make();
        }
        $title = 'الروابط الخارجية';
        return view('manager.external_link.index', compact('title'));
    }

    public function create()
    {
        $title = 'إضافة رابط خارجي';
        return view('manager.external_link.edit', compact('title'));
    }

    public function store(ExternalLinkRequest $request)
    {
        $data = $request->validated();
        ExternalLink::query()->create($data);
        return $this->redirectWith(false, 'manager.external-link.index', 'تم الإضافة بنجاح');
    }

    public function edit($id)
    {
        $title = 'تعديل رابط خارجي';
        $external_link = ExternalLink::query()->findOrFail($id);
        return view('manager.external_link.edit', compact('external_link', 'title'));
    }

    public function update(ExternalLinkRequest $request, $id)
    {
        $data = $request->validated();
        $external_link = ExternalLink::query()->findOrFail($id);
        $external_link->update($data);
        return $this->redirectWith(false, 'manager.external-link.index', 'تم التعديل بنجاح');
    }

    public function destroy($id)
    {
        $external_link = ExternalLink::query()->findOrFail($id);
        $external_link->delete();
        return $this->redirectWith(true, null, 'تم الحذف بنجاح');
    }
}
