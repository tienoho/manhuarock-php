<?php

namespace Controllers;

class GoogleLogin {
    public $select = ['user', 'email, password, id'];
    public function callback(){
        $GoogleLogin = new \Services\GoogleLogin();
        $user = $GoogleLogin->getUserInfo();
        $email = $user['email'];
        $name = $user['name'];
        $user = \Models\Model::getDB()->where('email', $email)->objectBuilder()->getOne('user', $this->select);

        if (!$user) {
            $password = data_crypt($email . time());

            \Models\Model::getDB()->insert('user', [
                'email' => $email,
                'name' => $name,
                'password' => $password,
                'role' => \Config\User::DEFALT_ROLE,
            ]);

            $user = \Models\Model::getDB()->where('email', $email)->objectBuilder()->getOne('user', $this->select);
        }

        $remember_time = time() + (365 * 24 * 60 * 60);

        if(\is_object($user)){
            $token = user_token($user->email . $user->password);

            setcookie("UserID", $user->id, $remember_time, '/');
            setcookie("UserToken", $token, $remember_time, '/');

        }
        
        header('Location: /');
    }
}