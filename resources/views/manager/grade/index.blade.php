@extends('manager.layout.container')
@section('style')
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection
@section('content')
    @push('breadcrumb')
        <li class="breadcrumb-item">
            سجل الدرجات المستحدثة
        </li>
    @endpush
    <div class="row">
        <div class="col-md-12">
            <div class="kt-portlet kt-portlet--height-fluid">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            الدرجات المستحدثة
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-wrapper">
                            <div class="kt-portlet__head-actions">
                                <a href="{{ route('manager.grade.create') }}"
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
                                <label>العنوان الوظيفي :</label>
                                <select class="form-control select2L" name="position" id="position">
                                    <option selected value="">الكل</option>
                                    @foreach($positions as $position)
                                        <option value="{{$position->id}}">{{$position->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile kt-margin-b-15">
                                <label>القسم :</label>
                                <select class="form-control select2L" name="department" id="department">
                                    <option selected value="">الكل</option>
                                </select>
                            </div>
                            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile kt-margin-b-15">
                                <label>الجهة/الوزارة :</label>
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
                                <label>الدرجة الوظيفية :</label>
                                <select class="form-control select2L" name="grade" id="grade">
                                    <option selected value="">الكل</option>
                                    @foreach($selected_grades as $grade)
                                        <option value="{{$grade}}">{{$grade}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile kt-margin-b-15">
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
                        <th>الشهادة</th>
                        <th>الجامعة</th>
                        <th>الكلية</th>
                        <th>العنوان الوظيفي</th>
                        <th>القسم</th>
                        <th>الدرجة</th>
                        <th>العدد</th>
                        <th>الوزارة / الجهة تسمية موحدة</th>
                        </thead>
                        <tfoot>
                        <tr>
                            <th></th>
                            <th>-</th>
                            <th>-</th>
                            <th>-</th>
                            <th>-</th>
                            <th>-</th>
                            <th>-</th>
                            <th>الإجمالي</th>
                            <th>-</th>
                        </tr>
                        </tfoot>
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
            $('select[name="grade"]').change(function () {
                var id = $(this).val();
                if (id > 0)
                {
                    getDepartments(id);
                }
            });

            $(document).on('click', '.deleteRecord', (function () {
                var id = $(this).data("id");
                var url = '{{ route("manager.degree.destroy", ":id") }}';
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
                    url: '{{ route('manager.grade.index') }}',
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
                        "targets": '_all',
                        "defaultContent": ""
                    }
                ],
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'lottery_degree.name', name: 'lottery_degree'},
                    {data: 'lottery_university.name', name: 'lottery_university'},
                    {data: 'lottery_college.name', name: 'lottery_college'},
                    {data: 'lottery_position.name', name: 'lottery_position'},
                    {data: 'lottery_department.name', name: 'lottery_department'},
                    {data: 'grade_required', name: 'grade_required'},
                    {data: 'total_required', name: 'total_required'},
                    {data: 'lottery_ministry.name', name: 'lottery_ministry'},
                ],
                footerCallback: function(row, data, start, end, display) {

                    var column = 7;
                    var api = this.api(), data;

                    // Remove the formatting to get integer data for summation
                    var intVal = function(i) {
                        return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
                    };

                    // Total over all pages
                    var total = api.column(column).data().reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                    // Total over this page
                    var pageTotal = api.column(column, {page: 'current'}).data().reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                    // Update footer
                    $(api.column(column).footer()).html(
                        parseInt(pageTotal.toFixed(2)) + '<br/> ( ' + parseInt(total.toFixed(2)) + ' الإجمالي)',
                    );
                },
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
                $("#search_form").attr("action",'{{route('manager.grade.export')}}');
                $('#search_form').submit();

                $("#search_form").attr("method",'');
                $("#search_form").attr("action",'');
            });
        });
    </script>
@endsection
