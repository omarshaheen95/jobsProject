@extends('layouts.container')

@section('content')
    <!-- Start Topics -->
    <section class="inner-section login-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-7 col-md-9">
                    <div class="login-box">
                        <div class="content">
                            <div class="section-title text-center">
                                <h1 class="title">مرحبًا بعودتك !</h1>
                            </div>
                            <div class="form">
                                <form action="{{route('login')}}" method="post" class="" id="login-form" novalidate>
                                    @csrf
                                    <div class="form-group">
                                        <label for="email" class="form-label"> البريد الالكتروني</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                               placeholder="البريد الإلكتروني" name="email"
                                               value="{{ old('email') }}" required autocomplete="email" autofocus
                                               pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="form-label">كلمة المرور</label>
                                        <input type="password"
                                               class="form-control @error('password') is-invalid @enderror" required
                                               autocomplete="current-password" name="password" id="password"
                                               placeholder="*********">
                                        <div class="invalid-feedback"></div>
                                    </div>

                                    <div class="form-group">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember"
                                                       id="remmber-me" {{ old('remember') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="remmber-me"> تذكرني </label>
                                            </div>
                                            <a href="{{route('password.request')}}" class="forget-password"> فقدت كلمة
                                                السر ! </a>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-theme btn-submit w-100">
                                            <span class="spinner-border spinner-border-sm me-2 d-none" role="status"
                                                  aria-hidden="true"></span>
                                            تسجيل الدخول
                                        </button>
                                    </div>
                                    @if (Route::has('register'))
                                        <div class="form-group">
                                            <div class="note ">
                                                ليس لديك حساب؟ <a href="{{route('register')}}" class="ms-2"> حساب
                                                    جديد</a>
                                            </div>
                                        </div>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Topics -->
@endsection
@section('script')
    <script src="{{asset('front/js/auth.js')}}"></script>
@endsection

