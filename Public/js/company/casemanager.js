$(document).on('click', '.caseEdit', function () {
    var content = '<div class="modal-body">';
    content += '<ul class="hr-ul">';
    content += '<li class="clearfix">';
    content += '<span class="pull-left left-form"><span class="green">*</span>职位名称</span>';
    content += '<span class="pull-left form-group"><input id="name" type="text" class="form-control" placeholder="职位名称" maxlength="50"></span>';
    content += '<span class="pull-left tips has-error" style="display:none" id="nameErr">必须输入职位名称</span>';
    content += '</li>';
    content += '<li class="clearfix">';
    content += '<span class="pull-left left-form"><span class="green">*</span>薪资范围</span>';
    content += '<span class="pull-left form-group"><input id="salary" type="text" class="form-control" placeholder="20万/年" maxlength="50"></span>';
    content += '<span class="pull-left tips has-error" style="display:none" id="salaryErr">必须输入薪资范围</span>';
    content += '</li>';
    content += '<li class="clearfix">';
    content += '<span class="pull-left left-form"><span class="green">*</span>工作职责</span>';
    content += '<span class="pull-left form-group  "><textarea id="content" style="width:360px" class="form-control" rows="10" maxlength="1000"></textarea>';
    content += '<span class="pull-left tips has-error" style="display:none" id="contentErr">请完善工作职责</span>';
    content += '</span></li>';
    content += '<li class="clearfix">';
    content += '<span class="pull-left left-form">公司福利</span>';
    content += '<span class="pull-left form-group"><span class="pull-left form-group"><textarea id="tags" class="form-control" maxlength="100"></textarea></span>';
    content += '</span>';
    content += '</li>';
    content += '</ul>';
    content += '</div>';
    content += '<div class="modal-footer">';
    content += '<button data-dismiss="modal" class="btn btn-default" type="button" id="closeDiv">关闭</button>';
    content += ' <button class="btn btn-primary" type="button" id="saveCase">确定</button>';
    content += '</div>';


    art.dialog({
        id: 'caseEdit',
        lock: true,
        opacity: 0.3, // 透明度
        title: '职位管理',
        width: 650,
        content: content
    });

    var caseId = $(this).attr("oId");
    $('#saveCase').attr("oId", caseId);
    if (caseId != "") {
        $.ajax({type: 'post', dataType: 'json', url: "",
            data: {id: caseId, isshow: 1},
            success: function (result) {
                if (result.status != 1) {
                    showErrTip(result.message);
                    return false;
                }
                $('#name').val(result.caseinfo.name);
                $('#salary').val(result.caseinfo.salary);
                $('#content').val(result.caseinfo.content);
                $('#tags').val(result.caseinfo.tags);
            }
        });
    }
});


$(document).on('click', '.caseDel', function () {
    if (confirm("确定要删除该信息吗？")) {
        var caseId = $(this).attr("oId");
        if (caseId != "") {
            $.ajax({type: 'post', dataType: 'json', url: "",
                data: {id: caseId, isdelete: 1},
                success: function (result) {
                    if (result.status != 1) {
                        showErrTip(result.message);
                        return false;
                    }
                    window.location.reload();
                }
            });
        }
    }
});


$(document).on('click', '#saveCase', function () {
    if ($.trim($('#name').val()) == "") {
        $('#nameErr').show();
        return;
    }

    if ($.trim($('#salary').val()) == "") {
        $('#salaryErr').show();
        return;
    }

    if ($.trim($('#content').val()) == "") {
        $('#contentErr').show();
        return;
    }

    var caseId = $('#saveCase').attr("oId");
    $.ajax({type: 'post', dataType: 'json', url: "",
        data: {id: caseId, name: $('#name').val(), salary: $('#salary').val(), content: $('#content').val(), tags: $('#tags').val(), isdelete: 0},
        success: function (result) {
            if (result.status != 1) {
                showErrTip(result.message);
                return false;
            }
            window.location.reload();
        }
    });
});

$(document).on('click', '#name', function () {
    $('#nameErr').hide();
});


$(document).on('click', '#salary', function () {
    $('#salaryErr').hide();
});


$(document).on('click', '#content', function () {
    $('#contentErr').hide();
});




$(document).on('click', '#closeDiv', function () {
    art.dialog({id: 'caseEdit'}).close();
});