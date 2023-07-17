@extends('manager.layout.container')
@section('style')
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection
@section('content')
    @push('breadcrumb')
        <li class="breadcrumb-item">
            سجل الدرجات المستحدثة (الأقسام الحاكمة)
        </li>
    @endpush
    <div class="row">
        <div class="col-md-12">
            <div class="kt-portlet kt-portlet--height-fluid">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            الدرجات المستحدثة (الأقسام الحاكمة)
                        </h3>
                    </div>
                    <div class="kt-portlet__head-toolbar">
                        <div class="kt-portlet__head-wrapper">
                            <div class="kt-portlet__head-actions">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <form class="kt-form kt-form--fit kt-margin-b-15" action="" id="search_form" method="get">
                        <div class="row ">
                            <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile kt-margin-b-15">
                                <label>الدرجة الوظيفية :</label>
                                <select class="form-control select2L" name="grade" id="grade">
                                    <option selected value="">الكل</option>
                                    @foreach($selected_grades as $selected_grade)
                                        <option value="{{$selected_grade}}">{{$selected_grade}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile kt-margin-b-15">
                                <label>القسم :</label>
                                <select class="form-control select2L" name="department" id="department">
                                    <option selected value="">الكل</option>
                                </select>
                            </div>
                            <div class="col-lg-3 kt-margin-b-10-tablet-and-mobile kt-margin-b-15">
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
                        <th>القسم</th>
                        <th>الدرجة</th>
                        <th>الوزارة / الجهة تسمية موحدة</th>
                        <th>العدد المطلوب</th>
                        <th>العدد المكتمل</th>
                        <th>العدد المتاح</th>
                        <th>الإجراءات</th>
                        </thead>
                        <tfoot>
                        <tr>
                            <th></th>
                            <th>-</th>
                            <th>-</th>
                            <th>-</th>
                            <th>الإجمالي</th>
                            <th>-</th>
                            <th>-</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
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
                    getDepartments(id, 0, 1);
                }
            });
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
                    url: '{{ route('manager.grade.governor') }}',
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
                    {data: 'lottery_department.name', name: 'lottery_department'},
                    {data: 'grade_required', name: 'grade_required'},
                    {data: 'lottery_ministry.name', name: 'lottery_ministry'},
                    {data: 'total_required', name: 'total_required'},
                    {data: 'used', name: 'used'},
                    {data: 'available', name: 'available'},
                    {data: 'actions', name: 'actions'},
                ],
                footerCallback: function(row, data, start, end, display) {

                    var column = 4;
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

            $('#kt_search').click(function (e) {
                e.preventDefault();
                $('#users-table').DataTable().draw(true);
            });
            $('#kt_excel').click(function(e){
                e.preventDefault();
                $("#search_form").attr("action",'{{route('manager.grade.governor.export')}}');
                $('#search_form').submit();

                $("#search_form").attr("method",'');
                $("#search_form").attr("action",'');
            });
        });
    </script>
@endsection
