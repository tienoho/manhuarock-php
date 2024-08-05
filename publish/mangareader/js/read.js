var settings = { readingMode: null, readingDirection: 'rtl', quality: 'medium', hozPageSize: 1 };

const currentUrl = new URL(window.location.href);
const wWidth = (window.innerWidth > 0) ? window.innerWidth : screen.width;

function initSettings() {
    if (Cookies.get('mr_settings') || localStorage.getItem('settings')) {
        settings = Cookies.get('mr_settings') || localStorage.getItem('settings');
        settings = JSON.parse(settings);

    } else {
        saveSettings();
    }

}


function saveSettings() {
    $(".read_tool").removeClass("active");
    if (isLoggedIn) {
        $.post('/ajax/user/settings', { settings })
    }


    localStorage.setItem('settings', JSON.stringify(settings));
    Cookies.set('mr_settings', JSON.stringify(settings), { path: '/', expires: 365 });

    activeSettings();
}

initSettings();


var readingBy = $('#wrapper').data('reading-by');
var continueReading = null;
var firstLoad = true;
var isRead = false;
var currentImageIndex = 0, oldImageIndex = 0, totalImage = 0, numberImagesPreload = 4;
var touchstartX = 0, touchstartY = 0, touchendX = 0, touchendY = 0;

var gesturesZone = document.getElementById('images-content');

gesturesZone.addEventListener('touchstart', function (event) {
    touchstartX = event.touches[0].clientX;
    touchstartY = event.touches[0].clientY;
}, false);

gesturesZone.addEventListener('touchend', function (event) {
    touchendX = event.changedTouches[0].clientX;
    touchendY = event.changedTouches[0].clientY;
    // handleGestures();
}, false);

window.addEventListener('contextmenu', function (e) {
    e.preventDefault();
}, false);
window.addEventListener('dragstart', function (e) {
    e.preventDefault();
}, false);

window.addEventListener('resize', function () {
    // console.log("window resize")
    if (settings.readingMode === 'horizontal') {
        document.getElementById("main-wrapper").style.height = window.innerHeight + "px";
    }
});

window.addEventListener("orientationchange", function (event) {
    // console.log("orientation change")
    if (settings.readingMode === 'horizontal') {
        document.getElementById("main-wrapper").style.height = window.innerHeight + "px";
    }
});


document.addEventListener('keyup', function (e) {
    switch (e.key) {
        case 'ArrowRight': //next

            if (settings.readingMode == 'horizontal') {
                settings.readingDirection === 'ltr' ? hozNextImage() : hozPrevImage();
            } else {
                nextChapterVolume()
            }
            break
        case 'ArrowLeft': // prev
            if (settings.readingMode == 'horizontal') {
                settings.readingDirection === 'ltr' ? hozPrevImage() : hozNextImage();
            } else {
                prevChapterVolume()
            }
            break;
    }
})

var doc = document.documentElement;
var prevScroll = window.scrollY || doc.scrollTop;
var curScroll;
var direction = null;
var prevDirection = null;
var header = document.getElementById('wrapper');

function handleVerticalScroll() {
    $('.iv-card').each(function () {
        var number = $('.iv-card').index(this);
        if (isInViewport(this) && number !== currentImageIndex) {
            currentImageIndex = number;
            verShowImage();
        }
    });

    curScroll = window.scrollY || doc.scrollTop;
    direction = curScroll > prevScroll ? 'down' : 'up';
    prevScroll = curScroll;
    if (direction !== prevDirection) {
        if (direction === 'down' && curScroll > 52) {
            //replace 52 with the height of your header in px
            header.classList.add('top-hide');
            prevDirection = direction;
        } else if (direction === 'up') {
            header.classList.remove('top-hide');
            prevDirection = direction;
        }
    }
}


function hozShowImage() {
    if (totalImage - (currentImageIndex + 1) === 0) {
        var nextEl = $('.reading-item.active').prev();
        if (nextEl.length === 0) {
            $('.hoz-next').addClass('disabled');
            $('.hoz-next-hide').hide();
        }
    } else {
        $('.hoz-next').removeClass('disabled');
        $('.hoz-next-hide').show()
    }

    if (currentImageIndex === 0) {
        var prevEl = $('.reading-item.active').next();
        if (prevEl.length === 0) {
            $('.hoz-prev').addClass('disabled');
            $('.hoz-prev-hide').hide();
        }
    } else {
        $('.hoz-prev').removeClass('disabled');
        $('.hoz-prev-hide').show();
    }

    var el = document.getElementsByClassName("ds-item").item(currentImageIndex);
    $('.ds-item').removeClass('active');
    $('.ds-item').hide();
    $(el).addClass('active');
    $(el).show();

    $('.hoz-current-index').text((currentImageIndex + 1).toString().padStart(totalImage.toString().length, '0'));

    if (currentImageIndex < totalImage - 1) {
        for (var i = currentImageIndex; i <= currentImageIndex + numberImagesPreload + 1; i++) {
            if (i < totalImage - 1) {
                hozProcessingImage(i);
            }
        }

        for (var i = (totalImage - 2) > numberImagesPreload ? numberImagesPreload : (totalImage - 2); i > 0; i--) {
            var index = currentImageIndex - i;
            hozProcessingImage(index >= 0 ? index : i);
        }
    }
}

function verShowImage() {
    if (currentImageIndex <= totalImage - 1) {
        for (var i = currentImageIndex; i <= currentImageIndex + numberImagesPreload; i++) {
            if (i <= totalImage - 1) {
                verProcessingImage(i);
            }
        }

        for (var i = (totalImage - 1) > numberImagesPreload ? numberImagesPreload : (totalImage - 1); i > 0; i--) {
            var index = currentImageIndex - i;
            verProcessingImage(index >= 0 ? index : i);
        }
    }
}

function hozProcessingImage(index) {
    var el = document.getElementsByClassName("ds-image").item(index);
    if (!el.classList.contains('loaded')) {
        el.classList.add('loaded');
        createImageElement(el, $(el).data('url'), 'image-horizontal');
    }
    el.scrollIntoView();
}

function verProcessingImage(index) {
    var el = document.getElementsByClassName("iv-card").item(index);
    if (!el.classList.contains('loaded')) {
        el.classList.add('loaded');
        createImageElement(el, $(el).data('url'), 'image-vertical');
    }
}

function hozNextImage() {
    if (currentImageIndex < totalImage - 1) {

        const el = $($('.ds-image').get(currentImageIndex)).parent();
        currentImageIndex += el.is(':last-child') ? 1 : el.find('.ds-image').length;

        hozShowImage();
    } else {
        nextChapterVolume();
    }
}

function hozPrevImage() {
    if (currentImageIndex > 0) {
        const el = $($('.ds-image').get(currentImageIndex)).parent().prev();
        currentImageIndex -= el.is(':last-child') ? 1 : el.find('.ds-image').length;
        // console.log(`-> index after prev: ${currentImageIndex}`)
        hozShowImage();
    } else {
        prevChapterVolume();
    }
}


$(document).ready(function () {
    readingListInfo('read');

    $(document).on('click', '#vertical-content', function (e) {
        $('html, body').animate({
            scrollTop: $(window).scrollTop() + 350
        }, 300);
    });

    $(".im-toggle").click(function (e) {
        $(".c_b-list").toggleClass("active");
    })

    $(".ad-toggle").click(function (e) {
        $(".page-reader").toggleClass("pr-full");
    });

    $(".read-tips-follow").click(function (e) {
        $(this).hide();
    });
    $(".item-hide").click(function (e) {
        $(".read-tips-keyboard").addClass("rtk-hide");
    });
    $(".kb-icon").click(function (e) {
        $(".read-tips-keyboard").removeClass("rtk-hide");
    });
    $(".rc-close").click(function (e) {
        $("body").removeClass("show-comment");
    });
    $(".hr-setting, #rt-close").click(function (e) {
        $(".read_tool").toggleClass("active");
    });
    $(".hr-comment, .comment-bottom-button .btn").click(function (e) {
        $("body").toggleClass("show-comment");
    });
});



$(document).on('shown.bs.dropdown', '#dropdown-chapters,#dropdown-volumes', function () {
    $(this).find('.search-reading-item').focus();
    $('.reading-item.active').parent().scrollTo('.reading-item.active', { duration: 300 });
})

$(document).on('click', '.mode-item', function (e) {
    settings.readingMode = $(this).data('value');

    if (settings.readingMode === 'vertical') {
        $('body').addClass('page-reader-ver');
    } else {
        window.removeEventListener('scroll', handleVerticalScroll);
        $('body').removeClass('page-reader-ver');
    }

    $('.hr-setting').show();
    $('.mode-item').removeClass('active');
    $(this).addClass('active');

    $('#current-mode').text(settings.readingMode.charAt(0).toUpperCase() + settings.readingMode.slice(1));


    saveSettings();
    getImages();
});

$(document).on('click', '.quality-item', function (e) {
    settings.quality = $(this).data('value');
    $('.quality-item').removeClass('active');
    $(this).addClass('active');
    $('#current-quality').text($(this).text());
    saveSettings();
    getImages();
});

$(document).on('click', '.direction-item', function (e) {
    settings.readingDirection = $(this).data('value');
    $('.direction-item').removeClass('active');
    $(this).addClass('active');
    $('#current-direction').text($(this).text());
    $('.hoz-controls').hide();
    $('.hoz-controls-' + settings.readingDirection).show();
    $('#hoz-btn-next').removeClass('ltr');
    $('#hoz-btn-next').removeClass('rtl');
    $('#hoz-btn-next').addClass(settings.readingDirection);
    saveSettings();
});



$(document).on("click", ".reading-item", function (e) {
    e.preventDefault();
    $('.reading-item').removeClass('active');
    $(this).addClass('active');
    if (firstLoad) {
        firstLoad = false;
        history.pushState({}, '', $(this).find('a').attr('href') + currentUrl.search);
    } else {
        history.pushState({}, '', $(this).find('a').attr('href'));
    }

    var sortName = $(this).find('a').data('shortname');
    $('#current-chapter').text(sortName);

    readingId = $(this).data('id');

    getImages();
});

function activeSettings() {
    if (settings.readingMode) {
        settings.readingMode === 'vertical' ? $('body').addClass('page-reader-ver') : $('body').removeClass('page-reader-ver');

        $('.hr-setting').show();

        $('.mode-item[data-value=' + settings.readingMode + ']').addClass('active');

        $('#current-mode').text(settings.readingMode.charAt(0).toUpperCase() + settings.readingMode.slice(1));
        getChaptersOrVolumes();

    } else {
        $('#first-read').show();
        getChaptersOrVolumes();

    }

    $('.direction-item[data-value=' + settings.readingDirection + ']').addClass('active');
    $('#current-direction').text($('.direction-item.active').text());

    $('.quality-item[data-value=' + settings.quality + ']').addClass('active');
    $('#current-quality').text($('.quality-item.active').text());
}

activeSettings();

function resetWhenChangeChapVol() {
    if (settings.readingMode === 'vertical') {
        $(window).scrollTop(0);
    } else {
        currentImageIndex = 0;
    }
}

function nextChapterVolume() {
    resetWhenChangeChapVol();

    var nextChapEl = $('.reading-item.active').prev();
    if (nextChapEl.length > 0) {
        nextChapEl.click();
        return;
    }

    alert("Đã đọc đến chương mới nhất!")
}

function prevChapterVolume() {
    resetWhenChangeChapVol();

    var prevEl = $('.reading-item.active').next();
    if (prevEl.length > 0) {
        prevEl.click();
    }
}

var readingId = $('#wrapper').data('reading-id') || null, langCode = $('#wrapper').data('lang-code') || null;

if (readingBy) {
    var elReadingBy = $('.select-reading-by[data-value=' + readingBy + ']');
    elReadingBy.addClass('active');
    $('#reading-by').text(elReadingBy.text());
}


function getContinueReadingFromStorage() {
    try {
        var data = localStorage.getItem('mr_reading_' + mangaId);
        if (data) {
            data = JSON.parse(data);
            if (readingBy) {
                const type = readingBy === 'chap' ? 1 : 2;
                const foundIndex = data.findIndex(item => item.type === type);
                return foundIndex >= 0 ? data[foundIndex] : null;
            } else {
                data = data.sort(compareValues('updated_at', 'desc'));
                return data[0];
            }
        }
    } catch (e) {

    }
    return null;
}

function getChaptersOrVolumes() {
    $.get('/ajax/manga/reading-list/' + mangaId + '?readingBy=' + readingBy, function (res) {
        $('#reading-list').html(res.html);
        // res.settings && (settings = res.settings);
        continueReading = res.continueReading || getContinueReadingFromStorage();

        if (readingId === null) {
            if (continueReading) {
                readingBy = continueReading.type === 1 ? 'chap' : 'vol';
                readingId = continueReading.reading_id;
                langCode = continueReading.lang_code;
            } else {
                if (readingBy === '') readingBy = $('.select-reading-by').first().data('value');
                if (langCode === null) {
                    $('.lang-item[data-code=en]').length > 0 ? (langCode = 'en') : (langCode = $('.lang-item').first().data('code'));
                }
            }
        }

        changeReadingBy();
        $('.hr-navigation').show();
        $('.lang-item[data-code=' + langCode + ']').click();

        var elReadingItem = $('.reading-list.active .reading-item[data-id=' + readingId + ']');
        // console.log(elReadingItem)
        if (elReadingItem.length > 0) {
            elReadingItem.click();
        } else {
            $('.reading-list.active .reading-item').last().click();
        }
    });
}

function changeReadingBy() {
    var elReadingBy = $('.select-reading-by[data-value=' + readingBy + ']');
    $('.select-reading-by').removeClass('active');
    elReadingBy.addClass('active');
    $('#reading-by').text(elReadingBy.text());
}

function getImages() {
    if (settings.readingMode && readingId) {

        $.get('/ajax/image/list/' + readingBy + '/' + readingId + '?mode=' + settings.readingMode + '&quality=' + settings.quality, function (res) {
            if (continueReading && continueReading.reading_id === parseInt(readingId)) {
                currentImageIndex = parseInt(continueReading.image_number);
            }

            $('#images-content').html(res.html);

            if ($("#unlock-read").length > 0) {

                return;
            }


            if (settings.readingMode === 'horizontal') {

                if (currentImageIndex > 0) {
                    currentImageIndex--;
                }
                console.log(`-> Current image index: ${currentImageIndex}`)

                totalImage = $('.ds-image').length;

                currentImageIndex >= totalImage && (currentImageIndex = totalImage);

                $('.hoz-total-image').text(totalImage);

                $('.hoz-controls').hide();
                $('.hoz-controls-' + settings.readingDirection).show();

                hozElImageNext = $('.reading-item.active').prev();

                if (hozElImageNext.length > 0) {
                    $('#hoz-btn-next').addClass(settings.readingDirection);
                    const fullname = hozElImageNext.find('.name').text().split(':');
                    if (fullname.length > 1) {
                        $('#text-next').html(fullname[0] + '<div class="name-chapt">' + fullname[1] + '</div>');
                    } else {
                        $('#text-next').html(fullname[0]);
                    }
                } else {
                    $('#hoz-btn-next').hide();
                    $('#content-end').show();
                    $('#content-next').hide();
                }

                $('body').hasClass('page-reader-ver') && $('body').removeClass('page-reader-ver');

                const h = window.innerHeight;
                document.getElementById("main-wrapper").style.height = h + "px";
                hozShowImage();

            } else {
                totalImage = $('.iv-card').length;
                if (totalImage <= 0) {
                    return;
                }

                currentImageIndex >= totalImage && (currentImageIndex = totalImage - 1);

                $('.reading-list.active .reading-item').length === 1 && $('.mrt-bottom').hide();
                $('.reading-item.active').is(':last-child') && $('#ver-prev-cv').hide();
                $('.reading-item.active').is(':first-child') && $('#ver-next-cv').hide();

                if (parseInt($('.reading-item.active').data('reading-mode')) === 1) {
                    $('.container-reader-chapter').addClass('no-margin');
                }

                !$('body').hasClass('page-reader-ver') && $('body').addClass('page-reader-ver');

                verShowImage();

                window.addEventListener('scroll', handleVerticalScroll, { passive: true });


                var mangaNanmeItem = $('.manga-name:first-child');
                $('.chapter-name').text($('#current-chapter').text());
                $('.manga-name').text(mangaNanmeItem.text());
                $('.manga-name').parent().attr('href', mangaNanmeItem.parent().attr('href'));

                $(window).scrollTop(0);
            }

            isRead = false;

            setTimeout(function () {
                $.post('/ajax/manga/count-view/' + readingId);

                voteInfo();
            }, 1000 * 15);

        });


    }
}

const isInViewport = (element) => {
    const viewportHeight = window.innerHeight;
    const rect = element.getBoundingClientRect();
    const position = rect.top / viewportHeight;
    return position >= 0 && position <= 1;
}

function getUrl(width, url) {
    return 'https://images1-focus-opensocial.googleusercontent.com/gadgets/proxy'
        + '?container=focus'
        + '&resize_w=' + width
        + '&url=' + url
        ;
}

const listServer = ['x', 'x2'];

var hex2a = function (hexx) {
    var hex = hexx.toString(); //force conversion
    var str = '';
    for (var i = 0; i < hex.length; i += 2) str += String.fromCharCode(parseInt(hex.substr(i, 2), 16));
    return str;
}


const keys = imageLoader.getKey(window.atob(hex2a(token)));

const factor = 0.2;

function imgReverser(imgUrl) {
    return new Promise((myResolve, myReject) => {
        var imgEl = new Image()


        // imgEl.crossOrigin = "Anonymous";
        imgEl.onload = function () {
            let canvas = imageLoader.decrypt(imgEl, keys, factor);

            if (typeof userID !== 'undefined' && userID !== null) {
                let ctx = canvas.getContext("2d");

                ctx.font = "bold 16px Arial";
                ctx.fillStyle = "rgba(255, 0, 0, 0.5)";
                ctx.fillText(userID, canvas.width / 1.2, canvas.height / 1.2);
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
            }

            return myResolve(canvas)
        }

        imgEl.src = imgUrl;
    })
}

function createImageElement(parentEl, imgUrl, elClass) {

    if (imgUrl.indexOf('scramble') > -1) {
        imgReverser(imgUrl).then(canvas => {
            if (canvas) {
                canvas.classList.add(elClass);
                parentEl.appendChild(canvas);
            }
        });
    } else {
        var imgEl = document.createElement('img'), totalError = 0;

        imgEl.classList.add(elClass);
        // imgEl.crossOrigin = 'Anonymous'
        // imgEl.referrerpolicy = "no-referrer"
        imgEl.onerror = function () {
            if (listServer[totalError] !== undefined) {
                imgEl.src = imgUrl + '?' + listServer[totalError];
                totalError++;
                return;
            }

            imgEl.onerror = null
            imgEl.src = "https://cdn.dribbble.com/users/1026512/screenshots/10130839/waifu_laifu_404_copia_4x.png";
        }

        imgEl.onload = function () {
            if (!parentEl.classList.contains('img-loaded')) {
                parentEl.classList.add('img-loaded');
            }

            parentEl.appendChild(imgEl);
        }


        imgEl.src = imgUrl;
    }
}

function logReading() {
    const elReading = $('.reading-item.active');
    const reading_id = elReading.data('id'),
        reading_number = elReading.data('number'),
        type = readingBy === 'chap' ? 1 : 2;
    if (currentImageIndex < 1 || currentImageIndex === 'NaN') {
        currentImageIndex = 1;
    }

    if (oldImageIndex !== currentImageIndex) {
        continueReading = {
            manga_id: mangaId,
            reading_id,
            reading_number,
            type,
            lang_code: langCode,
            image_number: currentImageIndex,
            updated_at: Date.now()
        };

        oldImageIndex = currentImageIndex;

        if (isLoggedIn && isRead === false) {
            isRead = true;
            $.post('/ajax/user/log-reading', continueReading, function (res) { });
        }

        var dataStorage = localStorage.getItem('mr_reading_' + mangaId);
        if (dataStorage) {
            dataStorage = JSON.parse(dataStorage);
            if (dataStorage.length > 0) {
                var foundIndex = dataStorage.findIndex(item => item.type === type);
                if (foundIndex >= 0) {
                    dataStorage[foundIndex] = continueReading;
                } else {
                    dataStorage.push(continueReading);
                }
            }
        } else {
            dataStorage = [continueReading];
        }

        localStorage.setItem('mr_reading_' + mangaId, JSON.stringify(dataStorage));
    }
}

setInterval(logReading, 2000);

window.addEventListener('load', (event) => {
    setTimeout(function () {
        getCommentWidget();
    }, 1500)
});

function unlockChapter() {
    if (!checkLogin()) {
        return;
    }

    $.post('/ajax/user/unlock-chapter', { reading_id: readingId }, function (res) {
        if (res.status === 'ok') {
            $('.reading-item.active').click();
        } else {
            alert(res.msg);
        }
    });
}

