var comment_loaded = false

jQuery(document.documentElement).ready(function () {

    jQuery(window).bind("load", function() {
        is_loadedComment()
    });

    // Add Emo
    jQuery('body').delegate('.emo-expand .emo-item', 'click', function () {
        jQuery(this).parents('.wrap-form-binhluan').find('.comment_content').append($(this).html());
    });

    // Show List Reply
    jQuery(document).on("click", ".view-replies", function (event) {
        event.preventDefault();
        if (jQuery(this).data('action') == 'click'){
            listReply(this)
        }
        jQuery(this).data('action','clicked')
    })

    // Show Form Reply
    jQuery(document).on("click", ".reply-comment", function (event) {
        event.preventDefault();
        let parent_comment = jQuery(this).parents(".comment_item")
        let reply_from = parent_comment.find(".reply-from")
        if(!reply_from.html()){
            reply_from.html(reply_template(parent_comment.data('id')))
        } else {
            reply_from.html('')
        }
        console.log('Đã click reply')
    });

    // Close Form Reply
    jQuery(document).on("click", ".close-reply", function (event){
        event.preventDefault();
        jQuery(this).parents(".comment_item").find(".reply-from").html('')
        console.log('Đã click close')

    })

    // Send Comment
    jQuery(document).on("click", ".send-comment", function (event){
        event.preventDefault();
        if(!is_login()){
            return alert(lang.MustBeLogin)
        }

        let from_comment = jQuery(this).parents("#khungpostcomment")
        let content = from_comment.find(".comment_content").html()

        if(content.length < 1){
            alert('Không được để trống bình luận')
            return false;
        }

        jQuery.ajax({
            url: "/api/manga/add-comment",
            dataType: "json",
            type: 'POST',
            data: {
                token: csrf_token,
                manga_id: manga_id,
                content: content
            }
        }).done(function (response) {
            if(response.success) {
                jQuery("ul.list_comment").prepend(response.data.content)
                from_comment.find(".comment_content").html("")

                return true;
            } else {
                alert(response.data.content)
            }

        }).fail(function (erro) {
            console.log(erro)
        })

        console.log('Đã click post comment')

    })

    // Send Reply
    jQuery(document).on("click", ".send-reply", function (event){
        event.preventDefault();
        if(!is_login()){
            return alert(lang.MustBeLogin)
        }

        let from_reply = jQuery(this).parents(".comment_item")
        content = from_reply.find(".comment_content").html()
        parent_id = from_reply.data('id')
        if(content.length < 1){
            alert('Không được để trống bình luận')
            return false;
        }

        jQuery.ajax({
            url: "/api/manga/add-reply-comment",
            dataType: "json",
            type: 'POST',
            data: {
                token: csrf_token,
                manga_id: manga_id,
                content: content,
                parent_id: parent_id
            }
        }).done(function (response) {
            if(response.success) {
                from_reply.find(".replies-comments").prepend(response.data.content)
                from_reply.find(".comment_content").html("")
                return true;
            } else {
                alert(response.data.content)
            }

        }).fail(function (erro) {
            console.log(erro)
        })

        console.log('Đã click post comment')

    })

    // See More Comment
    jQuery(document).on("click", ".see-more-comments", function (event) {
        event.preventDefault();
        page = jQuery(this).find('a').attr('href')
        jQuery(".comment-loader").find(".loader-icon").show()
        listComment(page)
    })

    // See More Reply
    jQuery(document).on("click", ".see-more-replies", function (event) {
        event.preventDefault();
        page = jQuery(this).find('a').attr('href')
        listReply(this, page)
    })
});

function is_loadedComment(){
    if(comment_loaded === false){
        comment_loaded = true;
        setTimeout(() => {
            listEmo()
            listComment();
        }, 3000);
    }
}

function listEmo(){
    jQuery.get( "/api/manga/emo-comment", function( data ) {
        jQuery( ".emo-box" ).html( data );
    });
}

function listComment(page) {
    var list_comment = jQuery("ul.list_comment");
    jQuery(".comment-loader").find(".loader-icon").hide()
    page = page ? '?page=' + page: ''

    jQuery.ajax({
        url: "/api/manga/list-comment" + page,
        dataType: "json",
        type: 'POST',
        data: {
            token: csrf_token,
            manga_id: manga_id
        }
    }).done(function (response) {
        list_comment.append(response.data.content)

        if(response.data.next_page){
            list_comment.parents("#binhluan_section").find(".see-more-comments").html(`<a style="display: block; text-align: center;" href="${response.data.next_page}" data-id="${manga_id}">Xem thêm...</a>`)
        } else {
            list_comment.parents("#binhluan_section").find(".see-more-comments").html("")
        }

    }).fail(function (erro) {
        console.log(erro)
    });
}

function listReply(view, page){
    let parent_comment = jQuery(view).parents(".parents_item")
    let parent_id = parent_comment.data("id")
    console.log(parent_comment.html())

    page = page ? '&page=' + page: ''
    jQuery.ajax({
        url: "/api/manga/list-comment?parent_id=" + parent_id + page,
        dataType: "json",
        type: 'POST',
        data: {
            token: csrf_token,
            manga_id: manga_id
        }
    }).done(function (response) {
        jQuery(parent_comment).find(".replies-comments").append(response.data.content)

        if (response.data.next_page) {
            jQuery(parent_comment).find(".see-more-replies").html(`<a style="display: block;text-align: center;border-top: solid 1px #eee;padding-top: 10px;" href="${response.data.next_page}" data-id="${parent_id}">Xem thêm trả lời...</a>`)
        } else {
            jQuery(parent_comment).find(".see-more-replies").html("")
        }

        //jQuery(this).remove()

    }).fail(function (e) {
        console.log(e)
    })
}

function reply_template(id) {
    var emoj = jQuery('#khungpostcomment .emo-box').html();
    return `<div class="wrap-form-binhluan post_comment_reply" data-id="${id}">
        <div class="comment-head" style="padding-bottom: inherit;">
        <a class="close-reply">Đóng <span class="ico-close"></span></a>
        </div> ${emoj}
           <div class="comment_content" contenteditable="true" id="reply_content" data-placeholder="Nội dung thần thức..."></div> 
           <div class="binhluan-button">
              <div class="hint"> Lưu ý: Nội dung bình luận không vượt quá 500 ký tự </div>
              <button class="btn-button send-reply" type="button">Gửi <span class="ico-send"></span></button>
              <br class="clear">
           </div>
        </div>`
}






