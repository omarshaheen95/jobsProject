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
                                <h1 class="title">{{$title}}</h1>
                            </div>
                            <div class="form">
                                <form action="{{route('password')}}" method="post" class="" id="password-form" novalidate>
                                    @csrf
                                    <div class="form-group">
                                        <label for="password" class="form-label">كلمة المرور الحالية</label>
                                        <input type="password" class="form-control" name="current_password" id="old_password"
                                               placeholder="*********" required autocomplete="old-password">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="form-label">كلمة المرور الجديدة</label>
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
                                           حفظ
                                        </button>
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

