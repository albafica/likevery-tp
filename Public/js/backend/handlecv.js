/* 
 * 简历处理相关
 */
var submitUrl = '';
$(document).ready(function () {
});
//绑定点击姓名展示用户基本信息弹窗
$(document).on('click', '.customerinfo', function () {
    var cname = $(this).attr('cname');
    var mobilephone = $(this).attr('mobilephone');
    var email = $(this).attr('email');
    var contentHtml = '<table class="table table-bordered table-hover">'
            + '<tr>'
            + '<td>姓名</td>'
            + '<td>' + cname + '&nbsp;</td>'
            + '</tr>'
            + '<tr>'
            + '<td>手机</td>'
            + '<td>' + mobilephone + '&nbsp;</td>'
            + '</tr>'
            + '<tr>'
            + '<td>邮箱</td>'
            + '<td>' + email + '&nbsp;</td>'
            + '</tr>'
            + '</table>';
    art.dialog({
        lock: true,
        opacity: 0.3, // 透明度
        title: '求职者基本信息',
        content: contentHtml
    });
    return false;
});
$(document).on('click', '.simpleHandleCV', function () {
    submitUrl = $(this).attr('href');
    var cvid = $(this).attr('cvid');
    var jobtype = $(this).attr('jobtype');
    jobtype = parseInt(jobtype);
    var contentHtml = '<div class="alert alert-danger alert-dismissible" id="errtip" style="display:none;" role="alert">'
            + '<button type="button" class="close" id="closetip"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'
            + '<div id="errcontent"></div>'
            + '</div>'
            + '<table class="table table-bordered table-hover">'
            + '<tr>'
            + '<td style="width:100px;" class="text-center"><label for="cname" class="control-label" style="padding:6px 12px;">职位:</label></td>'
            + '<td style="width:300px;"><select name="jobtype" id="jobtype">'
            + '<option value="1"' + (jobtype == 1 ? 'selected' : '') + '>技术</option>'
            + '<option value="2"' + (jobtype == 2 ? 'selected' : '') + '>设计师</option>'
            + '<option value="3"' + (jobtype == 3 ? 'selected' : '') + '>产品经理</option>'
            + '<option value="4"' + (jobtype == 4 ? 'selected' : '') + '>产品运营</option>'
            + '<option value="5"' + ((jobtype != 1 && jobtype != 2 && jobtype != 3 && jobtype != 4) ? 'selected' : '') + '>其他</option>'
            + '</select></td>'
            + '</tr>'
            + '<tr>'
            + '<td style="width:100px;" class="text-center"><label for="cname" class="control-label" style="padding:6px 12px;">姓名:</label><input type="hidden" id="cvid" name="cvid" value="' + cvid + '"></td>'
            + '<td style="width:300px;"><input type="text" class="form-control" id="cname" name="cname" placeholder="姓名" value=""></td>'
            + '</tr>'
            + '<tr>'
            + '<td class="text-center"><label for="mobilephone" class="control-label" style="padding:6px 12px;">手机:</label></td>'
            + '<td><input type="text" class="form-control" id="mobilephone" name="mobilephone" placeholder="手机" value=""></td>'
            + '</tr>'
            + '<tr>'
            + '<td class="text-center"><label for="email" class="control-label" style="padding:6px 12px;">邮箱:</label></td>'
            + '<td><input type="text" class="form-control" id="email" name="email" placeholder="邮箱" value=""></td>'
            + '</tr>'
            + '<tr><td colspan="2" class="text-center">'
            + '<button type="button" class="btn btn-primary" id="submituserinfo" style="margin-right:20px;">保存</button>'
            + '<button type="button" class="btn btn-default" id="canceluserinfo">取消</button>'
            + '</td></tr>'
            + '</table>';
    art.dialog({
        id: 'adduserinfo',
        lock: true,
        opacity: 0.3, // 透明度
        title: '求职者基本信息',
        width: 600,
        content: contentHtml
    });
    return false;
});
//点击取消按钮
$(document).on('click', '#canceluserinfo', function () {
    art.dialog({id: 'adduserinfo'}).close();
    return false;
});
//提交用户信息
$(document).on('click', '#submituserinfo', function () {
    var cname = $('#cname').val();
    var mobilephone = $('#mobilephone').val();
    var email = $('#email').val();
    var cvid = $('#cvid').val();
    var jobtype = $('#jobtype').val();
    if (cname.length <= 0) {
        showErrTip('姓名不可为空');
        return false;
    }
    if (cname.length >= 20) {
        showErrTip('姓名最多10个汉字');
        return false;
    }
    if (mobilephone.length <= 0 && email.length <= 0) {
        showErrTip('手机或邮箱至少填写一个');
        return false;
    }
    $.ajax({
        type: 'post',
        url: submitUrl,
        data: {
            cvid: cvid,
            cname: cname,
            mobilephone: mobilephone,
            email: email,
            jobtype: jobtype
        },
        dataType: 'json',
        success: function (result) {
            if (result.status != 1) {
                showErrTip(result.message);
                return false;
            }
            window.location.reload();
        }
    });
    return false;
});
$(document).on('click', '#closetip', function () {
    hideErrTip();
});
//展示错误信息
function showErrTip(content) {
    $('#errcontent').html(content);
    $('#errtip').show();
}
//关闭错误信息
function hideErrTip() {
    $('#errtip').hide();
}
/**
 * 上传新简历，覆盖旧简历用
 * @param {type} cvid
 * @returns {Boolean}
 */
function uploadNewCV(cvid) {
    var content = '<form action="index.php/Backend/CvHandle/coverCV" method="post" enctype="multipart/form-data">'
            + '<paper-button class="btn  btn-lg btn-primary ">上传新简历</paper-button>'
            + '<input type="hidden" name="cvid" value="' + cvid + '">'
            + '<input class="upload_file" type="file" onchange="$(this.form).submit();" name="uploadNewCv" id="uploadNewCv">'
            + '</form>';
    art.dialog({
        id: 'uploadNewCV',
        lock: true,
        opacity: 0.3, // 透明度
        title: '上传新简历',
        width: 500,
        content: content
    });
    return false;
}