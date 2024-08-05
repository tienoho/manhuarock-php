jQuery(document.documentElement).ready(function () {
    calcRate(rating_point);
    jQuery("#rating input").on('click', function (event) {
        event.preventDefault()

        if (!is_login()) {
            return alert(lang.MustBeLogin)
        }

        if (jQuery(this).prop("checked") === true) {
            var rating = jQuery(this).val()

            if (!localStorage.getItem('vote-' + manga_id)) {
                jQuery.post("/ajax/vote/submit", {mark: rating * 2, mangaId: manga_id}, function (response) {
                    calcRate(rating)
                    localStorage.setItem('vote-' + manga_id, '1');
                    console.log(response)
                });
            } else {
                calcRate(rating)
            }
        }
    });

    jQuery.fn.shorten = function (e) {
        var a = {
            maxHeight: 60,
            ellipsesText: "...",
            moreText: lang.See_more,
            lessText: lang.See_less
        };
        return e && $.extend(a, e), jQuery(document).off("click", ".morelink"), jQuery(document).on({
            click: function () {
                var e = jQuery(this);
                return e.hasClass("less") ? (e.removeClass("less"), e.html(a.moreText), e.prev().addClass("shortened")) : (e.addClass("less"), e.html(a.lessText), e.prev().removeClass("shortened")), !1
            }
        }, ".morelink"), this.each(function () {
            var e = $(this);
            e.hasClass("shortened") || e.height() > a.maxHeight && (e.addClass("shortened"), jQuery('<a href="#" class="morelink">' + a.moreText + "</a>").insertAfter(e))
        })
    },
        jQuery(".detail-content p").shorten();

    jQuery(".list-chap.view-more").on('click', function (event) {
        event.preventDefault()
        return jQuery(".chap-item.less").removeClass("less"), jQuery(this).remove(), !1;
    });

    $('#reverse-order').on('click', function () {
        $('#list-chapter').html($('ul#list-chapter').find('li.chap-item').get().reverse());
        return jQuery(".chap-item.less").removeClass("less"), jQuery(".list-chap.view-more").remove(), !1;

    });
});


function calcRate(rating) {
    var f = ~~rating,//Tương tự Math.floor(r): làm tròn
        id = 'star' + f + (rating % f ? 'half' : '')
    id && ((document.getElementById(id)) && (document.getElementById(id).checked = !0))
}

