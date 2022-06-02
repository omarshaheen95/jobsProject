@extends('manager.layout.container')
@section('content')
    @push('breadcrumb')
        <li class="breadcrumb-item">
            <a href="{{ route('manager.manager.index') }}">المسؤولين</a>
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
                      action="{{ isset($manager) ? route('manager.manager.update', $manager->id): route('manager.manager.store') }}"
                      method="post">
                    {{ csrf_field() }}
                    @if(isset($manager))
                        <input type="hidden" name="_method" value="patch">
                    @endif
                    <div class="kt-portlet__body">
                        <div class="kt-section kt-section--first">
                            <div class="kt-section__body">
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">اسم المسؤول</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <input class="form-control" name="name" type="text" value="{{ isset($manager->name) ? $manager->name : old('name') }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">البريد الإلكتروني</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <input class="form-control" name="email" type="email" value="{{ isset($manager->email) ? $manager->email : old('email') }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">كلمة المرور</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <input class="form-control" name="password" type="text" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">الصلاحيات</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <select multiple name="roles[]" class="form-control">
                                            @foreach($roles as $role)
                                                <option {{ in_array($role, $userRole) ? 'selected':'' }} value="{{ $role }}">{{ $role }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col-lg-12 text-right">
                                    <button type="submit"
                                            class="btn btn-danger">{{ isset($manager) ? 'تعديل':'إنشاء' }}</button>&nbsp;
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
    {!! JsValidator::formRequest(\App\Http\Requests\Manager\ManagerRequest::class, '#form_information') !!}
@endsection
