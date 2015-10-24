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

$(document).on('click', '.doLogin', function () {
    if ($.trim($("#loginName").val()) == "") {
        alert("公司邮箱不可为空");
        return false;
    }
    if ($.trim($("#loginPass").val()) == "") {
        alert("登陆密码不可为空");
        return false;
    }

    $.ajax({
        type: 'post',
        url: "",
        data: {
            isLogin: '1',
            loginName: $("#loginName").val(),
            loginPass: $("#loginPass").val()
        },
        dataType: 'json',
        success: function (result) {
            if (result.status != 1) {
                alert(result.info);
                return false;
            }
            window.location.href = 'http://www.likevery.com/index.php/Company/Viewmanager/';
        }
    });
    return false;
});

$(document).on('click', '.doRegister', function () {
    var actObj = $('#chosejy .active');
    var takeType = '';
    for (var i = 0; i < actObj.length; i++) {
        if (actObj.eq(i).attr("jyType") != "" && actObj.eq(i).attr("jyType") > 0) {
            if (takeType != "") {
                takeType += ",";
            }
            takeType += actObj.eq(i).attr("jyType");
        }
    }
    $("#choseType").val(takeType);
    if ($.trim($("#loginName").val()) == "") {
        alert("公司邮箱不可为空");
        return false;
    }
    if ($.trim($("#loginPass").val()) == "") {
        alert("登陆密码不可为空");
        return false;
    }

    $.ajax({
        type: 'post',
        url: "",
        data: {
            isLogin: '0',
            choseType: $("#choseType").val(),
            loginName: $("#loginName").val(),
            loginPass: $("#loginPass").val()
        },
        dataType: 'json',
        success: function (result) {
            if (result.status != 1) {
                alert(result.info);
                return false;
            }
            $("#register").hide();
            $("#login").show();
            $("#isLogin").val(1);
            if ($.trim($(".doLogin").html()) == "") {
                window.location.href = 'http://www.likevery.com/index.php/Company/Index/login';
            }
        }
    });
    return false;
});


$(document).on('click', '#chosejy .card-bg', function () {
    if ($(this).hasClass("active")) {
        $(this).removeClass("active");
    }
    else {
        $(this).addClass("active");
    }
    return false;
});

