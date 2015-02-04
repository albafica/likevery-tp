/* 
 * 简历处理相关
 */
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

