@extends('layouts.container')
@section('content')
    <section class="inner-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2 class="title">تواصل معنا</h2>
                        <p class="info">بينما يستثمر الناس في ترقية أنماط الحياة , نستثمر نحن في المقدرة على تحقيقها</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="contact-container">
                        <div class="row justify-content-center">
                            <div class="col-lg-6">
                                <div class="form">
                                    <form action="{{route('contact_us.message')}}" id="contact_us" method="post" class="" novalidate>
                                        {{csrf_field()}}
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="name" id="name" placeholder="الاسم" required>
                                                    <div class="invalid-feedback">الاسم مطلوب</div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <select class="form-control form-select" name="governorate_id" id="governorate_id" required>
                                                        <option value="" disabled selected> اختر المحافظة </option>
                                                        @foreach($governorates as $governorate)
                                                            <option value="{{$governorate->id}}">{{$governorate->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">المحافظة مطلوبة</div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <input type="email" class="form-control" name="email" id="email" placeholder="ex: example@domain.com" required>
                                                    <div class="invalid-feedback">البريد الإلكتروني مطلوب</div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <input type="tel" class="form-control" name="mobile" id="mobile" placeholder="الهاتف" required>
                                                    <div class="invalid-feedback">الهاتف مطلوب</div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <textarea rows="10" class="form-control" name="message" id="message" placeholder="رسالتك هنا" required></textarea>
                                                    <div class="invalid-feedback">الرسالة مطلوبة</div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-theme btn-submit w-100">
                                                        <span class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
                                                        ارسال
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="map-box">
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126928.7479229087!2d44.409111946190094!3d33.28127352461574!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x15577f67a0a74193%3A0x9deda9d2a3b16f2c!2z2KjYutiv2KfYr9iMINin2YTYudix2KfZgg!5e0!3m2!1sar!2s!4v1653854367258!5m2!1sar!2s" width="100%" height="450" style="border:0;" allowfullscreen="" control="off" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="share-section">
                        <h4 class="title">تابعنا </h4>
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
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script>
        $("form").on("submit", function(e) {
            e.preventDefault();
            var _form = $(this);
            _form.find(".btn-submit .spinner-border").toggleClass("d-none");
            _form.find(".btn-submit .spinner-border").addClass("disabled");

            $.ajax({
                type: "post",
                url: _form.attr("action"),
                data: _form.serialize(),
                success: function(res){
                    showToastify(res.message, 'success');
                    _form.find(".btn-submit .spinner-border").toggleClass("d-none");
                    _form.removeClass("disabled was-validated");
                    _form[0].reset();
                },
                error: function(data) {
                    _form.find(".btn-submit .spinner-border").toggleClass("d-none");
                    _form.find(".btn-submit .spinner-border").removeClass("disabled was-validated");
                    // showToastify( "حدث خطأ غير متوقع ، يرجى المحاولة مرة اخرى", 'error');
                    if (data.responseJSON.errors) {
                        $.each(data.responseJSON.errors, function (key, value) {
                            var input = '#contact_us [name=' + key + ']';
                            $(input).next('.invalid-feedback').text(value);
                            $(input).addClass('has-error');
                            $(input).addClass('is-invalid');
                            $(input).removeClass('is-valid');
                        });
                    } else {
                        showToastify(data.responseJSON.message.toString(), 'error');
                    }
                }
            });
        });
    </script>
@endsection
