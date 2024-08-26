<?php

namespace Models;

use Services\Cache;
use Exception;

class User extends Model
{
    public $user_roles = [
        'admin' => 'Admin',
        'trans' => 'Trans',
        'member' => 'Thành viên'
    ];


    protected $role_permission = [
        'admin' => 'all',
        'trans' => [
            'manga' => true
        ],
    ];


    function getRoleName($role)
    {
        return $this->user_roles[$role] ?? 'Unknown';
    }

    function hasPermission($permissions)
    {

        foreach ($permissions as $permission) {
            if (
                isset($this->role_permission[userget()->role ?? NULL])
                && ($this->role_permission[userget()->role] === $permission
                    || (isset($this->role_permission[userget()->role][$permission]) && $this->role_permission[userget()->role][$permission] == true))
            ) {
                return true;
            }
        }

        return false;
    }

    function getUserGroup($id)
    {
        User::getDB()->where('taxonomy_user.user_id', $id);
        User::getDB()->join('taxonomy', 'taxonomy.id=taxonomy_user.taxonomy_id');
        User::getDB()->joinWhere('taxonomy', 'taxonomy.taxonomy', 'artists');

        User::getDB()->groupBy('taxonomy_user.taxonomy_id');

        return User::getDB()->objectBuilder()->get('taxonomy_user', null, 'taxonomy.id, taxonomy.name');
    }


    static function addNewUser($data)
    {
        $id = Model::getDB()->insert('user', $data);

        if (empty($id)) {
            echo (Model::getDB()->getLastError());

            exit();
        }

        return $id;
    }

    static function setData($user_data, $token)
    {

        $_SESSION['user_data'] = $user_data;

        user_login($token, $user_data->id, $user_data->settings);

    }

    static function avatarList()
    {
        $data = Model::getDB()->objectBuilder()->get('user_avatar');

        foreach ($data as $avatar) {
            $avatars[$avatar->tag][] = $avatar;
        }

        return $avatars;
    }

    function getComent($manga_id, $page, $sort)
    {
        if ($sort) {
            switch ($sort) {
                case 'top':
                    Model::getDB()->orderBy('manga_comments.like');
                    break;
                case 'oldest':
                    Model::getDB()->orderBy('manga_comments.updated_at', 'ASC');
                    break;
                default:
                    Model::getDB()->orderBy('manga_comments.updated_at');
                    break;
            }
        }

        Model::getDB()->where('manga_comments.manga_id', $manga_id);
        Model::getDB()->where('manga_comments.parent_id', NULL, 'IS');

        Model::getDB()->join('user', 'user.id=manga_comments.user_id');
        Model::getDB()->join('user_avatar', 'user_avatar.id=user.avatar_id', 'LEFT');

        Model::getDB()->join('chapters', 'chapters.id=manga_comments.chapter_id', 'LEFT');

        Model::getDB()->pageLimit = 15;

        return Model::getDB()->objectBuilder()->paginate('manga_comments', $page, 'manga_comments.*, user.id as userid, user.name as username, user.role as userrole, user_avatar.url as useravata, chapters.name as chapter_name');
    }

    function getReplys($parent_id)
    {
        Model::getDB()->where('parent_id', $parent_id);
        Model::getDB()->orderBy('updated_at');

        Model::getDB()->objectBuilder();
        Model::getDB()->join('user', 'user.id=manga_comments.user_id');
        Model::getDB()->join('user as mention', 'mention.id=manga_comments.mention_id');
        Model::getDB()->join('user_avatar', 'user_avatar.id=user.avatar_id');

        return Model::getDB()->get('manga_comments', null, 'manga_comments.*, user.id as userid, user.name as username, user.role as userrole, user_avatar.url as useravata, mention.name as mention_name');
    }
}