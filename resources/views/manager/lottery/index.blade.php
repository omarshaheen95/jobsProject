@extends('manager.layout.container', compact('expand'))
@section('style')
   <link rel="stylesheet" href="{{asset('assets/css/spin.css')}}" type="text/css">
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="kt-portlet kt-portlet--height-fluid" style="background-color: #F1f1f1;">
                <div class="kt-portlet__body">
                    <form class="kt-form kt-form--fit kt-margin-b-15" action="" id="search_form" method="get">
                        <div class="row ">
                            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile kt-margin-b-15">
                                <label>الدرجة الوظيفية :</label>
                                <select class="form-control select2L" name="selected_grade" id="selected_grade">
                                    <option selected value="">اختر درجة وظيفية</option>
                                    @foreach($selected_grades as $selected_grade)
                                        <option value="{{$selected_grade}}">{{$selected_grade}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile kt-margin-b-15">
                                <label>القسم :</label>
                                <select class="form-control select2L" name="department" id="department">
                                    <option selected value="">اختر قسم</option>
                                </select>
                            </div>
                            <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile kt-margin-b-15">
                                <label>الإجراءات:</label>
                                <br/>
                                <button type="button" class="btn btn-danger btn-elevate btn-icon-sm" id="kt_search">
                                    <i class="la la-search"></i>
                                    بحث
                                </button>
                            </div>
                        </div>
                        <div class="row" >
                            <div class="col-12" id="ministriesList">

                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div id="chart"></div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm-12 text-center d-none" id="lottery_actions">
                                <div class="form-group">
                                    <button type="button" id="approve_lottery" class="btn btn-success pt-3"> اعتماد القرعة </button>
                                    <button type="button" id="reload_lottery" class="btn btn-dark pt-3"> اعادة القرعة </button>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div id="emp">

                                <h1 class="py-4"></h1>

                                <div class="emp-list" id="empList">
                                </div>
                            </div>

                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://d3js.org/d3.v3.min.js" charset="utf-8"></script>
    <script src="{{asset('assets/js/spin-wheel.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('select[name="selected_grade"]').change(function () {
                var id = $(this).val();
                if (id > 0)
                {
                    getDepartments(id);
                }
            });


            var ministriesURL = '{{ route("manager.ministriesByDepartment") }}';
            $('#kt_search').click(function (e) {
                $('#kt_search').attr('disabled', true);
                e.preventDefault();
                $('#empList').empty();
                $('#ministriesList').empty();
                $('#chart').empty();
                $("#emp h1").empty();
                $('#lottery_actions').addClass('d-none');
                $.ajax({
                    type: "get",
                    url: ministriesURL,
                    data:{
                        'selected_grade': $('select[name="selected_grade"]').val(),
                        'department': $('select[name="department"]').val(),
                    }
                }).done(function (data) {

                    if(data.data.ministries.length > 0)
                    {
                        applicants_counter = 1;
                        $.each(data.data.applicants, function (i, applicant) {
                            $('#empList').append('<div data-applicant="'+applicant.id+'" data-id="'+applicants_counter+'" class="emp-box bg-white rounded shadow-sm p-4">\n' +
                                '                                            <h5 class="mb-0"> '+applicant.code+'</h5>\n' +
                                '                                            <span class="small text-uppercase text-muted"> '+applicant.fake_code+' </span>\n' +
                                '                                        </div>');
                            applicants_counter++;

                        });
                        $.each(data.data.ministries, function (i, ministry) {
                            $('#ministriesList').append( '<h5>\n' +
                                '                                    <span>* الجهة/الوزارة: '+ministry.lottery_ministry.name+'</span>\n' +
                                '                                    *\n' +
                                '                                    <span class="text-danger">العدد المحجوز : '+ministry.total_completed+'</span>\n' +
                                '                                    *\n' +
                                '                                    <span class="text-info">العدد المتبقي (المطلوب) : '+ministry.total_required+'</span>\n' +
                                '                                    *\n' +
                                '                                    <span class="text-warning">العدد المتوقع من القرعة : '+ministry.total_expected+'</span>\n' +
                                '                                </h5>');
                            applicants_counter++;
                        });
                        if(data.data.available_applicants > 0)
                        {
                            drowSpin(data.data.ministries);
                        }else{
                            $("#emp h1").text('لا يوجد متقدمين للدرجة الوظيفية');
                        }
                    }else{
                        $("#emp h1").text('لا يوجد جهات معنية للدرجة الوظيفية');
                    }
                    $('#kt_search').attr('disabled', false);


                }).fail(function(error){
                    $('#kt_search').attr('disabled', false);
                });
            });




        });
    </script>
@endsection
