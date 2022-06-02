@extends('manager.layout.container')
@section('style')
    <link href="{{ asset('assets/vendors/general/summernote/dist/summernote.rtl.css') }}" rel="stylesheet"/>
@endsection
@section('content')
    @push('breadcrumb')
        <li class="breadcrumb-item">
            <a href="{{ route('manager.page.index') }}">الصفحات</a>
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
                      action="{{ isset($page) ? route('manager.page.update', $page->id): route('manager.page.store') }}"
                      method="post">
                    {{ csrf_field() }}
                    @if(isset($page))
                        <input type="hidden" name="_method" value="patch">
                    @endif
                    <div class="kt-portlet__body">
                        <div class="kt-section kt-section--first">
                            <div class="kt-section__body">
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">عنوان الصفحة</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <input class="form-control" name="title" type="text"
                                               value="{{ isset($page) ? $page->title : old("title") }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">عنوان الصفحة الفرعي</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <input class="form-control" name="sub_title" type="text"
                                               value="{{ isset($page) ? $page->sub_title : old("sub_title") }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">محتوى الصفحة</label>
                                    <div class="col-lg-9 col-xl-9">
                                        <textarea name="content" id="" cols="30" rows="10"
                                                  class="summernote">{{ isset($page) ? $page->content : old("content") }}</textarea>
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
                                            class="btn btn-danger">{{ isset($page) ? 'تعديل':'إنشاء' }}</button>&nbsp;
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
    {!! JsValidator::formRequest(\App\Http\Requests\Manager\PageRequest::class, '#form_information') !!}
    <script>
        $(document).ready(function () {
            $('.summernote').summernote({
                height: '300px',
            });
        });
    </script>
@endsection
