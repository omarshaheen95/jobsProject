$(document).on('submit', '#login-form', function (e) {
    e.preventDefault();
    var btn = $('button[type="submit"]') ;
    btn.addClass("disabled");
    btn.find(".spinner-border").removeClass("d-none");

    $('.invalid-feedback').text('');
    $('input').removeClass('has-error');
    $('input').removeClass('is-invalid');


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url: $(this).attr('action'),
        dataType: 'json',
        data: $(this).serialize()
    })
        .done(function (data) {
            showToastify("تم تسجيل الدخول بنجاح", 'success');
            window.location.replace('/');
        })
        .fail(function (data) {
            if (data.responseJSON.errors) {
                $.each(data.responseJSON.errors, function (key, value) {
                    console.log(key);
                    var input = '#login-form input[name=' + key + ']';
                    $(input).next('.invalid-feedback').text(value);
                    $(input).addClass('has-error');
                    $(input).addClass('is-invalid');
                    $(input).removeClass('is-valid');
                });
            } else {
                showToastify(data.responseJSON.message.toString(), 'error');
            }
            btn.removeClass("disabled");
            btn.find(".spinner-border").addClass("d-none");
        });
});
$(document).on('submit', '#register-form', function (e) {
    e.preventDefault();
    var btn = $('button[type="submit"]') ;
    btn.addClass("disabled");
    btn.find(".spinner-border").removeClass("d-none");

    $('.invalid-feedback').text('');
    $('input').removeClass('has-error');
    $('input').removeClass('is-invalid');
    $('input').removeClass('is-valid');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url: $(this).attr('action'),
        dataType: 'json',
        data: $(this).serialize()
    })
        .done(function (data) {
            showToastify("تم التسجيل بنجاح", 'success');
            window.location.replace('/');
        })
        .fail(function (data) {
            if (data.responseJSON.errors) {
                $.each(data.responseJSON.errors, function (key, value) {
                    console.log(key);
                    var input = '#register-form input[name=' + key + ']';
                    $(input).next('.invalid-feedback').text(value);
                    $(input).addClass('has-error');
                    $(input).addClass('is-invalid');
                });
            } else {
                showToastify(data.responseJSON.message.toString(), 'error');
            }
            btn.removeClass("disabled");
            btn.find(".spinner-border").addClass("d-none");
        });
});
$(document).on('submit', '#reset-form', function (e) {
    e.preventDefault();
    var btn = $('button[type="submit"]') ;
    btn.addClass("disabled");
    btn.find(".spinner-border").removeClass("d-none");

    $('.invalid-feedback').text('');
    $('input').removeClass('has-error');
    $('input').removeClass('is-invalid');


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url: $(this).attr('action'),
        dataType: 'json',
        data: $(this).serialize()
    })
        .done(function (data) {
            console.log(data);
            showToastify("تم تغيير كلمة المرور  بنجاح", 'success');
            window.location.replace('/');
        })
        .fail(function (data) {
            if(data.responseJSON.errors)
            {
                $.each(data.responseJSON.errors, function (key, value) {
                    console.log(key);
                    var input = '#reset-form input[name=' + key + ']';
                    $(input).next('.invalid-feedback').text(value);
                    $(input).addClass('has-error');
                    $(input).addClass('is-invalid');
                    $(input).removeClass('is-valid');
                });
            }else{
                showToastify(data.responseJSON.message.toString(), 'error');
            }
            btn.removeClass("disabled");
            btn.find(".spinner-border").addClass("d-none");
        });
});
$(document).on('submit', '#forget-form', function (e) {
    e.preventDefault();
    var btn = $('button[type="submit"]') ;
    btn.addClass("disabled");
    btn.find(".spinner-border").removeClass("d-none");

    $('.invalid-feedback').text('');
    $('input').removeClass('has-error');
    $('input').removeClass('is-invalid');


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url: $(this).attr('action'),
        dataType: 'json',
        data: $(this).serialize()
    })
        .done(function (data) {
            console.log(data);
            showToastify("تم تسجيل  بنجاح", 'success');
            // window.location.replace('/');
        })
        .fail(function (data) {
            if(data.responseJSON.errors)
            {
                $.each(data.responseJSON.errors, function (key, value) {
                    console.log(key);
                    var input = '#forget-form input[name=' + key + ']';
                    $(input).next('.invalid-feedback').text(value);
                    $(input).addClass('has-error');
                    $(input).addClass('is-invalid');
                    $(input).removeClass('is-valid');
                });
            }else{
                showToastify(data.responseJSON.message.toString(), 'error');
            }
            btn.removeClass("disabled");
            btn.find(".spinner-border").addClass("d-none");
        });
});
$(document).on('submit', '#password-form', function (e) {
    e.preventDefault();
    var btn = $('button[type="submit"]') ;
    btn.addClass("disabled");
    btn.find(".spinner-border").removeClass("d-none");

    $('.invalid-feedback').text('');
    $('input').removeClass('has-error');
    $('input').removeClass('is-invalid');


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "POST",
        url: $(this).attr('action'),
        dataType: 'json',
        data: $(this).serialize()
    })
        .done(function (data) {
            showToastify(data.message, 'success');
            btn.removeClass("disabled");
            btn.find(".spinner-border").addClass("d-none");
            $('#password-form')[0].reset();
        })
        .fail(function (data) {
            if (data.responseJSON.errors) {
                $.each(data.responseJSON.errors, function (key, value) {
                    console.log(key);
                    var input = '#password-form input[name=' + key + ']';
                    $(input).next('.invalid-feedback').text(value);
                    $(input).addClass('has-error');
                    $(input).addClass('is-invalid');
                    $(input).removeClass('is-valid');
                });
            } else {
                showToastify(data.responseJSON.message.toString(), 'error');
            }
            btn.removeClass("disabled");
            btn.find(".spinner-border").addClass("d-none");
        });
});

