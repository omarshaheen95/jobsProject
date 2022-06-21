'use strict';
let dir = $("html").attr("dir");

/*---------------------------------------------------
    owlCarousel
---------------------------------------------------*/

$('#owl-header').owlCarousel({
    loop: true,
    rtl: (dir == "ltr") ? false : true,
    margin: 0,
    dots: true,
    autoplay: true,
    nav: false,
    responsiveClass: true,
    items: 1
});

$('#owl-career-slide').owlCarousel({
    loop: true,
    rtl: (dir == "ltr") ? false : true,
    margin: 0,
    dots: true,
    autoplay: true,
    nav: false,
    responsiveClass: true,
    items: 1
});

$('#owl-career').owlCarousel({
    loop: false,
    rtl: (dir == "ltr") ? false : true,
    margin: 24,
    dots: false,
    nav: false,
    autoplay: true,
    responsiveClass: true,
    responsive: {
        0: {
            items: 2
        },
        760: {
            items: 3
        },
        1080: {
            items: 4
        }
    }
});
/*---------------------------------------------------
    Form validation
---------------------------------------------------*/

var forms = document.querySelectorAll('.needs-validation');
Array.prototype.slice.call(forms).forEach(function (form) {
    form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
        }
        form.classList.add('was-validated')
    }, false)
});

/*---------------------------------------------------
    Submit Form
---------------------------------------------------


$("form").on("submit", function(e){
    e.preventDefault();
    var _form = $(this);
    if (_form[0].checkValidity() === false) {
        e.stopPropagation();
    } else {
        _form.find(".btn-submit .spinner-border").toggleClass("d-none");
        _form.addClass("disabled");

        setTimeout( function(){
            showToastify("Success, you email was added !", "success");
            _form.find(".btn-submit .spinner-border").toggleClass("d-none");
            _form.removeClass("disabled was-validated");
            _form[0].reset();
        }, 3000);
    }
    /*
        backend developer =)

    $.ajax({
        type: "post",
        dataType: "html",
        url: form.attr("action"),
        data: form.serialize(),
        success: function(res){
            var res = JSON.parse(res);
            setTimeout( function(){
                if(res.status == "error"){
                    showToastify(res.text_msg, success);
                } else {
                    showToastify(res.text_msg, error);
                }
                _form.find(".btn-submit .spinner-border").toggleClass("d-none");
                _form.removeClass("disabled was-validated");
                _form[0].reset();
            }, 3000);
        },
        error: function() {
            showToastify("خطأ !!", "حدث خطأ غير متوقع ، يرجى المحاولة مرة اخرى", error);
        }
    });

});
*/

/*---------------------------------------------------
    Show Toastify
---------------------------------------------------*/

function showToastify(text_msg, status) {
    var color = "#203359";
    if (status == "success") {
        color = "#61C3BB";
    } else if (status == "error") {
        color = "#E37281";
    } else if (status == "warning") {
        color = "#E7AF4B";
    } else if (status == "info") {
        color = "#0F9DC2";
    } else {
        color = "#203359";
    }

    Toastify({
        text: text_msg,
        duration: 3000,
        newWindow: true,
        close: true,
        gravity: "bottom", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`
        stopOnFocus: true, // Prevents dismissing of toast on hover
        style: {
            background: color,
        },
        onClick: function () {
        } // Callback after click
    }).showToast();
}


/*------------------------------------
    Change Pic User From Profile
----------------------------------------*/

$('#remove_pic').hide();

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#profile-user-pic').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$("#change_pic").change(function () {
    if ($('#change_pic').val() != "") {
        $('#remove_pic').show();
    } else {
        $('#remove_pic').hide();
    }
    readURL(this);
});


$('#remove_pic').click(function () {
    $('#change_pic').val('');
    $(this).hide();
    $('#profile-user-pic').attr('src', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRHfHdfcQ1cDWzgVLJr32Z3mVYq20D6pir7fKupEKB6fhvQWGZ5xVx76ydUx9nQJiJlKL0&usqp=CAU');
});

var jobPage = 1;
$(".get-more-career").on("click", function () {
    var btn = $(this) ;
    btn.addClass("disabled");
    btn.find(".spinner-border").removeClass("d-none");
    var positions_ids = [];
    $('input[name="position[]"]:checked').each(function(i, e) {
        positions_ids.push($(this).val());
    });
    var degrees_ids = [];
    $('input[name="degree[]"]:checked').each(function(i, e) {
        degrees_ids.push($(this).val());
    });
    var ministries_ids = [];
    $('input[name="ministry[]"]:checked').each(function(i, e) {
        ministries_ids.push($(this).val());
    });
    var qualifications_ids = [];
    $('input[name="qualification[]"]:checked').each(function(i, e) {
        qualifications_ids.push($(this).val());
    });

    $.ajax({
        type: "get",
        dataType: "html",
        url: $(this).data("url"),
        data: {
            "page": jobPage + 1,
            "name": $('input[name="name"]').val(),
            "ministry[]":ministries_ids,
            "qualification[]": qualifications_ids,
            "degree[]": degrees_ids,
            "position[]": positions_ids,
        },
        success: function(res){
            var res = JSON.parse(res);
            if(res.data.html.length > 0)
            {
                $(".grid-career").append(res.data.html);
            }

            btn.removeClass("disabled");
            btn.find(".spinner-border").addClass("d-none");
            if(res.data.paginate.next_page_url != null)
            {
                jobPage ++;
            }else{
                btn.hide();
            }
        },
        error: function(){
            showToastify(res.res, "error");

            btn.removeClass("disabled");
            btn.find(".spinner-border").addClass("d-none");
        }
    });
});

var newsPage = 1;
$(".get-more-topic").on("click", function () {
    var btn = $(this) ;
    btn.addClass("disabled");
    btn.find(".spinner-border").removeClass("d-none");
    $.ajax({
        type: "get",
        dataType: "html",
        url: $(this).data("url"),
        data: {
            "page" : newsPage + 1,
        },
        success: function(res){
            var res = JSON.parse(res);
            if(res.data.html.length > 0)
            {
                $(".topics-section").append(res.data.html);
            }

            btn.removeClass("disabled");
            btn.find(".spinner-border").addClass("d-none");
            if(res.data.paginate.next_page_url != null)
            {
                newsPage ++;
            }else{
                btn.hide();
            }
        },
        error: function(){
            showToastify(res.res, "error");

            btn.removeClass("disabled");
            btn.find(".spinner-border").addClass("d-none");
        }
    });
});

function jobSearch(){
    var btn = $('#searchJobs') ;
    var getMore = $('.get-more-career') ;
    btn.addClass("disabled");
    btn.find(".spinner-border").removeClass("d-none");
    getMore.addClass("disabled");
    getMore.find(".spinner-border").removeClass("d-none");

    var positions_ids = [];
    $('input[name="position[]"]:checked').each(function(i, e) {
        positions_ids.push($(this).val());
    });
    var degrees_ids = [];
    $('input[name="degree[]"]:checked').each(function(i, e) {
        degrees_ids.push($(this).val());
    });
    var ministries_ids = [];
    $('input[name="ministry[]"]:checked').each(function(i, e) {
        ministries_ids.push($(this).val());
    });
    var qualifications_ids = [];
    $('input[name="qualification[]"]:checked').each(function(i, e) {
        qualifications_ids.push($(this).val());
    });

    $.ajax({
        type: "get",
        dataType: "html",
        url: $('#searchJobs').data("url"),
        data: {
            "page": 1,
            "name": $('input[name="name"]').val(),
            "ministry[]":ministries_ids,
            "qualification[]": qualifications_ids,
            "degree[]": degrees_ids,
            "position[]": positions_ids,
        },
        success: function(res){
            $(".grid-career").empty();
            var res = JSON.parse(res);
            if(res.data.html.length > 0)
            {
                $(".grid-career").append(res.data.html);
            }

            btn.removeClass("disabled");
            btn.find(".spinner-border").addClass("d-none");
            getMore.removeClass("disabled");
            getMore.find(".spinner-border").addClass("d-none");
            if(res.data.paginate.next_page_url != null)
            {
                jobPage ++;
                getMore.show();
            }else{
                getMore.hide();
            }
        },
        error: function(){
            showToastify(res.res, "error");

            btn.removeClass("disabled");
            btn.find(".spinner-border").addClass("d-none");
        }
    });
}





