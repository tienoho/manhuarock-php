<?php

namespace Controllers;

use Models\Chapter as ChapterModel;
use Models\Manga as MangaModel;
use Models\Model;
use Models\Taxonomy as TaxonomyModel;
use Services\Blade;

class Admin
{
    public function show(): string
    {
        return (new Blade)->render('admin.pages.dashboard');
    }

    public function mangaManage(): string
    {
        return (new Blade)->render('admin.pages.manga_manage', []);
    }

    public function mangaAdd(): string
    {
        return (new Blade)->render('admin.pages.manga_add', []);
    }

    public function mangaEdit($m_id): string
    {

        ChapterModel::getDB()->orderBy('chapters.chapter_index', 'DESC');
        $chapters = ChapterModel::ChapterListByID($m_id, null, true);
        MangaModel::getDB()->where('id', $m_id);
        $manga = MangaModel::getDB()->objectBuilder()->getOne("mangas");

        if (!is_object($manga) ||  ((new \Models\User)->hasPermission(['manga']) && userget()->id !== $manga->created_by)) {
            response()->redirect('/', 403);
        }

        return (new Blade)->render('admin.pages.manga_edit', [
            "manga" => $manga,
            "chapters" => $chapters,
        ]);
    }

    public function addMangaApi()
    {
        $manga = inputManga();
        $manga['created_by'] = userget()->id;

        $taxonomys = inputTaoxaomy();

        $manga_id = MangaModel::AddManga($manga);

        if (!is_int($manga_id)) {
            if (strpos($manga_id, 'Duplicate entry') !== false) {
                response()->httpCode(500)->json(['message' => 'Truyện đã tồn tại', 'error' => $manga_id]);
            } else {
                response()->httpCode(500)->json(['message' => 'Lỗi không xác định', 'error' => $manga_id]);
            }
            return false;
        }

        foreach ($taxonomys as $taxonomy => $taxonomy_data) {
            if (!empty($taxonomy_data) && is_array($taxonomy_data)) {

                $taxonomy_data = array_filter($taxonomy_data);
                TaxonomyModel::SetTaxonomy($taxonomy, $taxonomy_data, $manga_id);
            }
        }

        response()->httpCode(200)->json(['message' => 'Thêm thành công']);
    }

    public function editMangaApi($manga_id)
    {
        $manga = inputManga();
        $taxonomys = inputTaoxaomy();
        if ((new \Models\User)->hasPermission(['manga'])) {
            response()->redirect('/', 403);
        }

        MangaModel::EditManga($manga_id, $manga);

        TaxonomyModel::ReSetTaoxaomyManga($manga_id);

        foreach ($taxonomys as $taxonomy => $taxonomy_data) {
            if (!empty($taxonomy_data) && is_array($taxonomy_data)) {

                $taxonomy_data = array_filter($taxonomy_data);
                TaxonomyModel::SetTaxonomy($taxonomy, $taxonomy_data, $manga_id);
            }
        }

        response()->httpCode(200)->json(['message' => 'Sửa thành công']);
    }

    public function addChapter($m_id)
    {
        Model::getDB()->where('id', $m_id);
        $manga = Model::getDB()->objectBuilder()->getOne("mangas");

        if (!empty($manga)) {

            Model::getDB()->where('manga_id', $m_id);
            Model::getDB()->where('name', null, 'IS');

            $chapter = Model::getDB()->objectBuilder()->getOne("chapters");
            if (!empty($chapter) && is_object($chapter)) {
                $edit_url = url('admin.chapter-edit', [
                    'c_id' => $chapter->id,
                ]);

                return response()->redirect($edit_url);
            }

            $chapter_id = Model::getDB()->insert('chapters', [
                'manga_id' => $m_id,
                'hidden' => 1,
                'created_by' => userget()->id,
                'last_update' => Model::getDB()->now(),
            ]);

            if ($chapter_id) {
                Model::getDB()->insert('chapter_data', [
                    'chapter_id' => $chapter_id,
                    'content' => null,
                    'type' => 'image',
                ]);

                $edit_url = url('admin.chapter-edit', [
                    'c_id' => $chapter_id,
                ]);

                return response()->redirect($edit_url);
            }
        }
        // return (new Blade)->render('admin.pages.chapter_add', ["manga" => $manga,]);
    }

    public function chapterEdit($c_id)
    {

        Model::getDB()->where('id', $c_id);
        $chapter = Model::getDB()->objectBuilder()->getOne("chapters");

        if(!is_object($chapter)){
            $chapter = (object) [
                'id' => null,
                'manga_id' => null,
                'chapter_index' => null,
                'name' => null,
                'hidden' => null,
                'created_by' => null,
                'last_update' => null,
            ];
        }

        if ((new \Models\User)->hasPermission(['manga']) && userget()->id !== $chapter->created_by) {
            response()->redirect('/', 403);
        }

        Model::getDB()->where('chapter_id', $c_id);
        $chapter_content = Model::getDB()->objectBuilder()->getOne("chapter_data");
        if (!$chapter_content || !is_object($chapter_content)) {
            $chapter_content = (object) [
                'content' => [],
                'type' => 'image',
            ];
        }

        if ($chapter_content->type === 'image') {
            if (!$chapter_content->content) {
                $chapter_content->content = [];
            } else {
                $chapter_content->content = json_decode($chapter_content->content);
            }
        }

        Model::getDB()->where('id', $chapter->manga_id);
        $manga = Model::getDB()->objectBuilder()->getOne("mangas");

        return (new Blade)->render('admin.pages.chapter_edit', [
            "manga" => $manga,
            "chapter" => $chapter,
            "chapter_content" => $chapter_content,
        ]);
    }

    public function chapterEditApi($c_id)
    {
        $chapObj = Model::getDB()->where('id', $c_id)->objectBuilder()->getOne('chapters', 'manga_id, created_by');
        
        if (!isset($chapObj) || !is_object($chapObj)) {
            return response()->json([
                'message' => 'Chương Không Tồn Tại!',
            ]);
        }

        if ((new \Models\User)->hasPermission(['manga']) && userget()->id !== $chapObj->created_by) {
            response()->redirect('/', 403);
        }

        $manga_id = $chapObj->manga_id;
        $chapter['name'] = input()->value('name');
        $chapter['name_extend'] = input()->value('name_extend');
        $chapter['price'] = input()->value('price');
        $chapter['slug'] = slugGenerator($chapter['name']);
        $chapter['chapter_index'] = input()->value('chapter_index');
        $chapter['hidden'] = input()->value('hidden');

        try {
            Model::getDB()->where('id', $c_id)->update('chapters', $chapter);

        } catch (\PDOException $e) {
            print_r($e->getMessage());
        }


        $content = input()->value('content');
        $content_id = input()->value('content_id');
        $chap_content["type"] = "text";

        if (is_array($content)) {
            $chap_content["type"] = "image";
            $content = array_filter($content);

            foreach ($content as $key => $item) {
                if (strpos($item, 'uploads/tmp') !== false) {

                    $localPath = ROOT_PATH . '/public/uploads/tmp/' . basename($item);

                    if (file_exists($localPath)) {
                        $item_binary = file_get_contents($localPath);

                        $upload_config = include(\ROOT_PATH . "/config/upload-storage.php");
                        $content[$key] = (new $upload_config['driver'])->upload($item_binary, "manga/$manga_id/$c_id/" . basename($item));
                       
                        unlink($localPath);
                    }
                }
            }

            $content = json_encode($content);
        } else {
            $content = trim($content);
            if (is_url($content)) {
                $chap_content["type"] = "leech";
                $chap_content["storage_name"] = "Server 1";
            }
        }

        $chap_content["content"] = $content;

        if (!empty($content_id)) {
            Model::getDB()->where('id', $content_id)->update('chapter_data', $chap_content);

        } else {
            $chap_content["chapter_id"] = $c_id;

            Model::getDB()->insert('chapter_data', $chap_content);
        }

        MangaModel::UpdateLastChapter($manga_id);


        response()->json([
            'message' => 'Sửa thành công',
        ]);
    }

    public function MangaManageApi()
    {
        $draw = input()->value('draw', 1);
        $search = input()->value('search')['value'] ?? null;
        $limit = input()->value('length', 10);
        $limit = $limit <= 0 ? 10 : $limit;
        $start = input()->value('start', 0);
        $page = ceil(($start - 1) / $limit) + 1;

        $orderbys = input()->value('order', []);
        $columns = input()->value('columns', []);

        foreach ($columns as $column) {
            if ($column['data']) {
                if (!$column['data'] == 'chapters') {
                    $selectes[] = 'mangas.' . $column['data'];
                }
            }
        }

        $selectes = implode(', ', $selectes ?? []);

        $orderby = $columns[$orderbys[0]['column'] ?? 3]['data'] ?? 'id';
        $orderType = $orderbys[0]['dir'] ?? "DESC";

        if (!(new \Models\User)->hasPermission(['all', 'administration'])) {
            $user_id = userget()->id;
            $user_groups = (new \Models\User)->getUserGroup($user_id);

            if (!empty($user_groups)) {
                $q =
                    "(
                          SELECT $selectes
                          FROM mangas
                          JOIN taxonomy_manga
                          ON taxonomy_manga.manga_id=mangas.id
                          AND taxonomy_manga.taxonomy_id = ?
                          OR mangas.created_by = $user_id
                          WHERE 1 " . ($search ? " AND mangas.name LIKE %$search%
                          OR mangas.other_name LIKE %$search%" : '') . "


                    ) ";

                foreach ($user_groups as $user_group) {
                    $qs[] = $q;
                    $params[] = $user_group->id;
                }

                $q = 'SELECT * FROM ( ' . implode(' UNION  ', $qs) . " ) as b GROUP BY b.id ORDER BY b.$orderby $orderType LIMIT $start,$limit";

                $data = Model::getDB()->rawQuery($q, $params);

            } else {
                $q =
                    "(
                    SELECT $selectes
                          FROM mangas
                          WHERE mangas.created_by = $user_id " . ($search ? " AND mangas.name LIKE %$search%
                          OR mangas.other_name LIKE %$search%" : '') . "
                          GROUP BY mangas.name
                          ORDER BY $orderby $orderType
                          LIMIT $start, $limit
                    ) ";

                $data = Model::getDB()->rawQuery($q);
            }

        } else {
            Model::getDB()->orderBy('mangas.' . $orderby, $orderType);

            if ($search) {
                Model::getDB()->where('mangas.name', "%$search%", 'LIKE');
                Model::getDB()->orWhere('mangas.other_name', "%$search%", 'LIKE');
            }

            Model::getDB()->pageLimit = $limit;
            $data = Model::getDB()->paginate('mangas', $page, $selectes);
        }

        foreach ($data as $key => $manga) {
            $data[$key]['last_update'] = timeago($manga['last_update']);
            $data[$key]['chapters'] = get_manga_data('chapters', $manga['id'], []);
        }

        $totalRecord = Model::getDB()->totalPages * $limit;

        $jayParsedAry = [
            "draw" => $draw,
            "recordsTotal" => $totalRecord,
            "recordsFiltered" => $totalRecord,
            "data" => $data,
        ];

        response()->json($jayParsedAry);
    }

    public function searchTaxonomyApi()
    {
        $search_query = input()->value('search');
        $taxonomy = input()->value('taxonomy');
        $limit = input()->value('limit', null);

        TaxonomyModel::getDB()->where('taxonomy', $taxonomy);

        if ($search_query) {
            TaxonomyModel::getDB()->where('name', "%$search_query%", 'LIKE');
        }
        $data = TaxonomyModel::getDB()->get('taxonomy', $limit, 'id, name');

        response()->json($data);
    }

    public function deleteManga()
    {
        $manga_ids = input()->value('manga_ids');

        if (is_array($manga_ids)) {
            foreach ($manga_ids as $manga_id) {
                Model::getDB()->where('id', $manga_id);
            }
        } else {
            Model::getDB()->where('id', $manga_ids);
        }

        Model::getDB()->delete('mangas');
    }

    public function deleteChapter($chapter_id)
    {
        Model::getDB()->where('id', $chapter_id);
        Model::getDB()->delete('chapters');

        response()->redirect(request()->getReferer());
    }

    public function userManage($page = 1)
    {
        $search = input()->value('search');

        if ($search) {
            Model::getDB()->where('name', "%$search%", "LIKE");
            Model::getDB()->Orwhere('email', "%$search%", "LIKE");
            Model::getDB()->Orwhere('role', $search);
        }

        Model::getDB()->pageLimit = 10;
        Model::getDB()->orderBy('id');

        Model::getDB()->join('user_avatar', 'user_avatar.id=user.avatar_id', 'LEFT');

        $users = Model::getDB()->objectBuilder()->paginate('user', $page, 'user.*, user_avatar.url as avatar_url');

        return (new Blade)->render('admin.pages.user_manage', [
            'page' => $page,
            'total_page' => Model::getDB()->totalPages,
            'users' => $users,
        ]);
    }

    public function userEdit($user_id)
    {
        $user = Model::getDB()->where("id", $user_id)->objectBuilder()->getOne("user");

        return (new Blade)->render('admin.components.form.user-edit', [
            'user' => $user,
        ]);
    }

    public function userEditUpdate($user_id)
    {
        $data = [
            'name' => input()->value('name'),
            'email' => input()->value('email'),
            'coin' => input()->value('coin'),
            'role' => input()->value('role'),
        ];

        Model::getDB()->where('id', $user_id)->update('user', $data);

        response()->json(['message' => 'Thông tin đã được thay đổi, F5 để xem bản cập nhật!']);
    }

    public function addCoin($user_id)
    {
        $user = Model::getDB()->where("id", $user_id)->objectBuilder()->getOne("user", "id, coin");

        return (new Blade)->render('admin.components.form.add-coin', [
            'user' => $user,
        ]);
    }

    public function addCoinUpdate($user_id)
    {
        $coin = input()->value('coin');

        Model::getDB()->rawQuery('UPDATE user SET coin = coin + ? WHERE id = ?', [$coin, $user_id]);

        response()->json(['message' => "Đã cộng thêm $coin Coin"]);
    }

    public function deleteUser()
    {
        $users = input()->value('user');

        if (is_array($users)) {
            foreach ($users as $user) {
                Model::getDB()->where('id', $user);
            }
        } else {
            Model::getDB()->where('id', $users);
        }

        Model::getDB()->delete('user');
    }

    public function groupManage($page = 1)
    {

        $search = input()->value('search');

        if ($search) {
            Model::getDB()->where('name', "%$search%", "LIKE");
        }

        Model::getDB()->pageLimit = 10;
        Model::getDB()->orderBy('taxonomy.id');
        Model::getDB()->groupBy('taxonomy.id');
        Model::getDB()->where('taxonomy.taxonomy', 'artists');

        Model::getDB()->join('taxonomy_user', 'taxonomy_user.taxonomy_id=taxonomy.id', 'LEFT');

        $artists = Model::getDB()->objectBuilder()->paginate('taxonomy', $page, 'taxonomy.*, COUNT(taxonomy_user.id) as total_member');

        return (new Blade)->render('admin.pages.group_manage', [
            'page' => $page,
            'total_page' => Model::getDB()->totalPages,
            'groups' => $artists,
        ]);
    }

    public function groupEdit($group_id)
    {
        $group = Model::getDB()->where("id", $group_id)->objectBuilder()->getOne("taxonomy");

        return (new Blade)->render('admin.components.form.group-edit', [
            'group' => $group,
        ]);
    }

    public function groupEditUpdate($group_id)
    {
        $name = input()->value('name');
        $description = input()->value('description');

        Model::getDB()->where('id', $group_id);
        Model::getDB()->update('taxonomy', [
            'name' => $name,
            'description' => $description,
        ]);

        response()->json(['message' => 'Thông tin đã được thay đổi, F5 để xem bản cập nhật!']);
    }

    public function deleteTaxonomy()
    {
        $taxonomys = input()->value('taxonomy');

        if (is_array($taxonomys)) {
            foreach ($taxonomys as $taxonomy) {
                Model::getDB()->where('id', $taxonomy);
            }
        } else {
            Model::getDB()->where('id', $taxonomys);
        }

        Model::getDB()->delete('taxonomy');
    }

    public function addMember($group_id)
    {
        $group = Model::getDB()->where("id", $group_id)->objectBuilder()->getOne("taxonomy");

        $members = Model::getDB()
            ->where('taxonomy_user.taxonomy_id', $group_id)
            ->join('user', 'user.id=taxonomy_user.user_id')
            ->join('user_avatar', 'user.avatar_id=user_avatar.id')
            ->objectBuilder()->get("taxonomy_user", null, 'user.*, user_avatar.url as avatar_url');

        return (new Blade)->render('admin.components.form.add-member', [
            'group' => $group,
            'members' => $members,
        ]);
    }

    public function addMemberUpdate($group_id)
    {
        $ids = input()->value('ids', []);

        foreach ($ids as $id) {
            Model::getDB()->where('id', $id)->update('user', ['role' => 'trans']);

            Model::getDB()->insert('taxonomy_user', [
                'taxonomy_id' => $group_id,
                'user_id' => $id,
            ]);
        }

        response()->json(['message' => 'Thêm thành công!']);
    }

    public function searchUser()
    {
        $search = input()->value('search');

        if ($search) {
            Model::getDB()->Orwhere('id', $search);
            Model::getDB()->where('name', "%$search%", 'LIKE');
            Model::getDB()->Orwhere('email', "%$search%", 'LIKE');
        }

        Model::getDB()->orderBy('id');

        $data = Model::getDB()->get('user');

        response()->json($data);
    }

    public function requestManage($page = 1)
    {

        Model::getDB()->join('user', 'user.id=user_request.user_id');

        $datas = Model::getDB()->objectBuilder()->paginate('user_request', $page, 'user.name, user_request.*');

        return (new Blade)->render('admin.pages.user_request', [
            'page' => $page,
            'total_page' => Model::getDB()->totalPages,
            'datas' => $datas,
        ]);
    }

    public function acceptRequest()
    {
        $id = input()->value('id');
        $type = input()->value('type');
        $user_id = input()->value('user_id');
        $is_accept = false;

        switch ($type) {
            case 'permission':
                Model::getDB()->where('id', $user_id)->update('user', ['role' => 'trans']);
                $is_accept = true;
                break;
        }

        if ($is_accept) {
            Model::getDB()->where('id', $id)->delete('user_request');
        }
    }

    public function pinManga($page = 1)
    {

        return (new Blade)->render('admin.pages.pin_manga', [
            'page' => $page,
        ]);
    }

    public function searchPin()
    {
        $search = input()->value('search');

        Model::getDB()->where('name', "%$search%", "LIKE")->orWhere('other_name', "%$search%", "LIKE");
        Model::getDB()->pageLimit = 10;
        $mangas = Model::getDB()->objectBuilder()->get('mangas');

        return (new Blade)->render('admin.components.pinsearch', [
            'mangas' => $mangas,
        ]);
    }

    public function setPin()
    {
        $manga_id = input()->value('manga_id');
        Model::getDB()->where('id', $manga_id)->update('mangas', ['pin' => 1]);
    }

    public function removePin()
    {
        $manga_id = input()->value('manga_id');
        Model::getDB()->where('id', $manga_id)->update('mangas', ['pin' => 0]);
    }

    public function getPin()
    {
        $mangas = Model::getDB()->where('pin', 0, 'NOT LIKE')->objectBuilder()->get('mangas');

        return (new Blade)->render('admin.components.pinlist', [
            'mangas' => $mangas,
        ]);
    }

    public function settings()
    {
        $siteConf = getConf('site');

        if (!request()->isAjax()) {
            return (new Blade)->render('admin.pages.settings', [
                'siteConf' => $siteConf,
            ]);
        }

        $listConf = ['site_url', 'tag_footer', 'newupdate_home', 'general_page', 'total_related', 'SBhistory', 'SBpopular', 'analytics_id', 'FBAppID', 'is_cache'];

        foreach ($listConf as $Conf) {
            $siteConf[$Conf] = input()->value($Conf, "");

            if (!input()->value('is_cache')) {
                $siteConf['is_cache'] = "off";
            }
        }

        setConf('site', $siteConf);

        response()->json([
            'msg' => 'Đã thay đổi cài đặt',
            'status' => true,
        ]);
    }

    public function scraperManage()
    {
        return (new Blade())->render('admin.pages.scraper-manage');
    }

    public function reported($page = 1)
    {
        Model::getDB()->pageLimit = 15;
        $reported = Model::getDB()->objectBuilder()->paginate('reported', $page);

        return (new Blade())->make('admin.pages.reported', [
            'reported' => $reported,
            'page' => $page,
            'total_page' => Model::getDB()->totalPages,
        ]);
    }

    public function addGroup()
    {
        return (new Blade)->render('admin.components.form.add-group');
    }

    public function addGroupUpdate()
    {
        $name = input()->value('name');

        Model::getDB()->insert('taxonomy', [
            'name' => $name,
            'slug' => slugGenerator($name),
            'description' => input()->value('description'),
            'taxonomy' => 'artists',
        ]);

        response()->json([
            'status' => true,
            'message' => 'Thêm thành công',
        ]);

    }

    public function adsSetting()
    {
        return (new Blade())->render('admin.pages.ads-setting');

    }

    public function seoSetting()
    {
        $slugs = [
            'manga' => 'Truyện',
            'chapter' => 'Chương',
            'manga_list' => 'Danh sách truyện',
            'completed' => 'Hoàn thành',
            'new-release' => 'Mới phát hành',
            'latest-updated' => 'Mới cập nhật',
            'most-viewed' => 'Xem nhiều',
            'search' => 'Tìm kiếm',
            'filter' => 'Bộ lọc',
            'genres' => 'Thể loại',
            'authors' => 'Tác giả',
            'artists' => 'Hoạ sĩ, Nhóm dịch',
            'manga-type' => 'Loại truyện',

        ];

        return (new Blade())->render('admin.pages.seo-setting', [
            'slugs' => $slugs,
        ]);

    }

}