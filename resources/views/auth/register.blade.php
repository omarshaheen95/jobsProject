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
                                <h1 class="title">تسجيل جديد</h1>
                            </div>
                            <div class="form">
                                <form action="{{ route('register') }}" method="post" class="" id="register-form"
                                      novalidate>
                                    @csrf
                                    <div class="form-group">
                                        <label for="name" class="form-label"> الاسم </label>
                                        <input type="text" class="form-control" name="name" id="name"
                                               placeholder="الاسم" value="{{ old('name') }}" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="form-label"> البريد الالكتروني</label>
                                        <input type="email" class="form-control" name="email" id="email"
                                               value="{{ old('email') }}" placeholder="ex: example@domain.com"
                                               pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="form-label">كلمة المرور</label>
                                        <input type="password" class="form-control" name="password" id="password"
                                               placeholder="*********" required autocomplete="new-password">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
                                        <input type="password" class="form-control" name="password_confirmation"
                                               id="password_confirmation" placeholder="*********" required
                                               autocomplete="new-password">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-theme btn-submit w-100">
                                            <span class="spinner-border spinner-border-sm me-2 d-none" role="status"
                                                  aria-hidden="true"></span>
                                            تسجيل
                                        </button>
                                    </div>
                                    <div class="form-group">
                                        <div class="note ">
                                            لديك حساب <a href="{{route('login')}}" class="ms-2">تسجيل دخول</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script src="{{asset('front/js/auth.js')}}"></script>
@endsection

