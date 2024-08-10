<?php

namespace Controllers;

use Models\Model;
use Services\Blade;

class Comment
{

    function vote()
    {
        $type = input()->value('type');
        $id = input()->value('id');

        if (isset($_SESSION['voted_' . $id])) {
            response()->json([
                'status' => false,
                'msg' => 'Voted'
            ]);
        }

        $check = Model::getDB()->objectBuilder()->where('id', $id)->getOne('manga_comments', 'likes, dislikes');

        if (!$check || !$type) {
            response()->httpCode(403);
        }

        switch ($type) {
            case 1:
                $input['likes'] = ($check->likes ?? 0) + 1;
                break;

            case 0:
                $input['dislikes'] = ($check->dislikes ?? 0) + 1;
                break;
        }

        $_SESSION['voted_' . $id] = 1;

        Model::getDB()->where('id', $id)->update('manga_comments', $input);

        response()->json([
            'status' => true
        ]);

    }

    function manage()
    {
        $page = input('page', 1);

        Model::getDB()->join('mangas m', 'm.id=c.manga_id');
        Model::getDB()->join('user u', 'u.id=c.user_id');

        Model::getDB()->pageLimit = 20;

        $comments = Model::getDB()->objectBuilder()->paginate('manga_comments c', $page, 'c.*, m.name, u.name as username');

        $total_page = Model::getDB()->totalPages;

        return (new Blade())->render('admin.pages.comment-manage', [
            'comments' => $comments,
            'total_page' => $total_page,
            'page' => $page,
        ]);
    }

    function delete($id)
    {
        Model::getDB()->where('id', $id)->delete('manga_comments');

        response()->json([
            'status' => true
        ]);
    }
}