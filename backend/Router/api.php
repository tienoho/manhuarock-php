<?php

use Services\Router;

Router::group(['prefix' => '/api'], function () {
    Router::group(['middleware' => Middleware\Auth::class], function () {
        Router::group(['middleware' => Middleware\PermissionManga::class], function () {
            Router::post('/manga-add', 'Admin@addMangaApi', ['as' => 'api.manga-add']);
            Router::post('/manga-edit/{m_id}', 'Admin@editMangaApi', ['as' => 'api.manga-edit']);
            Router::post('/chapter-add/{m_id}', 'Api@addChapter', ['as' => 'api.chapter-add']);
            Router::post('/chapter-edit/{c_id}', 'Admin@chapterEditApi', ['as' => 'api.chapter-edit']);
            Router::all('/search-taxonomy', 'Admin@searchTaxonomyApi');
            Router::all('/manga-manage', 'Admin@MangaManageApi', ['as' => "api.manga-manage"]);
            Router::post('/delete-manga', 'Admin@deleteManga', ['as' => "api.delete-manga"]);
            Router::get('/delete-chapter/{c_id}', 'Admin@deleteChapter', ['as' => "api.delete-chapter"]);
            Router::post('/upload-tmp', 'Api@uploadTmp');

        });

        Router::group(['middleware' => Middleware\PermissionAdministration::class], function () {
            Router::get('/user-edit/{u_id}', 'Admin@userEdit');
            Router::post('/user-edit/{u_id}', 'Admin@userEditUpdate');
            Router::get('/add-coin/{u_id}', 'Admin@addCoin');
            Router::post('/add-coin/{u_id}', 'Admin@addCoinUpdate');
            Router::get('/group-edit/{u_id}', 'Admin@groupEdit');
            Router::post('/group-edit/{u_id}', 'Admin@groupEditUpdate');

            Router::get('/add-group', 'Admin@addGroup');
            Router::post('/add-group', 'Admin@addGroupUpdate');

            Router::get('/add-member/{u_id}', 'Admin@addMember');
            Router::post('/add-member/{u_id}', 'Admin@addMemberUpdate');
            Router::get('/view-member/{u_id}', 'Admin@viewMember');
            Router::post('/view-member/{u_id}', 'Admin@viewMemberUpdate');

            Router::post('/delete-user', 'Admin@deleteUser');
            Router::post('/delete-taxonomy', 'Admin@deleteTaxonomy');

            Router::get('/search-user', 'Admin@searchUser');
            Router::post('/accept-request', 'Admin@acceptRequest');

            Router::post('/search-pin', 'Admin@searchPin');
            Router::post('/set-pin', 'Admin@setPin');
            Router::post('/get-pin', 'Admin@getPin');
            Router::post('/remove-pin', 'Admin@removePin');

            Router::post('/remove-report', 'Api@removeReport');
            Router::all('/reset-cache', 'Api@removeCache');

            Router::post('/run-scarper', 'Api@runScraper');
            Router::post('/add-ads', 'Api@addAds');
            Router::post('/meta-setting', 'Api@metaSetting');
            Router::post('/slug-setting', 'Api@slugSetting');

            Router::post('/add-taxonomy/{type}', 'Taxonomy@addTaxonomy');
            Router::get('/add-taxonomy-template/{type}', 'Taxonomy@addTaxonomyTemplate');
            Router::get('/edit-taxonomy-template/{id}', 'Taxonomy@editTaxonomyTemplate');

            Router::post('/comment/delete/{id}', "Comment@delete");

            // Lock chapter
            Router::get('/lock-chapter-template/{id}', 'Admin@lockChapterTemplate');
            Router::post('/lock-chapter/{id}', 'Admin@lockChapter');

        });
    });

    Router::post('/get-mangas', 'Manga@GetMangas');
    Router::post('/report/chapter', 'Api@ChapterReport');

    Router::post('/search-manga', function () {
        $_POST = file_get_contents("php://input");

        $_POST = json_decode($_POST);

        $search_query = $_POST->search_query ?? null;

        \Models\Manga::getDB()->where('name', "%$search_query%", 'LIKE');
        \Models\Manga::getDB()->orWhere('other_name', "%$search_query%", 'LIKE');

        $data = \Models\Manga::getDB()->get('mangas', 10, 'name, slug, id');

        response()->json($data);
    });

    Router::get('/unlock-chapter-template/{id}', 'Manga@unlockChapterTemplate');
    Router::post('/unlock-chapter', 'User@unlockChapter');
});

Router::group(['prefix' => '/ajax'], function () {
    Router::post('/vote/submit', "Manga@voteSubmit");
    Router::post('/comment/vote', "Comment@vote");
    Router::all('/manga/search/suggest', "Manga@seachSuggest");

});

Router::post('/services-upload/{server}', function ($server) {
    if (\Config\Config::APP_KEY !== input()->value('app_key')) {
        response()->json([
            'status' => false,
        ]);
    }

    $image_data = input()->post('image_data')->getValue();
    $image_path = input()->post('image_path')->getValue();

    if (empty($image_data) || !($image_path)) {
        response()->json(['status' => false, 'msg' => 'Data Not Aviable!']);
    }

    $ServicesUpload = ("\\Services\\" . $server);

    if (!class_exists($ServicesUpload)) {
        response()->json(['status' => false, 'msg' => 'Services Not Found!']);
    }
    try {
        response()->json(['status' => true, 'url' => (new $ServicesUpload)->upload($image_data, $image_path)]);
    } catch (Exception $e) {
        response()->json(['status' => false, 'msg' => $e]);
    }
});
