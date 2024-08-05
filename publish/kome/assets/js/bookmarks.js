jQuery("#btn_theodoitruyen, #btntheodoi").on('click', function(event) {
    event.preventDefault()

    if(!is_login()){
        return alert(lang.MustBeLogin)
    }

    const kt = this
    const tb = jQuery("#total-bookmark")
    const action = jQuery(kt).attr('action')
    const total_bookmark = tb.attr('total') * 1


    jQuery.post('/ajax/reading-list/add?type='+ (action === "bookmark" ? 1 : 0) +'&page=detail&mangaId=' + manga_id, function (response) {
        if(action === "bookmark") {
            jQuery(kt).attr("action", "unbookmark")
            if(typeof chapter_id === 'undefined' || chapter_id === null) {
                jQuery(kt).removeClass("btn-primary").addClass("btn-activered");
                jQuery(tb).attr("total", total_bookmark + 1).html(total_bookmark + 1)
            } else if( manga_id && !chapter_id){
                jQuery(kt).removeClass("btn-info").addClass("btn-success");
            }
            jQuery(kt).html(jQuery(kt).html().replace(lang.Bookmark, lang.UnBookmark))

            console.log('Đã click theo dõi ' + response)
        }
        else if(action === 'unbookmark') {
            jQuery(kt).attr('action', "bookmark")
            if(typeof chapter_id === 'undefined' || chapter_id === null) {
                jQuery(kt).removeClass('btn-activered').addClass('btn-primary');
                jQuery(tb).attr("total", total_bookmark - 1).html(total_bookmark - 1)
            } else {
                jQuery(kt).removeClass("btn-success").addClass("btn-info");
            }

            jQuery(kt).html(jQuery(kt).html().replace(lang.UnBookmark, lang.Bookmark))

            console.log('Đã click bỏ theo dõi ' + response)
        }
    })

});

$.get('/ajax/reading-list/info/' + manga_id, function (res) {
    if(res.data.type === 1){
        var $kt = $("#btn_theodoitruyen, #btntheodoi");
        $kt.attr("action", "unbookmark")

        if(typeof chapter_id === 'undefined' || chapter_id === null) {
            $kt.removeClass("btn-primary").addClass("btn-activered");
        } else {
            $kt.removeClass("btn-info").addClass("btn-success");
        }

        $kt.html($kt.html().replace(lang.Bookmark, lang.UnBookmark))
    }
})