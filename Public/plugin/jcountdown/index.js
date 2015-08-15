jQuery(function () {
    /*for (var b = new Date, i = b.getFullYear() + "/" + (b.getMonth() + 1) + "/" + (b.getDate() + 1) + " " + b.getHours() + ":" + b.getMinutes() + ":" + b.getSeconds(), e = b.getFullYear() + 1 + "/" + (b.getMonth() + 1) + "/" + b.getDate() + " " + b.getHours() + ":" + b.getMinutes() + ":" + b.getSeconds(), h = b.getFullYear() + 1E4 + "/" + (b.getMonth() + 1) + "/" + b.getDate() + " " + b.getHours() + ":" + b.getMinutes() + ":" + b.getSeconds(), b = -b.getTimezoneOffset() / 60, j = [{
        timeText: e,
        timeZone: b,
        style: "flip",
        color: "black",
        width: 0,
        textGroupSpace: 15,
        textSpace: 0,
        reflection: !0,
        reflectionOpacity: 10,
        reflectionBlur: 0,
        dayTextNumber: 3,
        displayDay: !0,
        displayHour: !0,
        displayMinute: !0,
        displaySecond: !0,
        displayLabel: !0,
        onFinish: function () {}
    }], i = jQuery("#content"), e = jQuery("#content>.page"), h = 0; h < j.length - 1; h++) {
        var b = j[h]
        k.children(".countdown").jCountdown(b);
        i.append(k)
    }
    jQuery(".page").each(function (b, c) {
        var d = jQuery(c),
            f = d.children(".countdown"),
            d = j[b];
			console.log(d);
        f.jCountdown(d);
    });*/
	$('#show').jCountdown({
		timeText: '2015/8/15 16:10:00',
        timeZone: 8,
        style: "flip",
        color: "black",
        width: 0,
        textGroupSpace: 15,
        textSpace: 0,
        reflection: !0,
        reflectionOpacity: 10,
        reflectionBlur: 0,
        dayTextNumber: 3,
        displayDay: !0,
        displayHour: !0,
        displayMinute: !0,
        displaySecond: !0,
        displayLabel: !0,
        onFinish: function () {}
            });
});