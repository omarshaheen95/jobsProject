@extends('manager.layout.container', compact('expand'))
@section('style')
    <link rel="stylesheet" href="{{asset('assets/css/spin.css')}}" type="text/css">
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="kt-portlet kt-portlet--height-fluid" style="background-color: #F1f1f1;">
                <div class="kt-portlet__body">

                        <h3>{{$row->lottery_ministry->name}}</h3>
                        <div class="row ">
                            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile kt-margin-b-15">
                                <label>الدرجة الوظيفية :</label>
                                {{$row->grade_required}}
                            </div>
                            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile kt-margin-b-15">
                                <label>القسم :</label>
                                {{$row->lottery_department->name}}
                            </div>
                            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile kt-margin-b-15">
                                <label>العدد المطلوب :</label>
                                {{$row->sum_total_required}}
                            </div>
                            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile kt-margin-b-15">
                                <label>العدد المحدد مسبقا :</label>
                                {{$old_applicants}}
                            </div>
                            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile kt-margin-b-15">
                                <label>الشواغر المتبقية :</label>
                                {{$total_needs}}
                            </div>
                            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile kt-margin-b-15">
                                <label>المتقدمين الشواغر :</label>
                                {{count($applicants)}}
                            </div>

                        </div>
                        <form action="{{isset($route) && !is_null($route) ? $route:route('manager.lottery.update-discrimination-ministry')}}" method="post"
                              id="lotteryForm">
                            @csrf()
                            <input type="hidden" name="selected_ministry" value="{{$row->lottery_ministry_id}}">
                            <input type="hidden" name="selected_grade" value="{{$row->grade_required}}">
                            <input type="hidden" name="selected_department" value="{{$row->lottery_department_id}}">

                            @if(count($applicants) > 0 && $total_needs > 0)
                            <div class="row justify-content-center">
                                <div class="col-sm-12 text-center" id="lottery_actions">
                                    <div class="form-group">
                                        <button type="button" data-toggle="modal" data-target="#approveModel"
                                                id="approve_lottery" class="btn btn-success pt-3"> اعتماد
                                            القرعة
                                        </button>
                                        <a href="{{url()->full()}}" id="reload_lottery" class="btn btn-dark pt-3"> اعادة
                                            القرعة
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @else
                                <div class="row justify-content-center">
                                <h3>لا يوجد نتائج يمكن اعتمادها</h3>
                                </div>
                            @endif

                            <div class="row justify-content-center">
                                <div id="emp">

                                    <h1 class="py-4"></h1>

                                    <div class="emp-list" id="empList">
                                        @foreach($applicants as $applicant)
                                            <div data-applicant="{{$applicant->id}}" data-id="{{$count}}"
                                                 class="emp-box {{$count <= $total_needs ? 'checked':''}} bg-white rounded shadow-sm p-4">
                                                <h5 class="mb-0"> {{$applicant->code}}</h5>
                                                <span
                                                    class="small text-uppercase text-muted"> {{$applicant->fake_code}} </span>
                                                @if($count <= $total_needs)
                                                    <input type="hidden" value="{{$applicant->id}}"
                                                           name="selected_applicants[{{$applicant->id}}]"/>
                                                @else
                                                    <input type="hidden" value=""
                                                           name="selected_applicants[]"/>
                                                @endif
                                            </div>
                                            @php
                                                $count ++;
                                            @endphp
                                        @endforeach
                                    </div>
                                </div>

                            </div>
                        </form>


                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="approveModel" tabindex="-1" role="dialog" aria-labelledby="approveModel"
         aria-hidden="true" style="display: none;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">تأكيد اعتماد النتائج</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <h5>هل أنت متأكد من اعتماد النتائج المحددة ؟</h5>
                    <br/>
                    <p>اعتماد التائج المحدد سيعمل على تسجيل و حجز المتقدمين للجهة والدرجة الوظيفية والقسم المحددين .</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                    <button type="button" class="btn btn-warning" id="approveButton">اعتماد</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $(document).on('click', '#approveButton', (function (e) {
                e.preventDefault();
                $('#lotteryForm').submit();
            }));
        });
    </script>
@endsection
