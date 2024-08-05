new Swiper('#slider', {
    // init: false,
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    pagination: {
        el: '#slider .swiper-pagination',
        clickable: true,
    },
    loop: true,
    autoplay: {
        delay: 4000,
    },
    effect: 'fade',
});

function settingsSwiperSmall(element) {
    return {
        slidesPerView: 3,
        spaceBetween: 30,
        navigation: {
            nextEl: element + ' .featured-navi .navi-next',
            prevEl: element + ' .featured-navi .navi-prev',
        },
        breakpoints: {
            300: {
                slidesPerView: 2,
                spaceBetween: 2,
            },
            360: {
                slidesPerView: 3,
                spaceBetween: 2,
            },
            640: {
                slidesPerView: 4,
                spaceBetween: 5,
            },
            830: {
                slidesPerView: 5,
                spaceBetween: 15,
            },
            1100: {
                slidesPerView: 6,
                spaceBetween: 15,
            },
            1400: {
                slidesPerView: 8,
                spaceBetween: 15,
            },
        },
        autoplay: false,
    };
}

if ($('#trending-home .swiper-container').length > 0) {
    const swiperSmall1 = new Swiper('#trending-home .swiper-container', {
        slidesPerView: 6,
        spaceBetween: 20,
        navigation: {
            nextEl: '#trending-home .trending-navi .navi-next',
            prevEl: '#trending-home .trending-navi .navi-prev',
        },
        breakpoints: {
            300: {
                slidesPerView: 2,
                spaceBetween: 2,
            },
            360: {
                slidesPerView: 3,
                spaceBetween: 2,
            },
            640: {
                slidesPerView: 4,
                spaceBetween: 5,
            },
            830: {
                slidesPerView: 5,
                spaceBetween: 15,
            },
            1100: {
                slidesPerView: 6,
                spaceBetween: 20,
            },
        },
        autoplay: false,
    });
    $('#trending-home').fadeIn();
    swiperSmall1.update();
}
if ($('#featured-03 .swiper-container').length > 0) {
    const swiperSmall3 = new Swiper('#featured-03 .swiper-container', settingsSwiperSmall('#featured-03'));
    $('#featured-03').fadeIn();
    swiperSmall3.update();
}
if ($('#featured-04 .swiper-container').length > 0) {
    const swiperSmall4 = new Swiper('#featured-04 .swiper-container', settingsSwiperSmall('#featured-04'));
    $('#featured-04').fadeIn();
    swiperSmall4.update();
}
