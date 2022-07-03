<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\PageRequest;
use App\Models\Page;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:pages management');
    }

    public function index(Request $request)
    {
        if (request()->ajax())
        {
            $search = $request->get('search', false);
            $rows = Page::query()
                ->when($search, function(Builder $query) use($search){
                    $query->where('name', 'like', '%'.$search.'%');
                })
                ->latest();
            return DataTables::make($rows)
                ->escapeColumns([])
                ->addColumn('actions', function ($row){
                    $edit_url = route('manager.page.edit', $row->id);
                    return view('manager.settings.actions_buttons', compact( 'edit_url'));
                })
                ->make();
        }
        $title = 'قائمة الصفحات';
        return view('manager.page.index', compact('title'));
    }

    public function edit($id)
    {
        $page = Page::query()->findOrFail($id);
        $title = 'تعديل الصفحة';
        return view('manager.page.edit', compact('title', 'page'));
    }

    public function update(PageRequest $request, $id)
    {
        $data = $request->validated();
        $page = Page::query()->findOrFail($id);
        $page->update($data);
        return redirect(route('manager.page.index'))->with('message', t('Successfully Updated'));
    }
}
