$().ready(function () {
    $('#retroclockbox').jCountdown({
        timeText: timeText,
        timeZone: 8,
        style: "flip",
        color: "black",
        width: 0,
        textGroupSpace: 15,
        textSpace: 0,
        reflection: 0,
        reflectionOpacity: 10,
        reflectionBlur: 0,
        dayTextNumber: 2,
        displayDay: 1,
        displayHour: 1,
        displayMinute: 1,
        displaySecond: 1,
        displayLabel: 1,
        onFinish: function () {
        }
    });
});

$(document).on('click', '#auctionemploee', function () {
    var obj = $(this);
    getCaseList(obj);
    return false;
});

/**
 * 获取企业case列表
 * @param {type} obj
 * @returns {undefined}
 */
function getCaseList(obj) {
    var submitUrl = obj.attr('getcaselisturl');
    if (submitUrl == '') {
        return false;
    }
    $.ajax({
        url: submitUrl,
        type: 'get',
        dataType: 'json',
        data: {},
        success: function (data) {
//            console.log(data.caselist);
            if (data.caselist === null || data.caselist === '') {
                //case为空,直接展示新增窗口
                $('#addCaseModal').modal('show');
            } else {
                //case不为空,展示case列表

                var content = '';
                $(data.caselist).each(function (idx, val) {
                    content += '<li value="' + val.id + '" class="caseListOption"><a href="#">' + val.name + '</a></li>';
//                    content += '<option value="' + val.id + '">' + val.name + '</option>';
                });
                $('#caseList').append(content);
                $('#choseCaseModal').modal('show');
            }
        }
    });
}

/**
 * 保存新增的case
 */
$(document).on('click', '#saveNewCase', function () {
    var position = $('#positionIpt').val();
    var salary = $('#salaryIpt').val();
    var content = $('#contentIpt').val();
    var tags = $('#tagsIpt').val();
    var requestUrl = $('#saveCasePath').val();
    $.ajax({
        type: 'post',
        url: requestUrl,
        data: {
            name: position,
            salary: salary,
            content: content,
            tags: tags,
            isdelete: 0
        },
        dataType: 'json',
        success: function (data) {
            if (data.status != 1) {
                alert(data.message);
                return;
            }
            var caseid = data.caseid;
            //case保存成功后直接提交
            auctionCV(caseid);
        }
    })
});

/**
 * 竞拍简历
 * @param {type} obj
 * @returns {undefined}
 */
function auctionCV(caseid) {
    var obj = $('#auctionemploee');
    var submitUrl = obj.attr('href');
    if (submitUrl == '') {
        return false;
    }
    $.ajax({
        url: submitUrl,
        type: 'get',
        dataType: 'json',
        data: {caseid: caseid},
        success: function (data) {
            if (!data.status) {
                if (data.errCode == -10) {
                    obj.addClass('disabled');
                    obj.attr('url', '');
                    art.dialog({
                        id: 'auctionErr',
                        lock: true,
                        opacity: 0.3, // 透明度
                        title: '竞拍失败',
                        content: data.errMsg,
                        ok: function () {
                            window.location.href = data.directURL;
                            return false;
                        }
                    });
                    return false;
                }
                if (data.errCode == -1 || data.errCode == -2 || data.errCode == -3) {
                    //不可继续竞拍，将竞拍按钮清空
                    obj.addClass('disabled');
                    obj.attr('url', '');
                }
                art.dialog({
                    id: 'auctionErr',
                    lock: true,
                    opacity: 0.3, // 透明度
                    title: '竞拍失败',
                    content: data.errMsg
                });
            } else {
                //不可继续竞拍，将竞拍按钮清空
                obj.addClass('disabled');
                obj.attr('url', '');
                art.dialog({
                    id: 'auctionSucc',
                    lock: true,
                    opacity: 0.3, // 透明度
                    title: '竞拍成功',
                    content: '竞拍成功'
                });
            }
        }
    });
}

$(document).on('click', '.caseListOption', function () {
    var caseid = $(this).val();
//    console.log(caseid);
    auctionCV(caseid);
    $('#choseCaseModal').modal('hide');
    $('#addCaseModal').modal('hide');
});

/**
 * 选择case页点击新增case按钮
 */
$(document).on('click', '#showAddCase', function () {
    $('#choseCaseModal').modal('hide');
    $('#addCaseModal').modal('show');
});