@extends('manager.layout.container')
@section('style')
    <link href="{{ asset('assets/vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    @push('breadcrumb')
        <li class="breadcrumb-item">
            <a href="{{ route('manager.job_offer.index') }}">العروض الوظیفیة</a>
        </li>
        <li class="breadcrumb-item">
            {{ isset($title) ? $title:'' }}
        </li>
    @endpush
    <div class="row">
        <div class="col-xl-10 offset-1">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">{{ isset($title) ? $title:'' }}</h3>
                    </div>
                </div>
                <form enctype="multipart/form-data" id="form_information" class="kt-form kt-form--label-right"
                      action="{{ route('manager.job_offer.update_status', $job_offer->id) }}"
                      method="post">
                    {{ csrf_field() }}
                    @if(isset($ministry))
                        <input type="hidden" name="_method" value="patch">
                    @endif
                    <div class="kt-portlet__body">
                        <div class="kt-section kt-section--first">
                            <div class="kt-section__body">
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">اسم العرض الوظيفي</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <input class="form-control" type="text" disabled
                                               value="{{ isset($job_offer) ? $job_offer->jobOffer->name : old("name") }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">حالة الطلب</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <select class="form-control" name="status">
                                            <option value="pending" {{isset($job_offer) && $job_offer->status == 'pending' ? 'selected':''}}>قيد الانتظار</option>
                                            <option value="checked" {{isset($job_offer) && $job_offer->status == 'checked' ? 'selected':''}}>تم التدقیق</option>
                                            <option value="approve" {{isset($job_offer) && $job_offer->status == 'approve' ? 'selected':''}}>مقبول</option>
                                            <option value="rejected" {{isset($job_offer) && $job_offer->status == 'rejected' ? 'selected':''}}>مرفوض</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">مكان المقابلة</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <input class="form-control" name="interview_place" type="text"
                                               value="{{ isset($job_offer) ? optional($job_offer->interview)->interview_place : 1 }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">تاريخ المقابلة</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <input class="form-control dateTime" name="interview_date" type="text"
                                               value="{{ isset($job_offer) ? optional($job_offer->interview)->interview_date : 1 }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">ملاحظات</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <textarea class="form-control" name="note"
                                               placeholder="ملاحظات">{{ isset($job_offer) ? $job_offer->note : 1 }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col-lg-12 text-right">
                                    <button type="submit" class="btn btn-danger">حفظ</button>&nbsp;
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/vendors/general/bootstrap-datetime-picker/js/bootstrap-datetimepicker.js') }}"
            type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    <script>
        $('.dateTime').datetimepicker({
            todayHighlight: true,
            autoclose: true,
            format: 'yyyy-mm-dd hh:ii:ss'
        });
    </script>
    {!! JsValidator::formRequest(\App\Http\Requests\Manager\InterviewRequest::class, '#form_information') !!}
@endsection
