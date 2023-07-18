@extends('manager.layout.container')
@section('style')
@endsection
@section('content')
    @push('breadcrumb')
        <li class="breadcrumb-item">
            الاعدادات العامة
        </li>
    @endpush
    <div class="row">
        <div class="col-xl-10 offset-1">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">الاعدادات العامة</h3>
                    </div>
                </div>
                <form enctype="multipart/form-data" id="form_information" class="kt-form kt-form--label-right"
                      action="{{ route('manager.settings.update') }}" method="post">
                    {{ csrf_field() }}
                    <div class="kt-portlet__body">
                        <div class="kt-section kt-section--first">
                            <div class="kt-section__body">
                                @foreach($settings as $setting)
                                    @if($setting->type == 'text')
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">{{$setting->name}}</label>
                                            <div class="col-lg-9 col-xl-6">
                                                <input class="form-control" name="settings[{{$setting->key}}]"
                                                       type="text" value="{{$setting->value}}">
                                            </div>
                                        </div>
                                    @elseif($setting->type == 'textarea')
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">{{$setting->name}}</label>
                                            <div class="col-lg-9 col-xl-6">
                                                <textarea class="form-control"
                                                          name="settings[{{$setting->key}}]">{{$setting->value}}</textarea>
                                            </div>
                                        </div>
                                    @elseif($setting->type == 'bool')
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label">{{$setting->name}}</label>
                                            <div class="col-lg-9 col-xl-6  col-form-label">
                                                <div class="radio-inline">
                                                    <label class="radio radio-primary">
                                                        <input type="radio" value="1" name="settings[{{$setting->key}}]"
                                                               @if($setting->value) checked @endif />
                                                        <span></span>
                                                        تفعيل
                                                    </label>
                                                    <label class="radio radio-primary">
                                                        <input type="radio" value="0" name="settings[{{$setting->key}}]"
                                                               @if($setting->value != 1) checked @endif/>
                                                        <span></span>
                                                        تعطيل
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
{{--                                <div class="form-group row">--}}
{{--                                    <label class="col-xl-3 col-lg-3 col-form-label">--}}
{{--                                        اعتماد الأقسام الحاكمة--}}
{{--                                    </label>--}}
{{--                                    <div class="col-lg-9 col-xl-6">--}}
{{--                                        <a href="{{ route('manager.grade.governor.approve') }}"--}}
{{--                                           class="btn btn-danger btn-elevate btn-icon-sm">--}}
{{--                                            <i class="la la-check"></i>--}}
{{--                                            اعتماد--}}
{{--                                        </a>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col-lg-3 col-xl-3">
                                </div>
                                <div class="col-lg-9 col-xl-9">
                                    <button type="submit" class="btn btn-brand">تحديث</button>&nbsp;
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
    <script>
    </script>
@endsection
