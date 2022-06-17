@extends('website.profile.container')
@section('profile_content')
    <div class="table-content form-step-box">
        <div class="head">
            <h3 class="title"> الوضع الصحي </h3>
            <a href="#!" class="btn btn-add">
                اضافة
            </a>
        </div>

        <div class="d-none" id="form-content">
            <form action="#!" method="post" class="needs-validation form-collapse" novalidate>
                <input type="hidden" class="form-control" id="id" value="0">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="type" class="form-label"> نوع الاعاقة</label>
                            <select id="type" class="form-control form-select" required>
                                <option value="" disabled selected> اختر الاعاقة</option>
                                <option value="1"> سمعي </option>
                                <option value="2"> بصري </option>
                                <option value="3"> حركي </option>
                                <option value="4"> نطق </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <label for="org" class="form-label"> اسم (الجمعية / المؤسسة / الجهة ) التابع لها</label>
                        <input type="text" id="org" class="form-control" placeholder="اسم (الجمعية / المؤسسة / الجهة ) التابع لها" required>
                    </div>
                    <div class="col-lg-12">
                        <label for="range" class="form-label">نسبة الاعاقة  <strong class=" ms-4 h4"><output id="rangeValue">50</output>  %</strong></label>
                        <input type="range" class="form-range" min="1" max="100" oninput="rangeValue.value = range.value" id="range" required>
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
                    <th>نوع الإعاقة</th>
                    <th>نسبة الإعاقة</th>
                    <th>الجهة او المؤسسة</th>
                    <th>خيارات</th>
                </tr>
                </thead>
                <tbody>
                <tr id="row_1">
                    <td> نوع الإعاقة </td>
                    <td> نسبة الإعاقة </td>
                    <td> جمعية رؤى للمكفوفين </td>
                    <td>
                        <div class="btn-action btn-edit"
                             data-id="1"
                             data-url="localhost/update_lang"
                             data-type="بصري"
                             data-type_id="2"
                             data-range="88"
                             data-org="جمعية رؤى للمكفوفين"
                        >
                            <svg id="Group_52533" data-name="Group 52533" xmlns="http://www.w3.org/2000/svg" width="21.137" height="22" viewBox="0 0 21.137 22">
                                <path id="Path_50197" data-name="Path 50197" d="M18.224,13.66V19a2.054,2.054,0,0,1-.563,1.412A1.881,1.881,0,0,1,16.31,21H2.914a1.881,1.881,0,0,1-1.351-.588A2.055,2.055,0,0,1,1,19V5a2.055,2.055,0,0,1,.563-1.412A1.881,1.881,0,0,1,2.914,3h5.11" fill="none" stroke="#89c69a" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                <path id="Path_50198" data-name="Path 50198" d="M16.31,1l3.828,4L10.569,15H6.741V11Z" fill="none" stroke="#89c69a" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                            </svg>
                        </div>
                        <div class="btn-action btn-remove" data-id="1" data-url="#!" data-title=" هل تريد حذف الاعاقة ؟" data-details=" لا يمكنك استرداد هذه المعلومات عند حذفها ؟">
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

                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex align-items-center justify-content-between gap-4">
        <a href="{{route('profile.step', 6)}}" class="btn btn-secondary border px-5">
            رجوع
        </a>

    </div>
@endsection
@section('script')
    <script>

        /*-----------------------
            Form action
        -----------------------*/

        $(".form-collapse").on("submit", function(e){
            e.preventDefault();
            var _form = $(this),
                id = $(this).find("#id").val();

            if (_form[0].checkValidity() === false) {
                e.stopPropagation();
            } else {
                _form.find(".btn-submit .spinner-border").toggleClass("d-none");
                _form.addClass("disabled");
                var row = '\
                        <tr id="row_'+ id +'">\
                            <td>'+ $(this).find("#type option:selected").text()  +'</td>\
                            <td>'+  $(this).find("#range").val() +'</td>\
                            <td>'+  $(this).find("#org").val() +'</td>\
                            <td>\
                                <div class="btn-action btn-edit"\
                                    data-id="'+ id +'"\
                                    data-url="localhost/update_qualification"\
                                    data-type="'+ $(this).find("#type option:selected").text() +'"\
                                    data-type_id="'+ $(this).find("#type").val() +'"\
                                    data-range="'+ $(this).find("#range").val() +'"\
                                    data-org="'+ $(this).find("#org").val() +'"\
                                >\
                                    <svg id="Group_52533" data-name="Group 52533" xmlns="http://www.w3.org/2000/svg" width="21.137" height="22" viewBox="0 0 21.137 22">\
                                        <path id="Path_50197" data-name="Path 50197" d="M18.224,13.66V19a2.054,2.054,0,0,1-.563,1.412A1.881,1.881,0,0,1,16.31,21H2.914a1.881,1.881,0,0,1-1.351-.588A2.055,2.055,0,0,1,1,19V5a2.055,2.055,0,0,1,.563-1.412A1.881,1.881,0,0,1,2.914,3h5.11" fill="none" stroke="#89c69a" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>\
                                        <path id="Path_50198" data-name="Path 50198" d="M16.31,1l3.828,4L10.569,15H6.741V11Z" fill="none" stroke="#89c69a" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>\
                                    </svg>\
                                </div>\
                                <div class="btn-action btn-remove" data-id="'+ id +'" data-url="#!" data-title=" هل تريد حذف الاعاقة ؟" data-details=" لا يمكنك استرداد هذه المعلومات عند حذفها ؟">\
                                    <svg xmlns="http://www.w3.org/2000/svg" width="19.224" height="22" viewBox="0 0 19.224 22">\
                                        <g id="Group_52534" data-name="Group 52534" transform="translate(-30.62)">\
                                            <path id="Path_50193" data-name="Path 50193" d="M31.62,5H48.844" fill="none" stroke="#dd4947" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>\
                                            <path id="Path_50194" data-name="Path 50194" d="M36.4,5V3a2.055,2.055,0,0,1,.563-1.412A1.881,1.881,0,0,1,38.318,1h3.827a1.88,1.88,0,0,1,1.351.588A2.054,2.054,0,0,1,44.059,3V5ZM46.93,5V19a2.055,2.055,0,0,1-.563,1.412A1.881,1.881,0,0,1,45.016,21H35.447a1.88,1.88,0,0,1-1.351-.588A2.054,2.054,0,0,1,33.534,19V5Z" fill="none" stroke="#dd4947" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>\
                                            <path id="Path_50195" data-name="Path 50195" d="M38.318,10v6" fill="none" stroke="#dd4947" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>\
                                            <path id="Path_50196" data-name="Path 50196" d="M42.146,10v6" fill="none" stroke="#dd4947" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>\
                                        </g>\
                                    </svg>\
                                </div>\
                            </td>\
                        </tr>';

                setTimeout( function(){
                    if(id == 0){
                        $("#table_content tbody").append(row);
                    } else {
                        $("#table_content tbody #row_"+id).replaceWith(row);
                    }
                    showToastify("Success, you email was added !", "success");
                    _form.find(".btn-submit .spinner-border").toggleClass("d-none");
                    _form.removeClass("disabled was-validated");
                    _form[0].reset();
                    $("#form-content").addClass("d-none");
                }, 3000);
            }
        });

        /*-----------------------
            add
        -----------------------*/

        $(document).on('click', '.btn-add', (function (e) {
            e.preventDefault();
            $("#form-content").removeClass("d-none");
            $("#form-content .form-collapse")[0].reset();
            $("#form-content .form-collapse .form-control").val("");
        }));

        /*-----------------------
            Edit
        -----------------------*/

        $(document).on('click', '.btn-edit', (function (e) {
            e.preventDefault();
            var data = $(this).data();

            $(".form-collapse").attr("action", data.url);
            $("#id").val(data.id);
            $("#type option[value="+data.type_id+"]").attr('selected','selected');
            $("#range").val(data.range);
            $("#rangeValue").text(data.range);
            $("#org").val(data.org);
            $("#form-content").removeClass("d-none");
        }));

        /*-----------------------
            remove
        -----------------------*/

        $(document).on('click', '.btn-remove', (function () {
            var id = $(this).data("id");
            Swal.fire({
                icon: 'warning',
                title: $(this).data("title"),
                text: $(this).data("details"),
                showCancelButton: true,
                confirmButtonText: 'نعم',
                confirmButtonColor: '#E37281',
                cancelButtonText: 'الغاء',
            }).then((result) => {
                if (result.isConfirmed) {

                    $("#row_"+ id).remove();
                    showToastify("تم حذف المعلومات بنجاح", "success");
                    $(".form-collapse")[0].reset();
                    $("#form-content").addClass("d-none");
                    /*
                        $.ajax({
                            type: "post",
                            dataType: "html",
                            url: $(this).data("url"),
                            data: {
                                "id" : id,
                            },
                            success: function(res){
                                var res = JSON.parse(res);
                                $("#row_"+ id).remove();
                                showToastify(res.res, "success")
                                $(".form-collapse")[0].reset();
                                $("#form-content").addClass("d-none");
                            },
                            error: function(){
                                showToastify(res.res, "error")
                            }
                        });
                    */
                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                    showToastify("تم حذف المعلومات بنجاح", "error")
                } else {
                    showToastify("لم يتم اتخاد اي اجراء ", "info")
                }
            });
        }));
    </script>
@endsection
