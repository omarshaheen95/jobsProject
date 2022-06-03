<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $rows = Role::query()->latest();
            return DataTables::make($rows)
                ->escapeColumns([])
                ->addColumn('status', function ($row){
                    return $row->status;
                })
                ->addColumn('actions', function ($row){
                    $edit_url = route('manager.role.edit', $row->id);
                    return view('manager.settings.actions_buttons', compact('row', 'edit_url'));
                })->make();
        }
        $title = 'عرض الأدوار';
        return view('manager.role.index', compact('title'));
    }

    public function create()
    {
        $title = 'إضافة دور';
        $permissions = Permission::query()->get()->groupBy('group');
        return view('manager.role.edit', compact('permissions', 'title'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
//            'permission' => 'required',
        ]);
        $role = Role::create(['guard_name' => 'manager', 'name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission', []));

        return redirect()->route('manager.role.index')
            ->with('message',t(t('Successfully Added')))->with('m-class', 'success');
    }

    public function show($id)
    {
        $title = 'عرض دور';
        $role = Role::query()->find($id);
        $permissions = $role->permissions()->get()->chunk(4);
        return view('manager.role.edit', compact('role', 'permissions', 'title'));
    }

    public function edit($id)
    {
        $title = 'تعديل دور';
        $role = Role::find($id);
        $permissions = Permission::query()->get()->groupBy('group');
        $rolePermissions = $role->permissions()->get()
            ->pluck('id')
            ->all();

        return view('manager.role.edit', compact('role', 'permissions', 'rolePermissions', 'title'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
//            'permission' => 'required',
        ]);


        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();


        $role->syncPermissions($request->input('permission', []));

        return redirect()->route('manager.role.index')
            ->with('message',t(t('Successfully Updated')))->with('m-class', 'success');
    }

    public function destroy($id)
    {
        Role::query()->findOrFail($id)->delete();
        return redirect()->route('manager.role.index')
            ->with('message', t('Successfully Deleted'))->with('m-class', 'success');
    }
}
