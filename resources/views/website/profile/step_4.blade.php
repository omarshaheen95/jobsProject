@extends('website.profile.container')
@section('style')
    <link href="{{asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('profile_content')
    <div class="table-content form-step-box">
        <div class="head">
            <h3 class="title"> الدورات </h3>
            <a href="#!" class="btn btn-add">
                اضافة
            </a>
        </div>

        <div class="d-none" id="form-content">
            <form action="{{route('user_course.store')}}" method="post" class="form-collapse" id="form-collapse" novalidate>
                @csrf
                <input type="hidden" class="form-control" id="id" value="0" name="id">
                <div class="row">
                    <div class="col-lg-4 col-sm-6">
                        <div class="form-group">
                            <label for="course_name" class="form-label">عنوان الدورة</label>
                            <input type="text" id="course_name" name="course_name" class="form-control" placeholder=" اكتب عنوان الدورة " required>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <div class="form-group">
                            <label for="course_hours" class="form-label">الساعات</label>
                            <input type="number" min="20" id="course_hours" name="course_hours" class="form-control" placeholder=" عدد الساعات " required>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <div class="form-group">
                            <label for="course_place" class="form-label">مكان الإنعقاد</label>
                            <input type="text" id="course_place" name="course_place" class="form-control" placeholder="مكان الإنعقاد " required>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="start_at" class="form-label">تاريخ البداية</label>
                            <input type="text" id="start_at" name="start_at" class="form-control date" placeholder="تاريخ البداية" required>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="end_at" class="form-label">تاريخ النهاية</label>
                            <input type="text" id="end_at" name="end_at" class="form-control date" placeholder="تاريخ النهاية" required>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-end">
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                        <div class="text-end">
                            <button type="submit" class="btn btn-theme btn-submit w-100">
                                <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
                                حفظ
                            </button>
                        </div>
                    </div>
                </div>
                <hr class="border my-5">
            </form>
        </div>

        <div class="table-responsive">
            <table class="table" id="table_content">
                <thead>
                <tr>
                    <th>عنوان الدورة</th>
                    <th>الساعات</th>
                    <th>مكان الانعقاد</th>
                    <th>تاريخ البداية</th>
                    <th>تاريخ النهاية</th>
                    <th>خيارات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($user_courses as $u_c)
                <tr id="row_{{$u_c->id}}">
                    <td>{{$u_c->course_name}} </td>
                    <td>{{$u_c->course_hours}}</td>
                    <td>{{$u_c->course_place}}</td>
                    <td>{{$u_c->start_at}}</td>
                    <td>{{$u_c->end_at}}</td>
                    <td>
                        <div class="btn-action btn-edit"
                             data-id="{{$u_c->id}}"
                             data-url="{{route('user_course.store')}}"
                             data-course_name="{{$u_c->course_name}}"
                             data-course_hours="{{$u_c->course_hours}}"
                             data-course_place="{{$u_c->course_place}}"
                             data-start_at="{{$u_c->start_at}}"
                             data-end_at="{{$u_c->end_at}}"
                        >
                            <svg id="Group_52533" data-name="Group 52533" xmlns="http://www.w3.org/2000/svg" width="21.137" height="22" viewBox="0 0 21.137 22">
                                <path id="Path_50197" data-name="Path 50197" d="M18.224,13.66V19a2.054,2.054,0,0,1-.563,1.412A1.881,1.881,0,0,1,16.31,21H2.914a1.881,1.881,0,0,1-1.351-.588A2.055,2.055,0,0,1,1,19V5a2.055,2.055,0,0,1,.563-1.412A1.881,1.881,0,0,1,2.914,3h5.11" fill="none" stroke="#89c69a" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                <path id="Path_50198" data-name="Path 50198" d="M16.31,1l3.828,4L10.569,15H6.741V11Z" fill="none" stroke="#89c69a" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                            </svg>
                        </div>
                        <div class="btn-action btn-remove" data-id="{{$u_c->id}}" data-url="{{route('user_course.delete', $u_c->id)}}" data-title=" هل تريد حذف الدورة ؟" data-details=" لا يمكنك استرداد هذه المعلومات عند حذفها ؟">
                            <svg xmlns="http://www.w3.org/2000/svg" width="19.224" height="22" viewBox="0 0 19.224 22">
                                <g id="Group_52534" data-name="Group 52534" transform="translate(-30.62)">
                                    <path id="Path_50193" data-name="Path 50193" d="M31.62,5H48.844" fill="none" stroke="#dd4947" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                    <path id="Path_50194" data-name="Path 50194" d="M36.4,5V3a2.055,2.055,0,0,1,.563-1.412A1.881,1.881,0,0,1,38.318,1h3.827a1.88,1.88,0,0,1,1.351.588A2.054,2.054,0,0,1,44.059,3V5ZM46.93,5V19a2.055,2.055,0,0,1-.563,1.412A1.881,1.881,0,0,1,45.016,21H35.447a1.88,1.88,0,0,1-1.351-.588A2.054,2.054,0,0,1,33.534,19V5Z" fill="none" stroke="#dd4947" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                    <path id="Path_50195" data-name="Path 50195" d="M38.318,10v6" fill="none" stroke="#dd4947" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                    <path id="Path_50196" data-name="Path 50196" d="M42.146,10v6" fill="none" stroke="#dd4947" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                </g>
                            </svg>
                        </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex align-items-center justify-content-between gap-4">
        <a href="{{route('profile.step', 'skills')}}" class="btn btn-secondary border px-5">
            رجوع
        </a>
        <a href="{{route('profile.step', 'experiences')}}" class="btn btn-theme px-5">
            التالي
        </a>
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{asset('front/js/user_course.js')}}">

    </script>

@endsection
