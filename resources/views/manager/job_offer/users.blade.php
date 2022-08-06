@extends('manager.layout.container')
@section('b_style')
    <link href="{{asset('assets/vendors/general/bootstrap-daterangepicker/daterangepicker.rtl.css')}}" rel="stylesheet" type="text/css" />

@endsection
@section('style')
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">

@endsection
@section('content')
    @push('breadcrumb')
        <li class="breadcrumb-item">
            المتقدمين للعرض
        </li>
    @endpush
    <div class="row">
        <div class="col-md-12">
            <div class="kt-portlet kt-portlet--height-fluid">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            المتقدمين للعرض الوظيفي
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
                            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile kt-margin-b-15">
                                <label>الاسم :</label>
                                <input type="text" name="name" id="name" class="form-control kt-input"
                                       placeholder="الاسم ">
                            </div>
                            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile kt-margin-b-15">
                                <label>الموبايل :</label>
                                <input type="text" name="mobile" id="mobile" class="form-control kt-input"
                                       placeholder="الموبايل ">
                            </div>
                            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile kt-margin-b-15">
                                <label>رقم الهوية :</label>
                                <input type="text" name="uid" id="uid" class="form-control kt-input"
                                       placeholder="رقم الهوية ">
                            </div>
                            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile kt-margin-b-15">
                                <label>الجنس :</label>
                                <select class="form-control select2L" name="gender" id="gender">
                                    <option selected value="">الكل</option>
                                    <option value="male">ذكر</option>
                                    <option value="female">أنثى</option>

                                </select>
                            </div>
                            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile kt-margin-b-15">
                                <label>المحافظة :</label>
                                <select class="form-control select2L" name="governorate_id" id="governorate_id">
                                    <option selected value="">الكل</option>
                                    @foreach($governorates as $governorate)
                                        <option value="{{$governorate->id}}">{{$governorate->name}}
                                    @endforeach

                                </select>
                            </div>
                            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile kt-margin-b-15">
                                <label>حالة الطلب :</label>
                                <select class="form-control select2L" name="status" id="status">
                                    <option selected value="">الكل</option>
                                    <option value="pending" >قيد الانتظار</option>
                                    <option value="approve" >مقبول</option>
                                    <option value="rejected" >مرفوض</option>
                                </select>
                            </div>
                            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile kt-margin-b-15">
                                <label>حالة المقابلة :</label>
                                <select class="form-control select2L" name="interview" id="interview">
                                    <option selected value="">الكل</option>
                                    <option value="1" >تم التحديد</option>
                                    <option value="2" >لم يتم التحديد</option>
                                </select>
                            </div>
                            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile kt-margin-b-15">
                                <label>تاريخ الطلب :</label>
                                <input class="form-control " id="daterangepicker" name="created_at" readonly placeholder="اختر تاريخ" type="text" />
                            </div>
                            <input type='hidden' name="start_date" id="start_date" />
                            <input type='hidden' name="end_date" id="end_date"/>

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
                        <th>الاسم</th>
                        <th>رقم الهوية</th>
                        <th>الجنس</th>
                        <th>المحافظة</th>
                        <th>الموبايل</th>
                        <th>تاريخ التقديم</th>
                        <th>حالة الطلب</th>
                        <th>حالة المقابلة</th>
                        <th>الإجراءات</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteModel" tabindex="-1" role="dialog" aria-labelledby="deleteModel" aria-hidden="true" style="display: none;">
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
                        <br />
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
    <script src="{{asset('assets/vendors/general/bootstrap-daterangepicker/daterangepicker.js')}}"></script>

    <!-- Bootstrap JavaScript -->
    <script>
        $(document).ready(function(){
            $('input[name="created_at"]').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD',
                    cancelLabel: 'إلغاء',
                    applyLabel: 'تحديد',
                },

                autoUpdateInput: false,
                buttonClasses: ' btn',
                applyClass: 'btn-danger',
                cancelClass: 'btn-secondary'
            });
            $('input[name="created_at"]').on('apply.daterangepicker', function(ev, picker) {
                $('#start_date').val(picker.startDate.format('YYYY-MM-DD'));
                $('#end_date').val(picker.endDate.format('YYYY-MM-DD'));
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
            });
            $('input[name="created_at"]').on('cancel.daterangepicker', function(ev, picker) {
                //do something, like clearing an input
                $(this).val('');
                $('#start_date').val('');
                $('#end_date').val('');
            });
            $(document).on('click','.deleteRecord',(function(){
                var id = $(this).data("id");
                var url = '{{ route("manager.job_offer.deleteUsers", ":id") }}';
                url = url.replace(':id', id );
                $('#delete_form').attr('action',url);
            }));
            $(function() {
                $('#users-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ordering:false,
                    searching: false,
                    dom: `<'row'<'col-sm-12'tr>>
      <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,

                    language: {
                        url: "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Arabic.json"
                    },
                    ajax: {
                        url : '{{ route('manager.job_offer.users', $job_offer->id) }}',
                        data: function (d) {
                            var frm_data = $('#search_form').serializeArray();
                            $.each(frm_data, function (key, val) {
                                d[val.name] = val.value;
                            });
                        }
                    },
                    columns: [
                        {data: 'name', name: 'name'},
                        {data: 'uid', name: 'uid'},
                        {data: 'gender', name: 'gender'},
                        {data: 'governorate', name: 'governorate'},
                        {data: 'mobile', name: 'mobile'},
                        {data: 'created_at', name: 'created_at'},
                        {data: 'status', name: 'status'},
                        {data: 'interview', name: 'interview'},
                        {data: 'actions', name: 'actions'},
                    ],
                });
            });
            $('#kt_search').click(function(e){
                e.preventDefault();
                $('#users-table').DataTable().draw(true);
            });
            $('#kt_excel').click(function(e){
                e.preventDefault();
                $("#search_form").attr("action",'{{route('manager.exportUserJobOfferExcel', $job_offer->id)}}');
                $('#search_form').submit();

                $("#search_form").attr("method",'');
                $("#search_form").attr("action",'');
            });
        });
    </script>
@endsection
