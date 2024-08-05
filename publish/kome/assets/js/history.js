if (typeof (Storage) !== 'undefined') {
     var manga_history = localStorage.getItem('manga_history');

    manga_history = JSON.parse(manga_history)
    if(manga_history){
        manga_history = manga_history.reverse();
    }
    // console.log(manga_history)
}


function getHistorys(page, template, page_size = 12) {
    let data = [];
    if(manga_history){
        data = paginate(manga_history, page_size, page)
    }

    if(data.length === 0){
        $("#history_loading").attr('style','display:none !important');
        return;
    }

    $.post('/api/get-mangas?template=' + template, {data : JSON.stringify(data)}, function (res) {
        $("#history_loading").attr('style','display:none !important');

        $("#history_content").append(res);
    });
}


function paginate(array, page_size, page_number) {
    // human-readable page numbers usually start with 1, so we reduce 1 in the first argument
    return array.slice((page_number - 1) * page_size, page_number * page_size);
}