function fillyear_select(start_year, end_year, select_name, op) {
    if (op == "--") {
        for (i = start_year; i > end_year; i--) {
            $("select[name='" + select_name + "']").append(
                $('<option />').val(i).html(i));
        }
    } else {

        for (i = start_year; i < end_year; i++) {
            $("select[name='" + select_name + "']").append(
                $('<option />').val(i).html(i));
        }
    }
}

function fillmonth_select(year_dd_val, control_intial) {
    var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug",
        "Sep", "Oct", "Nov", "Dec"
    ];
    $("select[name='" + control_intial + "_month']").empty();
    $("select[name='" + control_intial + "_day']").empty();
    $("select[name='" + control_intial + "_day']").append(
        $('<option />').val('').html("Day"));
    $("select[name='" + control_intial + "_month']").append(
        $('<option />').val('').html("Month"));

    var no_of_month = 12;
    var start_month = 0;
    if (year_dd_val == new Date().getFullYear() && control_intial == "bd") // (this
    // codition
    // for
    // "dob")if
    // dd
    // value
    // is
    // current
    // year
    // then
    // shows
    // month
    // "upto"
    // current
    // month
    // else
    // shows
    // all
    // months
    {
        start_month = 0;
        no_of_month = new Date().getMonth() + 1;
    } else if (year_dd_val == new Date().getFullYear() && control_intial == "ub") // (this codition for "unborn")if dd
    // value is current year then shows
    // month "above" current month else
    // shows all months
    {
        start_month = new Date().getMonth();
        no_of_month = 12
    } else if (year_dd_val == new Date().getFullYear() && control_intial == "bdn") // (this codition for "unborn")if dd
    // value is current year then shows
    // month "above" current month else
    // shows all months
    {
        start_month = start_month = 0;
        no_of_month = new Date().getMonth() + 1;
    } else if (year_dd_val == new Date().getFullYear() && control_intial == "ubn") // (this codition for "unborn")if dd
    // value is current year then shows
    // month "above" current month else
    // shows all months
    {
        start_month = new Date().getMonth();
        no_of_month = 12
    } else {
        start_month = 0;
        no_of_month = 12;
    }

    for (i = start_month; i < no_of_month; i++) {

        $("select[name='" + control_intial + "_month']").append(
            $('<option />').val(i).html(months[i]));
    }
}

function fillday_select(month_dd_val, control_intial) {
    $("select[name='" + control_intial + "_day']").empty();
    $("select[name='" + control_intial + "_day']").append(
        $('<option />').val('').html("Day"));

    var no_of_days = daysInMonth(parseInt(month_dd_val) + 1, $(
        "select[name='" + control_intial + "_year']").val());
    var start_day = 1;
    if ($("select[name='" + control_intial + "_year']").val() == new Date()
        .getFullYear() && month_dd_val == new Date().getMonth() && control_intial == "bd") {
        start_day = 1;
        no_of_days = new Date().getDate();
    }
    if ($("select[name='" + control_intial + "_year']").val() == new Date()
        .getFullYear() && month_dd_val == new Date().getMonth() && control_intial == "bdn") {
        start_day = 1;
        no_of_days = new Date().getDate();
    } else if ($("select[name='" + control_intial + "_year']").val() == new Date()
        .getFullYear() && month_dd_val == new Date().getMonth() && control_intial == "ub") {
        start_day = new Date().getDate();
    } else if ($("select[name='" + control_intial + "_year']").val() == new Date()
        .getFullYear() && month_dd_val == new Date().getMonth() && control_intial == "ubn") {
        start_day = new Date().getDate();
    }
    for (i = start_day; i <= no_of_days; i++) {
        $("select[name='" + control_intial + "_day']").append(
            $('<option />').val(i).html(i));
    }
}

function fill_dropdown() {
    fillyear_select(new Date().getFullYear(), "1900", "bd_year", "--");
    fillyear_select(new Date().getFullYear(), "1900", "bdn_year", "--");
    fillyear_select(new Date().getFullYear(),
        parseInt(new Date().getFullYear()) + 5, "ub_year", "++");
    fillyear_select(new Date().getFullYear(),
        parseInt(new Date().getFullYear()) + 5, "ubn_year", "++");
    set_selected_date();
    $("select[name='bd_year']").change(function () {
        fillmonth_select($(this).val(), 'bd');
    })
    $("select[name='bdn_year']").change(function () {
        fillmonth_select($(this).val(), 'bdn');
    })
    $("select[name='ub_year']").change(function () {
        fillmonth_select($(this).val(), 'ub');
    })
    $("select[name='ubn_year']").change(function () {
        fillmonth_select($(this).val(), 'ubn');
    })
    $("select[name='bd_month']").change(function () {
        fillday_select($(this).val(), 'bd');
    })
    $("select[name='bdn_month']").change(function () {
        fillday_select($(this).val(), 'bdn');
    })
    $("select[name='ub_month']").change(function () {
        fillday_select($(this).val(), 'ub');
    })
    $("select[name='ubn_month']").change(function () {
        fillday_select($(this).val(), 'ubn');
    })

    $("input[name='birth_info']").click(function () {
        var divid = "." + $(this).attr("id");
        $(".birtdiv").hide();
        $(divid).show();
        // $(divid).css("visibility","visible");
    });
}

function daysInMonth(month, year) {
    return new Date(year, month, 0).getDate();
}

function set_selected_date() {
    var day, month, year, dd_intial;
    day = $("#birth_day_hid").val();
    month = $("#birth_month_hid").val();
    year = $("#birth_year_hid").val();
	day1 = $("#birth_day_hid1").val();
    month1 = $("#birth_month_hid1").val();
    year1 = $("#birth_year_hid1").val();
    if ($('#Dob123').is(':checked')) {
        $("select[name='bd_year']").val(year);
        fillmonth_select(year, "bd");
        $("select[name='bd_month']").val(month - 1);
        fillday_select(month - 1, "bd");
        $("select[name='bd_day']").val(day);
    }
    if ($('#Unborn123').is(':checked')) {
        $("select[name='ub_year']").val(year1);
        fillmonth_select(year, "ub");
        $("select[name='ub_month']").val(month1 - 1);
        fillday_select(month - 1, "ub");
        $("select[name='ub_day']").val(day1);
    }
}