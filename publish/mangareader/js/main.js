var isLoading = false, clickedRecaptcha = false;
toastr.options.positionClass = 'toast-bottom-right';
var loadedRecaptcha = false;

var forgotRecaptcha, registerRecaptcha, malImportRecaptcha;

const getScript = (url) => {
    var script = document.createElement('script');
    script.src = url;
    document.head.appendChild(script);
}


const loadCapcha = () => {
    setTimeout(function () {
        if (!loadedRecaptcha) {
            $.getScript("https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit")
                .done(function (script, textStatus) {
                    if (typeof grecaptcha !== "undefined") {
                        grecaptcha.ready(() => {
                            if ($('#forgot-recaptcha').length > 0) {
                                forgotRecaptcha = grecaptcha.render('forgot-recaptcha', {
                                    'sitekey': recaptchaV2SiteKey,
                                    'callback': function () {
                                        clickedRecaptcha = true;
                                    }
                                });
                            }
                            if ($('#register-recaptcha').length > 0) {
                                registerRecaptcha = grecaptcha.render('register-recaptcha', {
                                    'sitekey': recaptchaV2SiteKey,
                                    'callback': function () {
                                        clickedRecaptcha = true;
                                    }
                                });
                            }
                            if ($('#malImport-recaptcha').length > 0) {
                                malImportRecaptcha = grecaptcha.render('malImport-recaptcha', {
                                    'sitekey': recaptchaV2SiteKey,
                                    'callback': function () {
                                        clickedRecaptcha = true;
                                    }
                                });
                            }
                        });
                    }
                    loadedRecaptcha = true;
                    console.log('test')

                });
        }
    }, 500);
}


function checkLogin() {

    if (!isLoggedIn) {
        loadCapcha()
        $('#modal-auth').modal('show');
    }
    return isLoggedIn;
}

function paginationGetData(el) {
    const container = $(el).attr('data-container');
    $(container).find('.loading-relative').show();
    $.get($(el).attr('data-url'), function (res) {
        $(container).html(res.html);
        $(container).find('.loading-relative').hide();
    });
}

function voteInfo() {
    $.get('/ajax/vote/info/' + mangaId, function (res) {
        // $('#vote-loading').hide();
        if (res.status) $('#vote-info').html(res.html);
    });
}

function voteSubmit(data) {
    if (!isLoading) {
        isLoading = true;
        $.post('/ajax/vote/submit', data, function (res) {
            // $('#vote-loading').hide();
            if (res.redirectTo) {
                window.location.href = res.redirectTo;
            }
            if (res.status) {
                $('#vote-info').html(res.html);
                toastr.success(res.msg, "", { timeOut: 5000 });
            } else {
                toastr.error(res.msg, '', { timeOut: 5000 });
            }
            isLoading = false;
        });
    }
}

function readingListInfo(page) {
    $.get('/ajax/reading-list/info/' + mangaId + '?page=' + page, function (res) {
        if (res.status) $('#reading-list-info').html(res.html);
    });
}

function readingListSubmit(data) {
    if (!isLoading) {
        isLoading = true;
        $.post('/ajax/reading-list/add', data, function (res) {
            if (res.redirectTo) {
                window.location.href = res.redirectTo;
            }
            if (res.status) {
                toastr.success(res.msg, 'Success', { timeOut: 5000 });
                if (['detail', 'read'].indexOf(data.page) >= 0) {
                    $('#reading-list-info').html(res.html);
                } else if (data.page === 'reading-list') {
                    window.location.reload();
                }
            } else {
                toastr.error(res.msg, '', { timeOut: 5000 });
            }
            isLoading = false;
        });
    }
}

function compareValues(key, order = 'asc') {
    return function innerSort(a, b) {
        if (!a.hasOwnProperty(key) || !b.hasOwnProperty(key)) {
            // property doesn't exist on either object
            return 0;
        }

        const varA = (typeof a[key] === 'string')
            ? a[key].toUpperCase() : a[key];
        const varB = (typeof b[key] === 'string')
            ? b[key].toUpperCase() : b[key];

        var comparison = 0;
        if (varA > varB) {
            comparison = 1;
        } else if (varA < varB) {
            comparison = -1;
        }
        return (
            (order === 'desc') ? (comparison * -1) : comparison
        );
    };
}

$(document).ready(function () {
    $("#modal-auth").one('click', function () {
        loadCapcha()
    })
    $('body').tooltip({ selector: '[data-toggle="tooltip"]' });

    $(".im-toggle").click(function (e) {
        $(".c_b-list").toggleClass("active");
    });
    
    $("#mobile_menu").click(function (e) {
        $("#sidebar_menu, #mobile_menu").toggleClass("active");
        $("#sidebar_menu_bg").addClass("active");
        $("#search-toggle, #search, #header").removeClass("active");
        $("body").toggleClass("body-hidden");
    });

    $(".toggle-sidebar, #sidebar_menu_bg").click(function (e) {
        $("#sidebar_menu, #mobile_menu, #sidebar_menu_bg, #search-toggle, #search, #header").removeClass("active");
        $("body").removeClass("body-hidden");
    });

    $("#mobile_search").click(function (e) {
        $("#search").toggleClass("active");
    });

    $(".nav-more .nav-link").click(function (e) {
        $("#sidebar_menu .sidebar_menu-list > .nav-item .nav").toggleClass("active");
    });
    $(".detail-extend-toggle").click(function (e) {
        $(".detail-extend").toggleClass("active");
    });
    $(".cbox-genres .btn-showmore").click(function (e) {
        $(".cbox-genres").toggleClass("active");
    });
    $(".toggle-onoff").click(function (e) {
        $(this).toggleClass("active");
    });
    $(".pc-fav").click(function (e) {
        $(this).toggleClass("active");
    });
    $(".register-tab-link").click(function (e) {
        $("#modal-tab-register").addClass("active show");
        $("#modal-tab-login").removeClass("active show");
    });
    $(".forgot-tab-link").click(function (e) {
        $("#modal-tab-forgot").addClass("active show");
        $("#modal-tab-login").removeClass("active show");
    });
    $(".login-tab-link").click(function (e) {
        $("#modal-tab-login").addClass("active show");
        $("#modal-tab-register, #modal-tab-forgot").removeClass("active show");
    });
    $(document).on('mouseover', '.header_menu-list .nav-item', function () {
        $(this).find('.header_menu-sub').show();
    })
    $(document).on('mouseout', '.header_menu-list .nav-item', function () {
        $(this).find('.header_menu-sub').hide();
    });
    $('a[href*="#"].smoothlink')
        // Remove links that don't actually link to anything
        .not('[href="#"]')
        .not('[href="#0"]')
        .click(function (event) {
            // On-page links
            if (
                location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '')
                &&
                location.hostname == this.hostname
            ) {
                // Figure out element to scroll to
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                // Does a scroll target exist?
                if (target.length) {
                    // Only prevent default if animation is actually gonna happen
                    event.preventDefault();
                    $('html, body').animate({
                        scrollTop: target.offset().top
                    }, 300, function () {
                        // Callback after animation
                        // Must change focus!
                        var $target = $(target);
                        $target.focus();
                        if ($target.is(":focus")) { // Checking if the target was focused
                            return false;
                        } else {
                            $target.attr('tabindex', '-1'); // Adding tabindex for elements not focusable
                            $target.focus(); // Set focus again
                        }
                        ;
                    });
                }
            }
        });


    $('#login-form').submit(function (e) {
        e.preventDefault();

        if (!isLoading) {
            isLoading = true;
            $('#login-loading').show();
            $('#login-error').hide();
            var data = $(this).serializeArray();

            $.post('/ajax/auth/login', data, function (res) {
                $('#login-loading').hide();
                isLoading = false;
                if (res.status) {
                    $('#modal-auth').modal('hide');
                    toastr.success(res.msg, '', { timeout: 5000 });
                    window.location.reload();
                } else {
                    $('#login-error').html(res.msg);
                    $('#login-error').show();
                }
            });
        }
    });
    $('#register-form').submit(function (e) {
        e.preventDefault();

        if (!isLoading) {
            isLoading = true;
            $('#register-loading').show();
            $('#register-error').hide();
            var data = $(this).serializeArray();
            $.post('/ajax/auth/register', data, function (res) {
                $('#register-loading').hide();
                isLoading = false;
                if (res.status) {
                    $('#modal-auth').modal('hide');
                    toastr.success(res.msg, '', { timeout: 5000 });
                    window.location.reload();
                } else {
                    $('#register-error').html(res.msg);
                    $('#register-error').show();
                    setTimeout(function () {
                        $('#register-error').hide();
                    }, 5000);
                }
                grecaptcha.reset(registerRecaptcha);
            });
        }
    });
    $('#forgot-form').submit(function (e) {
        e.preventDefault();

        if (!isLoading) {
            $('#forgot-loading').show();
            $('#forgot-error').hide();
            $('#forgot-success').hide();
            var data = $(this).serializeArray();
            $.post('/ajax/auth/reset-password', data, function (res) {
                $('#forgot-loading').hide();
                isLoading = false;
                if (res.status) {
                    $('#forgot-form').trigger("reset");
                    $('#forgot-success').html(res.msg);
                    $('#forgot-success').show();
                } else {
                    $('#forgot-error').html(res.msg);
                    $('#forgot-error').show();
                }
                setTimeout(function () {
                    $('#forgot-error').hide();
                    $('#forgot-success').hide();
                }, 5000);
                grecaptcha.reset(forgotRecaptcha);
            });
        }
    });
});

$(document).on('click', '.btn-remove-cr', function () {
    var id = $(this).data('id');
    $('#cr-loading-' + id).show();
    $.post('/ajax/continue-reading/remove', { id }, function (res) {
        if (res.status) {
            $('#manga-continue').length > 0 ? getContinueReadingHome() : window.location.reload();
            toastr.success(res.msg, '', { timeOut: 5000 });
        } else {
            toastr.error(res.msg, '', { timeOut: 5000 });
        }
    })
})

$(document).on('click', '.cm-report', function () {
    if (checkLogin()) {
        var id = $(this).data('id'), type = $(this).data('type');
        $.post('/ajax/comment/report', { id, type }, function (res) {
            toastr.success(res.msg, '', { timeOut: 5000 });
        })
    }
})

// js search
var hideResults = true, timeout = null;
$('#search-suggest').mouseover(function () {
    hideResults = false;
});
$('#search-suggest').mouseout(function () {
    hideResults = true;
});
$('.search-input').keyup(function (e) {
    if (!$(this).hasClass('no-suggest')) {
        var keycode = (e.keyCode ? e.keyCode : e.which);
        if ([13, 32].indexOf(keycode) < 0) {
            if (timeout != null) {
                clearTimeout(timeout);
            }
            timeout = setTimeout(function () {
                timeout = null;
                var keyword = $('.search-input').val().trim();
                if (keyword.length > 1) {
                    $('#search-suggest').show();
                    $('#search-loading').show();
                    $.get("/ajax/manga/search/suggest?keyword=" + keyword, function (res) {
                        if (res) {
                            $('#search-suggest .result').html(res.html);
                            $('#search-suggest .result').slideUp('fast');
                            $('#search-suggest .result').slideDown('fast');
                            $('#search-loading').hide();
                        }
                    });
                } else {
                    $('#search-suggest .result').empty();
                }
            }, 500);
        }
    }
});
$('.search-input').blur(function () {
    if (hideResults) {
        $('#search-suggest').slideUp('fast');
    }
});
$('.search-input').focus(function () {
    $('#search-suggest').slideDown('fast');
});
$('.search-submit .search-icon').click(function () {
    $('#search-home-form .search-input').val().trim().length > 0 && $('#search-home-form').submit();
})

// js search chapter & volume
$(document).on('keyup', '.search-reading-item', function (e) {
    if (e.keyCode !== 13) {
        var number = $(this).val();
        $('.reading-item').removeClass('highlight');
        if (number) {
            var elFound = $('.reading-list.active .reading-item[data-number="' + number + '"]');
            if (elFound.length > 0) {
                elFound.addClass('highlight');
                $('.reading-list.active').scrollTo(elFound, { duration: 300 });
            }
        } else {
            if ($('.reading-item.active').length > 0) {
                $('.reading-list.active').scrollTo('.reading-item.active', { duration: 300 });
            } else {
                $('.reading-list.active').scrollTo(0, { duration: 300 });
            }
        }
    }
});
$(document).on('submit', '.search-reading-item-form', function (e) {
    e.preventDefault();
    $('.reading-item.highlight').click();
    $('.reading-item').removeClass('highlight');
    $('.search-reading-item').val('');
});

// js page detail & read
const mangaId = $('#wrapper').data('manga-id') || null;

$('#modalcharacters').on('shown.bs.modal', function () {
    $.get('/ajax/character/list/' + mangaId, function (res) {
        if (res.status) {
            $('#characters-content').html(res.html);
        }
    });
});

$(document).on("click", ".rl-item", function () {
    if (checkLogin()) {
        const type = $(this).data('type'), mangaId = $(this).data('manga-id'), page = $(this).data('page');
        if (typeof grecaptcha !== 'undefined') {
            grecaptcha.execute(recaptchaV3SiteKey, { action: 'reading_list' }).then(function (_token) {
                readingListSubmit({ mangaId, type, page, _token });
            })
        } else {
            readingListSubmit({ mangaId, type, page, _token: '' });
        }
    }
});


$(document).on("click", ".btn-vote", function () {
    if (checkLogin()) {
        $('#vote-loading').show();
        var mark = $(this).data('mark');
        if (typeof grecaptcha !== 'undefined') {
            grecaptcha.execute(recaptchaV3SiteKey, { action: 'vote' }).then(function (_token) {
                voteSubmit({ mangaId, mark, _token });
            })
        } else {
            voteSubmit({ mangaId, mark, _token: '' });
        }
    }
});

if ($('#comment-widget').length > 0) {
    $.get('/ajax/comment/widget-home', function (res) {
        $('#comment-widget').html(res.html);
    })
}

$(document).on('click', '.notify-seen-all', function (e) {
    if (checkLogin()) {
        var position = $(this).data('position');

        $.post('/ajax/notification/seen-all', function (res) {
            if (res.status) {
                toastr.success(res.msg, 'Success', { timeOut: 5000 });
                if (position === 'header') {
                    $('.nnl-item').removeClass('new');
                    $('#notify-number').remove();
                } else {
                    window.location.reload();
                }
            } else {
                toastr.error(res.msg, '', { timeOut: 5000 });
            }
            if (res.redirectTo) {
                window.location.href = res.redirectTo;
            }
        });
    }
});