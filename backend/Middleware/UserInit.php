<?php
namespace Middleware;

use Models\Model;
use Models\User;
use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;
use Services\Cache;

class UserInit implements IMiddleware {

    public function handle(Request $request)  : void {

        if(!isset($_COOKIE['UserID']) || !isset($_COOKIE['UserToken'])){
            return;
        }

        if(!empty(userget()->id)){
            return;
        }
       
        Model::getDB()->where('user.id', $_COOKIE['UserID']);
        Model::getDB()->join('user_avatar', 'user.avatar_id=user_avatar.id', "LEFT");
        $user_data = Model::getDB()
            ->objectBuilder()
            ->getOne('user', 'user.*,IFNULL(user_avatar.url, "https://i.pinimg.com/736x/4e/06/0b/4e060bd1ec00e99dad7bb8a684411209.jpg") as avatar_url');

        if(!$user_data){
            setcookie("UserID", $user_data->id, time() - 10, '/');
            setcookie("UserToken", $token, time() - 10, '/');
            return;
        }

        $token = user_token($user_data->email. $user_data->password);
        if($token === $_COOKIE['UserToken']){
            User::setData($user_data, $token);
        }


    }

}