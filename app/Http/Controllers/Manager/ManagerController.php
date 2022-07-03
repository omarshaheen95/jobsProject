<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\manager\ManagerRequest;
use App\Models\Manager;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Proengsoft\JsValidation\Facades\JsValidatorFacade as JsValidator;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class ManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:managers management')
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    }

    public function index(Request $request)
    {
        if (request()->ajax()) {
            $name = $request->get('name', false);
            $email = $request->get('email', false);
            $role_id = $request->get('role_id', false);
            $rows = Manager::query()
                ->when($name, function (Builder $query) use ($name) {
                    $query->where(function (Builder $query) use ($name) {
                        $query->where('name', 'like', '%' . $name . '%');
                    });
                })
                ->when($email, function (Builder $query) use ($email) {
                    $query->where(function (Builder $query) use ($email) {
                        $query->where('email', 'like', '%' . $email . '%');
                    });
                })
                ->when($role_id, function (Builder $query) use ($role_id) {
                    $query->whereHas("roles", function ($q) use ($role_id) {
                        $q->where("role_id", $role_id);
                    });
                })
                ->latest();
            return DataTables::make($rows)
                ->escapeColumns([])
                ->addColumn('created_at', function ($row) {
                    return Carbon::parse($row->created_at)->toDateTimeString();
                })
                ->addColumn('roles', function ($row) {
                    return $row->roles_list;
                })
                ->addColumn('actions', function ($row) {
                    $edit_url = route('manager.manager.edit', $row->id);
                    return view('manager.settings.actions_buttons', compact('row', 'edit_url'));
                })
                ->make();
        }
        $title = "عرض المسؤولين";
        $roles = Role::query()->get();
        return view('manager.manager.index', compact('title', 'roles'));
    }

    public function create()
    {
        $title = 'إضافة مسؤول';
        $roles = Role::query()->pluck('name', 'name')->all();
        $managerRole = array();
        return view('manager.manager.edit', compact('title', 'roles', 'managerRole'));
    }

    public function store(ManagerRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($request->get('password', 123456));

//        if ($request->hasFile('image')) {
//            $up_file = uploadFile($request->file('image'), 'admins');
//            $data['image'] = $up_file['path'];
//        }

        $manager = Manager::query()->create($data);
        if ($request->has('roles') && count($request->get('roles')) > 0)
            $manager->assignRole($request->input('roles'));


        return $this->redirectWith(false, 'manager.manager.index', 'تم الإضافة بنجاح');
    }


    public function edit(Manager $manager)
    {
        $title = 'تعديل المسؤول';
        $roles = Role::query()->pluck('name', 'name')->all();
        $managerRole = optional(optional($manager->roles)->pluck('name', 'name'))->all() ?? [];
        return view('manager.manager.edit', compact('manager', 'title', 'roles', 'managerRole'));
    }

    public function update(ManagerRequest $request, Manager $manager)
    {
        $data = $request->validated();
        $data['password'] = $request->get('password', false) ? bcrypt($request->get('password', 123456)) : $manager->password;
        DB::table('model_has_roles')->where('model_id', $manager->id)->delete();

//        if ($request->hasFile('image')) {
//            $up_file = uploadFile($request->file('image'), 'admins');
//            $data['image'] = $up_file['path'];
//        }

        if ($request->has('roles') && count($request->get('roles')) > 0)
            $manager->assignRole($request->input('roles'));

        $manager->update($data);
        return $this->redirectWith(false, 'manager.manager.index', 'تم التعديل بنجاح');
    }

    public function destroy(Manager $manager)
    {
        $manager->delete();
        return $this->redirectWith(true, null, 'تم الحذف بنجاح');
    }

    public function view_profile()
    {
        $title = 'عرض الملف الشخصي';
        $this->validationRules = [
            'name' => 'required',
            'password' => 'nullable',
            'email' => 'required|email|unique:managers,email',
        ];
        $validator = JsValidator::make($this->validationRules);
        return view('manager.manager.profile', compact('title', 'validator'));
    }

    public function profile(Request $request)
    {
        $user = Auth::guard('manager')->user();
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:managers,email,'. $user->id,
        ]);
        $data = $request->all();
        $user->update($data);
        return redirect()->route('manager.home')->with('message', 'تم التحديث بنجاح')->with('m-class', 'success');
    }

    public function view_password()
    {
        $title = 'تغيير كلمة المرور';
        $this->validationRules = [
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed'
        ];
        $validator = JsValidator::make($this->validationRules);
        return view('manager.manager.password', compact('title', 'validator'));
    }

    public function password(Request $request)
    {
        $user = Auth::guard('manager')->user();
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed'
        ]);
        if(Hash::check($request->get('current_password'), $user->password)) {
            $data['password'] = bcrypt($request->get('password'));
            $user->update($data);
        }else{
            return $this->redirectWith(true, null, 'Current Password Invalid', 'error');
        }

        return redirect()->route('manager.home')->with('message', 'تم التحديث بنجاح')->with('m-class', 'success');
    }
}
