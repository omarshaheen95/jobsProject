@extends('manager.layout.container')
@section('content')
    @push('breadcrumb')
        <li class="breadcrumb-item">
            <a href="{{ route('manager.role.index') }}">الأدوار</a>
        </li>
        <li class="breadcrumb-item">
            {{ isset($title) ? $title:'' }}
        </li>
    @endpush
    <div class="row">
        <div class="col-xl-10 offset-1">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">{{ isset($title) ? $title:'' }}</h3>
                    </div>
                </div>
                <form enctype="multipart/form-data" id="form_information" class="kt-form kt-form--label-right"
                      action="{{ isset($role) ? route('manager.role.update', $role->id): route('manager.role.store') }}"
                      method="post">
                    {{ csrf_field() }}
                    @if(isset($role))
                        <input type="hidden" name="_method" value="patch">
                    @endif
                    <div class="kt-portlet__body">
                        <div class="kt-section kt-section--first">
                            <div class="kt-section__body">
                                <div class="form-group row">
                                    <label class="col-2 col-form-label">اسم الدور :</label>
                                    <div class="col-6">
                                        <input class="form-control" name="name" type="text"
                                               value="{{ isset($role) ? $role->name : old("name") }}"
                                               placeholder="اسم الدور"/>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <table class="table table-striped table-bordered w-100">
                                    <thead>
                                    <th colspan="4" class=""><strong>الصلاحيات :</strong> <input type="checkbox"
                                                                                                             id="allPermissions"
                                                                                                             onClick="toggle(this)"/> تحديد الكل
                                        <br/></th>
                                    </thead>
                                    <tbody>
                                    @foreach($permissions as $row)
                                        <tr class="">
                                            @foreach($row as $permission)
                                                <td>
                                                    <input type="checkbox" name="permission[]" value="{{ $permission->id }}" class="name" {{ in_array($permission->id, $rolePermissions) ? 'checked':false }}>
                                                    {{ t($permission->name) }}</td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col-lg-12 text-right">
                                    <button type="submit"
                                            class="btn btn-danger">{{ isset($role) ? 'تعديل':'إنشاء' }}</button>&nbsp;
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest(\App\Http\Requests\Manager\RoleRequest::class, '#form_information') !!}
    <script type="text/javascript">
        function toggle(source) {
            checkboxes = document.getElementsByName('permission[]');
            for(var i=0, n=checkboxes.length;i<n;i++) {
                checkboxes[i].checked = source.checked;
            }
        }
    </script>
@endsection

