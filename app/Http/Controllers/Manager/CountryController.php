<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\CountryRequest;
use App\Models\Country;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CountryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:countries management');
    }

    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $rows = Country::query()->search($request)->latest();
            return DataTables::make($rows)
                ->escapeColumns([])
                ->addColumn('status', function ($row){
                    return $row->status;
                })
                ->addColumn('actions', function ($row){
                    $edit_url = route('manager.country.edit', $row->id);
                    return view('manager.settings.actions_buttons', compact('row', 'edit_url'));
                })->make();
        }
        $title = 'عرض الدول';
        return view('manager.country.index', compact('title'));
    }

    public function create()
    {
        $title = 'إضافة دولة';
        return view('manager.country.edit', compact('title'));
    }

    public function store(CountryRequest $request)
    {
        $data = $request->validated();
        $data['active'] = $request->get('active', false);
        Country::query()->create($data);
        return $this->redirectWith(false, 'manager.country.index', 'تم الإضافة بنجاح');
    }

    public function edit($id)
    {
        $title = 'تعديل الدولة';
        $country = Country::query()->findOrFail($id);
        return view('manager.country.edit', compact('country', 'title'));
    }

    public function update(CountryRequest $request, $id)
    {
        $data = $request->validated();
        $data['active'] = $request->get('active', false);
        $country = Country::query()->findOrFail($id);
        $country->update($data);
        return $this->redirectWith(false, 'manager.country.index', 'تم التعديل بنجاح');
    }

    public function destroy($id)
    {
        $country = Country::query()->findOrFail($id);
        $country->delete();
        return $this->redirectWith(true, null, 'تم الحذف بنجاح');
    }
}
