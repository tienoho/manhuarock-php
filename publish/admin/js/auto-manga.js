$( document ).ready(function() {
    $(".open-ajax-modal").on('click', function () {
        var template = $(this).data('template');

        getTemplate(template, openModalAjax)
    })
});


function getTemplate(template, callback, data = {}){
    $.get(base_url + '/ajax-template/' + template, data).done(callback);
}

function openModalAjax(response){
    var $modal_content = $('#modal-ajax-content').html(response);

    var $modal = $modal_content.find("#modal-ajax");

    $modal.modal('show');
}