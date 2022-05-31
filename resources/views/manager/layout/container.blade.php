{{--Dev Omar Shaheen
    Devomar095@gmail.com
    WhatsApp +972592554320
    --}}
    <!DOCTYPE html>
<html lang="ar" dir="rtl">

<!-- begin::Head -->
<head>

    <meta charset="utf-8"/>
    <title>{{ isset($title) ? $title. " | ":''  }}لوحة التحكم </title>
    <meta name="description" content="{{ t('Dashboard') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--begin::Fonts -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]
            },
            active: function () {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!--end::Fonts -->


    <!--begin::Global Theme Styles(used by all pages) -->
    <link href="{{ asset('assets/css/demo1/style.bundle.rtl.css') }}" rel="stylesheet" type="text/css"/>
    <!--end::Global Theme Styles -->

    <!--begin:: Global Mandatory Vendors -->
    <link href="{{ asset('assets/vendors/general/perfect-scrollbar/css/perfect-scrollbar.rtl.css') }}"
          rel="stylesheet" type="text/css"/>

    <!--end:: Global Mandatory Vendors -->
@yield('b_style')

<!--begin:: Global Optional Vendors -->
    <link href="{{ asset('assets/vendors/general/tether/dist/css/tether.rtl.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/vendors/general/animate.css/animate.rtl.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/vendors/general/toastr/build/toastr.rtl.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/vendors/general/sweetalert2/dist/sweetalert2.rtl.css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/vendors/custom/vendors/line-awesome/css/line-awesome.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset("assets/vendors/custom/vendors/flaticon/flaticon.css") }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset("assets/vendors/custom/vendors/flaticon2/flaticon.css") }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/vendors/general/@fortawesome/fontawesome-free/css/all.min.rtl.css') }}"
          rel="stylesheet" type="text/css"/>

    <!--end:: Global Optional Vendors -->
    <!--begin::Layout Skins(used by all pages) -->
    <link href="{{asset('assets/css/demo1/skins/header/base/light.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/css/demo1/skins/header/menu/light.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/css/demo1/skins/brand/light.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/css/demo1/skins/aside/light.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('css/bootstrap-select.css')}}" rel="stylesheet"/>
    @if(app()->getLocale() == 'ar')
        <style>
            .bootstrap-select .dropdown-toggle .filter-option {
                text-align: right;
            }

            .bootstrap-select .dropdown-toggle .filter-option-inner {
                padding-right: unset;
                padding-left: inherit;
            }

            .bootstrap-select > .dropdown-toggle.btn-light, .bootstrap-select > .dropdown-toggle.btn-secondary {
                text-align: left;
            }
        </style>
    @endif
    @yield('style')
<!--end::Layout Skins -->
</head>

<!-- end::Head -->

<!-- begin::Body -->
<body
    class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--fixed kt-subheader--enabled kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">

<!-- begin:: Page -->

<!-- begin:: Header Mobile -->
<div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
    <div class="kt-header-mobile__logo">
        <a href="{{ url("/manager/home") }}">
                <img alt="Logo" src="" style="width: 6%"/>
        </a>
    </div>
    <div class="kt-header-mobile__toolbar">
        <button class="kt-header-mobile__toggler kt-header-mobile__toggler--left" id="kt_aside_mobile_toggler">
            <span></span></button>
        <button class="kt-header-mobile__toggler" id="kt_header_mobile_toggler"><span></span></button>
        <button class="kt-header-mobile__topbar-toggler" id="kt_header_mobile_topbar_toggler"><i
                class="flaticon-more"></i></button>
    </div>
</div>

<!-- end:: Header Mobile -->
<div class="kt-grid kt-grid--hor kt-grid--root">
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">

        <!-- begin:: Aside -->
        <button class="kt-aside-close " id="kt_aside_close_btn"><i class="la la-close"></i></button>
        <div class="kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop"
             id="kt_aside">

            <!-- begin:: Aside -->
            <div class="kt-aside__brand kt-grid__item " id="kt_aside_brand">
                <div class="kt-aside__brand-logo w-100">
                    <a href="{{ url("/manager/home") }}" class="w-100 text-center">
                            <img src="" width="20%"/>
                    </a>
                </div>
                <div class="kt-aside__brand-tools">
                    <button class="kt-aside__brand-aside-toggler" id="kt_aside_toggler">
								<span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                           width="24px" height="24px" viewBox="0 0 24 24" version="1.1"
                                           class="kt-svg-icon">
										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<polygon id="Shape" points="0 0 24 0 24 24 0 24"/>
											<path
                                                d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z"
                                                id="Path-94" fill="#000000" fill-rule="nonzero"
                                                transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999) "/>
											<path
                                                d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z"
                                                id="Path-94" fill="#000000" fill-rule="nonzero" opacity="0.3"
                                                transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999) "/>
										</g>
									</svg></span>
                        <span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                   width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<polygon id="Shape" points="0 0 24 0 24 24 0 24"/>
											<path
                                                d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z"
                                                id="Path-94" fill="#000000" fill-rule="nonzero"/>
											<path
                                                d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z"
                                                id="Path-94" fill="#000000" fill-rule="nonzero" opacity="0.3"
                                                transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "/>
										</g>
									</svg></span>
                    </button>

                    <!--
    <button class="kt-aside__brand-aside-toggler kt-aside__brand-aside-toggler--left" id="kt_aside_toggler"><span></span></button>
    -->
                </div>
            </div>

            <!-- end:: Aside -->

            <!-- begin:: Aside Menu -->
            <div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
                <div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1"
                     data-ktmenu-dropdown-timeout="500">
                    <ul class="kt-menu__nav ">
                        <li class="kt-menu__item  @if(Route::is('manager.home') ) kt-menu__item--active @endif"
                            aria-haspopup="true">
                            <a href="{{ route('manager.home') }}" class="kt-menu__link ">
                                <i class="kt-menu__link-icon flaticon2-protection"></i>
                                <span class="kt-menu__link-text">الرئيسية</span>
                            </a>
                        </li>
                        <li class="kt-menu__item  @if(Route::is('*') ) kt-menu__item--active @endif"
                            aria-haspopup="true">
                            <a href="" class="kt-menu__link ">
                                <i class="kt-menu__link-icon flaticon2-sheet"></i>
                                <span class="kt-menu__link-text">المحافظات</span>
                            </a>
                        </li>
                        <li class="kt-menu__item  @if(Route::is('*') ) kt-menu__item--active @endif"
                            aria-haspopup="true">
                            <a href="" class="kt-menu__link ">
                                <i class="kt-menu__link-icon flaticon2-sheet"></i>
                                <span class="kt-menu__link-text">الدرجات العلمية</span>
                            </a>
                        </li>
                        <li class="kt-menu__item  @if(Route::is('*') ) kt-menu__item--active @endif"
                            aria-haspopup="true">
                            <a href="" class="kt-menu__link ">
                                <i class="kt-menu__link-icon flaticon2-sheet"></i>
                                <span class="kt-menu__link-text">الاعاقات</span>
                            </a>
                        </li>
                        <li class="kt-menu__item  @if(Route::is('*') ) kt-menu__item--active @endif"
                            aria-haspopup="true">
                            <a href="" class="kt-menu__link ">
                                <i class="kt-menu__link-icon flaticon2-sheet"></i>
                                <span class="kt-menu__link-text">الوزارات</span>
                            </a>
                        </li>
                        <li class="kt-menu__item  @if(Route::is('*') ) kt-menu__item--active @endif"
                            aria-haspopup="true">
                            <a href="" class="kt-menu__link ">
                                <i class="kt-menu__link-icon flaticon2-sheet"></i>
                                <span class="kt-menu__link-text">المناصب الوظيفية</span>
                            </a>
                        </li>
                        <li class="kt-menu__item  @if(Route::is('*') ) kt-menu__item--active @endif"
                            aria-haspopup="true">
                            <a href="" class="kt-menu__link ">
                                <i class="kt-menu__link-icon flaticon2-sheet"></i>
                                <span class="kt-menu__link-text">الجامعات</span>
                            </a>
                        </li>
                        <li class="kt-menu__item  @if(Route::is('*') ) kt-menu__item--active @endif"
                            aria-haspopup="true">
                            <a href="" class="kt-menu__link ">
                                <i class="kt-menu__link-icon flaticon2-sheet"></i>
                                <span class="kt-menu__link-text">التخصصات</span>
                            </a>
                        </li>
                        <li class="kt-menu__item  @if(Route::is('*') ) kt-menu__item--active @endif"
                            aria-haspopup="true">
                            <a href="" class="kt-menu__link ">
                                <i class="kt-menu__link-icon flaticon2-sheet"></i>
                                <span class="kt-menu__link-text">التخصصات الدقيقة</span>
                            </a>
                        </li>
                        <li class="kt-menu__item  @if(Route::is('*') ) kt-menu__item--active @endif"
                            aria-haspopup="true">
                            <a href="" class="kt-menu__link ">
                                <i class="kt-menu__link-icon flaticon2-sheet"></i>
                                <span class="kt-menu__link-text">اللغات</span>
                            </a>
                        </li>
                        <li class="kt-menu__item  @if(Route::is('*') ) kt-menu__item--active @endif"
                            aria-haspopup="true">
                            <a href="" class="kt-menu__link ">
                                <i class="kt-menu__link-icon flaticon2-sheet"></i>
                                <span class="kt-menu__link-text">الدول</span>
                            </a>
                        </li>
                        <li class="kt-menu__item  @if(Route::is('*') ) kt-menu__item--active @endif"
                            aria-haspopup="true">
                            <a href="" class="kt-menu__link ">
                                <i class="kt-menu__link-icon flaticon2-sheet"></i>
                                <span class="kt-menu__link-text">الاخبار</span>
                            </a>
                        </li>
                        <li class="kt-menu__item  @if(Route::is('*') ) kt-menu__item--active @endif"
                            aria-haspopup="true">
                            <a href="" class="kt-menu__link ">
                                <i class="kt-menu__link-icon flaticon2-sheet"></i>
                                <span class="kt-menu__link-text">المتقدمين</span>
                            </a>
                        </li>
                        <li class="kt-menu__item  @if(Route::is('*') ) kt-menu__item--active @endif"
                            aria-haspopup="true">
                            <a href="" class="kt-menu__link ">
                                <i class="kt-menu__link-icon flaticon2-sheet"></i>
                                <span class="kt-menu__link-text">الصفحات</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>

            <!-- end:: Aside Menu -->
        </div>

        <!-- end:: Aside -->
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">

            <!-- begin:: Header -->
            <div id="kt_header" class="kt-header kt-grid__item  kt-header--fixed ">

                <!-- begin:: Header Menu -->
                <button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i
                        class="la la-close"></i></button>
                <div class="kt-header-menu-wrapper" id="kt_header_menu_wrapper">
                    <div id="kt_header_menu"
                         class="kt-header-menu kt-header-menu-mobile  kt-header-menu--layout-default ">
                        <ul class="kt-menu__nav ">
                            {{--                            <li class="kt-menu__item"--}}
                            {{--                                aria-haspopup="true">--}}
                            {{--                                <a href="/" class="kt-menu__link ">--}}
                            {{--                                    <i class="kt-menu__link-icon flaticon2-protection"></i>--}}
                            {{--                                    <span class="kt-menu__link-text">{{ t('Preview') }}</span>--}}
                            {{--                                </a>--}}
                            {{--                            </li>--}}

                                <li class="kt-menu__item"
                                    aria-haspopup="true">
                                    <a href=""
                                       class="kt-menu__link @if(Request::is('manager/contact_us*')) kt-menu__item--active @endif">
                                        <span class="kt-menu__link-text">اتصل بنا</span>
                                    </a>
                                </li>
                        </ul>

                    </div>
                </div>

                <!-- end:: Header Menu -->

                <!-- begin:: Header Topbar -->
                <div class="kt-header__topbar">
                    <!--begin: Language bar -->

                    <!--end: Language bar -->


                    <!--begin: User Bar -->
                    <div class="kt-header__topbar-item kt-header__topbar-item--user">
                        <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
                            <span class="kt-hidden kt-header__topbar-welcome"></span>
                            <span class="kt-hidden kt-header__topbar-username">{{ Auth::user()->name }}</span>
                            <span class="kt-header__topbar-icon kt-hidden-"><i
                                    class="flaticon2-user-outline-symbol"></i></span>
                        </div>
                        <div
                            class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl">

                            <!--begin: Head -->
                            <div class="kt-user-card kt-user-card--skin-dark kt-notification-item-padding-x"
                                 style="background: linear-gradient(to right,#39B448,#31ab3f);;">
                                {{--                                <div class="kt-user-card__avatar">--}}

                                {{--                                    <span class="kt-badge kt-badge--lg kt-badge--rounded kt-badge--bold kt-font-success">{{ substr(Auth::user()->name,0,1) }}</span>--}}
                                {{--                                </div>--}}
                                <div class="kt-user-card__name">
                                    {{ Auth::user()->name }}
                                </div>

                            </div>
                            <!--end: Head -->
                            <!--begin: Navigation -->
                            <div class="kt-notification">
                                <a href="" class="kt-notification__item">
                                    <div class="kt-notification__item-icon">
                                        <i class="flaticon2-calendar-3 kt-font-success"></i>
                                    </div>
                                    <div class="kt-notification__item-details">
                                        <div class="kt-notification__item-title kt-font-bold">
                                            الملف الشخصي
                                        </div>
                                        <div class="kt-notification__item-time">
                                            إعدادات الملف الشخصي
                                        </div>
                                    </div>
                                </a>
                                <a href="" class="kt-notification__item">
                                    <div class="kt-notification__item-icon">
                                        <i class="flaticon2-calendar-3 kt-font-success"></i>
                                    </div>
                                    <div class="kt-notification__item-details">
                                        <div class="kt-notification__item-title kt-font-bold">
                                            كلمة المرور
                                        </div>
                                        <div class="kt-notification__item-time">
                                            تغيير كلمة المرور
                                        </div>
                                    </div>
                                </a>
                                <div class="kt-notification__custom kt-space-between">
                                    <form id="logout-form" action="{{ url("/manager/logout") }}" method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                    <a href="{{ url("/manager/logout") }}" onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();"
                                       class="btn btn-label btn-label-brand btn-sm btn-bold">تسجيل الخروج</a>
                                </div>
                            </div>

                            <!--end: Navigation -->
                        </div>
                    </div>

                    <!--end: User Bar -->
                </div>

                <!-- end:: Header Topbar -->
            </div>

            <!-- end:: Header -->
            @stack('search')
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">

                <!-- begin:: Content -->
                <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
                    @if(!Request::is('manager/home'))
                        <div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ url('/manager/home') }}">الرئيسية</a>
                                </li>
                                @stack('breadcrumb')
                            </ul>
                        </div>
                    @endif
                    @if (count($errors) > 0)
                        <div class="alert alert-warning">
                            <ul style="width: 100%;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @yield("content")

                </div>

                <!-- end:: Content -->
            </div>

            <!-- begin:: Footer -->
            <div class="kt-footer kt-grid__item kt-grid kt-grid--desktop kt-grid--ver-desktop" id="kt_footer">
                <div class="kt-footer__copyright">
                    {{ date('Y') }}&nbsp;&copy;&nbsp;<a href="" target="_blank" class="kt-link"> </a>
                </div>

            </div>

            <!-- end:: Footer -->
        </div>
    </div>
</div>

<!-- end:: Page -->


<!-- begin::Scrolltop -->
<div id="kt_scrolltop" class="kt-scrolltop">
    <i class="fa fa-arrow-up"></i>
</div>

<!-- end::Scrolltop -->


<!-- begin::Global Config(global config for global JS sciprts) -->

<!-- end::Global Config -->
<script>
    var KTAppOptions = {
        "colors": {
            "state": {
                "brand": "#22b9ff",
                "light": "#ffffff",
                "dark": "#282a3c",
                "primary": "#000000",
                "success": "#34bfa3",
                "info": "#36a3f7",
                "warning": "#ffb822",
                "danger": "#fd3995"
            },
            "base": {
                "label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
                "shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#000000"]
            }
        }
    };
</script>
<!--begin:: Global Mandatory Vendors -->
<script src="{{ asset("assets/vendors/general/jquery/dist/jquery.js") }}" type="text/javascript"></script>
<script src="{{ asset("assets/vendors/general/popper.js/dist/umd/popper.js") }}" type="text/javascript"></script>
<script src="{{ asset("assets/vendors/general/bootstrap/dist/js/bootstrap.min.js") }}" type="text/javascript"></script>
<script src="{{ asset("assets/vendors/general/js-cookie/src/js.cookie.js") }}" type="text/javascript"></script>
<script src="{{ asset("assets/vendors/general/moment/min/moment.min.js") }}" type="text/javascript"></script>
<script src="{{ asset("assets/vendors/general/sticky-js/dist/sticky.min.js") }}" type="text/javascript"></script>
<script src="{{ asset("assets/vendors/general/perfect-scrollbar/dist/perfect-scrollbar.js") }}"
        type="text/javascript"></script>


<!--end:: Global Mandatory Vendors -->
@yield('b_script')
<!--begin:: Global Optional Vendors -->
<script src="{{ asset("assets/vendors/general/toastr/build/toastr.min.js") }}" type="text/javascript"></script>

<!--end:: Global Optional Vendors -->
<script src="{{asset('js/bootstrap-select.min.js')}}"></script>

<!--begin::Global Theme Bundle(used by all pages) -->
<script src="{{ asset("assets/js/demo1/scripts.bundle.js") }}" type="text/javascript"></script>

<!--end::Global Theme Bundle -->

<!--begin::Page Vendors(used by this page) -->

<!--end::Page Vendors -->

<!--begin::Page Scripts(used by this page) -->

<!--end::Page Scripts -->
@yield('script')
<script type="text/javascript">
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "100",
        "hideDuration": "2000",
        "timeOut": "10000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    @if(Session::has('message'))
    toastr.{{Session::get('m-class') ? Session::get('m-class'):'success'}}("{{Session::get('message')}}");
    @endif

    $('select').selectpicker({
        liveSearch: true,
        noneSelectedText: 'غير محدد',
    });
</script>

</body>

<!-- end::Body -->
</html>
