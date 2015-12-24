$(document).ready(function () {
});

$(document).on('click', '.toRegister', function () {
    $("#login").hide();
    $("#register").show();
    $("#isLogin").val(0);
    return false;
});

$(document).on('click', '.toLogin', function () {
    $("#register").hide();
    $("#login").show();
    $("#isLogin").val(1);
    return false;
});

$(document).on('click', '#chosejy .card-bg', function () {
    var obj = $(this).find(".iconCustom");
    if (obj.hasClass("icon_gou_green")) {
        obj.removeClass("icon_gou_green").addClass("icon_gou_grey");
    }
    else {
        obj.removeClass("icon_gou_grey").addClass("icon_gou_green");
    }
    return false;
});
