{{--
Dev Omar Shaheen
Devomar095@gmail.com
WhatsApp +972592554320
 --}}
@extends('manager.layout.container')
@section('style')

@endsection
@section('content')
    @push('breadcrumb')
        <li class="breadcrumb-item">
            <a href="{{ route('manager.contact_us.index') }}">اتصل بنا</a>
        </li>
        <li class="breadcrumb-item">
            عرض اتصل بنا
        </li>
    @endpush
    <div class="row">
        <div class="col-xl-10 offset-1">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">عرض اتصل بنا</h3>
                    </div>
                </div>
                <div class="kt-portlet__body">
                    <div class="kt-section kt-section--first">
                        <div class="kt-section__body">
                            <div class="kt-portlet__body">
                                <div class="kt-widget kt-widget--user-profile-3">
                                    <div class="kt-widget__top">
                                        <div class="kt-widget__media kt-hidden-">
                                            <i class="fa fa-user fa-4x"></i>
                                        </div>
                                        <div class="kt-widget__pic kt-widget__pic--danger kt-font-danger kt-font-boldest kt-font-light kt-hidden">
                                            JM
                                        </div>
                                        <div class="kt-widget__content">
                                            <div class="kt-widget__head">
                                                <a href="#" class="kt-widget__username">
                                                    {{ $contact->name }}
                                                </a>
                                            </div>

                                            <div class="kt-widget__subhead">
                                                <p href="#"><i class="flaticon2-new-email"></i> {{  $contact->governorate->name }}</p>
                                                <a href="#"><i class="flaticon2-phone"></i> {{  $contact->mobile }} </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="kt-widget__bottom">
                                        <div class="kt-widget__item">
                                            <div class="kt-widget__icon">
                                                <i class="flaticon-chat-1"></i>
                                            </div>
                                            <div class="kt-widget__details">
                                                <span class="kt-widget__title">محتوى الرسالة</span>
                                                <p  class="kt-widget__value kt-font-brand">{{  $contact->message }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
