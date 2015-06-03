// JavaScript Document
//$("#reportdetails").hide();
$("#memberedit").hide();

function test(a, $this) {
    $("#formdetails").getNiceScroll().resize();
    $("#formdetails").show().removeClass("secondscroll");
    $("#memberedit").hide();
    $(".upload_err_msg").html("");
    //$(".list-group-item").removeClass("active").removeAttr("id");
    window.location.href = "#memberid/" + a;
    //$($this).parent().parent().addClass("active").attr("id",a);
    $("#editdetails").hide();
    $("#test_value").val("");
    $("#no_member").hide();
    $(".details").show();
    $('#edit_member_details', this.el).css('display', 'block');
    $('#cancel_button', this.el).css('display', 'none');
    $('#save_button', this.el).css('display', 'none');
    $(".repoert_edit").hide();
    $("#delete_report").val("");
    $('#cancel_button').hide();
    var am = $('#memberid', this.el).val();
    var ad = $('#fst_mmbr').val();
    if (am == ad) {
        $('#modals-bootbox-confirm', this.el).hide();
        $('#edit_member_details', this.el).hide();
    }
}
function edit_profile(a){
	setTimeout(function () {
	$("#validateSubmitForm").show();
	$("#test_value").val("");
	$("#delete_report").val("");
	$('#save_button', this.el).css("display", "block");
//	$('#cancel_button', this.el).css("display", "block");
	$(this).hide();
	$(".details").removeAttr("id").hide();
	$("#no_member").hide();
	$(".repoert_edit").css("display", "none");
	$("#editdetails").css("display", "block");
	}, 500);
}

function contacts(a, $this) {
    $("#formdetails").getNiceScroll().resize();
    $("#formdetails").show();
    window.location.href = "#contactid/" + a;
    $(".innerAll").parent().removeClass("active");
    $($this).parent().addClass("active").attr("id", a);
}
function memberreport(a, $this) {
    //window.location.href="#memberreport/"+a;
    //$($this).parent().parent().addClass("active").attr("id",a);
    $(".details").hide();
    $("#test_value").val("");
    $("#no_member").hide();
    $("#editdetails").hide();
    $(".repoert_edit").css("display", "block");
    $("#delete_report").val("");
}

function memberedit(a, $this) {
    //window.location.href="#memberedit/"+a;
    //$($this).parent().parent().addClass("active").attr("id",a);
    $("#memberedit").show();
    $("#formdetails").hide();
    $("#test_value").val("");
    $("#delete_report").val("");
    $($this).next().css("display", "block");
    $(".details").hide();
    //$("#no_member").hide();
    $(".repoert_edit").css("display", "none");
    $("#editdetails").css("display", "block");
    $("#validateSubmitForm").hide();

}

function ignore(a) {
    $.ajax({
        type: "POST",
        url: "search_rest",
        data: {
            id: a
        },
        success: function(msg) {}
    });
    location.reload();

}

function confirm(a) {
    $.ajax({
        type: "POST",
        url: "search_rest",
        data: {
            confirm_id: a
        },
        success: function(msg) {
            location.reload();
        }
    });
}
function ok(a, $this) {
    $.ajax({
        type: "POST",
        url: "search_rest",
        data: {
            alert_ok_id: a,
            alert_type: $($this).attr("data-type")
        },
        success: function(msg) {
            location.reload();
        }
    });
}
function send_request(id, $this) {
    var self = $($this);
    $(self).removeClass("savereports").html('Request sent..');
    $(self).css("background", "white");
    $(self).css("color", "#1ba0a2");
    $(self).attr('disabled', 'disabled');

    $.ajax({
        type: "POST",
        url: "contacts",
        data: {
            send_request_to: id
        },
        success: function(msg) {}
    });
}
function report_edit(a, $this) {
        $("#recordid").val(a);
        $("#test_value").val("");
        $(".details").hide();
        $('.dz-message').css('opacity', '1');
        //var user_tags=($("#users_tag").val().substring(0, $("#users_tag").val().length - 1));

        $("#repoert_edit" + a).css("display", "block");
        if ($("#prev_files").children().length < 1) {
            $("#prev_files").parent().hide();
        }
        $.ajax({
            type: "POST",
            url: "member/delete_temp_file",

            success: function(msg) {
                console.log(msg);
                var b = (msg.substring(0, msg.length - 1));
                var a = b.split(",");
                $(".tags", this.el).select2({
                    tags: a
                });
            }
        }); //ajax  
        $(".fstscroll").getNiceScroll().remove();
        $("#formdetails").removeClass('fstscroll');
        $("#formdetails").addClass('thrdscroll');
        $(".thrdscroll").niceScroll({
            cursorcolor: "#1ba0a2",
            horizrailenabled: false,
        });
        $(".thrdscroll").getNiceScroll().resize();
    }
    //ajax file upload try	
$('#privacy1').click(function() {
    bootbox.alert("<h2>Privacy Policy</h2><br>We know you care about your life, and that of your near and dear ones.We do too. At Ospinet we understand the importance of quality healthcare, and realize healthcare record management needs to be a tool not a hurdle for a better healthier life.We comply with HIPPA and ensure maximum privacy of your records.All your records are encrypted with 256 AES encryption making it as secure as, well, the US government records.We guarantee we will never share your personal contact information with any third party without your consent.");
});

function fileUpload(form, action_url, div_id) {
    // Create the iframe...
    var iframe = document.createElement("iframe");
    iframe.setAttribute("id", "upload_iframe");
    iframe.setAttribute("name", "upload_iframe");
    iframe.setAttribute("width", "0");
    iframe.setAttribute("height", "0");
    iframe.setAttribute("border", "0");
    iframe.setAttribute("style", "width: 0; height: 0; border: none;");

    // Add to document...
    form.parentNode.appendChild(iframe);
    window.frames['upload_iframe'].name = "upload_iframe";
    iframeId = document.getElementById("upload_iframe");
    // Add event...
    var eventHandler = function() {

        if (iframeId.detachEvent) iframeId.detachEvent("onload", eventHandler);
        else iframeId.removeEventListener("load", eventHandler, false);

        // Message from server...
        if (iframeId.contentDocument) {
            content = iframeId.contentDocument.body.innerHTML;
        } else if (iframeId.contentWindow) {
            content = iframeId.contentWindow.document.body.innerHTML;
        } else if (iframeId.document) {
            content = iframeId.document.body.innerHTML;
        }

        document.getElementById(div_id).innerHTML = content;

        // Del the iframe...
        setTimeout('iframeId.parentNode.removeChild(iframeId)', 250);
    }

    if (iframeId.addEventListener) iframeId.addEventListener("load", eventHandler, true);
    if (iframeId.attachEvent) iframeId.attachEvent("onload", eventHandler);
    // Set properties of form...
    form.setAttribute("target", "upload_iframe");
    form.setAttribute("action", action_url);
    form.setAttribute("method", "post");
    form.setAttribute("enctype", "multipart/form-data");
    form.setAttribute("encoding", "multipart/form-data");
    // Submit the form...
    form.submit();

    document.getElementById(div_id).innerHTML = "Uploading...";
    return false;
}

function call($this) {
    $("a[rel^='prettyPhoto[pp_gal]']").prettyPhoto();

}

function close_lightbox() {
    $('#light').css("display", "none");
    $('#video_call').css("display", "none");
    $('#fade').css("display", "none");
    $('.white_content').css({
        'opacity': '0'
    });
    $('.black_overlay').css({
        'opacity': '0'
    });
}
function files(a, $this) {
    $("#filesdetails").getNiceScroll().resize();
    $("#filesdetails").show();
    window.location.href = "#fileid/" + a;
    $(".innerAll").parent().removeClass("active");
    $($this).parent().addClass("active").attr("id", a);
}