@extends('manager.layout.container')
@section('style')
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection
@section('content')
    @push('breadcrumb')
        <li class="breadcrumb-item">
            <a href="{{ route('manager.position.index') }}">المستخدمين</a>
        </li>
        <li class="breadcrumb-item">
            {{ isset($title) ? $title:'' }}
        </li>
    @endpush
    <input type="hidden" name="userId" value="{{$user->id}}">
    <div class="row">
        <div class="col-xl-12">
            <!--begin:: Widgets/Applications/User/Profile3-->
            <div class="kt-portlet kt-portlet--height-fluid">
                <div class="kt-portlet__body">
                    <div class="kt-widget kt-widget--user-profile-3">
                        <div class="kt-widget__top">
                            <div class="kt-widget__media kt-hidden-">
                                <img src="{{ optional($user->userInfo)->getFirstMediaUrl('users') }}" alt="image">
                            </div>
                            <div class="kt-widget__content">
                                <div class="kt-widget__head">
                                    <label href="#" class="kt-widget__username">
                                        {{ $user->name }}
                                        @if($user->active == 1)
                                            <i class="flaticon2-correct"></i>
                                        @endif
                                    </label>
                                </div>
                                @if($user->email)
                                    <div class="kt-widget__subhead">
                                        <a href="mailTo:{{ $user->email }}">{{ $user->email }}</a>
                                    </div>
                                @endif
                                <div class="kt-widget__info">
                                    <div class="kt-widget__desc">
                                        <label href="#" class="mr-2">مسجل منذ
                                            : {{ $user->created_at->toDateTimeString() }}</label>
                                        <br>
                                        <label href="#" class="mr-2">الجنس : {{ $user->userInfo->gender_name }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="kt-widget__media kt-hidden-">
                            </div>
                            <div class="kt-widget__content">
                                <div class="kt-widget__head">
                                    <label><span>رقم الهوية</span>: {{ $user->userInfo->uid }}</label>
                                </div>
                                <div class="kt-widget__subhead">
                                    <label><span>الاسم كاملا</span>: {{ $user->userInfo->full_name }}</label>
                                </div>
                                <div class="kt-widget__head">
                                    <label><span>الموبايل</span>: {{ $user->userInfo->mobile }}</label>
                                </div>
                                <div class="kt-widget__subhead">
                                    <label><span>الهاتف</span>: {{ $user->userInfo->phone }}</label>
                                </div>
                            </div>
                            <div class="kt-widget__content">
                                <div class="kt-widget__head">
                                    <label><span>مكان الميلاد</span>: {{ $user->userInfo->birthGovernorate->name }}
                                    </label>
                                </div>
                                <div class="kt-widget__subhead">
                                    <label><span>المحافظة الحالية</span>: {{ $user->userInfo->governorate->name }}
                                    </label>
                                </div>
                                <div class="kt-widget__head">
                                    <label><span>العنوان</span>: {{ $user->userInfo->address }}</label>
                                </div>
                                <div class="kt-widget__subhead">
                                    <label><span>تاريخ الميلاد</span>: {{ $user->userInfo->dob }} - العمر
                                        : {{\Carbon\Carbon::parse($user->userInfo->dob)->age}} سنة </label>
                                </div>
                            </div>
                        </div>
                        <div class="kt-widget__bottom mt-0">
                            <div class="kt-widget__item">
                                <div class="kt-widget__details">
                                    <span class="kt-widget__title">الحالة الاجتماعية</span>
                                    <span class="kt-widget__value">{{$user->userInfo->marital_status_name}}</span>
                                </div>
                            </div>
                            <div class="kt-widget__item">
                                <div class="kt-widget__details">
                                    <span class="kt-widget__title">عدد الأبناء</span>
                                    <span class="kt-widget__value">{{$user->userInfo->number_of_children}}</span>
                                </div>
                            </div>
                            <div class="kt-widget__item">
                                <div class="kt-widget__details">
                                    <span class="kt-widget__title">عدد الموظفين في العائلة</span>
                                    <span class="kt-widget__value">{{$user->userInfo->number_of_employees}}</span>
                                </div>
                            </div>
                            <div class="kt-widget__item">
                                <div class="kt-widget__details">
                                    <span class="kt-widget__title">من فئة الطلاب المبتعثين</span>
                                    <span
                                        class="kt-widget__value">{{$user->userInfo->scholarship_student ? 'نعم':'لا'}}</span>
                                </div>
                            </div>
                            <div class="kt-widget__item">
                                <div class="kt-widget__details">
                                    <span class="kt-widget__title">من فئة الطلاب 10 الأوائل</span>
                                    <span
                                        class="kt-widget__value">{{$user->userInfo->scholarship_student ? 'نعم':'لا'}}</span>
                                </div>
                            </div>
                            <div class="kt-widget__item">
                                <div class="kt-widget__details">
                                    <span class="kt-widget__title">يعمل في القطاع الخاص</span>
                                    <span class="kt-widget__value">{{$user->userInfo->unemployed ? 'نعم':'لا'}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="kt-widget__bottom mt-2">
                            <div class="kt-widget__item">
                                <div class="kt-widget__details">
                                    <span class="kt-widget__title">يعمل في منظمات غير حكومية</span>
                                    <span
                                        class="kt-widget__value">{{$user->userInfo->work_nonGovernmental_org ? 'نعم':'لا'}}</span>
                                </div>
                            </div>
                            <div class="kt-widget__item">
                                <div class="kt-widget__details">
                                    <span class="kt-widget__title">مسجل عاطل عن العمل في الوزارة</span>
                                    <span
                                        class="kt-widget__value">{{$user->userInfo->registered_unemployed_ministry ? 'نعم':'لا'}}</span>
                                </div>
                            </div>
                            <div class="kt-widget__item">
                                <div class="kt-widget__details">
                                    <span class="kt-widget__title">من فئة ذوي الأسرى</span>
                                    <span
                                        class="kt-widget__value">{{$user->userInfo->family_of_prisoners ? 'نعم':'لا'}}</span>
                                </div>
                            </div>
                            <div class="kt-widget__item">
                                <div class="kt-widget__details">
                                    <span class="kt-widget__title">من فئة ذوي الجرحى</span>
                                    <span
                                        class="kt-widget__value">{{$user->userInfo->injured_people ? 'نعم':'لا'}}</span>
                                </div>
                            </div>
                            <div class="kt-widget__item">
                                <div class="kt-widget__details">
                                    <span class="kt-widget__title">من فئة ذوي الشهداء</span>
                                    <span
                                        class="kt-widget__value">{{$user->userInfo->family_of_martyrs ? 'نعم':'لا'}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="kt-portlet kt-portlet--height-fluid">
                <div class="kt-portlet__body">
                    <ul class="nav nav-tabs  nav-tabs-line nav-tabs-line-danger" role="tablist">
                        <li class="nav-item active">
                            <a class="nav-link active" data-toggle="tab" href="#qualifications" role="tab">المؤهلات</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#skills" role="tab">الخبرات</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " data-toggle="tab" href="#courses" role="tab">الدورات</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " data-toggle="tab" href="#experiences" role="tab">المهارات</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " data-toggle="tab" href="#languages" role="tab">اللغات</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " data-toggle="tab" href="#disabilities" role="tab">الوضع الصحي</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " data-toggle="tab" href="#job_applications" role="tab">طلبات التوظيف</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " data-toggle="tab" href="#interviews" role="tab">المقابلات</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="qualifications" role="tabpanel">
                            <table class="table text-center" id="qualifications-table">
                                <thead>
                                    <td>المؤهل</td>
                                    <td>التخصص العام</td>
                                    <td>التخصص الدقيق</td>
                                    <td>المعهد/المدرسة/الجامعة</td>
                                    <td>بلد التخرج</td>
                                    <td>تاريخ التخرج</td>
                                    <td>المعدل</td>
                                    <td>التقدير</td>
                                </thead>
                            </table>
                        </div>
                        <div class="tab-pane " id="skills" role="tabpanel">
                            <table class="table text-center" id="skills-table">
                                <thead>
                                <td>العنوان الوظيفي</td>
                                <td>مكان العمل</td>
                                <td>تاريخ البداية</td>
                                <td>تاريخ النهاية</td>
                                <td>سبب الإنتهاء</td>
                                </thead>
                            </table>
                        </div>
                        <div class="tab-pane" id="courses" role="tabpanel">
                            <table class="table text-center" id="courses-table">
                                <thead>
                                <td>عنوان الدورة</td>
                                <td>عدد الساعات</td>
                                <td>مكان الإنعقاد</td>
                                <td>تاريخ البداية</td>
                                <td>تاريخ النهاية</td>
                                </thead>
                            </table>
                        </div>
                        <div class="tab-pane" id="experiences" role="tabpanel">
                            <table class="table text-center" id="experiences-table">
                                <thead>
                                <td>عنوان المهارة</td>
                                <td>التقييم</td>
                                </thead>
                            </table>
                        </div>
                        <div class="tab-pane" id="languages" role="tabpanel">
                            <table class="table text-center" id="languages-table">
                                <thead>
                                <td>اللغة</td>
                                <td>القراءة</td>
                                <td>الكتابة</td>
                                <td>المحادثة</td>
                                </thead>
                            </table>
                        </div>
                        <div class="tab-pane" id="disabilities" role="tabpanel">
                            <table class="table text-center" id="disabilities-table">
                                <thead>
                                <td>نوع الإعاقة</td>
                                <td>نسبة الإعاقة</td>
                                <td>الجهة او المؤسسة</td>
                                </thead>
                            </table>
                        </div>
                        <div class="tab-pane " id="job_applications" role="tabpanel">
                            <table class="table text-center" id="job_applications-table">
                                <thead>

                                </thead>
                            </table>
                        </div>
                        <div class="tab-pane " id="interviews" role="tabpanel">
                            <table class="table text-center" id="interviews-table">
                                <thead>

                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script>
        const userId = $('input[name="userId"]').val();

        $(function () {
            var url = '{{ route('manager.userQualifications', ':id') }}';
            url = url.replace(':id', userId);
            $('#qualifications-table').DataTable({
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
                    url: url,
                    data: function (d) {
                        d.search = $("#search").val();
                    }
                },
                columns: [
                    {data: 'qualification.name', name: 'qualification.name'},
                    {data: 'degree.name', name: 'degree.name'},
                    {data: 'sub_degree.name', name: 'sub_degree.name'},
                    {data: 'graduation_place', name: 'graduation_place'},
                    {data: 'country.name', name: 'country.name'},
                    {data: 'graduation_date', name: 'graduation_date'},
                    {data: 'average', name: 'average'},
                    {data: 'appreciation.name', name: 'appreciation.name'},
                ],
            });
        });
        $(function () {
            var url = '{{ route('manager.userSkills', ':id') }}';
            url = url.replace(':id', userId);
            $('#skills-table').DataTable({
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
                    url: url,
                    data: function (d) {
                        d.search = $("#search").val();
                    }
                },
                columns: [
                    {data: 'position', name: 'position'},
                    {data: 'work_place', name: 'work_place'},
                    {data: 'start_at', name: 'start_at'},
                    {data: 'end_at', name: 'end_at'},
                    {data: 'end_reasons', name: 'end_reasons'},
                ],
            });
        });
        $(function () {
            var url = '{{ route('manager.userCourses', ':id') }}';
            url = url.replace(':id', userId);
            $('#courses-table').DataTable({
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
                    url: url,
                    data: function (d) {
                        d.search = $("#search").val();
                    }
                },
                columns: [
                    {data: 'course_name', name: 'course_name'},
                    {data: 'course_hours', name: 'course_hours'},
                    {data: 'course_place', name: 'course_place'},
                    {data: 'start_at', name: 'start_at'},
                    {data: 'end_at', name: 'end_at'},
                ],
            });
        });
        $(function () {
            var url = '{{ route('manager.userExperiences', ':id') }}';
            url = url.replace(':id', userId);
            $('#experiences-table').DataTable({
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
                    url: url,
                    data: function (d) {
                        d.search = $("#search").val();
                    }
                },
                columns: [
                    {data: 'experience_name', name: 'experience_name'},
                    {data: 'self_rate', name: 'self_rate'},
                ],
            });
        });
        $(function () {
            var url = '{{ route('manager.userLanguages', ':id') }}';
            url = url.replace(':id', userId);
            $('#languages-table').DataTable({
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
                    url: url,
                    data: function (d) {
                        d.search = $("#search").val();
                    }
                },
                columns: [
                    {data: 'language.name', name: 'language.name'},
                    {data: 'reading_rate', name: 'reading_rate'},
                    {data: 'writing_rate', name: 'writing_rate'},
                    {data: 'conversation_rate', name: 'conversation_rate'},
                ],
            });
        });
        $(function () {
            var url = '{{ route('manager.userDisabilities', ':id') }}';
            url = url.replace(':id', userId);
            $('#disabilities-table').DataTable({
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
                    url: url,
                    data: function (d) {
                        d.search = $("#search").val();
                    }
                },
                columns: [
                    {data: 'disability.name', name: 'disability.name'},
                    {data: 'disability_rate', name: 'disability_rate'},
                    {data: 'enterprise_follow_up', name: 'enterprise_follow_up'},
                ],
            });
        });
    </script>
@endsection
