var cmSort = "newest", commentLoading = false;

$(document).on('click', '#cm-view-more', function () {
    if (!commentLoading) {
        commentLoading = true;
        const el = $(this);
        const page = $(this).data('page');
        $.get('/ajax/comment/list/' + mangaId + '?page=' + page + '&sort=' + cmSort, function (res) {
            commentLoading = false;
            if (res && res.status) {
                res.nextPage > 0 ? el.data('page', res.nextPage) : el.remove();
                $('.cw_list').append(res.html);
            }
        });
    }
});

$(document).on('click', '.cm-sort', function () {
    if (!commentLoading) {
        commentLoading = true;
        $('.cm-sort').removeClass('active');
        $('.cm-sort .fa-check').hide();
        $(this).addClass('active');
        $(this).find('.fa-check').show();

        cmSort = $(this).data('value');
        getCommentWidget();
    }
})
$(document).on('click', '.btn-spoil', function () {
    $(this).toggleClass("active");
});
$(document).on('click', '.cm-btn-show-rep', function () {
    const id = $(this).data('id');
    $(this).toggleClass("active");
    $('#replies-' + id).slideToggle(200);
});
$(document).on('click', '.show-spoil', function () {
    $(this).hide();
    $(this).parent().removeClass('is-spoil');
});
$(document).on('click', '.ib-reply,.btn-close-reply', function () {
    if (checkLogin()) {
        $('#reply-' + $(this).data('id')).slideToggle(100);
    }
});
$(document).on('focus', '#df-cm-content', function () {
    if (checkLogin()) {
        $('#df-cm-buttons').slideDown(100);
    }
});
$(document).on('click', '#df-cm-close', function () {
    $('#df-cm-buttons').slideUp(100);
});
$(document).on('click', '.cm-btn-vote', function () {
    if (checkLogin()) {
        if (!commentLoading) {
            commentLoading = true;
            const el = $(this);
            const type = parseInt(el.data('type')), id = el.data('id');

            const elCurrentVote = $('.cm-btn-vote[data-id=' + id + '].active');
            if (elCurrentVote.length > 0 && parseInt(elCurrentVote.data('type')) !== type) {
                elCurrentVote.removeClass('active');
                var elCurrentVoteValue = parseInt(elCurrentVote.find('.value').text());
                if (elCurrentVoteValue > 0) {
                    elCurrentVoteValue = elCurrentVoteValue - 1;
                    elCurrentVote.find('.value').text(elCurrentVoteValue > 0 ? elCurrentVoteValue : "");
                }
            }

            el.toggleClass("active");
            var value = parseInt(el.find('.value').text());
            if (value > 0) {
                value = el.hasClass('active') ? (value + 1) : (value - 1);
            } else {
                value = 1;
            }
            el.find('.value').text(value > 0 ? value : "");

            $.post('/ajax/comment/vote', { id, type }, function (res) {
                commentLoading = false;
            })
        }
    }
});
$(document).on('submit', '.comment-form', function (e) {
    e.preventDefault();
    if (!commentLoading) {
        commentLoading = true;
        const el = $(this);
        const loadingEl = $(this).find('.loading-absolute');
        loadingEl.show();
        var data = $(this).serializeArray();
        data.push({ name: "manga_id", value: mangaId });
        data.push({ name: "chapter_id", value: readingId });
        data.push({ name: "is_spoil", value: $('.btn-spoil').hasClass('active') ? 1 : 0 });
        $.post('/ajax/comment/add', data, function (res) {
            commentLoading = false;
            loadingEl.hide();
            if (res && res.status) {
                if (parseInt(res.parentId) > 0) {
                    const repliesEl = $('#cm-' + res.parentId + ' .replies');
                    if (repliesEl.length > 0) {
                        repliesEl.html(res.html);
                    } else {
                        $('#cm-' + res.parentId).append('<div class="replies">' + res.html + '</div>');
                    }
                    $('#replies-' + res.parentId).slideToggle(100);
                    $('#reply-' + res.parentId).slideToggle(100);
                } else {
                    $('#df-cm-buttons').slideUp(100);
                    $('.cw_list').html(res.html);
                }
                el[0].reset();
                el.find('.btn-spoil').removeClass('active');
            }
        });
    }
})

function getCommentWidget() {
    var ajaxUrl = `/ajax/comment/widget/${mangaId}?sort=${cmSort}`;
    if (currentUrl.search) {
        const urlParams = new URLSearchParams(currentUrl.search);
        if (urlParams.get('c_id')) {
            $('body').addClass('show-comment');
            ajaxUrl = `${ajaxUrl}&cid=${urlParams.get('c_id')}`;
        }
    }
    $.get(ajaxUrl, function (res) {
        commentLoading = false;
        $('#content-comments').html(res.html);
        if (res.gotoId) {
            const cmEl = $('#cm-' + res.gotoId);
            cmEl.addClass('comment-focus');
            const parentId = cmEl.data('parent-id');
            if (parentId) {
                $('.cm-btn-show-rep[data-id=' + cmEl.data('parent-id') + ']').click();
                if ($('#replies-' + parentId + ' .cw_l-line').length > 1) {
                    $('.comments-wrap').scrollTo($('#cm-' + res.gotoId).prev(), { duration: 300 });
                }
            }
        }
    });
}