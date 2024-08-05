function addtheloaisearch(slug, name) {
    var item, isAdd;
    isAdd = true;

    jQuery('.lst-loc li[data-type=tag]').each(function () {
        if(jQuery(this).data('id') === slug)
            return alert('Bạn đã chọn thể loại này rồi!');

        isAdd = true
    });
    isAdd && (
        item = '<li data-type="tag" onclick="removefilter($(this))" data-id="XX_ID_XX"><a class="btn-primary">' + '<i class="fa fa-tag" aria-hidden="true"></i> XX_NAME_XX &nbsp; &nbsp;' + '<i class="ico-close"></i>' + '</a></li>',
            jQuery(".lst-loc").prepend(item.replace('XX_ID_XX', slug).replace("XX_NAME_XX", name))
    )
}

function filter() {
    var tag = [], sort = 0, status = 0;
    jQuery('.lst-loc li[data-type]').each(function () {
        var ID = jQuery(this).data('id');
        jQuery(this).data('type') === 'tag' && (tag.push(ID));
        jQuery(this).data('type') === 'sort' && (sort = ID);
        jQuery(this).data('type') === 'status' && (status = ID);
    });
    var url = "/manga?status=" + status + '&sort=' + sort;
    // Nếu có thể loại
    tag.length > 0 && ( url = "/manga?status=" + status + '&sort=' + sort + "&genre[]=" + tag.join('&genre[]=') )
    location.href = url
}

function removefilter(item) {
    item.remove()
}

function addstatussearch(id, name) {
    $('.lst-loc li[data-type=status]').each(function () {
        $(this).remove()
    });
    var item = '<li data-type="status" onclick="removefilter($(this))" data-id="XX_ID_XX"><a class="btn-primary">' + '<i class="ico-signal" ></i> XX_NAME_XX <i class="ico-close"></i></a></li>';
    $('.lst-loc').append(item.replace('XX_ID_XX', id).replace('XX_NAME_XX', name))
}

function addsortsearch(t, x) {
    $('.lst-loc li[data-type=sort]').each(function () {
        $(this).remove()
    });
    var i = '<li data-type="sort" onclick="removefilter($(this))" data-id="XX_ID_XX"><a class="btn-primary">' + '<i class="ico-sort" ></i> XX_NAME_XX <i class="ico-close"></i></a></li>';
    $('.lst-loc')
        .append(i.replace('XX_ID_XX', t).replace("XX_NAME_XX", x))
}