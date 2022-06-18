/*-----------------------
Form action
-----------------------*/

$(".form-collapse").on("submit", function (e) {
    e.preventDefault();

    var _form = $(this),
        id = $(this).find("#id").val();
    var btn = _form.find(".btn-submit");

    _form.find(".invalid-feedback").text("").prev().removeClass('is-invalid');
    _form.find(".btn-submit .spinner-border").toggleClass("d-none");
    _form.find(".btn-submit").addClass("disabled");


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
            var row = data.data.row;
            if (id == 0) {
                $("#table_content tbody").append(row);
            } else {
                $("#table_content tbody #row_" + id).replaceWith(row);
            }
            _form.find(".btn-submit .spinner-border").toggleClass("d-none");
            _form.find(".btn-submit").removeClass("disabled");
            _form[0].reset();
            $("#form-content").addClass("d-none");
        })
        .fail(function (data) {
            if (data.responseJSON.errors) {
                $.each(data.responseJSON.errors, function (key, value) {
                    var input = '#form-collapse [name=' + key + ']';
                    $(input).next('.invalid-feedback').text(value);
                    $(input).addClass('is-invalid');
                    $(input).removeClass('is-valid');
                });
            } else {
                showToastify(data.responseJSON.message.toString(), 'error');
            }

            _form.find(".btn-submit .spinner-border").toggleClass("d-none");
            _form.find(".btn-submit").removeClass("disabled");
        });

});

/*-----------------------
add
-----------------------*/

$(document).on('click', '.btn-add', (function (e) {
    e.preventDefault();
    $("#form-content").removeClass("d-none");
    $("#form-content .form-collapse")[0].reset();
    $("#form-content .form-collapse .form-control").val("");
}));

/*-----------------------
Edit
-----------------------*/

$(document).on('click', '.btn-edit', (function (e) {
    e.preventDefault();
    var data = $(this).data();

    $(".form-collapse").attr("action", data.url);
    $("#id").val(data.id);
    $("#disability_id option[value="+data.disability_id+"]").attr('selected','selected');
    $("#range").val(data.disability_rate);
    $("#rangeValue").text(data.disability_rate);
    $("#enterprise_follow_up").val(data.enterprise_follow_up);
    $("#form-content").removeClass("d-none");
}));

/*-----------------------
work_now
-----------------------*/

$(document).on('change', '#work_now', (function () {
    var work_now = $(this);
    if (work_now.val() == 1) {
        $("#end_date").attr("disabled", "disabled");
    } else {
        $("#end_date").removeAttr("disabled", "disabled");
    }
}));

/*-----------------------
remove
-----------------------*/

$(document).on('click', '.btn-remove', (function () {
    var id = $(this).data("id");
    Swal.fire({
        icon: 'warning',
        title: $(this).data("title"),
        text: $(this).data("details"),
        showCancelButton: true,
        confirmButtonText: 'نعم',
        confirmButtonColor: '#E37281',
        cancelButtonText: 'الغاء',
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "DELETE",
                dataType: "json",
                url: $(this).data("url"),
                success: function (data) {
                    $("#row_" + id).remove();
                    showToastify(data.message, "success")
                },
                error: function () {
                    showToastify(res.res, "error")
                }
            });
        } else if (result.isDenied) {
            Swal.fire('Changes are not saved', '', 'info')
            showToastify("تم حذف المعلومات بنجاح", "error")
        } else {
            showToastify("لم يتم اتخاد اي اجراء ", "info")
        }
    });
}));
