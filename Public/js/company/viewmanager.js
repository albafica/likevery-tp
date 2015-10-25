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
    var submitUrl = $(this).attr('href');
    if (submitUrl == '') {
        return false;
    }
    $.ajax({
        url: submitUrl,
        type: 'post',
        dataType: 'json',
        data: {},
        success: function (data) {
            if (!data.status) {
                console.log(data);
                console.log(data.errCode);
                if (data.errCode == -1 || data.errCode == -2 || data.errCode == -2) {
                    console.log($(this));
                    //不可继续竞拍，将竞拍按钮清空
                    $(this).addClass('disabled');
                    $(this).attr('url', '');
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
                $(this).addClass('disabled');
                $(this).attr('url', '');
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
    return false;
});
