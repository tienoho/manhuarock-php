var app = angular.module('myApp', ['ngSanitize']);
app.controller('livesearch', function ($scope, $http) {
    $scope.loading = false;
    $scope.fetchData = function () {
        $scope.loading = true;
        $http({
            method: "POST",
            url: "/api/search-manga",
            data: {search_query: $scope.search_query}
        }).success(function (response) {
            $scope.loading = false;
            $scope.searchData = response;
        });
    };
    $scope.readManga = function (id, slug) {
        $scope.manga = location.protocol + '//' + location.host + '/' + slugConf.manga + '/' + slug + '/' + id;
        window.location.replace($scope.manga);
    };
});
app.controller('userSetting', function ($scope, $http) {
    $scope.changeDisplay = function (formData) {
        if (formData) {
            $scope.formData = formData;
        } else {
            return;
        }
        $http({
            method: "POST",
            url: "/ajax/user/profile",
            data: {
                name: $scope.formData.displayname
            }
        }).success(function (response) {
            $scope.result = response;
            if ($scope.result.status) {
                $scope.newname = $scope.formData.displayname;
                $scope.validate = true;
                $scope.message = $scope.result.msg;

                alert($scope.result.msg);
            } else {
                $scope.validate = false;
                $scope.message = $scope.result.msg;
            }
        });
    };

    $scope.changePass = function (formData) {
        if (formData) {
            $scope.formData = formData;
        } else {
            return;
        }
        $http({
            method: "POST",
            url: "/ajax/user/profile",
            data: {
                current_password : $scope.formData.current_password,
                new_password: $scope.formData.new_password,
                confirm_new_password: $scope.formData.repeat_password
            }
        }).success(function (response) {
            $scope.result = response;
            if ($scope.result.validate) {
                $scope.p_validate = true;
                $scope.p_message = $scope.result.msg;
                alert($scope.result.msg);
            } else {
                $scope.p_validate = false;
                $scope.p_message = $scope.result.msg;
            }
        });
    };
});


var isCheck = false;
app.controller('userFunction', function ($scope, $http) {
    $scope.bkresult = false;
    $scope.loading_number_notification = false;
    $scope.number_notification = 0;
    $scope.isCheck = false

    $scope.getstatus = function (manga_id){
        $scope.bookmark_url = '/ajax/reading-list/info/' + manga_id;
        $http.get($scope.bookmark_url).success(function (data) {

            $scope.bkresult = {
                status: data.data.type !== null
            };
            console.log($scope.bkresult.status)
        });
    }


    $scope.bookmark = function (manga_id) {

        $scope.bookmark_url = '/ajax/reading-list/add?type=1&page=detail&mangaId=' + manga_id;
        $http.post($scope.bookmark_url).success(function (data) {
            $scope.bkresult = data;
        });
    };

    $scope.removebookmark = function (manga_id, reload = false) {
        $scope.bookmark_url = '/ajax/reading-list/add?type=0&page=detail&mangaId=' + manga_id;
        $http.post($scope.bookmark_url).success(function (data) {
            if (data.status) {
                $scope.bkresult = {
                    status: false
                }
            }
        });

        if(reload){
            location.reload()
        }
    };

});



$(document).ready(function () {
    $('.menu-ico').click(function () {
        if ($('.header-menu').css('display') === 'none') {
            $('.open-menu').css('display', 'none');
            $('.close-menu').css('display', 'block');
            $('.header-menu').css('display', 'block');
        } else {
            $('.open-menu').css('display', 'block');
            $('.close-menu').css('display', 'none');
            $('.header-menu').css('display', 'none');
        }
    });
    $('.search-ico').click(function () {
        if ($('.search-manga').css('display') === 'none') {
            $('.open-search').css('display', 'none');
            $('.close-search').css('display', 'block');
            $('.search-manga').css('display', 'block');
        } else {
            $('.open-search').css('display', 'block');
            $('.close-search').css('display', 'none');
            $('.search-manga').css('display', 'none');
        }
    });
    $('.dropdownmenu').click(function () {
        if ($('.sub-menu').css('display') === 'none') {
            $('.sub-menu').css('display', 'block');
        } else {
            $('.sub-menu').css('display', 'none');
        }
    });
    $('.dropdownmenumb').click(function () {
        if ($('.sub-menumb').css('display') === 'none') {
            $('.sub-menumb').css('display', 'block');
        } else {
            $('.sub-menumb').css('display', 'none');
        }
    });
    if ($('#back_to_top').length) {
        var scrollTrigger = 100, backToTop = function () {
            var scrollTop = $(window).scrollTop();
            if (scrollTop > scrollTrigger) {
                $('#back_to_top').addClass('show');
            } else {
                $('#back_to_top').removeClass('show');
            }
        };
        backToTop();
        $(window).on('scroll', function () {
            backToTop();
        });
        $('#back_to_top').on('click', function (e) {
            e.preventDefault();
            $('html,body').animate({scrollTop: 0}, 700);
        });
    }
});
$('.c-user_avatar-image').click(function () {
    if ($('.c-user_menu').css('display') == 'none') {
        $('.c-user_menu').css('display', 'block');
    } else {
        $('.c-user_menu').css('display', 'none');
    }
});
$("#searchpc input[type='text']").on('input', function () {
    $('.live-pc-result').css('display', 'block');
});
$("#searchmb input[type='text']").on('input', function () {
    $('.live-mb-result').css('display', 'block');
});
window.addEventListener('click', function (e) {
    var flyoutElement = document.getElementById('searchpc'), targetElement = e.target;
    do {
        if (targetElement == flyoutElement) {
            return;
        }
        targetElement = targetElement.parentNode;
    } while (targetElement);
    $('.live-pc-result').css('display', 'none');
});
window.addEventListener('click', function (e) {
    var flyoutElement = document.getElementById('searchmb'), targetElement = e.target;
    do {
        if (targetElement == flyoutElement) {
            return;
        }
        targetElement = targetElement.parentNode;
    } while (targetElement);
    $('.live-mb-result').css('display', 'none');
});

function checkLogin(){
    return isLoggedIn;

}