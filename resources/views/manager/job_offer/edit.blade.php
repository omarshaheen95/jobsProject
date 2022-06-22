@extends('manager.layout.container')
@section('b_style')
    <link href="{{asset('assets/css/demo1/pages/general/wizard/wizard-3.rtl.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/vendors/general/sweetalert2/dist/sweetalert2.rtl.css')}}" rel="stylesheet"
          type="text/css"/>
@endsection
@section('style')
    <link href="{{ asset('assets/vendors/general/summernote/dist/summernote.rtl.css') }}" rel="stylesheet"/>
    <link href="{{asset('assets/vendors/general/bootstrap-tagsinput/dist/bootstrap-tagsinput.css')}}" rel="stylesheet"/>
    <link href="{{asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css') }}"
          rel="stylesheet" type="text/css"/>

    <style>
        .bootstrap-tagsinput .tag {
            margin-right: 2px;
            color: #ffffff;
            background: #2196f3;
            padding: 3px 7px;
            border-radius: 3px;
        }

        .bootstrap-tagsinput {
            width: 100%;
        }
    </style>
@endsection
@section('content')
    @push('breadcrumb')
        <li class="breadcrumb-item">
            <a href="{{ route('manager.job_offer.index') }}">العروض الوظيفية</a>
        </li>
        <li class="breadcrumb-item">
            {{ isset($title) ? $title:'' }}
        </li>
    @endpush
    <div class="row">
        <div class="col-xl-12">
            <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
                <div class="kt-portlet">
                    <div class="kt-portlet__body kt-portlet__body--fit">
                        <div class="kt-grid kt-wizard-v3 kt-wizard-v3--white" id="kt_wizard_v3"
                             data-ktwizard-state="step-first">
                            <div class="kt-grid__item">

                                <!--begin: Form Wizard Nav -->
                                <div class="kt-wizard-v3__nav">
                                    <div class="kt-wizard-v3__nav-items">
                                        <a class="kt-wizard-v3__nav-item" data-step="1" href="#"
                                           data-ktwizard-type="step" data-ktwizard-state="current">
                                            <div class="kt-wizard-v3__nav-body">
                                                <div class="kt-wizard-v3__nav-label">
                                                    <span>1</span> البيانات الاساسية
                                                </div>
                                                <div class="kt-wizard-v3__nav-bar"></div>
                                            </div>
                                        </a>
                                        <a class="kt-wizard-v3__nav-item" data-step="2" href="#"
                                           data-ktwizard-type="step">
                                            <div class="kt-wizard-v3__nav-body">
                                                <div class="kt-wizard-v3__nav-label">
                                                    <span>2</span>التخصيص والتحديد
                                                </div>
                                                <div class="kt-wizard-v3__nav-bar"></div>
                                            </div>
                                        </a>
                                        <a class="kt-wizard-v3__nav-item" data-step="3" href="#"
                                           data-ktwizard-type="step">
                                            <div class="kt-wizard-v3__nav-body">
                                                <div class="kt-wizard-v3__nav-label">
                                                    <span>3</span> الشروط الوظيفية
                                                </div>
                                                <div class="kt-wizard-v3__nav-bar"></div>
                                            </div>
                                        </a>
                                        <a class="kt-wizard-v3__nav-item" data-step="4" href="#"
                                           data-ktwizard-type="step">
                                            <div class="kt-wizard-v3__nav-body">
                                                <div class="kt-wizard-v3__nav-label">
                                                    <span>4</span> المهام الوظيفية
                                                </div>
                                                <div class="kt-wizard-v3__nav-bar"></div>
                                            </div>
                                        </a>
                                        <a class="kt-wizard-v3__nav-item" data-step="5" href="#"
                                           data-ktwizard-type="step">
                                            <div class="kt-wizard-v3__nav-body">
                                                <div class="kt-wizard-v3__nav-label">
                                                    <span>5</span> نشر العرض الوظيفي
                                                </div>
                                                <div class="kt-wizard-v3__nav-bar"></div>
                                            </div>
                                        </a>
                                    </div>
                                </div>

                                <!--end: Form Wizard Nav -->
                            </div>
                            <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v3__wrapper">

                                <!--begin: Form Wizard Form-->
                                <form class="kt-form" method="post"
                                      action="{{isset($job_offer) ? route('manager.job_offer.update', $job_offer->id):route('manager.job_offer.store')}}"
                                      id="kt_form">
                                    {{ csrf_field() }}
                                    @if(isset($job_offer))
                                        <input type="hidden" name="_method" value="patch">
                                    @endif
                                    <!--begin: Form Wizard Step 1-->
                                    <div class="kt-wizard-v3__content" data-ktwizard-type="step-content"
                                         data-ktwizard-state="current">
                                        <div class="row">
                                            <div class="col-xl-10">
                                                <div class="form-group">
                                                    <label>اسم/عنوان العرض الوظيفي</label>
                                                    <input type="text" class="form-control" name="name"
                                                           placeholder="اسم/عنوان العرض الوظيفي"
                                                           value="{{isset($job_offer) ? $job_offer->name:old('name')}}">
                                                </div>
                                            </div>
                                            <div class="col-xl-2">
                                                <div class="form-group">
                                                    <label>رقم الإعلان الوظيفي</label>
                                                    <input type="text" class="form-control" name="job_uuid"
                                                           placeholder="رقم الإعلان"
                                                           value="{{isset($job_offer) ? $job_offer->job_uuid:old('job_uuid')}}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>المسمى الوظيفي</label>
                                                    <select class="form-control select2L" title="اختر مسمى وظيفي"
                                                            name="position_id">
                                                        @foreach($positions as $position)
                                                            <option
                                                                {{isset($job_offer) && $job_offer->position_id == $position->id ? 'selected':''}} value="{{$position->id}}">{{$position->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>الجنس</label>
                                                    <div class="kt-radio-inline">
                                                        <label class="kt-radio kt-radio--success">
                                                            <input type="radio"
                                                                   {{isset($job_offer) && is_null($job_offer->gender) ? 'checked':''}} checked
                                                                   value="0" name="gender"> الكل
                                                            <span></span>
                                                        </label>
                                                        <label class="kt-radio kt-radio--success">
                                                            <input type="radio"
                                                                   {{isset($job_offer) && $job_offer->gender == 'male' ? 'checked':''}} value="male"
                                                                   name="gender"> الذكور
                                                            <span></span>
                                                        </label>
                                                        <label class="kt-radio kt-radio--success">
                                                            <input type="radio"
                                                                   {{isset($job_offer) && $job_offer->gender == 'female' ? 'checked':''}} value="female"
                                                                   name="gender"> الإناث
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>ذوي الأسرى</label>
                                                    <div class="kt-radio-inline">
                                                        <label class="kt-radio kt-radio--success">
                                                            <input type="radio"
                                                                   {{isset($job_offer) && $job_offer->family_of_prisoners == '0' ? 'checked':''}} checked
                                                                   value="0"
                                                                   name="family_of_prisoners"> الكل
                                                            <span></span>
                                                        </label>
                                                        <label class="kt-radio kt-radio--success">
                                                            <input type="radio"
                                                                   {{isset($job_offer) && $job_offer->family_of_prisoners == '1' ? 'checked':''}} value="1"
                                                                   name="family_of_prisoners">
                                                            ذوي الأسرى
                                                            <span></span>
                                                        </label>
                                                        <label class="kt-radio kt-radio--success">
                                                            <input type="radio"
                                                                   {{isset($job_offer) && $job_offer->family_of_prisoners == '2' ? 'checked':''}} value="2"
                                                                   name="family_of_prisoners">
                                                            العاديين
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label>ذوي الجرحى</label>
                                                    <div class="kt-radio-inline">
                                                        <label class="kt-radio kt-radio--success">
                                                            <input type="radio"
                                                                   {{isset($job_offer) && $job_offer->injured_people == '0' ? 'checked':''}} checked
                                                                   value="0" name="injured_people">
                                                            الكل
                                                            <span></span>
                                                        </label>
                                                        <label class="kt-radio kt-radio--success">
                                                            <input type="radio"
                                                                   {{isset($job_offer) && $job_offer->injured_people == '1' ? 'checked':''}} value="1"
                                                                   name="injured_people"> ذوي
                                                            الجرحى
                                                            <span></span>
                                                        </label>
                                                        <label class="kt-radio kt-radio--success">
                                                            <input type="radio"
                                                                   {{isset($job_offer) && $job_offer->injured_people == '2' ? 'checked':''}} value="2"
                                                                   name="injured_people">
                                                            العاديين
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="form-group">
                                                    <label>ذوي الشهداء</label>
                                                    <div class="kt-radio-inline">
                                                        <label class="kt-radio kt-radio--success">
                                                            <input type="radio"
                                                                   {{isset($job_offer) && $job_offer->family_of_martyrs == '0' ? 'checked':''}} checked
                                                                   value="0"
                                                                   name="family_of_martyrs"> الكل
                                                            <span></span>
                                                        </label>
                                                        <label class="kt-radio kt-radio--success">
                                                            <input type="radio"
                                                                   {{isset($job_offer) && $job_offer->family_of_martyrs == '1' ? 'checked':''}} value="1"
                                                                   name="family_of_martyrs"> ذوي
                                                            الشهداء
                                                            <span></span>
                                                        </label>
                                                        <label class="kt-radio kt-radio--success">
                                                            <input type="radio"
                                                                   {{isset($job_offer) && $job_offer->family_of_martyrs == '2' ? 'checked':''}} value="2"
                                                                   name="family_of_martyrs">
                                                            العاديين
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <label>وصف قصير</label>
                                            <textarea class="form-control"
                                                      name="content">{{isset($job_offer) ? $job_offer->content:old('content')}}</textarea>
                                        </div>
                                    </div>

                                    <!--end: Form Wizard Step 1-->

                                    <!--begin: Form Wizard Step 2-->
                                    <div class="kt-wizard-v3__content" data-ktwizard-type="step-content">
                                        <div class="row">
                                            <div class="col-xl-4">
                                                <div class="form-group">
                                                    <label>المؤهلات</label>
                                                    <select class="form-control select2L" title="الكل" multiple
                                                            name="qualifications[]">
                                                        @foreach($qualifications as $qualification)
                                                            <option
                                                                value="{{$qualification->id}}" {{isset($job_offer) && in_array($qualification->id, $job_qualifications) ? 'selected':''}}>{{$qualification->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="form-group">
                                                    <label>التخصص</label>
                                                    <select class="form-control select2L" title="اختر تحصص"
                                                            name="degree_id">
                                                        @foreach($degrees as $degree)
                                                            <option
                                                                {{isset($job_offer) && $job_offer->degree_id == $degree->id ? 'selected':''}}
                                                                value="{{$degree->id}}">{{$degree->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="form-group">
                                                    <label>التخصصات الدقيقة</label>
                                                    <select class="form-control select2L" title="الكل" multiple
                                                            name="sub_degrees[]">
                                                        @isset($sub_degrees)
                                                            @foreach($sub_degrees as $sub_degree)
                                                                <option
                                                                    value="{{$sub_degree->id}}" {{isset($job_offer) && in_array($sub_degree->id, $job_sub_degrees) ? 'selected':''}}>{{$sub_degree->name}}</option>
                                                            @endforeach
                                                        @endisset
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-4">
                                                <div class="form-group">
                                                    <label>اللغات</label>
                                                    <select class="form-control select2L" title="الكل" multiple
                                                            name="languages[]">
                                                        @foreach($languages as $language)
                                                            <option
                                                                value="{{$language->id}}" {{isset($job_offer) && in_array($language->id, $job_languages) ? 'selected':''}}>{{$language->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="form-group">
                                                    <label>الإعاقات</label>
                                                    <select class="form-control select2L" title="الكل" multiple
                                                            name="disabilities[]">
                                                        @foreach($disabilities as $disability)
                                                            <option
                                                                value="{{$disability->id}}" {{isset($job_offer) && in_array($disability->id, $job_disabilities) ? 'selected':''}}>{{$disability->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="form-group">
                                                    <label>المحافظات المخصصة</label>
                                                    <select class="form-control select2L" title="الكل" multiple
                                                            name="governorates[]">
                                                        @foreach($governorates as $governorate)
                                                            <option
                                                                value="{{$governorate->id}}" {{isset($job_offer) && in_array($governorate->id, $job_governorates) ? 'selected':''}}>{{$governorate->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="form-group">
                                                    <label>الوزارات المخصصة</label>
                                                    <select class="form-control select2L" title="الكل" multiple
                                                            name="ministries[]">
                                                        @foreach($ministries as $ministry)
                                                            <option
                                                                value="{{$ministry->id}}" {{isset($job_offer) && in_array($ministry->id, $job_ministries) ? 'selected':''}}>{{$ministry->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--end: Form Wizard Step 2-->

                                    <!--begin: Form Wizard Step 3-->
                                    <div class="kt-wizard-v3__content" data-ktwizard-type="step-content">
                                        <div class="form-group">
                                            <label>وصف الشروط الوظيفية</label>
                                            <textarea class="form-control editor"
                                                      name="functional_terms">{{isset($job_offer) ? $job_offer->functional_terms:old('functional_terms')}}</textarea>
                                        </div>
                                    </div>

                                    <!--end: Form Wizard Step 3-->

                                    <!--begin: Form Wizard Step 4-->
                                    <div class="kt-wizard-v3__content" data-ktwizard-type="step-content">
                                        <div class="form-group">
                                            <label>وصف المهام الوظيفية</label>
                                            <textarea class="form-control editor"
                                                      name="functional_tasks">{{isset($job_offer) ? $job_offer->functional_tasks:old('functional_tasks')}}</textarea>
                                        </div>
                                    </div>

                                    <!--end: Form Wizard Step 4-->

                                    <!--begin: Form Wizard Step 5-->
                                    <div class="kt-wizard-v3__content" data-ktwizard-type="step-content">
                                        <div class="row">
                                            <div class="col-xl-4">
                                                <div class="form-group">
                                                    <label>تاريخ بدء التقديم</label>
                                                    <input type="text" readonly name="start_at"
                                                           value="{{isset($job_offer) ? $job_offer->start_at:old('start_at')}}"
                                                           class="form-control date">
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="form-group">
                                                    <label>تاريخ انتهاء التقديم</label>
                                                    <input type="text" readonly name="end_at"
                                                           value="{{isset($job_offer) ? $job_offer->end_at:old('end_at')}}"
                                                           class="form-control date">
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="form-group">
                                                    <label>تاريخ نشر العرض الوطيفي</label>
                                                    <input type="text" readonly name="publish_at"
                                                           value="{{isset($job_offer) ? $job_offer->publish_at:old('publish_at')}}"
                                                           class="form-control dateTime">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <lable>كلمات مفتاحية</lable>
                                            <input class="form-control" data-role="tagsinput" name="tags" type="text"
                                                   value="{{isset($job_offer) ? $job_offer->tags:old('tags')}}">
                                        </div>
                                    </div>

                                    <!--end: Form Wizard Step 5-->

                                    <!--begin: Form Actions -->
                                    <div class="kt-form__actions">
                                        <div
                                            class="btn btn-secondary btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"
                                            data-ktwizard-type="action-prev">
                                            السابق
                                        </div>
                                        <div
                                            class="btn btn-success btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"
                                            data-ktwizard-type="action-submit">
                                            حفظ
                                        </div>
                                        <div
                                            class="btn btn-brand btn-md btn-tall btn-wide kt-font-bold kt-font-transform-u"
                                            data-ktwizard-type="action-next">
                                            التالي
                                        </div>
                                    </div>

                                    <!--end: Form Actions -->
                                </form>

                                <!--end: Form Wizard Form-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/vendors/general/summernote/dist/summernote.min.js') }}"
            type="text/javascript"></script>
    <script src="{{asset('assets/vendors/general/jquery-validation/dist/jquery.validate.js')}}"
            type="text/javascript"></script>
    <script src="{{asset('assets/vendors/custom/js/vendors/jquery-validation.init.js')}}"
            type="text/javascript"></script>
    <script src="{{asset('assets/vendors/general/sweetalert2/dist/sweetalert2.min.js')}}"
            type="text/javascript"></script>
    <script src="{{asset('assets/vendors/custom/js/vendors/sweetalert2.init.js')}}" type="text/javascript"></script>

    <script src="{{asset('assets/vendors/general/bootstrap-tagsinput/dist/bootstrap-tagsinput.js')}}"></script>

    <script src="{{ asset('assets/vendors/general/bootstrap-datetime-picker/js/bootstrap-datetimepicker.js') }}"
            type="text/javascript"></script>
    <script src="{{asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"
            type="text/javascript"></script>
    <script>
        var clickableSteps = false;

        @isset($job_offer)
            clickableSteps = true;
        @endisset
        $(document).ready(function () {


            $('.editor-custom').summernote({
                height: '150px',

            });
            var gArrayFonts = ['book','bold','Arial', 'Arial Black', 'Comic Sans MS', 'Courier New',
                'Helvetica Neue', 'Helvetica', 'Impact', 'Lucida Grande',
                'Tahoma', 'Times New Roman', 'Verdana'];

            $('.editor').summernote({
                height: '300px',
                fontNames: gArrayFonts,
                fontNamesIgnoreCheck: gArrayFonts,
            });
            $('.dateTime').datetimepicker({
                todayHighlight: true,
                autoclose: true,
                format: 'yyyy-mm-dd hh:ii:ss'
            });
            $('.date').datepicker({
                todayHighlight: true,
                autoclose: true,
                format: 'yyyy-mm-dd'
            });
        });
    </script>
    <script src="{{asset('assets/js/demo1/pages/wizard/wizard-3.js')}}" type="text/javascript"></script>
    {{--    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>--}}
@endsection
