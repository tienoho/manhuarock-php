$(document).ready(function () {
    $(".baoloibutton").on('click', function (event) {
        event.preventDefault()
        var content = jQuery("#motabaoloi").val();
        if ("" === content) {
            alert("Bạn chưa nhập lỗi gặp phải!")
        } else {
            event.preventDefault()
            jQuery.ajax({
                url: "/api/report/chapter",
                type: "POST",
                dataType: "html",
                data: {
                    content: content,
                    chapter_id: chapter_id
                },
                success: function () {
                    jQuery("#motabaoloi").val("")
                    jQuery("#baoloi").modal("hide")
                    jQuery("#report_error").fadeOut(2e3)
                }
            })
        }
    });

    $(document.documentElement).keyup(function (e) {
        if (e.keyCode == 37) {
            console.log('Prev');
            jQuery(".changeChap.prev")[0].click();

        } else if (e.keyCode == 39) {
            console.log('Next');
            jQuery(".changeChap.next")[0].click();
        }
    });

    if (typeof (Storage) !== 'undefined') {
        let manga_history = localStorage.getItem('manga_history');
        let isread = 'isread_' + chapter_id;
        if (!localStorage.getItem(isread)) {
            localStorage.setItem(isread, 1);
        }

        if (!manga_history) {
            manga_history = [];
        } else {
            manga_history = JSON.parse(manga_history)
            let max_item = 100;
            manga_history = manga_history.slice(manga_history.length - max_item, max_item);
        }

        manga_history.forEach(function (value, index) {
            if (value.manga_id !== undefined && value.manga_id === manga_id) {
                manga_history.splice(index, 1);
            }
        });

        manga_history.push({
            manga_id: manga_id,
            current_reading: {
                chapter_id: chapter_id,
                url: window.location.href,
                name: chapter_name
            }
        });

        localStorage.setItem('manga_history', JSON.stringify(manga_history));
    }
});

