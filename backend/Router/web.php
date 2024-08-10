<?php

use Services\Router;

$slugConf = getConf('slug');

Router::get('/', 'Manga@index', ['as' => 'home']);
Router::get('/' . $slugConf['chapter'] . '/{m_slug}', 'Manga@showChapter', ['as' => 'read_first']);

Router::get('/' . $slugConf['manga'] . '/{m_slug}/{m_id}', 'Manga@show', ['as' => 'manga'])->where(['m_id' => '([0-9]*[1-9][0-9]*(\.[0-9]+)?|[0]+\.[0-9]*[1-9][0-9]*)']);
Router::get('/' . $slugConf['chapter'] . '/{m_slug}/{c_slug}/{c_id}', 'Manga@showChapter', ['as' => 'chapter'])->where(['c_id' => '([0-9]*[1-9][0-9]*(\.[0-9]+)?|[0]+\.[0-9]*[1-9][0-9]*)']);
Router::get('/' . $slugConf['manga_list'] . '/{page?}', 'Page@default', ['as' => 'manga_list'])->where(['page' => '([0-9]*[1-9][0-9]*(\.[0-9]+)?|[0]+\.[0-9]*[1-9][0-9]*)']);
Router::get('/' . $slugConf['completed'] . '/{page?}', 'Page@completed', ['as' => 'completed'])->where(['page' => '([0-9]*[1-9][0-9]*(\.[0-9]+)?|[0]+\.[0-9]*[1-9][0-9]*)']);
Router::get('/' . $slugConf['new-release'] . '/{page?}', 'Page@newRelease', ['as' => 'new-release'])->where(['page' => '([0-9]*[1-9][0-9]*(\.[0-9]+)?|[0]+\.[0-9]*[1-9][0-9]*)']);
Router::get('/' . $slugConf['latest-updated'] . '/{page?}', 'Page@latestUpdated', ['as' => 'latest-updated'])->where(['page' => '([0-9]*[1-9][0-9]*(\.[0-9]+)?|[0]+\.[0-9]*[1-9][0-9]*)']);
Router::get('/' . $slugConf['most-viewed'] . '/{page?}', 'Page@mostViewed', ['as' => 'most-viewed'])->where(['page' => '([0-9]*[1-9][0-9]*(\.[0-9]+)?|[0]+\.[0-9]*[1-9][0-9]*)']);
Router::get('/' . $slugConf['search'] . '/{page?}', 'Page@search', ['as' => 'search'])->where(['page' => '([0-9]*[1-9][0-9]*(\.[0-9]+)?|[0]+\.[0-9]*[1-9][0-9]*)']);
Router::get('/' . $slugConf['filter'] . '/{page?}', 'Page@filter', ['as' => 'filter'])->where(['page' => '([0-9]*[1-9][0-9]*(\.[0-9]+)?|[0]+\.[0-9]*[1-9][0-9]*)']);
Router::get('/' . $slugConf['genres'] . '/{genres}/{page?}', 'Page@genres', ['as' => 'genres'])->where(['page' => '([0-9]*[1-9][0-9]*(\.[0-9]+)?|[0]+\.[0-9]*[1-9][0-9]*)']);
Router::get('/' . $slugConf['authors'] . '/{authors}/{page?}', 'Page@authors', ['as' => 'authors'])->where(['page' => '([0-9]*[1-9][0-9]*(\.[0-9]+)?|[0]+\.[0-9]*[1-9][0-9]*)']);
Router::get('/' . $slugConf['artists'] . '/{artists}/{page?}', 'Page@artists', ['as' => 'artists'])->where(['page' => '([0-9]*[1-9][0-9]*(\.[0-9]+)?|[0]+\.[0-9]*[1-9][0-9]*)']);
Router::get('/tag/{tag}/{page?}', 'Page@tags', ['as' => 'tag'])->where(['page' => '([0-9]*[1-9][0-9]*(\.[0-9]+)?|[0]+\.[0-9]*[1-9][0-9]*)']);
Router::get('/' . $slugConf['manga-type'] . '/{type}/{page?}', 'Page@mangaType', ['as' => 'manga.type'])->where(['page' => '([0-9]*[1-9][0-9]*(\.[0-9]+)?|[0]+\.[0-9]*[1-9][0-9]*)']);
Router::get('/history', 'Page@history', ['as' => 'manga.history']);

// USER
Router::get('/login/', 'User@login', ['as' => 'user.login']);
Router::get('/register/', 'User@register', ['as' => 'user.register']);
Router::get('/fb-callback/', 'User@fbCallback', ['as' => 'fb-callback']);

Router::all('/terms', 'Page@terms', ['as' => 'terms']);
Router::all('/dmca', 'Page@dmca', ['as' => 'dmca']);
Router::all('/request-permission', 'Page@requestPermission');
Router::all('/contact', 'Page@contact', ['as' => 'contact']);
Router::all('/get-image', 'Manga@proxyGoogle', ['as' => 'get-image']);
Router::get('/shuffled', 'Manga@imageScramble', ['as' => 'scramble-image']);
Router::all('/random', 'Manga@readRandom');

// RSS
Router::get('/rss', 'Rss@index');

Router::all("/payment/callback", "Payment@callback");

// ADMIN PANEL
Router::group(['middleware' => Middleware\Auth::class], function () {

    Router::group(
        ['prefix' => '/cpanel'],
        function () {
            Router::get('/', 'Admin@show', ['as' => 'admin']);

            Router::group(
                ['middleware' => Middleware\PermissionManga::class],
                function () {
                        Router::all('/manga-add', 'Admin@mangaAdd', ['as' => 'admin.manga-add']);
                        Router::all('/chapter-add/{m_id}', 'Admin@addChapter', ['as' => 'admin.chapter-add'])->where(['m_id' => '([0-9]*[1-9][0-9]*(\.[0-9]+)?|[0]+\.[0-9]*[1-9][0-9]*)']);
                        Router::all('/manga-edit/{m_id}', 'Admin@mangaEdit', ['as' => 'admin.manga-edit'])->where(['m_id' => '([0-9]*[1-9][0-9]*(\.[0-9]+)?|[0]+\.[0-9]*[1-9][0-9]*)']);
                        Router::all('/chapter-edit/{c_id}', 'Admin@chapterEdit', ['as' => 'admin.chapter-edit'])->where(['c_id' => '([0-9]*[1-9][0-9]*(\.[0-9]+)?|[0]+\.[0-9]*[1-9][0-9]*)']);
                        Router::get('/manga-manage', 'Admin@mangaManage', ['as' => 'admin.manga-manage']);
                        Router::all('/payment-method', 'User@paymentMethod', ['as' => 'admin.payment-method']);
                    }
            );

            Router::group(
                ['middleware' => Middleware\PermissionAdministration::class],
                function () {
                        Router::get('/user-manage/{page?}', 'Admin@userManage', ['as' => 'admin.user-manage'])->where(['page' => '([0-9]*[1-9][0-9]*(\.[0-9]+)?|[0]+\.[0-9]*[1-9][0-9]*)']);
                        Router::get('/group-manage/{page?}', 'Admin@groupManage', ['as' => 'admin.group-manage'])->where(['page' => '([0-9]*[1-9][0-9]*(\.[0-9]+)?|[0]+\.[0-9]*[1-9][0-9]*)']);
                        Router::get('/request-manage/{page?}', 'Admin@requestManage', ['as' => 'admin.request-manage'])->where(['page' => '([0-9]*[1-9][0-9]*(\.[0-9]+)?|[0]+\.[0-9]*[1-9][0-9]*)']);
                        Router::get('/pin-manga/{page?}', 'Admin@pinManga', ['as' => 'admin.pin-manga'])->where(['page' => '([0-9]*[1-9][0-9]*(\.[0-9]+)?|[0]+\.[0-9]*[1-9][0-9]*)']);

                        Router::all('/settings/', 'Admin@settings', ['as' => 'admin.settings']);
                        Router::all('/reported/{page?}', 'Admin@reported', ['as' => 'admin.reported'])->where(['page' => '([0-9]*[1-9][0-9]*(\.[0-9]+)?|[0]+\.[0-9]*[1-9][0-9]*)']);
                        ;
                        Router::all('/scarper-manage/', 'Admin@scraperManage', ['as' => 'admin.scarper-manage']);
                        Router::get('/ads-setting/', 'Admin@adsSetting', ['as' => 'admin.ads-setting']);
                        Router::get('/seo-setting/', 'Admin@seoSetting', ['as' => 'admin.seo-setting']);
                        Router::get('/taxonomy-manage/{type?}', 'Taxonomy@manage', ['as' => 'admin.taxonomy-manage']);

                        Router::get('/comment-manage', 'Comment@manage', ['as' => 'admin.comment-manage']);

                    }
            );
        }
    );

    Router::group(
        ['prefix' => '/user'],
        function () {
            Router::get('/profile', 'User@profilePage', ['as' => 'user.profile']);
            Router::get('/continue-reading', 'User@continueReadingPage', ['as' => 'user.continue-reading']);
            Router::get('/reading-list', 'User@readingListPage', ['as' => 'user.reading-list']);
            Router::all('/request-permission', 'User@requestPermission', ['as' => 'user.request-permission']);
            Router::get('/payment', 'Payment@index');
            Router::post('/payment/charging', 'Payment@charging');
        }
    );

    Router::group(
        ['prefix' => '/ajax'],
        function () {
            Router::post('/user/settings', 'User@userSettings');
            Router::post('/user/profile', 'User@userUpdateProfile');
            Router::post('/reading-list/add', 'User@readingListAdd');
        }
    );

    Router::group(
        ['prefix' => '/auto-tool'],
        function () {
            Router::group(
                ['middleware' => Middleware\PermissionAdministration::class],
                function () {
                        Router::get('/', 'AutoTool@index')->name('autotool');
                        Router::get('/configuration', 'AutoTool@configuration');
                        Router::get('/campaign', 'AutoTool@campaign');
                        Router::get('/cron-manage', 'AutoTool@cronManage');
                        Router::get('/ajax-template/{template}', 'AutoTool@ajaxTemplate');

                        // AJAX
                        Router::post('/add-campaign', 'AutoTool@addCampaign');
                        Router::post('/edit-campaign', 'AutoTool@editCampaign');
                        Router::post('/change-config', 'AutoTool@changeConfig');
                        Router::post('/add-cron', 'AutoTool@addCron');
                        Router::post('/add-queue', 'AutoTool@addQueue');
                        Router::post('/remove-cron', 'AutoTool@removeCron');

                    }
            );
        }
    );
});

Router::group(['prefix' => '/ajax'], function () {
    Router::get('/user/login-state', 'User@loginState');
    Router::get('/notification/latest', 'User@notificationLatest');
    Router::get('/vote/{page_type}/{m_id}', 'User@voteManga')->where(['m_id' => '([0-9]*[1-9][0-9]*(\.[0-9]+)?|[0]+\.[0-9]*[1-9][0-9]*)']);
    Router::get('/reading-list/info/{m_id}', 'User@readingList')->where(['m_id' => '([0-9]*[1-9][0-9]*(\.[0-9]+)?|[0]+\.[0-9]*[1-9][0-9]*)']);
    Router::get('/comment/widget/{m_id}', 'User@commentManga')->where(['m_id' => '([0-9]*[1-9][0-9]*(\.[0-9]+)?|[0]+\.[0-9]*[1-9][0-9]*)']);
    Router::post('/comment/add', 'User@addComment');
    Router::post('/comment/report', 'User@commentReport');

    Router::group(
        ['middleware' => Middleware\reCAPTCHAv2::class],
        function () {
            Router::post('/auth/register', 'User@registerApi');
            Router::post('/auth/reset-password', 'User@getPassApi');
        }
    );

    Router::group(
        ['middleware' => Middleware\Auth::class],
        function () {
            Router::post('/user/log-reading', 'User@logReadingApi');
            Router::post('/continue-reading/remove', 'User@continueReadingRemove');
        }
    );

    Router::post('/auth/login', 'User@loginApi');

    Router::get('/manga/reading-list/{m_id}', 'Manga@readingList')->where(['m_id' => '([0-9]*[1-9][0-9]*(\.[0-9]+)?|[0]+\.[0-9]*[1-9][0-9]*)']);
    Router::post('/manga/count-view/{m_id}', 'Manga@viewsCount')->where(['m_id' => '([0-9]*[1-9][0-9]*(\.[0-9]+)?|[0]+\.[0-9]*[1-9][0-9]*)']);
    Router::get('/image/list/chap/{c_id}', 'Manga@imageListChap')->where(['c_id' => '([0-9]*[1-9][0-9]*(\.[0-9]+)?|[0]+\.[0-9]*[1-9][0-9]*)']);

    Router::get('/source/list/chap/{c_id}', 'Manga@sourceListChap')->where(['c_id' => '([0-9]*[1-9][0-9]*(\.[0-9]+)?|[0]+\.[0-9]*[1-9][0-9]*)']);

    Router::post('/user/unlock-chapter', 'User@unlockChapter');
});

Router::all('/logout', 'User@logoutApi', ['as' => 'logout']);