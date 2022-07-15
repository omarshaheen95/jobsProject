var maxField = 10 //Input fields increment limitation
var addButton = $('#add_option'); //Add button selector
$(addButton).click(function () {
    var wrapper_row = $('#options_form'); //Input field wrapper
    x = $('#options_form').children().length;
    y = $('#options_form').children().length;
    //Check maximum number of input fields
    if (x < maxField) {
        x++; //Increment field counter
        y++; //Increment field counter.
        $(wrapper_row).append(
            "<div class=\"form-group row option_form\">\n" +
            "<div class=\"col-md-4\">\n" +
            "<label>الخيار :</label>\n" +
            "<input required type=\"text\" name=\"option[" + y + "]\" class=\"form-control\" placeholder=\"\"/>\n" +
            "<div class=\"d-md-none mb-2\"></div>\n" +
            "</div>\n" +
            "<div class=\"col-md-3\">\n" +
            "<label>الإجابة</label>\n" +
            "<div class=\"radio-inline mt-3\">\n" +
            "<label class=\"radio\">\n" +
            "<input type=\"radio\" checked name=\"result[" + y + "]\" value=\"0\"/>\n" +
            "<span></span>\n" +
            "بدون إجابة" +
            "</label>\n" +
            "<label class=\"radio\">\n" +
            "<input type=\"radio\" name=\"result[" + y + "]\" value=\"1\"/>\n" +
            "<span></span>\n" +
            "صحيحة" +
            " </label>\n" +
            "<label class=\"radio\">\n" +
            "<input type=\"radio\" name=\"result[" + y + "]\" value=\"2\"/>\n" +
            "<span></span>\n" +
            "خاطئة" +
            " </label>\n" +
            "</div>\n" +
            "</div>\n" +
            "<div class=\"col-md-1\">\n" +
            "<button type=\"button\" name=\"delete_option\" class=\"btn btn-sm font-weight-bolder btn-danger btn-icon btn-danger delete_option mt-4\">\n" +
            "<i class=\"la la-trash-o\"></i>\n" +
            "</button>\n" +
            "</div>\n" +
            "</div>"
        )
        ; //Add field html
    }
});
//Once remove button is clicked
$(document).on('click', '.delete_option', function (e) {
    e.preventDefault();
    $(this).parent().parent('div').remove(); //Remove field html
    // x--;
});
//Once remove button is clicked
$(document).on('click', '.delete_old_option', function (e) {
    e.preventDefault();
    $(this).parent().parent('div').remove(); //Remove field html
    // x--;
});
$(document).on('click', '.delete_old_option', function (e) {
    e.preventDefault();
    let ele = $(this);
    let csrf = $('meta[name="csrf-token"]').attr('content');
    var id = $(this).attr('data-id');
    var url = option_delete_url;
    url = url.replace(':id', id);
    ele.attr('disabled', true)
    $.ajax({
        url: url,
        type: 'POST',
        data: {
            '_token': csrf,
            '_method': 'delete',
        },
        success: function (data) {
            if (data.success) {
                ele.parent('div').parent('div').parent('div').parent('div').remove(); //Remove field html
                x--; //Decrement field counter
                //btn.attr('disabled', false)
                toastr.success(data.message);
            } else {
                toastr.error(data.message);
            }
        },
        error: function (errMsg) {
            toastr.error(errMsg.responseJSON.message);
            btn.attr('disabled', false)
        }
    });
});

