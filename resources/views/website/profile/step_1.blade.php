@extends('website.profile.container')
@section('style')
    <link href="{{asset('assets/vendors/general/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css')}}" rel="stylesheet" type="text/css" />

@endsection
@section('profile_content')
    <form action="{{route('profile.update')}}" method="post" id="step_1_form" class="form" novalidate>
        @csrf
        <div class="form-step-box">
            <div class="row">
                <div class="col-lg-3">
                    <div class="profile-user change_pic mb-4">
                        <div class="profile-user-pic">
                            <img src="{{optional($user->userInfo)->getFirstMediaUrl('users') ?? 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRHfHdfcQ1cDWzgVLJr32Z3mVYq20D6pir7fKupEKB6fhvQWGZ5xVx76ydUx9nQJiJlKL0&usqp=CAU'}}" id="profile-user-pic" alt="">
                        </div>
                        <label for="change_pic" class="file-upload btn mb-0">
                            <i class="fa fa-pencil-alt"></i>
                        </label>
                        <button type="button" id="remove_pic" class="btn"><i class="fas fa-times"></i></button>
                    </div>
                    <input id="change_pic" type="file" name="avatar" class="d-none form-control">
                    <div class="invalid-feedback"> الرجاء ارفاق صورة شخصية </div>
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label for="uid" class="form-label">رقم الهوية</label>
                                <input type="tel" id="uid" name="uid" class="form-control" value="{{optional($user->userInfo)->uid}}" size="10" placeholder="رقم الهوية" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label for="full_name" class="form-label">الاسم رباعي</label>
                                <input type="text" id="full_name" name="full_name" value="{{optional($user->userInfo)->full_name}}" class="form-control" placeholder="الاسم رباعي" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label for="gender" class="form-label">الجنس</label>
                                <select id="gender" name="gender" class="form-control form-select" required>
                                    <option value="" disabled selected> اختر الجنس</option>
                                    <option value="male" {{optional($user->userInfo)->gender == 'male' ? 'selected':''}}> ذكر </option>
                                    <option value="female" {{optional($user->userInfo)->gender == 'female' ? 'selected':''}}> انثى </option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label for="dob" class="form-label">تاريخ الميلاد</label>
                                <input type="text" id="dob" name="dob" value="{{optional($user->userInfo)->dob}}" class="form-control date" size="10" placeholder="تاريخ الميلاد" required>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label for="birth_governorate_id" class="form-label">مكان الميلاد</label>
                                <select id="birth_governorate_id" name="birth_governorate_id" class="form-control form-select" required>
                                    <option value="" disabled selected> اختر محافظة</option>
                                    @foreach($governorates as $governorate)
                                        <option value="{{$governorate->id}}" {{optional($user->userInfo)->birth_governorate_id == $governorate->id ? 'selected':''}}> {{$governorate->name}} </option>
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
                        <input type="tel" id="mobile" name="mobile" value="{{optional($user->userInfo)->mobile}}" class="form-control" size="10" placeholder="رقم الموبايل" required>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="phone" class="form-label">رقم الهاتف</label>
                        <input type="tel" id="phone" name="phone" value="{{optional($user->userInfo)->phone}}" class="form-control" size="10" placeholder="رقم الهاتف" required>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <label for="marital_status" class="form-label">الحالة الاجتماعية</label>
                    <select id="marital_status" name="marital_status" class="form-control form-select" required>
                        <option value="" disabled selected> اختر الحالة الاجتماعية</option>
                        <option value="1" {{optional($user->userInfo)->marital_status == 1 ? 'selected':''}}> أعزب / انسة </option>
                        <option value="2" {{optional($user->userInfo)->marital_status == 2 ? 'selected':''}}>  متزوج / متزوجة </option>
                        <option value="3" {{optional($user->userInfo)->marital_status == 3 ? 'selected':''}}>  مطلق / مطلقة </option>
                        <option value="4" {{optional($user->userInfo)->marital_status == 4 ? 'selected':''}}>  أرمل / ارملة </option>
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="number_of_children" class="form-label">عدد الابناء</label>
                        <input type="number" id="number_of_children" name="number_of_children" value="{{optional($user->userInfo)->number_of_children}}" class="form-control" size="10" placeholder="عدد الابناء" required>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="number_of_employees" class="form-label">عدد الموظفين في العائلة</label>
                        <input type="number" id="number_of_employees" name="number_of_employees" value="{{optional($user->userInfo)->number_of_employees}}" class="form-control" size="10" placeholder="عدد الموظفين في العائلة" required>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="governorate_id"  class="form-label">مكان الإقامة</label>
                        <select id="governorate_id" name="governorate_id" class="form-control form-select" required>
                            <option value="" disabled selected> اختر محافظة</option>
                            @foreach($governorates as $governorate)
                            <option value="{{$governorate->id}}" {{optional($user->userInfo)->governorate_id == $governorate->id ? 'selected':''}}> {{$governorate->name}} </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-8 col-sm-12">
                    <div class="form-group">
                        <label for="address" class="form-label">العنوان</label>
                        <input type="text" id="address" name="address" class="form-control" value="{{optional($user->userInfo)->address}}" size="10" placeholder="العنوان" required>
                        <div class="invalid-feedback"></div>
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
                            <option value="1" {{optional($user->userInfo)->scholarship_student == 1 ? 'selected':''}}> نعم </option>
                            <option value="0" {{optional($user->userInfo)->scholarship_student == 0 ? 'selected':''}}> لا </option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="top_ten_students" class="form-label">هل أنت من ال10 الأوائل</label>
                        <select id="top_ten_students" name="top_ten_students" class="form-control form-select" required>
                            <option value="" disabled selected> اختر إجابة</option>
                            <option value="1" {{optional($user->userInfo)->top_ten_students == 1 ? 'selected':''}}> نعم </option>
                            <option value="0" {{optional($user->userInfo)->top_ten_students == 0 ? 'selected':''}}> لا </option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="unemployed" class="form-label">هل تعمل في القطاع الخاص</label>
                        <select id="unemployed" name="unemployed" class="form-control form-select" required>
                            <option value="" disabled selected> اختر إجابة</option>
                            <option value="1" {{optional($user->userInfo)->unemployed == 1 ? 'selected':''}}> نعم </option>
                            <option value="0" {{optional($user->userInfo)->unemployed == 0 ? 'selected':''}}> لا </option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="work_nonGovernmental_org" class="form-label"> تعمل في منظمات غير حكومية ؟</label>
                        <select id="work_nonGovernmental_org" name="work_nonGovernmental_org" class="form-control form-select" required>
                            <option value="" disabled selected> اختر إجابة</option>
                            <option value="1" {{optional($user->userInfo)->work_nonGovernmental_org == 1 ? 'selected':''}}> نعم </option>
                            <option value="0" {{optional($user->userInfo)->work_nonGovernmental_org == 0 ? 'selected':''}}> لا </option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="registered_unemployed_ministry" class="form-label"> مسجل عاطل عن العمل في الوزارة ؟</label>
                        <select id="registered_unemployed_ministry" name="registered_unemployed_ministry" class="form-control form-select" required>
                            <option value="" disabled selected> اختر إجابة</option>
                            <option value="1" {{optional($user->userInfo)->registered_unemployed_ministry == 1 ? 'selected':''}}> نعم </option>
                            <option value="0" {{optional($user->userInfo)->registered_unemployed_ministry == 0 ? 'selected':''}}> لا </option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="family_of_prisoners" class="form-label"> هل أنت من ذوي الأسرى ؟</label>
                        <select id="family_of_prisoners" name="family_of_prisoners" class="form-control form-select" required>
                            <option value="" disabled selected> اختر إجابة</option>
                            <option value="1" {{optional($user->userInfo)->family_of_prisoners == 1 ? 'selected':''}}> نعم </option>
                            <option value="0" {{optional($user->userInfo)->family_of_prisoners == 0 ? 'selected':''}}> لا </option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="injured_people" class="form-label"> هل أنت من ذوي الجرحى ؟</label>
                        <select id="injured_people" name="injured_people" class="form-control form-select" required>
                            <option value="" disabled selected> اختر إجابة</option>
                            <option value="1" {{optional($user->userInfo)->injured_people == 1 ? 'selected':''}}> نعم </option>
                            <option value="0" {{optional($user->userInfo)->injured_people == 0 ? 'selected':''}}> لا </option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="form-group">
                        <label for="family_of_martyrs" class="form-label"> هل أنت من ذوي الشهداء ؟</label>
                        <select id="family_of_martyrs" name="family_of_martyrs" class="form-control form-select" required>
                            <option value="" disabled selected> اختر إجابة</option>
                            <option value="1" {{optional($user->userInfo)->family_of_martyrs == 1 ? 'selected':''}}> نعم </option>
                            <option value="0" {{optional($user->userInfo)->family_of_martyrs == 0 ? 'selected':''}}> لا </option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

            </div>
            <div class="row justify-content-end">
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="text-end">
                        <button type="submit" data-next-url="{{route('profile.step', 'qualifications')}}" class="btn btn-theme btn-submit w-100">
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
    <script>
        $("form").on("submit", function(e) {
            e.preventDefault();
            var _form = $(this);
            _form.find(".btn-submit .spinner-border").toggleClass("d-none");
            _form.find(".btn-submit").addClass("disabled");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = new FormData(_form[0]);
            $.ajax({
                processData: false,
                contentType: false,
                type: "post",
                url: _form.attr("action"),
                data: formData,
                success: function(res){
                    showToastify(res.message, 'success');
                    _form.find(".btn-submit .spinner-border").toggleClass("d-none");
                    _form.removeClass("disabled was-validated");
                    window.location.replace(_form.find(".btn-submit").attr('data-next-url'));
                },
                error: function(data) {
                    _form.find(".btn-submit .spinner-border").toggleClass("d-none");
                    _form.find(".btn-submit .spinner-border").removeClass("disabled was-validated");
                    _form.find(".btn-submit").removeClass("disabled was-validated");
                    if (data.responseJSON.errors) {
                        $.each(data.responseJSON.errors, function (key, value) {
                            var input = '#step_1_form [name=' + key + ']';
                            $(input).next('.invalid-feedback').text(value);
                            $(input).addClass('has-error');
                            $(input).addClass('is-invalid');
                            $(input).removeClass('is-valid');
                        });
                    } else {
                        showToastify(data.responseJSON.message.toString(), 'error');
                    }
                }
            });
        });
    </script>
@endsection
