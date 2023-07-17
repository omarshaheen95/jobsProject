@extends('manager.layout.container')
@section('style')
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection
@section('content')
    @push('breadcrumb')
        <li class="breadcrumb-item">
            المتقدمين
        </li>
    @endpush
    <div class="row">
        <div class="col-md-12">
            <div class="kt-portlet kt-portlet--height-fluid">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            المتقدمين
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-wrapper">
                            <div class="kt-portlet__head-actions">
                                <a href="{{ route('manager.applicant.create') }}"
                                   class="btn btn-danger btn-elevate btn-icon-sm">
                                    <i class="la la-plus"></i>
                                    إستيراد
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <form class="kt-form kt-form--fit kt-margin-b-15" action="" id="search_form" method="get">
                        <div class="row ">
                            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile kt-margin-b-15">
                                <label>الاسم :</label>
                               <input type="text" name="name" id="name" placeholder="الاسم" class="form-control" />
                            </div>
                            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile kt-margin-b-15">
                                <label>الشهادة :</label>
                                <select class="form-control select2L" name="degree" id="degree">
                                    <option selected value="">الكل</option>
                                    @foreach($degrees as $degree)
                                        <option value="{{$degree->id}}">{{$degree->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile kt-margin-b-15">
                                <label>الجامعة :</label>
                                <select class="form-control select2L" name="university" id="university">
                                    <option selected value="">الكل</option>
                                    @foreach($universities as $university)
                                        <option value="{{$university->id}}">{{$university->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile kt-margin-b-15">
                                <label>الكلية :</label>
                                <select class="form-control select2L" name="college" id="college">
                                    <option selected value="">الكل</option>
                                </select>
                            </div>
                            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile kt-margin-b-15">
                                <label>الدرجة الوظيفية :</label>
                                <select class="form-control select2L" name="selected_grade" id="selected_grade">
                                    <option selected value="">الكل</option>
                                    @foreach($selected_grades as $selected_grade)
                                        <option value="{{$selected_grade}}">{{$selected_grade}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile kt-margin-b-15">
                                <label>القسم :</label>
                                <select class="form-control select2L" name="department" id="department">
                                    <option selected value="">الكل</option>
                                </select>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile kt-margin-b-15">
                                <label>المحافظة :</label>
                                <select class="form-control select2L" name="governorate" id="governorate">
                                    <option selected value="">الكل</option>
                                    @foreach($governorates as $governorate)
                                        <option value="{{$governorate->id}}">{{$governorate->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile kt-margin-b-15">
                                <label>التسلسل :</label>
                                <select class="form-control select2L" name="sequencing" id="sequencing">
                                    <option selected value="">الكل</option>
                                    @foreach($sequencing as $sequence)
                                        <option value="{{is_null($sequence) ? 10:$sequence}}">{{is_null($sequence) ? 'بدون':$sequence}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile kt-margin-b-15">
                                <label>الكود :</label>
                                <input type="text" name="code" id="code" placeholder="الكود" class="form-control" />
                            </div>
                            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile kt-margin-b-15">
                                <label>سنة التخرج :</label>
                                <input type="number" min="1900" name="graduation_year" id="graduation_year" placeholder="سنة التخرج" class="form-control" />
                            </div>
                            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile kt-margin-b-15">
                                <label>الجنس :</label>
                                <select class="form-control select2L" name="gender" id="gender">
                                    <option selected value="">الكل</option>
                                    <option value="1">ذكر</option>
                                    <option value="2">أنثى</option>

                                </select>
                            </div>

                            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile kt-margin-b-15">
                                <label>الجهة / الوزارة :</label>
                                <select class="form-control select2L" name="ministry" id="ministry">
                                    <option selected value="">الكل</option>
                                    @foreach($ministries as $ministry)
                                        <option value="{{$ministry->id}}">{{$ministry->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile kt-margin-b-15">
                                <label>الإجراءات:</label>
                                <br/>
                                <button type="button" class="btn btn-danger btn-elevate btn-icon-sm" id="kt_search">
                                    <i class="la la-search"></i>
                                    بحث
                                </button>
                                <button type="submit" class="btn btn-danger btn-elevate btn-icon-sm" id="kt_excel">
                                    <i class="la la-paper-plane"></i>
                                    إكسل
                                </button>
                            </div>
                        </div>
                    </form>
                    <table class="table text-center" id="users-table">
                        <thead>
                        <th></th>
                        <th>الاسم</th>
                        <th>التسلسل</th>
                        <th>الكود</th>
                        <th>سنة التخرج</th>
                        <th>الجامعة</th>
                        <th>الكلية</th>
                        <th>القسم</th>
                        <th>الشهادة</th>
                        <th>الجنس</th>
                        <th>الدرجة الوظيفية</th>
                        <th>المحافظة</th>
                        <th>الجهة/الوزارة</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteModel" tabindex="-1" role="dialog" aria-labelledby="deleteModel"
         aria-hidden="true" style="display: none;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">تأكيد الحذف</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form method="post" action="" id="delete_form">
                    <input type="hidden" name="_method" value="delete">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <h5>هل أنت متأكد من حذف السجل المحدد ؟</h5>
                        <br/>
                        <p>حذف السجل المحدد سيؤدي لحذف السجلات المرتبطة به .</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-warning">حذف</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script>
        $(document).ready(function () {
            $('select[name="selected_grade"]').change(function () {
                var id = $(this).val();
                if (id > 0)
                {
                    getDepartments(id);
                }
            });
            $(document).on('click', '.deleteRecord', (function () {
                var id = $(this).data("id");
                var url = '{{ route("manager.applicant.destroy", ":id") }}';
                url = url.replace(':id', id);
                $('#delete_form').attr('action', url);
            }));
            var table = $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ordering: false,
                searching: false,
                dom: `<'row'<'col-sm-12'tr>>
      <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,

                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Arabic.json"
                },
                ajax: {
                    url: '{{ route('manager.applicant.index') }}',
                    data: function (d) {
                        var frm_data = $('#search_form').serializeArray();
                        $.each(frm_data, function (key, val) {
                            d[val.name] = val.value;
                        });
                    }
                },
                columnDefs: [
                    {
                        targets: 0,
                        width: '30px',
                        className: 'dt-left',
                        orderable: false,
                        render: function (data, type, full, meta) {
                            return meta.row + 1;
                        },
                    },
                    {
                        targets: 9,
                        render: function(data, type, full, meta) {
                            var status = {
                                1: {'title': 'ذكر', 'class': 'kt-badge--brand'},
                                2: {'title': 'أنثى', 'class': ' kt-badge--warning'},
                            };
                            if (typeof status[data] === 'undefined') {
                                return data;
                            }
                            return '<span class="kt-badge ' + status[data].class + ' kt-badge--inline kt-badge--pill">' + status[data].title + '</span>';
                        },
                    },
                    {
                        "targets": '_all',
                        "defaultContent": ""
                    }
                ],
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'sequencing', name: 'sequencing'},
                    {data: 'code', name: 'code'},
                    {data: 'graduation_year', name: 'graduation_year'},
                    {data: 'lottery_university.name', name: 'lottery_university'},
                    {data: 'lottery_college.name', name: 'lottery_college'},
                    {data: 'lottery_department.name', name: 'lottery_department'},
                    {data: 'lottery_degree.name', name: 'lottery_degree'},
                    {data: 'gender', name: 'gender'},
                    {data: 'selected_grade', name: 'selected_grade'},
                    {data: 'lottery_governorate.name', name: 'lottery_governorate'},
                    {data: 'lottery_ministry.name', name: 'lottery_ministry'},
                ],
            });

            var subDegreeURL = '{{ route("manager.collegeByUniversity", ":id") }}';
            $('select[name="university"]').change(function () {
                var id = $(this).val();
                if (id > 0)
                {
                    getSubDegree(id);
                }
            });
            function getSubDegree(id, selected = 0)
            {
                var url = subDegreeURL;
                url = url.replace(':id', id );
                $.ajax({
                    type: "get",
                    url: url,
                }).done(function (data) {
                    $('select[name="college"]').html(data.html);
                    $('select[name="college"]').selectpicker('refresh');
                });
            }

            $('#kt_search').click(function (e) {
                e.preventDefault();
                $('#users-table').DataTable().draw(true);
            });
            $('#kt_excel').click(function(e){
                e.preventDefault();
                $("#search_form").attr("action",'{{route('manager.applicant.export')}}');
                $('#search_form').submit();

                $("#search_form").attr("method",'');
                $("#search_form").attr("action",'');
            });
        });
    </script>
@endsection
