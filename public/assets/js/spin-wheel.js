var padding = {top: 20, right: 40, bottom: 0, left: 0},
    w = 500 - padding.left - padding.right,
    h = 500 - padding.top - padding.bottom,
    r = Math.min(w, h) / 2,
    applicants_need = 0,
    selected_ministry = 0,
    rotation = 0,
    oldrotation = 0,
    picked = 100000,
    oldpick = [],
    durationTime = 3000,
    color = d3.scale.category20(),
    container = '',
    svg = '',
    vis = '',
    pie = '',
    arc = '',
    arcs = '';
var data = [];
var selected_applicants = [];

function drowSpin(ministries) {
    rotation = 0;
    oldrotation = 0;
    picked = 100000;
    oldpick = [];
    data = [];
    applicants_need = 0;
    selected_ministry = 0;
    $.each(ministries, function (i, ministry) {
        data.push({
            "label": ministry.lottery_ministry.name,
            "value": ministry.lottery_ministry.id,
            "total_required": ministry.total_expected,
        });
    });
    $('#chart').empty();
    svg = d3.select('#chart')
        .append("svg")
        .data([data])
        .attr("width", w + padding.left + padding.right)
        .attr("height", h + padding.top + padding.bottom);

    container = svg.append("g")
        .attr("class", "chartholder")
        .attr("transform", "translate(" + (w / 2 + padding.left) + "," + (h / 2 + padding.top) + ")");

    vis = container
        .append("g");

    pie = d3.layout.pie().sort(null).value(function (d) {
        return 1;
    });
    // declare an arc generator function
    arc = d3.svg.arc().outerRadius(r);
    // select paths, use arc generator to draw
    arcs = vis.selectAll("g.slice")
        .data(pie)
        .enter()
        .append("g")
        .attr("class", "slice");

    arcs.append("path")
        .attr("fill", function (d, i) {
            return color(i);
        })
        .attr("d", function (d) {
            return arc(d);
        });

    // add the text
    arcs.append("text").attr("transform", function (d) {
        d.innerRadius = 0;
        d.outerRadius = r;
        d.angle = (d.startAngle + d.endAngle) / 2;
        return "rotate(" + (d.angle * 180 / Math.PI - 90) + ")translate(" + (d.outerRadius - 10) + ")";
    })
        .attr("text-anchor", "start")
        .text(function (d, i) {
            return data[i].label;
        });

    //make arrow
    svg.append("g")
        .attr("transform", "translate(" + (w + padding.left + padding.right) + "," + ((h / 2) + padding.top) + ")")
        .append("path")
        .attr("d", "M-" + (r * .15) + ",0L0," + (r * .10) + "L0,-" + (r * .10) + "Z")
        .style({"fill": "#89c69a"});

    //draw spin circle
    container.append("circle")
        .attr("cx", 0)
        .attr("cy", 0)
        .attr("r", 60)
        .style({"fill": "white", "cursor": "pointer"});
    //spin text
    container.append("text")
        .attr("x", 0)
        .attr("y", 5)
        .attr("text-anchor", "middle")
        .text("تدوير")
        .style({"font-weight": "bold", "font-size": "24px"});

    container.on("click", spin);
}

function spin(d) {
    // $("#emp").addClass("d-none");
    container.on("click", null);
    //all slices have been seen, all done
    console.log("OldPick: " + oldpick.length, "Data length: " + data.length);

    if (oldpick.length == data.length) {
        console.log("done");
        container.on("click", null);
        return;
    }
    var ps = 360 / data.length,
        pieslice = Math.round(1440 / data.length),
        rng = Math.floor((Math.random() * 1440) + 360);

    rotation = (Math.round(rng / ps) * ps);

    picked = Math.round(data.length - (rotation % 360) / ps);
    picked = picked >= data.length ? (picked % data.length) : picked;

    if (oldpick.indexOf(picked) !== -1) {
        d3.select(this).call(spin);
        return;
    }
    // else {
    //     oldpick.push(picked);
    // }

    rotation += 90 - Math.round(ps / 2);
    vis.transition()
        .duration(durationTime)
        .attrTween("transform", rotTween)
        .each("end", function () {

            // //mark emp as seen
            // d3.select(".slice:nth-child(" + (picked + 1) + ") path")
            //     .attr("fill", "rgb(0,0,0,.60)");

            //populate emp
            d3.select("#emp h1")
                .text(data[picked].label);
            oldrotation = rotation;

            /* Get the result value from object "data" */
            console.log(data[picked].value)

            /* Get the Success Employee  */
            applicants_need = data[picked].total_required;
            selected_ministry = data[picked].value;

            getEmp(data[picked].total_required);


            /* Comment the below line for restrict spin to sngle time */
            container.on("click", spin);
            $('#lottery_actions').removeClass('d-none');
        });
}

function rotTween(to) {
    var i = d3.interpolate(oldrotation % 360, rotation);
    return function (t) {
        return "rotate(" + i(t) + ")";
    };
}

function getRandomNumbers() {
    var array = new Uint16Array(1000);
    var scale = d3.scale.linear().range([360, 1440]).domain([0, 100000]);
    if (window.hasOwnProperty("crypto") && typeof window.crypto.getRandomValues === "function") {
        window.crypto.getRandomValues(array);
        console.log("works");
    } else {
        //no support for crypto, get crappy random numbers
        for (var i = 0; i < 1000; i++) {
            array[i] = Math.floor(Math.random() * 100000) + 1;
        }
    }
    return array;
}

//////////////////////////////////////////

function getEmp(ID) {

    console.log("Selected Ministry : " + selected_ministry);
    console.log("Required Selected Ministry : " + applicants_need);
}

$('#reload_lottery').click(function (e) {
    $('#lottery_actions').addClass('d-none');
    spin();
});
$('#approve_lottery').click(function (e) {

    if (applicants_need > 0) {
        var counter = 0;
        var selected_applicants = [];

        $("#empList div:not('.checked ')").each(function () {
            if (counter < applicants_need) {
                selected_applicants.push($(this).attr('data-applicant'));
            }
            counter++;
        });
        console.log(selected_applicants);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: '/manager/lottery/update-ministry-applicants',
            data: {
                'selected_department':$('select[name="department"]').val(),
                'selected_grade':$('select[name="selected_grade"]').val(),
                'selected_ministry':selected_ministry,
                'selected_applicants':selected_applicants,
            }
        })
            .done(function (data) {
                counter = 0;
                $("#empList div:not('.checked ')").each(function () {
                    if (counter < applicants_need) {
                        $(this).addClass('checked');
                    }
                    counter++;
                });
                d3.select(".slice:nth-child(" + (picked + 1) + ") path")
                    .attr("fill", "rgb(0,0,0,.60)");
                oldpick.push(picked);
                toastr.success("تم اعتماد النتائج بنجاح");
            })
            .fail(function (data) {
                toastr.error("خطأ يرجى إعادة اعتماد القرعة مرة أخرى !");
            });
    }else{
        d3.select(".slice:nth-child(" + (picked + 1) + ") path")
            .attr("fill", "rgb(0,0,0,.60)");
        oldpick.push(picked);
        toastr.success("تم اعتماد النتائج بنجاح");
    }

    $('#lottery_actions').addClass('d-none');
});
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
