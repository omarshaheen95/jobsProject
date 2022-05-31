@extends('manager.layout.container')
@section('content')
    @push('breadcrumb')
        <li class="breadcrumb-item">
            <a href="{{ route('manager.sub_degree.index') }}">التخصصات الدقيقة</a>
        </li>
        <li class="breadcrumb-item">
            {{ isset($sub_degree) ? 'تعديل التخصص الدقيق' : 'إضافة تخصص دقيق' }}
        </li>
    @endpush
    <div class="row">
        <div class="col-xl-10 offset-1">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">            {{ isset($sub_degree) ? 'تعديل التخصص الدقيق' : 'إضافة تخصص دقيق' }}
                        </h3>
                    </div>
                </div>
                <form enctype="multipart/form-data" id="form_information" class="kt-form kt-form--label-right"
                      action="{{ isset($sub_degree) ? route('manager.sub_degree.update', $sub_degree->id): route('manager.sub_degree.store') }}"
                      method="post">
                    {{ csrf_field() }}
                    @if(isset($sub_degree))
                        <input type="hidden" name="_method" value="patch">
                    @endif
                    <div class="kt-portlet__body">
                        <div class="kt-section kt-section--first">
                            <div class="kt-section__body">
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">التخصص العام</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <select class="form-control" name="degree_id">
                                            <option selected value="">اختر تخصص عام</option>
                                            @foreach($degrees as $degree)
                                                <option value="{{$degree->id}}" {{isset($sub_degree) && $sub_degree->degree_id == $degree->id ? 'selected':''}}>{{$degree->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">اسم التخصص الدقيق</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <input class="form-control" name="name" type="text"
                                               value="{{ isset($sub_degree) ? $sub_degree->name : old("name") }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">ترتيب التخصص الدقيق</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <input class="form-control" name="ordered" type="number"
                                               value="{{ isset($sub_degree) ? $sub_degree->ordered : 1 }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">تفعيل التخصص الدقيق</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <span class="kt-switch">
                                            <label>
                                                <input type="checkbox" value="1"
                                                       {{ isset($sub_degree) && $sub_degree->active ? 'checked' :'' }} name="active">
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
                                            class="btn btn-danger">{{ isset($sub_degree) ? 'تعديل':'إنشاء' }}</button>&nbsp;
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
    {!! JsValidator::formRequest(\App\Http\Requests\Manager\SubDegreeRequest::class, '#form_information') !!}
@endsection
