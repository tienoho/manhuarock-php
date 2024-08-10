<?php

use Services\Cache;

/**
 * @return object Data User
 */
function userget(){
    return $_SESSION['user_data'] ?? object();
}

function user_token($string){
    return sha1(md5($string));
}

function is_login(){
    return (!empty(userget()) && !empty($_COOKIE['UserID']));
}

function user_login($token, $user_id, $settings){
    $remember_time = time() + (2 * 24 * 60 * 60);
    setcookie("UserID", $user_id, $remember_time, '/');
    setcookie("UserToken", $token, $remember_time, '/');
    if(!empty($settings)){
        setcookie("mr_settings", $settings, $remember_time, '/');
    }
}

function user_logout(){
    $remember_time = time() - (365 * 24 * 60 * 60);
    setcookie("UserID", NULL, $remember_time, '/');
    setcookie("UserToken", NULL, $remember_time, '/');

    unset($_SESSION['user_data']);
}
