<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\LanguageRequest;
use App\Models\Language;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LanguageController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $rows = Language::query()->search($request)->latest();
            return DataTables::make($rows)
                ->escapeColumns([])
                ->addColumn('status', function ($row){
                    return $row->status;
                })
                ->addColumn('actions', function ($row){
                    $edit_url = route('manager.language.edit', $row->id);
                    return view('manager.settings.actions_buttons', compact('row', 'edit_url'));
                })->make();
        }
        $title = 'عرض اللغات';
        return view('manager.language.index', compact('title'));
    }

    public function create()
    {
        $title = 'إضافة لغة';
        return view('manager.language.edit', compact('title'));
    }

    public function store(LanguageRequest $request)
    {
        $data = $request->validated();
        $data['active'] = $request->get('active', false);
        Language::query()->create($data);
        return $this->redirectWith(false, 'manager.language.index', 'تم الإضافة بنجاح');
    }

    public function edit($id)
    {
        $title = 'تعديل اللغة';
        $language = Language::query()->findOrFail($id);
        return view('manager.language.edit', compact('language', 'title'));
    }

    public function update(LanguageRequest $request, $id)
    {
        $data = $request->validated();
        $data['active'] = $request->get('active', false);
        $language = Language::query()->findOrFail($id);
        $language->update($data);
        return $this->redirectWith(false, 'manager.language.index', 'تم التعديل بنجاح');
    }

    public function destroy($id)
    {
        $language = Language::query()->findOrFail($id);
        $language->delete();
        return $this->redirectWith(true, null, 'تم الحذف بنجاح');
    }
}
