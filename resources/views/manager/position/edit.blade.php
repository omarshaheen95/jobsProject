@extends('manager.layout.container')
@section('content')
    @push('breadcrumb')
        <li class="breadcrumb-item">
            <a href="{{ route('manager.position.index') }}">المناصب الوظيفية</a>
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
                      action="{{ isset($position) ? route('manager.position.update', $position->id): route('manager.position.store') }}"
                      method="post">
                    {{ csrf_field() }}
                    @if(isset($position))
                        <input type="hidden" name="_method" value="patch">
                    @endif
                    <div class="kt-portlet__body">
                        <div class="kt-section kt-section--first">
                            <div class="kt-section__body">
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">اسم المنصب الوظيفي</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <input class="form-control" name="name" type="text"
                                               value="{{ isset($position) ? $position->name : old("name") }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">درجة المنصب الوظيفي</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <input class="form-control" name="job_grade" type="text"
                                               value="{{ isset($position) ? $position->job_grade : old("job_grade") }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">ترتيب المنصب الوظيفي</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <input class="form-control" name="ordered" type="number"
                                               value="{{ isset($position) ? $position->ordered : 1 }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">تفعيل المنصب الوظيفي</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <span class="kt-switch">
                                            <label>
                                                <input type="checkbox" value="1"
                                                       {{ isset($position) && $position->active ? 'checked' :'' }} name="active">
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
                                            class="btn btn-danger">{{ isset($position) ? 'تعديل':'إنشاء' }}</button>&nbsp;
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
    {!! JsValidator::formRequest(\App\Http\Requests\Manager\PositionRequest::class, '#form_information') !!}
@endsection
