<!doctype html>
<html lang="en" dir="rtl">
<head>
    <title>{{isset($title) ? $title:config('settings.NAME')}}</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="{{asset('front/css/custom.css')}}">
    <link rel="stylesheet" href="{{asset('front/css/resposive.css')}}">
    @yield('style')
</head>
<body>
<!-- Start Navbar -->
<nav class="navbar navbar-expand-lg navbar-light {{ Route::is('welcome') ? 'navbar-main-page':'' }}">
    <div class="container">
        <div class="navbar-container">
            <a class="logo" href="/">
                <img src="{{asset('front/img/logo.svg')}}" alt="">
            </a>

            <div class="collapse navbar-collapse justify-content-center" id="main-menu">
                <ul class="navbar-nav">
                    <li class="nav-item d-lg-none">
                        <div class="navbar-logo">
                            <a href="/" class="logo">
                                <img src="{{asset('front/img/logo.svg')}}" alt=" logo ">
                            </a>
                            <a href="#main-menu" class="navbar-close" data-bs-toggle="collapse"> &times; </a>
                        </div>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="/">الرئيسية <span class="visually-hidden">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('news.all')}}">الاخبار</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('job_offers.all')}}">أحدث الوظائف</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('page.show', 'about_us')}}">عن النظام</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('contact_us.show')}}">تواصل معنا</a>
                    </li>
                </ul>
            </div>

            <div class="navbar-action">
                <!--
                    after login
                    when user loging to website just remove d-none class
                -->
                @auth
                <div class="dropdown">
                    <a class="dropdown-toggle btn-user" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="icon">
                                    <span class="text-uppercase">{{substr(Auth::user()->name, 0, 2)}}</span>
                                    <!-- <img src="front/img/user.png" alt=""> -->
                                </span>
                        <span class="user-name ms-2 text-uppercase">{{Auth::user()->name}}</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="triggerId">
                        <a class="dropdown-item" href="{{route('profile.step','general')}}">الملف الشخصي</a>
                        <a class="dropdown-item" href="#">تغيير كلمة السر</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">تسجيل الخروج</a>
                    </div>
                </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>

                <div class="btn-collapse ms-3 text-white d-lg-none" data-bs-toggle="collapse" data-bs-target="#main-menu">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
                    </svg>
                </div>

                @else
                <a href="{{route('login')}}" class="btn btn-theme btn-login"> تسجيل الدخول </a>
                @endauth


            </div>
        </div>
    </div>
</nav>
<!-- End Navbar -->
<!-- Start Main -->
<main class="wrapper">
    @yield('content')
</main>
<!-- End Main -->
<!-- Start Footer -->
<footer class="footer">
    <div class="container">
        <div class="row footer-container">
            <div class="col-lg-4 col-12">
                <div class="about">
                    <a href="#!" class="logo">
                        <img src="{{asset('front/img/logo.svg')}}" class="img-fluid" alt="">
                    </a>
                    <ul class="nav nav-social-media">
                        <li class="nav-item">
                            <a href="#!" target="_blank" rel="noopener noreferrer" class="nav-link">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#!" target="_blank" rel="noopener noreferrer" class="nav-link">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#!" target="_blank" rel="noopener noreferrer" class="nav-link">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#!" target="_blank" rel="noopener noreferrer" class="nav-link">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="links">
                    <h3 class="footer-title"> روابط سريعة</h3>
                    <ul class="nav">
                        <li class="nav-item">
                            <a href="/" class="nav-link">الرئيسية</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('job_offers.all')}}" class="nav-link">أحدث الوظائف</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('news.all')}}" class="nav-link">الاخبار</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('page.show', 'about_us')}}" class="nav-link">عن النظام</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('contact_us.show')}}" class="nav-link">تواصل معنـا</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="links">
                    <h3 class="footer-title"> روابط خارجية</h3>
                    <ul class="nav">
                        <li class="nav-item">
                            <a href="index.html" class="nav-link">وزارة التربية والتعليم</a>
                        </li>
                        <li class="nav-item">
                            <a href="index.html" class="nav-link">وزارة التربية والتعليم</a>
                        </li>
                        <li class="nav-item">
                            <a href="index.html" class="nav-link">وزارة التربية والتعليم</a>
                        </li>
                        <li class="nav-item">
                            <a href="index.html" class="nav-link">وزارة التربية والتعليم</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="copyright">
            <img src="{{asset('front/img/copyright-logo.png')}}" class="me-3" alt="">
            <span>
                        جميع الحقوق محفوظة لدي
                        <a href="/"> مجلس الخدمة العامة الأتحادي</a>
                        2022
                    </span>
        </div>
    </div>
</footer>
<!-- End Footer -->

<!-- Bootstrap JavaScript Libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script src="{{asset('front/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('front/js/custom.js')}}"></script>
@yield('script')
<script>
    @if(Session::has('message'))
    showToastify("{{Session::get('message')}}", "{{Session::get('m-class')}}");
    @endif
</script>
</body>
</html>
