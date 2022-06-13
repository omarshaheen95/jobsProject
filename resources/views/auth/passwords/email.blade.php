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
                                <h1 class="title">استرجاع الحساب</h1>
                                <p class="info"> اكتب بريدك الإلكتروني لإعادة تعيين كلمة المرور </p>
                            </div>
                            <div class="form">

                                <form action="{{ route('password.email') }}" method="post" class="" id="forget-form" novalidate>
                                    @csrf
                                    <div class="form-group">
                                        <label for="email" class="form-label"> البريد الالكتروني</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="ex: example@domain.com" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-theme btn-submit w-100">
                                            <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
                                            إرسال
                                        </button>
                                    </div>
                                    @if (session('status'))
                                    <div class="form-group">
                                        <div class="alert alert-info border-0">
                                            <p class="mb-0">
                                                <small>
                                                    {{ session('status') }}
                                                </small>
                                            </p>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="form-group">
                                        <div class="note ">
                                            ليس لديك حساب؟ <a href="{{route('register')}}" class="ms-2"> حساب جديد</a>
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
    <!-- End Topics -->
@endsection
@section('script')
    <script src="{{asset('front/js/auth.js')}}"></script>
@endsection

