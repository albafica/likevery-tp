jQuery(function () {
    for (var b = new Date, i = b.getFullYear() + "/" + (b.getMonth() + 1) + "/" + (b.getDate() + 1) + " " + b.getHours() + ":" + b.getMinutes() + ":" + b.getSeconds(), e = b.getFullYear() + 1 + "/" + (b.getMonth() + 1) + "/" + b.getDate() + " " + b.getHours() + ":" + b.getMinutes() + ":" + b.getSeconds(), h = b.getFullYear() + 1E4 + "/" + (b.getMonth() + 1) + "/" + b.getDate() + " " + b.getHours() + ":" + b.getMinutes() + ":" + b.getSeconds(), b = -b.getTimezoneOffset() / 60, j = [{
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
        var b = j[h],
            k = e.clone();
        k.children(".countdown").jCountdown(b);
        i.append(k)
    }
    var g = function (b) {
        var c = b.children(".panel"),
            b = b.children(".countdown"),
            d = c.find(".timeText").val(),
            f = parseFloat(c.find(".timeZone").val()),
            a = c.find(".style[checked]").val(),
            l = c.find(".color[checked]").val(),
            m = "auto" == c.find(".widthType[checked]").val() ? 0 : c.find(".width").slider("value"),
            n = c.find(".textGroupSpace").slider("value"),
            e = c.find(".textSpace").slider("value"),
            g = "checked" == c.find(".reflection").attr("checked"),
            h = c.find(".reflectionOpacity").slider("value"),
            i = c.find(".reflectionBlur").slider("value"),
            j = c.find(".dayTextNumber").slider("value"),
            k = "checked" == c.find(".displayDay").attr("checked"),
            p = "checked" == c.find(".displayHour").attr("checked"),
            q = "checked" == c.find(".displayMinute").attr("checked"),
            r = "checked" == c.find(".displaySecond").attr("checked"),
            s = "checked" == c.find(".displayLabel").attr("checked");
        6 != d.split("/").join(" ").split(":").join(" ").split(" ").length ? c.find(".timeText").addClass("error") : c.find(".timeText").removeClass("error");
        isNaN(f) ? c.find(".timeZone").addClass("error") : c.find(".timeZone").removeClass("error");
        g ? c.find(".reflectionOpacity").parents(".group").show() : c.find(".reflectionOpacity").parents(".group").hide();
        g ? c.find(".reflectionBlur").parents(".group").show() : c.find(".reflectionBlur").parents(".group").hide();
        b.jCountdown({
                timeText: d,
                timeZone: f,
                style: a,
                color: l,
                width: m,
                textGroupSpace: n,
                textSpace: e,
                reflection: g,
                reflectionOpacity: h,
                reflectionBlur: i,
                dayTextNumber: j,
                displayDay: k,
                displayHour: p,
                displayMinute: q,
                displaySecond: r,
                displayLabel: s
            });
        c.find(".width").slider("value", b.children().width());
        c.find(".width").parents(".group").find(".value").html(b.children().width())
    };
    jQuery(".page").each(function (b, c) {
        var d = jQuery(c),
            f = d.children(".countdown"),
            a = d.children(".panel"),
            d = j[b];
        f.jCountdown(d);
        a.find("input").removeAttr("disabled");
        a.find(".timeText").val(d.timeText);
        a.find(".timeZone").val(d.timeZone);
        a.find(".style").removeAttr("checked");
        a.find(".style[value=" + d.style + "]").attr("checked", "checked");
        a.find(".color").removeAttr("checked");
        a.find(".color[value=" + d.color + "]").attr("checked", "checked");
        a.find(".widthType").removeAttr("checked");
        0 == d.width ? a.find(".widthType[value=auto]").attr("checked", "checked") : a.find(".widthType[value=fixed]").attr("checked", "checked");
        0 == d.width ? a.find(".width").parents(".group").hide() : a.find(".width").parents(".group").find(".value").html(d.width);
        a.find(".width").slider({
                min: 50,
                max: 900,
                step: 1,
                value: f.children().width()
            });
        a.find(".textGroupSpace").slider({
                min: 0,
                max: 100,
                step: 1,
                value: d.textGroupSpace
            });
        a.find(".textSpace").slider({
                min: 0,
                max: 50,
                step: 1,
                value: d.textSpace
            });
        a.find(".reflection").attr("checked", d.reflection);
        a.find(".reflectionOpacity").slider({
                min: 0,
                max: 100,
                step: 1,
                value: d.reflectionOpacity
            });
        d.reflection ? a.find(".reflectionOpacity").parents(".group").show() : a.find(".reflectionOpacity").parents(".group").hide();
        a.find(".reflectionBlur").slider({
                min: 0,
                max: 10,
                step: 1,
                value: d.reflectionBlur
            });
        d.reflection ? a.find(".reflectionBlur").parents(".group").show() : a.find(".reflectionBlur").parents(".group").hide();
        a.find(".dayTextNumber").slider({
                min: 2,
                max: 8,
                step: 1,
                value: d.dayTextNumber
            });
        a.find(".displayDay").attr("checked", d.displayDay);
        a.find(".displayHour").attr("checked", d.displayHour);
        a.find(".displayMinute").attr("checked", d.displayMinute);
        a.find(".displaySecond").attr("checked", d.displaySecond);
        a.find(".displayLabel").attr("checked", d.displayLabel);
        a.find(".textGroupSpace").parent().find(".value").html(d.textGroupSpace);
        a.find(".textSpace").parent().find(".value").html(d.textSpace);
        a.find(".reflectionOpacity").parent().find(".value").html(d.reflectionOpacity);
        a.find(".reflectionBlur").parent().find(".value").html(d.reflectionBlur);
        a.find(".dayTextNumber").parent().find(".value").html(d.dayTextNumber);
        a.find("input[type=text]").keyup(function () {
                g(jQuery(this).parents(".page"))
            }).change(function () {
                g(jQuery(this).parents(".page"))
            });
        a.find("input[type=checkbox]").change(function () {
                g(jQuery(this).parents(".page"))
            });
        a.find("input[type=radio]").click(function () {
                var a = jQuery(this),
                    c = a.parents(".page");
                c.find("." + a.attr("class")).removeAttr("checked");
                a.attr("checked", "checked");
                g(c)
            });
        f = function () {
                var a = jQuery(this),
                    c = a.parents(".page");
                a.parent().find(".value").html(a.slider("value"));
                g(c)
            };
        a.find(".slider").slider({
                start: f,
                slide: f,
                stop: f
            });
        a.find(".widthType").click(function () {
                var a = jQuery(this).parents(".page");
                "auto" == a.find(".widthType[checked]").val() ? a.find(".width").parents(".group").hide() : a.find(".width").parents(".group").show()
            });
        a.find(".stop").click(function () {
                var c = jQuery(this);
                c.parents(".page").children(".countdown").jCountdown("stop");
                c.hasClass("disable") || (a.find(".slider").slider("disable"), a.find("input").attr("disabled", "disabled"), a.find("*").addClass("disable"), a.find(".start").parent().removeClass("disable"), a.find(".start").removeClass("disable"), c.addClass("disable"))
            });
        a.find(".start").click(function () {
                var c = jQuery(this),
                    b = c.parents(".page").children(".countdown");
                c.hasClass("disable") || (b.jCountdown("start"), a.find(".slider").slider("enable"), a.find("input").removeAttr("disabled", "disabled"), a.find("*").removeClass("disable"), a.find(".stop").parent().removeClass("disable"), a.find(".stop").removeClass("disable"), c.addClass("disable"), a.find(".create").addClass("disable"))
            }).addClass("disable");
        a.find(".destroy").click(function () {
                var a = jQuery(this),
                    c = a.parents(".page"),
                    b = c.children(".panel"),
                    c = c.children(".countdown");
                a.hasClass("disable") || (c.jCountdown("destroy"), b.find(".slider").slider("disable"), b.find("input").attr("disabled", "disabled"), b.find("*").addClass("disable"), b.find(".create").parent().removeClass("disable"), b.find(".create").removeClass("disable"), a.addClass("disable"))
            });
        a.find(".create").click(function () {
                var a = jQuery(this),
                    c = a.parents(".page"),
                    b = c.children(".panel");
                c.children(".countdown");
                a.hasClass("disable") || (g(c), b.find(".slider").slider("enable"), b.find("input").removeAttr("disabled", "disabled"), b.find("*").removeClass("disable"), b.find(".destroy").parent().removeClass("disable"), b.find(".destroy").removeClass("disable"), a.addClass("disable"), b.find(".start").addClass("disable"))
            }).addClass("disable")
    });
    jQuery(".backgroundPicker .button").click(function () {
        for (var b = jQuery(this), c = b.parents(".page"), d = c.children(".countdown"), f = c.children(".backgroundPicker"), a = ["background1", "background2", "background3", "background4", "background5"], c = c.find(".backgroundPicker .button").index(b), e = 0; e < a.length; e++) d.removeClass(a[e]);
        d.addClass(a[c]);
        f.children(".button").removeClass("selected");
        b.addClass("selected")
    });
    jQuery(".backgroundPicker .button:first-child").trigger("click");
    jQuery("[tip]").mouseenter(function () {
        var b = jQuery(this),
            c = jQuery("#tip"),
            d = b.attr("tip"),
            e = b.innerWidth() - 10,
            a = b.offset().left + 5 + "px";
        b.hasClass("disable") || (c.children(".content").html(d), c.outerWidth(e), b = b.offset().top - c.outerHeight() - 5, c.stop(!0, !0).show().css("opacity", "0").css("left", a).css("top", b + 3).animate({
                opacity: 1,
                top: "-=3"
            }, 150))
    }).mouseleave(function () {
        var b = jQuery(this),
            c = jQuery("#tip");
        b.attr("tip");
        b = b.offset().top - c.outerHeight() - 5;
        c.stop(!0, !0).css("opacity", "1").css("top", b);
        c.animate({
                opacity: 0,
                top: "+=3"
            }, 150, function () {
                jQuery(this).hide()
            })
    })
});