@extends('manager.layout.container')
@section('style')
    <style>
        #chartdiv1, #chartdiv2, #chartdiv3, #chartdiv0 {
            width: 100%;
            height: 400px;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <!--begin::Form-->
                    <div class="kt-form">
                        <div class="row">
                            <div class="col-4 justify-content-center text-center">
                                <i class="flaticon2-list-2" style="font-size: 3.5rem"></i>
                            </div>
                            <div class="col-2">
                            </div>
                            <label class="col-6 text-center">
                                <span style="font-size: 2rem">
                                    {{ $data['applicants_need'] }}
                                </span>
                                <br>
                                المتقدمين المطلوبين
                            </label>

                        </div>
                    </div>
                    <!--end::Form-->
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <!--begin::Form-->
                    <div class="kt-form">
                        <div class="row">
                            <div class="col-4 justify-content-center text-center">
                                <i class="flaticon2-group" style="font-size: 3.5rem"></i>
                            </div>
                            <div class="col-2">
                            </div>
                            <label class="col-6 text-center">
                                <span style="font-size: 2rem">
                                    {{ $data['applicants'] }}
                                </span>
                                <br>
                                المتقدمين المسجلين
                            </label>

                        </div>
                    </div>
                    <!--end::Form-->
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <!--begin::Form-->
                    <div class="kt-form">
                        <div class="row">
                            <div class="col-4 justify-content-center text-center">
                                <i class="flaticon2-accept" style="font-size: 3.5rem"></i>
                            </div>
                            <div class="col-2">
                            </div>
                            <label class="col-6 text-center">
                                <span style="font-size: 2rem">
                                    {{ $data['applicants_top'] }}
                                </span>
                                <br>
                                المتقدمين الأوائل
                            </label>

                        </div>
                    </div>
                    <!--end::Form-->
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <!--begin::Form-->
                    <div class="kt-form">
                        <div class="row">
                            <div class="col-4 justify-content-center text-center">
                                <i class="flaticon2-check-mark" style="font-size: 3.5rem"></i>
                            </div>
                            <div class="col-2">
                            </div>
                            <label class="col-6 text-center">
                                <span style="font-size: 2rem">
                                    {{ $data['applicants_used'] }}
                                </span>
                                <br>
                                المتقدمين المكتملين
                            </label>

                        </div>
                    </div>
                    <!--end::Form-->
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <!--begin::Form-->
                    <div class="kt-form">
                        <div class="row">
                            <div class="col-4 justify-content-center text-center">
                                <i class="flaticon2-indent-dots" style="font-size: 3.5rem"></i>
                            </div>
                            <div class="col-2">
                            </div>
                            <label class="col-6 text-center">
                                <span style="font-size: 2rem">
                                    {{ $data['applicants_available'] }}
                                </span>
                                <br>
                                المتقدمين المتاحين
                            </label>

                        </div>
                    </div>
                    <!--end::Form-->
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <!--begin::Form-->
                    <div class="kt-form">
                        <div class="row">
                            <div class="col-4 justify-content-center text-center">
                                <i class="flaticon2-list-3" style="font-size: 3.5rem"></i>
                            </div>
                            <div class="col-2">
                            </div>
                            <label class="col-6 text-center">
                                <span style="font-size: 2rem">
                                    {{ $data['grades'] }}
                                </span>
                                <br>
                                الدرجات المستحدثة
                            </label>

                        </div>
                    </div>
                    <!--end::Form-->
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <!--begin::Form-->
                    <div class="kt-form">
                        <div class="row">
                            <div class="col-4 justify-content-center text-center">
                                <i class="flaticon2-list-3" style="font-size: 3.5rem"></i>
                            </div>
                            <div class="col-2">
                            </div>
                            <label class="col-6 text-center">
                                <span style="font-size: 2rem">
                                    {{ $data['total_grades_discrimination'] }}
                                </span>
                                <br>
                                إجمالي المطلوب للدرجات المستتناة
                            </label>

                        </div>
                    </div>
                    <!--end::Form-->
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <!--begin::Form-->
                    <div class="kt-form">
                        <div class="row">
                            <div class="col-4 justify-content-center text-center">
                                <i class="flaticon2-list-3" style="font-size: 3.5rem"></i>
                            </div>
                            <div class="col-2">
                            </div>
                            <label class="col-6 text-center">
                                <span style="font-size: 2rem">
                                    {{ $data['total_grades_general'] }}
                                </span>
                                <br>
                                إجمالي المطلوب للدرجات العامة
                            </label>

                        </div>
                    </div>
                    <!--end::Form-->
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-3">
            <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <!--begin::Form-->
                    <div class="kt-form">
                        <div class="row">
                            <div class="col-4 justify-content-center text-center">
                                <i class="flaticon2-writing" style="font-size: 3.5rem"></i>
                            </div>
                            <div class="col-2">
                            </div>
                            <label class="col-6 text-center">
                                <span style="font-size: 2rem">
                                    {{ $data['departments'] }}
                                </span>
                                <br>
                                الأقسام
                            </label>

                        </div>
                    </div>
                    <!--end::Form-->
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <!--begin::Form-->
                    <div class="kt-form">
                        <div class="row">
                            <div class="col-4 justify-content-center text-center">
                                <i class="flaticon2-writing" style="font-size: 3.5rem"></i>
                            </div>
                            <div class="col-2">
                            </div>
                            <label class="col-6 text-center">
                                <span style="font-size: 2rem">
                                    {{ $data['governor_departments'] }}
                                </span>
                                <br>
                                الأقسام الحاكمة
                            </label>

                        </div>
                    </div>
                    <!--end::Form-->
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <!--begin::Form-->
                    <div class="kt-form">
                        <div class="row">
                            <div class="col-4 justify-content-center text-center">
                                <i class="flaticon2-writing" style="font-size: 3.5rem"></i>
                            </div>
                            <div class="col-2">
                            </div>
                            <label class="col-6 text-center">
                                <span style="font-size: 2rem">
                                    {{ $data['ministries'] }}
                                </span>
                                <br>
                                الجهات/ الوزارات
                            </label>

                        </div>
                    </div>
                    <!--end::Form-->
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="kt-portlet">
                <div class="kt-portlet__body">
                    <!--begin::Form-->
                    <div class="kt-form">
                        <div class="row">
                            <div class="col-4 justify-content-center text-center">
                                <i class="flaticon2-writing" style="font-size: 3.5rem"></i>
                            </div>
                            <div class="col-2">
                            </div>
                            <label class="col-6 text-center">
                                <span style="font-size: 2rem">
                                    {{ $data['ministries_discrimination'] }}
                                </span>
                                <br>
                                الجهات/ الوزارات المستثناة
                            </label>

                        </div>
                    </div>
                    <!--end::Form-->
                </div>
            </div>
        </div>
    </div>


@endsection
