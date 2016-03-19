$(document).on('click', '#cvRoleSet .cardDiv', function () {
    var obj = $(this).find(".iconCustom");
    var isAdd = 1;
    if (obj.hasClass("icon_gou_green")) {
        isAdd = 0;
    }

    $.ajax({type: 'post', dataType: 'json', url: "",
        data: {type: $(this).attr("oType"), isadd: isAdd},
        success: function (result) {
            if (result.status != 1) {
                alert(result.info);
                return false;
            }
            if (obj.hasClass("icon_gou_green")) {
                obj.removeClass("icon_gou_green").addClass("icon_gou_grey");
            }
            else {
                obj.removeClass("icon_gou_grey").addClass("icon_gou_green");
            }
        }
    });
});

