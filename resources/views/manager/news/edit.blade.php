@extends('manager.layout.container')
@section('style')
    <link href="{{ asset('assets/vendors/general/summernote/dist/summernote.rtl.css') }}" rel="stylesheet"/>
    <link href="{{asset('assets/vendors/general/bootstrap-tagsinput/dist/bootstrap-tagsinput.css')}}"
          rel="stylesheet" />
    <style>
        .bootstrap-tagsinput .tag {
            margin-right: 2px;
            color: #ffffff;
            background: #2196f3;
            padding: 3px 7px;
            border-radius: 3px;
        }
        .bootstrap-tagsinput {
            width: 100%;
        }
    </style>
@endsection
@section('content')
    @push('breadcrumb')
        <li class="breadcrumb-item">
            <a href="{{ route('manager.news.index') }}">الأخبار</a>
        </li>
        <li class="breadcrumb-item">
            {{ isset($title) ? $title:'' }}
        </li>
    @endpush
    <div class="row">
        <div class="col-xl-12">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">{{ isset($title) ? $title:'' }}</h3>
                    </div>
                </div>
                <form enctype="multipart/form-data" id="form_information" class="kt-form kt-form--label-right"
                      action="{{ isset($news) ? route('manager.news.update', $news->id): route('manager.news.store') }}"
                      method="post">
                    {{ csrf_field() }}
                    @if(isset($news))
                        <input type="hidden" name="_method" value="patch">
                    @endif
                    <div class="kt-portlet__body">
                        <div class="kt-section kt-section--first">
                            <div class="kt-section__body">
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">صورة الخبر</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <div class="upload-btn-wrapper">
                                            <button class="btn btn-brand">اختر صورة</button>
                                            <input name="image" class="imgInp" id="imgInp" type="file" />
                                        </div>
                                        <img id="blah" @if(!isset($news)) style="display:none" @endif src="{{ isset($news) ? $news->getFirstMediaUrl('news'):'' }}" width="150" alt="No file chosen" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">عنوان الخبر</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <input class="form-control" name="title" type="text"
                                               value="{{ isset($news) ? $news->title : old("title") }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">عنوان الخبر الفرعي</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <input class="form-control" name="sub_title" type="text"
                                               value="{{ isset($news) ? $news->sub_title : old("sub_title") }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">كلمات مفتاحية</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <input class="form-control" data-role="tagsinput"  name="tags" type="text"
                                               value="{{ isset($news) ? $news->tags : old("tags") }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">محتوى الخبر</label>
                                    <div class="col-lg-9 col-xl-9">
                                        <textarea name="content" id="" cols="30" rows="10"
                                                  class="summernote">{{ isset($news) ? $news->content : old("content") }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">تمييز الخبر</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <span class="kt-switch">
                                            <label>
                                                <input type="checkbox" value="1"
                                                       {{ isset($news) && $news->special ? 'checked' :'' }} name="special">
                                                <span></span>
                                            </label>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col-lg-12 text-right">
                                    <button type="submit"
                                            class="btn btn-danger">{{ isset($news) ? 'تعديل':'إنشاء' }}</button>&nbsp;
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
    <script src="{{ asset('assets/vendors/general/summernote/dist/summernote.min.js') }}"
            type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    <script src="{{asset('assets/vendors/general/bootstrap-tagsinput/dist/bootstrap-tagsinput.js')}}"></script>
    {!! JsValidator::formRequest(\App\Http\Requests\Manager\NewsRequest::class, '#form_information') !!}
    <script>
        $(document).ready(function () {
            var gArrayFonts = ['book','bold','Arial', 'Arial Black', 'Comic Sans MS', 'Courier New',
                'Helvetica Neue', 'Helvetica', 'Impact', 'Lucida Grande',
                'Tahoma', 'Times New Roman', 'Verdana'];

            $('.summernote').summernote({
                height: '800px',
                fontNames: gArrayFonts,
                fontNamesIgnoreCheck: gArrayFonts,
            });
        });
    </script>
@endsection
