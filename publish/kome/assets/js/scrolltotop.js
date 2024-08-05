var scrolltotop = {
    setting: {
        startline: 100,
        scrollto: 0,
        scrollduration: 500,
        fadeduration: [500, 100]
    },
    controlHTML: '<i class="o-size ico-arrow-up"></i>',
    controlattrs: {
        offsetx: 5,
        offsety: 5
    },
    anchorkeyword: "#top",
    state: {
        isvisible: !1,
        shouldvisible: !1
    },
    scrollup: function() {
        this.cssfixedsupport || this.$control.css({
            opacity: 0
        });
        var a = isNaN(this.setting.scrollto) ? this.setting.scrollto : parseInt(this.setting.scrollto);
        a = "string" == typeof a && 1 === jQuery("#" + a).length ? jQuery("#" + a).offset().top : 0, this.$body.animate({
            scrollTop: a
        }, this.setting.scrollduration)
    },
    keepfixed: function() {
        var a = jQuery(window),
            b = a.scrollLeft() + a.width() - this.$control.width() - this.controlattrs.offsetx,
            c = a.scrollTop() + a.height() - this.$control.height() - this.controlattrs.offsety;
        this.$control.css({
            left: b + "px",
            top: c + "px"
        })
    },
    togglecontrol: function() {
        var a = jQuery(window).scrollTop();
        if (this.state.shouldvisible && !this.state.isvisible) {
            this.cssfixedsupport || this.keepfixed(), this.state.shouldvisible = a >= this.setting.startline, this.$control.stop().animate({
                opacity: 1
            }, this.setting.fadeduration[0]), this.state.isvisible = !0
        } else {
            this.cssfixedsupport || this.keepfixed(), this.state.shouldvisible = a >= this.setting.startline, this.state.shouldvisible === 0 && this.state.isvisible && (this.$control.stop().animate({
                opacity: 0
            }, this.setting.fadeduration[1]), this.state.isvisible = !1)
        }
    },
    init: function() {
        jQuery(document).ready(function(a) {
            var b = scrolltotop,
                c = document.getElementById;
            b.cssfixedsupport = !c || c && "CSS1Compat" === document.compatMode && window.XMLHttpRequest, b.$body = a(window.opera ? "CSS1Compat" === document.compatMode ? "html" : "body" : "html,body"), b.$control = a('<div class="bg top" id="top">' + b.controlHTML + "</div>").css({
                position: b.cssfixedsupport ? "fixed" : "absolute",
                bottom: b.controlattrs.offsety,
                right: b.controlattrs.offsetx,
                opacity: 0,
                cursor: "pointer"
            }).attr({
                title: "Back to Top"
            }).click(function() {
                return b.scrollup(), !1
            }).appendTo("body"), document.getElementById && !window.XMLHttpRequest && "" !== b.$control.text() && b.$control.css({
                width: b.$control.width()
            }), b.togglecontrol(), a('a[href="' + b.anchorkeyword + '"]').click(function() {
                return b.scrollup(), !1
            }), a(window).bind("scroll resize", function() {
                b.togglecontrol()
            })
        })
    }
};

jQuery(window).bind("load", function() {

    scrolltotop.init();

});