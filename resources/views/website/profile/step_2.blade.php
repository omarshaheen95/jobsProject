@extends('website.profile.container')
@section('style')
    <link href="{{asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('profile_content')
    <div class="table-content form-step-box">
        <div class="head">
            <h3 class="title"> المؤهلات </h3>
            <a href="#!" class="btn btn-add">
                اضافة
            </a>
        </div>

        <div class="d-none" id="form-content">
            <form action="{{route('user_qualification.store')}}"  method="post" id="form-collapse" class="form-collapse" novalidate>
                <input type="hidden" class="form-control" id="id" name="id" value="0">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="form-group">
                            <label for="qualification_id" class="form-label">المؤهل</label>
                            <select id="qualification_id" name="qualification_id" class="form-control form-select" required>
                                <option value="" disabled selected> اختر المؤهل</option>
                                @foreach($qualifications as $qualification)
                                <option value="{{$qualification->id}}"> {{$qualification->name}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="form-group">
                            <label for="degree_id" class="form-label">التخصص</label>
                            <select id="degree_id" name="degree_id" class="form-control form-select" required>
                                <option value="" disabled selected> اختر التخصص</option>
                                @foreach($degrees as $degree)
                                    <option value="{{$degree->id}}"> {{$degree->name}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="form-group">
                            <label for="sub_degree_id" class="form-label">التخصص الدقيق</label>
                            <select id="sub_degree_id" name="sub_degree_id" class="form-control form-select" required>
                                <option value="" disabled selected> اختر التخصص</option>

                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="form-group">
                            <label for="graduation_place" class="form-label">المعهد/المدرسة/الجامعة</label>
                            <input type="text" id="graduation_place" name="graduation_place" class="form-control" required>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="form-group">
                            <label for="country_id" class="form-label"> بلد التخرج </label>
                            <select id="country_id" name="country_id" class="form-control form-select" required>
                                <option value="" disabled selected> اختر بلد التخرج</option>
                                @foreach($countries as $country)
                                    <option value="{{$country->id}}"> {{$country->name}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="form-group">
                            <label for="graduation_date" class="form-label">تاريخ التخرج</label>
                            <input type="text" id="graduation_date" name="graduation_date" class="form-control date" required>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="form-group">
                            <label for="average" class="form-label">المعدل</label>
                            <input type="number" id="average" name="average" class="form-control" required>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="form-group">
                            <label for="appreciation_id" class="form-label"> التقدير </label>
                            <select id="appreciation_id" name="appreciation_id" class="form-control form-select" required>
                                <option value="" disabled selected> اختر التقدير</option>
                                @foreach($appreciations as $appreciation)
                                    <option value="{{$appreciation->id}}"> {{$appreciation->name}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-end">
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                        <div class="text-end">
                            <button type="submit" class="btn btn-theme btn-submit w-100">
                                <span class="spinner-border spinner-border-sm me-2 d-none" role="status"
                                      aria-hidden="true"></span>
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
                    <th>المؤهل</th>
                    <th>التخصص العام</th>
                    <th>التخصص الدقيق</th>
                    <th>المعهد/المدرسة/الجامعة</th>
                    <th>بلد التخرج</th>
                    <th>تاريخ التخرج</th>
                    <th>المعدل</th>
                    <th>التقدير</th>
                    <th>خيارات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($user_qualifications as $u_q)
                    <tr id="row_{{$u_q->id}}">
                        <td>{{$u_q->qualification->name}}</td>
                        <td>{{$u_q->degree->name}}</td>
                        <td>{{$u_q->sub_degree->name}}</td>
                        <td>{{$u_q->graduation_place}}</td>
                        <td>{{$u_q->country->name}}</td>
                        <td>{{$u_q->graduation_date}}</td>
                        <td>{{$u_q->average}}</td>
                        <td>{{$u_q->appreciation->name}}</td>
                        <td>
                            <div class="btn-action btn-edit"
                                 data-id="{{$u_q->id}}"
                                 data-url="{{route('user_qualification.store')}}"
                                 data-qualification_id="{{$u_q->qualification_id}}"
                                 data-degree_id="{{$u_q->degree_id}}"
                                 data-sub_degree_id="{{$u_q->sub_degree_id}}"
                                 data-graduation_place="{{$u_q->graduation_place}}"
                                 data-country_id="{{$u_q->country_id}}"
                                 data-graduation_date="{{$u_q->graduation_date}}"
                                 data-average="{{$u_q->average}}"
                                 data-appreciation_id="{{$u_q->appreciation_id}}"
                            >
                                <svg id="Group_52533" data-name="Group 52533" xmlns="http://www.w3.org/2000/svg"
                                     width="21.137" height="22" viewBox="0 0 21.137 22">
                                    <path id="Path_50197" data-name="Path 50197"
                                          d="M18.224,13.66V19a2.054,2.054,0,0,1-.563,1.412A1.881,1.881,0,0,1,16.31,21H2.914a1.881,1.881,0,0,1-1.351-.588A2.055,2.055,0,0,1,1,19V5a2.055,2.055,0,0,1,.563-1.412A1.881,1.881,0,0,1,2.914,3h5.11"
                                          fill="none" stroke="#89c69a" stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2"/>
                                    <path id="Path_50198" data-name="Path 50198"
                                          d="M16.31,1l3.828,4L10.569,15H6.741V11Z" fill="none" stroke="#89c69a"
                                          stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                </svg>
                            </div>
                            <div class="btn-action btn-remove" data-id="{{$u_q->id}}"
                                 data-url="{{route('user_qualification.delete', $u_q->id)}}"
                                 data-title=" هل تريد حذف المؤهل؟"
                                 data-details=" لا يمكنك استرداد هذه المعلومات عند حذفها ؟">
                                <svg xmlns="http://www.w3.org/2000/svg" width="19.224" height="22"
                                     viewBox="0 0 19.224 22">
                                    <g id="Group_52534" data-name="Group 52534" transform="translate(-30.62)">
                                        <path id="Path_50193" data-name="Path 50193" d="M31.62,5H48.844" fill="none"
                                              stroke="#dd4947" stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2"/>
                                        <path id="Path_50194" data-name="Path 50194"
                                              d="M36.4,5V3a2.055,2.055,0,0,1,.563-1.412A1.881,1.881,0,0,1,38.318,1h3.827a1.88,1.88,0,0,1,1.351.588A2.054,2.054,0,0,1,44.059,3V5ZM46.93,5V19a2.055,2.055,0,0,1-.563,1.412A1.881,1.881,0,0,1,45.016,21H35.447a1.88,1.88,0,0,1-1.351-.588A2.054,2.054,0,0,1,33.534,19V5Z"
                                              fill="none" stroke="#dd4947" stroke-linecap="round"
                                              stroke-linejoin="round" stroke-width="2"/>
                                        <path id="Path_50195" data-name="Path 50195" d="M38.318,10v6" fill="none"
                                              stroke="#dd4947" stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2"/>
                                        <path id="Path_50196" data-name="Path 50196" d="M42.146,10v6" fill="none"
                                              stroke="#dd4947" stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2"/>
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
        <a href="{{route('profile.step', 'general')}}" class="btn btn-secondary border px-5">
            رجوع
        </a>
        <a href="{{route('profile.step', 'skills')}}" class="btn btn-theme px-5">
            التالي
        </a>
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{asset('front/js/user_qualification.js')}}"></script>
    <script>
        var subDegreeURL = '{{ route("subDegreesByDegree", ":id") }}';
    </script>



@endsection
