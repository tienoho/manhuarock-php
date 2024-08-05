$(function () {
    $("#setting-form").submit(function (e) {

        e.preventDefault();

        let formData = $(this).serializeArray();
        let dataObj = {};

        $(formData).each(function (i, field) {
            dataObj[field.name] = field.value;
        });

        formData = JSON.stringify(dataObj);

        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: formData,
            processData: false,
            contentType: false,
        }).done(function () {
            $(document).Toasts('create', {
                class: 'bg-success m-1',
                title: 'Thông báo',
                body: 'Đã lưu cài đặt'
            });
        });


        console.log(formData)
        // console.log($(this).find())
    });

    $(".delete-report").on('click', function () {

        let report_id = $(this).data('id');

        $.post("/api/remove-report", {report_id: report_id}, function () {
            location.reload()
        })
    });

    $('#reset-cache').on('click', function () {
        let vm = $(this);
        vm.attr('disabled', 'disabled');
        $('#reset-cache-loading').show();

        $.post('/api/reset-cache', function () {
            vm.removeAttr('disabled')
            $('#reset-cache-loading').hide();

            $(document).Toasts('create', {
                class: 'bg-success m-1',
                title: 'Thông báo',
                body: 'Đã làm mới bộ nhớ đệm'
            });
        })
    });


    $('#submitleechthucong').on('click', function () {
        var site = $('#sitethucong').find(":selected").val(),
            urls = $('#listUrl').val()
        let vm = $(this);
        vm.attr('disabled', 'disabled');
        $('.scraper-loading').show();

        $.post('/api/run-scarper', {
            site: site,
            urls: urls
        }, function (data) {
            $('#scraper-response').html(data.response)
            vm.removeAttr('disabled')
            $('.scraper-loading').hide();

        })
    });

    $('#submitleechtudong').on('click', function () {
        var site = $('#sitetudong').find(":selected").val(),
            start = $('#page-start').val(),
            end = $('#page-end').val();
        let vm = $(this);
        vm.attr('disabled', 'disabled');
        $('.scraper-loading').show();

        $.post('/api/run-scarper', {
            site: site,
            start: start,
            end: end
        }, function (data) {
            $('#scraper-response').html(data.response)

            vm.removeAttr('disabled')
            $('.scraper-loading').hide();
        })
    });

    $("#submit-custom-ads").on('click', function () {
        $.post('/api/add-ads', {
            jshead: $('#jshead').val(),
            jsbody: $('#jsbody').val(),
        }, function () {
            $(document).Toasts('create', {
                class: 'bg-success m-1',
                title: 'Thông báo',
                body: 'Đã lưu cài đặt'
            });
        });
    });

    $("#submit-banner-ads").on('click', function () {
        $.post('/api/add-ads', {
            banner_ngang: $('#banner_ngang').val(),
            banner_sidebar: $('#banner_sidebar').val(),
        }, function () {
            $(document).Toasts('create', {
                class: 'bg-success m-1',
                title: 'Thông báo',
                body: 'Đã lưu cài đặt'
            });
        });
    })

    $("#submit-meta-setting").on('click', function (e) {
        e.preventDefault();

        var formData = $('#meta form').serializeArray(), dataObj = {};
        $(formData).each(function (i, field) {
            dataObj[field.name] = field.value;
        });

        $.post($('#meta form').attr('action'), dataObj, function () {
            $(document).Toasts('create', {
                class: 'bg-success m-1',
                title: 'Thông báo',
                body: 'Đã lưu cài đặt'
            });
        });

    });

    $("#submit-slug-setting").on('click', function (e) {
        e.preventDefault();

        let formData = $('#slug form').serializeArray(), dataObj = {};
        $(formData).each(function (i, field) {
            dataObj[field.name] = field.value;
        });

        $.post($('#slug form').attr('action'), dataObj, function () {
            $(document).Toasts('create', {
                class: 'bg-success m-1',
                title: 'Thông báo',
                body: 'Đã lưu cài đặt'
            });
        });

    });

    $(".delete-taxonomy").on('click', function(event){
        event.stopPropagation();
        event.stopImmediatePropagation();

        let $taxonomy_item = $(this).parents('.taxonomy-item'),
            taxonomy_id = $taxonomy_item.data('id');

        $.post('/api/delete-taxonomy', {
            taxonomy : taxonomy_id,
        }, function (){
            location.reload();
        })
    });

    $(".delete-comment").on('click', function(event){
        event.stopPropagation();
        event.stopImmediatePropagation();

        let $taxonomy_item = $(this).parents('.comment-item'),
            id = $taxonomy_item.data('id');

        $.post('/api/comment/delete/' + id, function (){
            location.reload();
        });
    });

    $(".edit-taxonomy").on('click', function(event){
        event.stopPropagation();
        event.stopImmediatePropagation();

        var id = $(this).data('id');

        $.get('/api/edit-taxonomy-template/' + id, function (data) {
            OpenAjaxModal(data);
        });
    });

    $('#add-taxonomy').on('click', function(event){
        event.stopPropagation();
        event.stopImmediatePropagation();

        var taxonomy = $(this).data('taxonomy');

        console.log(taxonomy)
        $.get('/api/add-taxonomy-template/' + taxonomy, function (data) {
            OpenAjaxModal(data);
        });
    });

});

function submitAjaxForm(){
    $("#AjaxSubmit").submit(function( event ){
        event.preventDefault();

        var data = $(this).serializeArray().reduce(function(obj, item) {
            obj[item.name] = item.value;
            return obj;
        }, {});

        var action = $(this).attr('action');

        $.post(action, data, function (res) {
            console.log(res);
        });
    });
}

function OpenAjaxModal(html){
    let modalPos = $('#modal-pos');

    modalPos.empty();

    modalPos.html(html)

    $("#ajax-modal").modal('show');
    submitAjaxForm();
}

function expandTextarea(id) {
    document.getElementById(id).addEventListener('keyup', function () {
        this.style.overflow = 'hidden';
        this.style.height = 0;
        this.style.height = this.scrollHeight + 'px';
    }, false);
}

