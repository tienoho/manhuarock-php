

function is_login(){
    return (isLoggedIn === 1)
}

function createScript(url){
    var tag = document.createElement('script');
    tag.src = url, jQuery("head").append(tag)
}
function csrfSafeMethod(method) {
    /* these HTTP methods do not require CSRF protection */
    return (/^(GET|HEAD|OPTIONS|TRACE)$/.test(method));
}


function Dangxuat(){
    jQuery.post('/user/logout', function (res){
        if(res.status){
            location.reload();
        }
    });
}