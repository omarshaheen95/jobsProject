@extends('manager.layout.container')
@section('content')
    @push('breadcrumb')
        <li class="breadcrumb-item">
            <a href="{{ route('manager.question.index') }}">الأسئلة</a>
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
                      action="{{ isset($question) ? route('manager.question.update', $question->id): route('manager.question.store') }}"
                      method="post">
                    {{ csrf_field() }}
                    @if(isset($question))
                        <input type="hidden" name="_method" value="patch">
                    @endif
                    <div class="kt-portlet__body">
                        <div class="kt-section kt-section--first">
                            <div class="kt-section__body">
                                <div class="form-group row">
                                    <label class="col-2 col-form-label">السؤال</label>
                                    <div class="col-8">
                                        <input class="form-control" name="question" type="text"
                                               value="{{ isset($question) ? $question->question : old("question") }}"
                                               placeholder="السؤال"/>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-2 col-form-label">نوع السؤال</label>
                                    <div class="col-8">
                                        <select class="form-control select2L" title="اختر نوع" name="type">
                                            <option
                                                value="radio" {{ isset($question) && $question->type == 'radio' ? 'selected':'' }}>اختيار مفرد</option>
                                            <option
                                                value="checkbox" {{ isset($question) && $question->type == 'checkbox' ? 'selected':'' }}>اختيار متعدد</option>
                                            <option
                                                value="writing" {{ isset($question) && $question->type == 'writing' ? 'selected':'' }}>كتابي</option>
                                            <option
                                                value="file" {{ isset($question) && $question->type == 'file' ? 'selected':'' }}>ملف مرفق (PDF)</option>
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>

                                <div class="form-group row" id="options_title">
                                    <hr/>

                                    <div class="col-md-6">
                                        <h3 class="card-title">
                                            الخيارات :
                                        </h3>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <button type="button" id="add_option" name="add_option"
                                                class="btn btn-sm btn-danger font-weight-bolder btn-light-primary ">
                                            <i class="la la-plus"></i>إضافة خيار
                                        </button>
                                    </div>


                                </div>
                                <div id="options_form">
                                    @if(isset($question))
                                        @foreach($question->options as $option)
                                            <div class="form-group row option_form">
                                                <div class="col-md-4">
                                                    <label>الخيار:</label>
                                                    <input type="text" required name="old_option[{{$option->id}}]"
                                                           value="{{$option->option}}"
                                                           class="form-control"
                                                           placeholder=""/>
                                                    <div class="d-md-none mb-2"></div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label>الإجابة</label>
                                                    <div class="radio-inline mt-3">
                                                        <label class="radio">
                                                            <input type="radio" @if($option->result == 0) checked
                                                                   @endif name="old_result[{{$option->id}}]" value="0"/>
                                                            <span></span>
                                                            بدون إجابة
                                                        </label>
                                                        <label class="radio">
                                                            <input type="radio" @if($option->result == 1) checked
                                                                   @endif name="old_result[{{$option->id}}]" value="1"/>
                                                            <span></span>
                                                            صحيحة
                                                        </label>
                                                        <label class="radio">
                                                            <input type="radio" @if($option->result == 2) checked
                                                                   @endif name="old_result[{{$option->id}}]" value="2"/>
                                                            <span></span>
                                                            خاطئة
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" data-id="{{$option->id}}" name="delete_old_option"
                                                            class="btn btn-sm font-weight-bolder btn-danger btn-icon delete_old_option mt-7">
                                                        <i class="la la-trash-o"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="form-group row option_form">
                                            <div class="col-md-4">
                                                <label>الخيار:</label>
                                                <input type="text" name="option[1]" class="form-control"
                                                       placeholder=""/>
                                                <div class="d-md-none mb-2"></div>
                                            </div>
                                            <div class="col-md-3">
                                                <label>الإجابة</label>
                                                <div class="radio-inline">
                                                    <label class="radio">
                                                        <input type="radio" checked name="result[1]" value="0"/>
                                                        <span></span>
                                                        بدون إجابة
                                                    </label>
                                                    <label class="radio">
                                                        <input type="radio" name="result[1]" value="1"/>
                                                        <span></span>
                                                        صحيحة
                                                    </label>
                                                    <label class="radio">
                                                        <input type="radio" name="result[1]" value="2"/>
                                                        <span></span>
                                                        خاطئة
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" name="delete_option"
                                                        class="btn btn-sm font-weight-bolder btn-danger btn-icon delete_option">
                                                    <i class="la la-trash-o"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                </div>



                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col-lg-12 text-right">
                                    <button type="submit"
                                            class="btn btn-danger">{{ isset($question) ? 'تعديل':'إنشاء' }}</button>&nbsp;
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
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest(\App\Http\Requests\Manager\QuestionRequest::class, '#form_information') !!}
    <script src="{{asset('js/question_edit.js')}}"></script>
    <script>
        option_delete_url = '{{route('manager.question.delete_option', ':id')}}';
        var eleVal = $('select[name="type"]').val();
        if(eleVal !== 'radio' && eleVal !== 'checkbox')
        {
            $('#options_form').hide();
            $('#options_title').hide();
        }else{
            $('#options_form').show();
            $('#options_title').show();
        }
        $('select[name="type"]').change(function(e){

            eleVal = $(this).val();

            if(eleVal !== 'radio' && eleVal !== 'checkbox')
            {
                $('#options_form').hide();
                $('#options_title').hide();
            }else{
                $('#options_form').show();
                $('#options_title').show();
            }
            // alert(eleVal);
        });
    </script>
@endsection
