<?php

namespace Controllers;

use Exception;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Models\Model;
use Models\User as UserModel;
use Services\Blade;
use Services\Fb;
use voku\helper\AntiXSS;

class User
{

    public function fbCallback()
    {
        $fb = (new Fb())->getFB();

        $helper = $fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch (FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        if (!isset($accessToken)) {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $helper->getError() . "\n";
                echo "Error Code: " . $helper->getErrorCode() . "\n";
                echo "Error Reason: " . $helper->getErrorReason() . "\n";
                echo "Error Description: " . $helper->getErrorDescription() . "\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }
            exit;
        }

        $_SESSION['fb_access_token'] = (string) $accessToken;

        $response = $fb->get('/me?fields=id,name,email', $accessToken);
        $user = $response->getGraphUser();

        $user_data = Model::getDB()->where('email', $user['email'])->objectBuilder()->getOne('user', 'email, password, id');

        if (!$user_data) {
            $pass = data_crypt(time() * 2);
            $data['name'] = $user->getName();
            $data['email'] = $user->getEmail();
            $data['role'] = \Config\User::DEFALT_ROLE;
            $data['password'] = $pass;
            $data['register_ip'] = request()->getIp();

            UserModel::addNewUser($data);

            $user_data = Model::getDB()->where('email', $user['email'])
                ->objectBuilder()
                ->getOne('user', 'email, password, id');
        }

        $remember_time = time() + (365 * 24 * 60 * 60);

        $token = user_token($user_data->email . $user_data->password);

        setcookie("UserID", $user_data->id, $remember_time, '/');
        setcookie("UserToken", $token, $remember_time, '/');

        response()->redirect('/');
    }

    public function login()
    {
        if (is_login()) {
            response()->redirect(path_url("home"));
        }

        $fbLogin = (new Fb())->getFB()->getRedirectLoginHelper()->getLoginurl(url('fb-callback'), ['email']);

        return (new Blade())->render('themes.' . app_theme() . '.pages.login', [
            'fbLogin' => $fbLogin,
        ]);
    }

    public function register()
    {
        if (is_login()) {
            response()->redirect(path_url("home"));
        }

        return (new Blade())->render('themes.' . app_theme() . '.pages.register');
    }

    /**
     * Show tình trang đăng nhập ajax ( Menu user action )
     */
    public function loginState()
    {
        $is_login = is_login();

        $html = (new Blade())->make('themes.' . app_theme() . '.components.ajax.login-state', ['is_login' => $is_login])->render();

        response()->httpCode(200)->json(['is_login' => $is_login, 'html' => $html]);
    }

    /**
     * Show thông báo cho user
     */
    public function notificationLatest()
    {
        $show_notification = [];
        if(is_login()){
            // Check user update
            $user = Model::getDB()->where('id', userget()->id)->objectBuilder()->getOne('user', 'coin, role');
            if(\is_object($user) && ($user->coin !== \userget()->coin || $user->role !== \userget()->role)){
                unset($_SESSION['user_data']);
            }

            $show_notification = Model::getDB()->where('user_id', userget()->id)->orderBy('create_at', 'DESC')->objectBuilder()->get('notification', 10);
        }

        $html = (new Blade())->make('themes.' . app_theme() . '.components.ajax.notification-latest', ['notification' => $show_notification])->render();

        response()->httpCode(200)->json(['status' => true, 'html' => $html]);
    }

    /**
     * @param $type
     * @param $manga_id
     * Show đánh giá truyện ajax
     */
    public function voteManga($type, $manga_id)
    {
        $blable = new Blade;

        switch ($type) {
            case 'info':
                $html = $blable->make('themes.' . app_theme() . '.components.ajax.info-vote', ['manga_id' => $manga_id])->render();
                break;
        }

        response()->httpCode(200)->json(['status' => true, 'html' => $html]);

    }

    /**
     * Api đăng kí tài khoản mới
     */
    public function registerApi()
    {
        $data['name'] = input()->value('name');
        $data['email'] = input()->value('email');
        $data['role'] = \Config\User::DEFALT_ROLE;
        $data['password'] = input()->value('password');
        $data['register_ip'] = request()->getIp();
        $cf_password = input()->value('cf_password');

        foreach ($data as $key => $value) {
            if (empty($value)) {
                response()->httpCode(200)->json(['status' => false, 'msg' => 'Có lỗi xảy ra. Vui lòng thử lại sau.']);
            }

            $data[$key] = (new AntiXSS)->xss_clean($data[$key]);
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            response()->httpCode(200)->json(['status' => false, 'msg' => 'Email không hợp lệ']);
        }

        if ($data['password'] !== $cf_password) {
            response()->httpCode(200)->json(['status' => false, 'msg' => 'Xác nhận mật khẩu không khớp']);
        }

        $data['password'] = data_crypt($data['password']);

        UserModel::addNewUser($data);

        response()->httpCode(200)->json(['status' => true, 'mgs' => 'Đăng kí thành công']);
    }

    /**
     * Api Login tài khoản mới
     */
    public function loginApi()
    {
        $data['email'] = input()->value('email');
        $password = data_crypt(input()->value('password'));
        $remember = input()->value('remember');

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            response()->httpCode(200)->json(['status' => false, 'msg' => 'Email không hợp lệ']);
        }

        UserModel::getDB()->where('email', $data['email']);
        UserModel::getDB()->where('password', $password);

        foreach ($data as $key => $value) {
            if (empty($value)) {
                response()->httpCode(200)->json(['status' => false, 'msg' => 'Có lỗi xảy ra. Vui lòng thử lại sau.']);
            }

            $data[$key] = (new AntiXSS)->xss_clean($data[$key]);
        }

        $user_data = UserModel::getDB()->objectBuilder()->getOne('user', 'email, password, id');
        if (!$user_data) {
            response()->httpCode(200)->json(
                ['status' => false, 'msg' => 'Tài khoản mật khẩu không hợp lệ']
            );
        }

        $remember_time = time() + (2 * 24 * 60 * 60);

        if ($remember === 'on') {
            $remember_time = time() + (365 * 24 * 60 * 60);
        }

        $token = user_token($user_data->email . $user_data->password);

        setcookie("UserID", $user_data->id, $remember_time, '/');
        setcookie("UserToken", $token, $remember_time, '/');

        //        UserModel::setData($user_data, $token);

        response()->httpCode(200)->json(['status' => true, 'msg' => 'Đăng nhập thành công']);
    }

    /**
     * Api Logout khỏi tài khoản hiện tại
     */
    public function logoutApi()
    {
        $remember_time = time() - (365 * 24 * 60 * 60);
        setcookie("UserID", null, $remember_time, '/');
        setcookie("UserToken", null, $remember_time, '/');

        unset($_SESSION['user_data']);

        $referer = request()->getReferer() ?? path_url('home');

        response()->redirect($referer, 200);
    }

    /**
     * Api lưu cài đặt user (Theme)
     */
    public function userSettings()
    {
        $settings = input()->value('settings');

        $settings = json_encode($settings, JSON_FORCE_OBJECT);

        UserModel::getDB()->where('id', userget()->id);
        UserModel::getDB()->update('user', ['settings' => $settings]);

        response()->httpCode(200)->json(['status' => true]);
    }

    /**
     * Api Cập nhật thông tin cá nhân
     */
    public function userUpdateProfile()
    {
        // Update Avatar User
        $avatar_id = input()->value('avatar_id', null);
        $name = input()->value('name', null);
        $new_password = input()->value('new_password');
        $confirm_new_password = input()->value('confirm_new_password');
        $current_password = input()->value('current_password');

        if ($avatar_id) {
            $data['avatar_id'] = $avatar_id;
        }

        if ($name) {
            $data['name'] = $name;
        }

        if ($current_password && !empty($new_password) && !empty($confirm_new_password) && ($new_password === $confirm_new_password)) {
            Model::getDB()->where('id', userget()->id)->where('password', $current_password);
            $check = Model::getDB()->getValue('user', 'id');

            if ($check) {
                $data['password'] = $new_password;
            }
        }

        Model::getDB()->where('id', userget()->id)->update('user', $data);

        unset($_SESSION['user_data']);
        response()->json(['status' => true, 'msg' => \L::_("Saved changes")]);
    }

    /**
     * Trang cá nhân của user
     */
    public function profilePage()
    {
        return (new Blade())->render('themes.' . app_theme() . '.pages.profile', []);
    }
    /**
     * Trang user nạp coin
     */
    public function addCoin()
    {
        return (new Blade())->render('themes.' . app_theme() . '.pages.addCoin', []);
    }
    /**
     * Api lưu lịch sử đọc truyện
     */
    public function logReadingApi()
    {
        $data = input()->all(['manga_id', 'reading_id', 'reading_number', 'image_number', 'type']);
        $data['user_id'] = userget()->id;
        $data['updated_at'] = Model::getDB()->now();

        Model::getDB()->where('manga_id', $data['manga_id']);
        Model::getDB()->where('reading_id', $data['reading_id']);
        Model::getDB()->where('user_id', $data['user_id']);

        $id_check = Model::getDB()->getValue('user_log_reading', 'id');

        if ($id_check) {
            Model::getDB()->where('id', $id_check);
            Model::getDB()->update('user_log_reading', $data);
        } else {
            Model::getDB()->insert('user_log_reading', $data);
        }

        response()->json(['status' => true]);
    }

    /**
     * Page sow lịch sử đọc truyện
     */
    public function continueReadingPage()
    {
        $page = input()->value('page', 1);
        // SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));

        Model::getDB()->where('log1.user_id', userget()->id);
        Model::getDB()->orderBy('log1.updated_at');

        $user_log_reading2 = Model::getDB()->subQuery("log2");
        $user_log_reading2->where('user_id', userget()->id);
        $user_log_reading2->groupBy('manga_id');
        $user_log_reading2->get('user_log_reading', null, 'max(updated_at) as max_updated_at, manga_id');

        Model::getDB()->join($user_log_reading2, 'log1.updated_at=log2.max_updated_at AND log2.manga_id=log1.manga_id', 'INNER');

        Model::getDB()->join('mangas', 'log1.manga_id=mangas.id', 'LEFT');
        Model::getDB()->where('mangas.hidden', 0);

        Model::getDB()->join('chapters', 'log1.reading_id=chapters.id');

        Model::getDB()->objectBuilder();

        Model::getDB()->pageLimit = 16;

        $list_reading = Model::getDB()->paginate('user_log_reading log1', $page, 'mangas.name, mangas.slug, mangas.id, mangas.cover, mangas.adult, chapters.last_update as chapter_last_update, chapters.slug as chapter_slug, chapters.name as chapter_name, chapters.id as chapter_id');
        $paginate = object();
        $paginate->total_page = Model::getDB()->totalPages;
        $paginate->current_page = $page;

        return (new Blade())->render('themes.' . app_theme() . '.pages.continue-reading', [
            'list_reading' => $list_reading,
            'paginate' => $paginate,
        ]);
    }

    /**
     * Api xóa lịch sử đọc
     */
    public function continueReadingRemove()
    {
        $id = input()->value('id');

        Model::getDB()->where('manga_id', $id)->delete('user_log_reading');

        response()->json(['status' => true, 'msg' => \L::_('Delete successfully')]);
    }

    /**
     * Show các loại bookmark
     * @param $manga_id
     * @throws Exception
     */
    public function readingList($manga_id)
    {
        if (is_login()) {
            Model::getDB()->where('manga_id', $manga_id);
            Model::getDB()->where('user_id', userget()->id);
            $check = Model::getDB()->objectBuilder()->getOne('user_reading_list', 'type');
        }

        $data['type'] = $check->type ?? null;
        $data['manga_id'] = $manga_id;

        $html = (new Blade)->make('themes.' . app_theme() . '.components.ajax.reading-list', $data)->render();

        response()->httpCode(200)->json(['status' => true, 'html' => $html, 'data' => $data]);
    }

    /**
     * Api lưu truyện vào danh tủ sách
     */
    public function readingListAdd()
    {
        $manga_id = input()->value('mangaId');
        $type = input()->value('type');

        Model::getDB()->where('manga_id', $manga_id);
        Model::getDB()->where('user_id', userget()->id);

        $html = (new Blade)->make('themes.' . app_theme() . '.components.ajax.reading-list', ['manga_id' => $manga_id, 'type' => $type])->render();

        if (!$type) {
            $id = Model::getDB()->getValue('user_reading_list', 'id');
            if (!$id) {
                response()->json([
                    'status' => false,
                    'msg' => 'Bạn chưa theo dõi truyện này',
                ]);
            }

            Model::getDB()->where('id', $id)->delete('user_reading_list', 1);

            response()->httpCode(200)->json(['status' => true, 'html' => $html, 'msg' => \L::_('This manga has been remove to Reading List')]);
        }

        $id = Model::getDB()->getValue('user_reading_list', 'id');
        if ($id) {
            Model::getDB()->where('id', $id);
            Model::getDB()->update('user_reading_list', ['type' => $type]);
        } else {
            Model::getDB()->insert('user_reading_list', [
                'manga_id' => $manga_id,
                'type' => $type,
                'user_id' => userget()->id,
            ]);
        }

        $total_bookmarks = Model::getDB()->where('manga_id', $manga_id)->getOne('user_reading_list', 'COUNT(id) as total_bookmarks');

        Model::getDB()->where('id', $manga_id)->update('mangas', [
            'total_bookmarks' => $total_bookmarks['total_bookmarks'],
        ]);
        response()->httpCode(200)->json([
            'status' => true,
            'html' => $html,
            'msg' => \L::_('This manga has been added to Reading List'),
        ]);
    }

    public function readingListPage()
    {
        $page = input()->value('page', 1);

        $page = input()->value('page', 1);
        $type = input()->value('type');
        $sort = input()->value('sort');
        // SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));

        Model::getDB()->where('user_reading_list.user_id', userget()->id);

        if ($type) {
            Model::getDB()->where('user_reading_list.type', $type);
        }

        Model::getDB()->join('mangas', 'user_reading_list.manga_id=mangas.id');
        Model::getDB()->groupBy('mangas.id');
        Model::getDB()->where('mangas.hidden', 0);
        Model::getDB()->orderBy(getSort($sort));

        Model::getDB()->objectBuilder();
        Model::getDB()->pageLimit = 16;

        $list_reading = Model::getDB()->paginate('user_reading_list', $page, 'mangas.name, mangas.slug, mangas.id, mangas.cover, mangas.adult, mangas.views, mangas.rating_score, user_reading_list.type as read_type');
        $paginate = object();
        $paginate->total_page = Model::getDB()->totalPages;
        $paginate->current_page = $page;

        return (new Blade())->render('themes.' . app_theme() . '.pages.reading-list', [
            'list_reading' => $list_reading,
            'paginate' => $paginate,
            'type' => $type,
            'sort' => $sort,
        ]);
    }

    public function commentManga($manga_id)
    {
        $page = input()->value('page', 1);
        $sort = input()->value('sort', 'newest');

        $comments = (new UserModel)->getComent($manga_id, $page, $sort);

        $html = (new Blade())->render('themes.' . app_theme() . '.components.ajax.comment', [
            'hidden_form' => false,
            'comments' => $comments,
        ]);

        response()->json([
            'gotoId' => null,
            'html' => $html,
            'status' => true,
        ]);
    }

    public function addComment()
    {
        $content = input()->value('content');
        $is_spoil = input()->value('is_spoil', 0);
        $manga_id = input()->value('manga_id');
        $parent_id = input()->value('parent_id');
        $mention_id = input()->value('mention_id');
        $chapter_id = input()->value('chapter_id');

        $manga = Model::getDB()->where('id', $manga_id)->objectBuilder()->getOne('mangas');
        if(!$manga){
            die();
        }

        if(!empty($chapter_id)){
            $chapter = Model::getDB()->where('id', $chapter_id)->objectBuilder()->getOne('chapters');
            if (!$chapter) {
                die();
            }
        }


        $user_id = userget()->id;

        $antiXss = (new AntiXSS);

        if (!$antiXss->xss_clean($content) || $antiXss->isXssFound()) {
            response()->json([
                'msg' => 'Comment không hợp lệ!',
            ]);
        }

        if (!is_numeric($manga_id) && !is_numeric($is_spoil)) {
            response()->redirect(path_url('404'));
        }

        Model::getDB()->insert('manga_comments', [
            'is_spoil' => $is_spoil,
            'manga_id' => $manga_id,
            'user_id' => $user_id,
            'content' => $content,
            'parent_id' => $parent_id,
            'mention_id' => $mention_id,
            'chapter_id' => $chapter_id,
        ]);

        $notification_config = include(\ROOT_PATH . '/config/notification.php');

        if(!empty($parent_id) || !empty($mention_id)){ 
            if($parent_id == $mention_id){

                if(!empty($chapter)){
                    $url = chapter_url($manga, $chapter);
                } else {
                    $url = \manga_url($manga);
                }

                Model::getDB()->insert('notification', [
                    'user_id' => $mention_id,
                    'msg' => \sprintf($notification_config['mention_msg'], \userget()->name),
                    'url' => $url
                ]);
            }
        }

        $comments = (new UserModel)->getComent($manga_id, 1, 'newest');

        $html = (new Blade())->render('themes.' . app_theme() . '.components.ajax.comment', [
            'hidden_form' => true,
            'comments' => $comments,

        ]);

        response()->json([
            'gotoId' => $parent_id,
            'html' => $html,
            'status' => true,
        ]);
    }

    public function commentReport()
    {
        $comment_id = input()->value('id');
        $report_type = input()->value('type');

        Model::getDB()->where('id', $comment_id);
        if (Model::getDB()->has('manga_comments')) {
            Model::getDB()->where('id', $comment_id);

            Model::getDB()->update('manga_comments', [
                'report_type' => $report_type,
            ]);

        }

    }

    public function requestPermission()
    {
        if (!is_login()) {
            response()->redirect('/request-permission');
        }
        if ((new \Models\User)->hasPermission(['all', 'manga'])) {
            response()->redirect(path_url('admin'));
        }

        $action = input()->value('submit');

        if ($action === 'permission') {
            $name_group = input()->value('name_group');
            $url_produce = input()->value('url_produce');

            Model::getDB()->where('user_id', userget()->id)
                ->where('type', $action);
            if (Model::getDB()->has('user_request')) {
                response()->redirect(path_url('admin'));
            }

            Model::getDB()->insert('user_request', [
                'user_id' => userget()->id,
                'type' => $action,
                'metadata' => json_encode([
                    'name_group' => $name_group,
                    'url_produce' => $url_produce,
                ]),
            ]);

        }

        return (new Blade())->render('themes.' . app_theme() . '.pages.request-permission');
    }

    public function paymentMethod()
    {
        $userID = userget()->id;
        //        $method = input()->value('method');

        return (new Blade())->render('admin.pages.user_payment_method');
    }

    public function getPassApi()
    {
        $email = input()->value('email');

        Model::getDB()->where('email', $email);
        $user = Model::getDB()->objectBuilder()->getOne('user');

        if (!$user) {
            response()->json([
                'msg' => 'Tài khoản không tồn tại!',
            ]);
        }
        $conf = getConf("mail");

        $pass = data_crypt($user->password, 'd');

        $htmforgotpass = (new Blade())->render('mail.forgotpass', [
            'user' => $user,
            'pass' => $pass,
        ]);
        $mail = (new \Services\Mail())->mail;

        $mail->setFrom($conf['Username'], $conf['UserDisplay']);

        $mail->addAddress($user->email, $user->name);

        //Content
        $mail->isHTML(true); //Set email format to HTML
        $mail->Subject = 'Lấy lại mật khẩu';
        $mail->Body = $htmforgotpass;
        $mail->AltBody = "Mật khẩu bạn đã quên là: $pass";

        if (!$mail->send()) {
            response()->json([
                'msg' => 'Xảy ra lỗi trong quá trình gửi mail, vui lòng thử lại sau!',
            ]);
        } else {
            response()->json([
                'msg' => 'Mật khẩu đã được gửi vào email của bạn!',
            ]);
        }
    }

    public function unlockChapter()
    {
        if (!is_login()) {
            response()->json([
                'status' => 'fail',
                'msg' => 'Bạn cần đăng nhập để thực hiện chức năng này!',
            ]);
        }

        $chapter_id = input()->value('reading_id');
        $user_id = userget()->id;

        $chapter = Model::getDB()->where('id', $chapter_id)->objectBuilder()->getOne('chapters');
        $user = Model::getDB()->where('id', $user_id)->objectBuilder()->getOne('user');

        if (!$chapter || !$user) {
            return response()->json([
                'status' => 'fail',
                'msg' => 'Không tìm thấy dữ liệu!',
            ]);
        }

        if ($user->coin < $chapter->price) {
            return response()->json([
                'status' => 'fail',
                'msg' => 'Bạn không đủ điểm để mua chương này!',
            ]);
        }

        Model::getDB()->where('chapter_id', $chapter_id);
        Model::getDB()->where('user_id', $user_id);
        $unlocked_chapters = Model::getDB()->getOne('unlocked_chapters');

        if (!$unlocked_chapters) {
            unset($_SESSION['user_data']);

            UserModel::getDB()->where('id', $user_id)->update('user', [
                'coin' => $user->coin - $chapter->price,
            ]);

            Model::getDB()->insert('unlocked_chapters', [
                'user_id' => $user_id,
                'chapter_id' => $chapter_id,
                'create_at' => Model::getDB()->now(),
            ]);

        }

        response()->json([
            'status' => 'ok',
            'msg' => 'Đã mở khóa chương này!',
        ]);

    }
}