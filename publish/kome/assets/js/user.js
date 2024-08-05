$(document.documentElement).ready(function () {
    jQuery("#isRemember").on('click',function (e){

        var isRemember = $(this);
        if(isRemember.is(":checked")){
            isRemember.val(1);
        } else {
            isRemember.val(2);
        }

    });
});


function ajaxSubmit(elm){
    var frm = $(elm);

    frm.submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
            success: function (data) {
                var ref = document.referrer;
                if (data.status) {
                    if (ref.indexOf(window.location.host)) {
                        window.location.href = ref;
                    } else {
                        window.location.href = window.location.host;
                    }
                } else {
                    alert(data.msg)
                }

            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);
            },
        });
    });
}