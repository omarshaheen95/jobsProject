@extends('website.profile.container')
@section('style')
    <link href="{{asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}" rel="stylesheet" type="text/css" />

@endsection
@section('profile_content')
    <form action="{{route('profile.update_step', 1)}}" method="post" class="needs-validation form" novalidate>
        <div class="form-step-box">
            <div class="row">
                <div class="col-lg-3">
                    <div class="profile-user change_pic mb-4">
                        <div class="profile-user-pic">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRHfHdfcQ1cDWzgVLJr32Z3mVYq20D6pir7fKupEKB6fhvQWGZ5xVx76ydUx9nQJiJlKL0&usqp=CAU" id="profile-user-pic" alt="">
                        </div>
                        <label for="change_pic" class="file-upload btn mb-0">
                            <i class="fa fa-pencil-alt"></i>
                        </label>
                        <button type="button" id="remove_pic" class="btn"><i class="fas fa-times"></i></button>
                    </div>
                    <input id="change_pic" type="file" name="avatar" class="d-none form-control" required>
                    <div class="invalid-feedback"> الرجاء ارفاق صورة شخصية </div>
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label for="uid" class="form-label">رقم الهوية</label>
                                <input type="tel" id="uid" name="uid" class="form-control" size="10" placeholder="رقم الهوية" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label for="full_name" class="form-label">الاسم رباعي</label>
                                <input type="text" id="full_name" name="full_name" class="form-control" placeholder="الاسم رباعي" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label for="gender" class="form-label">الجنس</label>
                                <select id="gender" name="gender" class="form-control form-select" required>
                                    <option value="" disabled selected> اختر الجنس</option>
                                    <option value="male"> ذكر </option>
                                    <option value="female"> انثى </option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label for="dob" class="form-label">تاريخ الميلاد</label>
                                <input type="text" readonly id="dob" name="dob" class="form-control date" size="10" placeholder="تاريخ الميلاد" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label for="birth_governorate_id" class="form-label">مكان الميلاد</label>
                                <select id="birth_governorate_id" name="birth_governorate_id" class="form-control form-select" required>
                                    <option value="" disabled selected> اختر محافظة</option>
                                    @foreach($governorates as $governorate)
                                        <option value="{{$governorate->id}}"> {{$governorate->name}} </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-step-box">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="mobile" class="form-label">رقم الموبايل</label>
                        <input type="tel" id="mobile" name="mobile" class="form-control" size="10" placeholder="رقم الموبايل" required>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="phone	" class="form-label">رقم الهاتف</label>
                        <input type="tel" id="phone	" name="phone	" class="form-control" size="10" placeholder="رقم الهاتف" required>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <label for="marital_status" class="form-label">الحالة الاجتماعية</label>
                    <select id="marital_status" class="form-control form-select" required>
                        <option value="" disabled selected> اختر الحالة الاجتماعية</option>
                        <option value="1"> أعزب / انسة </option>
                        <option value="2">  متزوج / متزوجة </option>
                        <option value="3">  أرمل / ارملة </option>
                        <option value="4">  مطلق / مطلقة </option>
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="number_of_children" class="form-label">عدد الابناء</label>
                        <input type="number" id="number_of_children" name="number_of_children" class="form-control" size="10" placeholder="عدد الابناء" required>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="number_of_employees" class="form-label">عدد الموظفين</label>
                        <input type="number" id="number_of_employees" name="number_of_employees" class="form-control" size="10" placeholder="عدد الموظفين" required>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="governorate_id"  class="form-label">مكان الإقامة</label>
                        <select id="governorate_id" name="governorate_id" class="form-control form-select" required>
                            <option value="" disabled selected> اختر محافظة</option>
                            @foreach($governorates as $governorate)
                            <option value="{{$governorate->id}}"> {{$governorate->name}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-6 col-md-8 col-sm-12">
                    <div class="form-group">
                        <label for="address" class="form-label">العنوان</label>
                        <input type="text" id="address" name="address" class="form-control" size="10" placeholder="العنوان" required>
                    </div>
                </div>

            </div>
        </div>
        <div class="form-step-box">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="scholarship_student" class="form-label">هل أنت من المبتعثين</label>
                        <select id="scholarship_student" name="scholarship_student" class="form-control form-select" required>
                            <option value="" disabled selected> اختر إجابة</option>
                            <option value="1"> نعم </option>
                            <option value="0"> لا </option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="top_ten_students" class="form-label">هل أنت من ال10 الأوائل</label>
                        <select id="top_ten_students" name="top_ten_students" class="form-control form-select" required>
                            <option value="" disabled selected> اختر إجابة</option>
                            <option value="1"> نعم </option>
                            <option value="0"> لا </option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="unemployed" class="form-label">هل تعمل في القطاع الخاص</label>
                        <select id="unemployed" name="unemployed" class="form-control form-select" required>
                            <option value="" disabled selected> اختر إجابة</option>
                            <option value="1"> نعم </option>
                            <option value="0"> لا </option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="work_nonGovernmental_org" class="form-label"> تعمل في منظمات غير حكومية ؟</label>
                        <select id="work_nonGovernmental_org" name="work_nonGovernmental_org" class="form-control form-select" required>
                            <option value="" disabled selected> اختر إجابة</option>
                            <option value="1"> نعم </option>
                            <option value="0"> لا </option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="registered_unemployed_ministry" class="form-label"> مسجل عاطل عن العمل في الوزارة ؟</label>
                        <select id="registered_unemployed_ministry" name="registered_unemployed_ministry" class="form-control form-select" required>
                            <option value="" disabled selected> اختر إجابة</option>
                            <option value="1"> نعم </option>
                            <option value="0"> لا </option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="family_of_prisoners" class="form-label"> هل أنت من ذوي الأسرى ؟</label>
                        <select id="family_of_prisoners" name="family_of_prisoners" class="form-control form-select" required>
                            <option value="" disabled selected> اختر إجابة</option>
                            <option value="1"> نعم </option>
                            <option value="0"> لا </option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="injured_people" class="form-label"> هل أنت من ذوي الجرحى ؟</label>
                        <select id="injured_people" name="injured_people" class="form-control form-select" required>
                            <option value="" disabled selected> اختر إجابة</option>
                            <option value="1"> نعم </option>
                            <option value="0"> لا </option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="family_of_martyrs" class="form-label"> هل أنت من ذوي الشهداء ؟</label>
                        <select id="family_of_martyrs" name="family_of_martyrs" class="form-control form-select" required>
                            <option value="" disabled selected> اختر إجابة</option>
                            <option value="1"> نعم </option>
                            <option value="0"> لا </option>
                        </select>
                    </div>
                </div>

            </div>
            <div class="row justify-content-end">
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="text-end">
                        <button type="submit" class="btn btn-theme btn-submit w-100">
                            <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
                            التالي
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('script')
    <script src="{{asset('assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.js')}}"
            type="text/javascript"></script>

    <script>
        $('.date').datepicker({
            todayHighlight: true,
            autoclose: true,
            format: 'yyyy-mm-dd'
        });
    </script>
@endsection
