/* 
 * 简历处理相关
 */
$(document).ready(function () {
});
/**
 * 上传新简历，覆盖旧简历用
 * @param {type} cvid
 * @returns {Boolean}
 */
function uploadNewCV(cvid, managerid) {
    var content = '<form action="/likevery/index.php/Backend/Manager/coverCV" method="post" enctype="multipart/form-data">'
            + '<paper-button class="btn  btn-lg btn-primary ">上传新简历</paper-button>'
            + '<input type="hidden" name="cvid" value="' + cvid + '">'
            + '<input type="hidden" name="managerid" value="' + managerid + '">'
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