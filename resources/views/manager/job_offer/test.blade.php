@extends('manager.layout.container')
@section('style')
    <link href="{{ asset('assets/vendors/general/bootstrap-datetime-picker/css/bootstrap-datetimepicker.css') }}"
          rel="stylesheet" type="text/css"/>
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
{{--                <div id="form_information" class="kt-form kt-form--label-right">--}}
                    <div class="kt-portlet__body">
                        <div class="kt-section kt-section--first">
                            <div class="kt-section__body">
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">النتيجة العامة للتقديم</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <input class="form-control" type="text" disabled
                                               value="{{ $job_offer->total_mark }}%">
                                    </div>
                                </div>
                                @foreach($job_offer->jobOffer->questions as $question)
                                    @if($question->type == 'radio')
                                        <div class="form-group row">
                                            <label
                                                class="col-xl-3 col-lg-3 col-form-label">{{$question->question}}</label>
                                            <div class="col-lg-9 col-xl-6 py-3">
                                                <div class="radio-inline">
                                                    @foreach($question->options as $option)
                                                    <label class="radio">
                                                        <input type="radio" disabled name="radios{{$question->id}}" @if($option->optionResult($job_offer->id)) checked @endif>
                                                        <span></span>{{$option->option}}</label>
                                                    @endforeach
                                                </div>

                                            </div>
                                        </div>

                                    @elseif($question->type == 'checkbox')
                                        <div class="form-group row">
                                            <label
                                                class="col-xl-3 col-lg-3 col-form-label">{{$question->question}}</label>
                                            <div class="col-lg-9 col-xl-6 py-3">
                                                <div class="radio-inline">
                                                    @foreach($question->options as $option)
                                                        <label class="radio">
                                                            <input type="checkbox" disabled name="radios2" @if($option->optionResult($job_offer->id)) checked @endif>
                                                            <span></span>{{$option->option}}</label>
                                                    @endforeach
                                                </div>

                                            </div>
                                        </div>

                                    @elseif($question->type == 'file')
                                        <div class="form-group row">
                                            <label
                                                class="col-xl-3 col-lg-3 col-form-label">{{$question->question}}</label>
                                            <div class="col-lg-9 col-xl-6 py-3">
                                                @if($file = $question->fileResult($job_offer->id))
                                                    <a href="{{$file}}" target="_blank">معاينة</a>
                                                @else
                                                    <span class="text-warning">لم يتم تقديم مرفقات</span>
                                                @endif
                                            </div>
                                        </div>
                                    @elseif($question->type == 'writing')
                                        <div class="form-group row">
                                            <label
                                                class="col-xl-3 col-lg-3 col-form-label">{{$question->question}}</label>
                                            <div class="col-lg-9 col-xl-6">
                                        <textarea disabled class="form-control" name="note"
                                                  placeholder="ملاحظات">{{ $question->textResult($job_offer->id) }}</textarea>
                                            </div>
                                        </div>
                                    @endif

                                @endforeach
                            </div>
                        </div>
                    </div>
{{--                </div>--}}
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
