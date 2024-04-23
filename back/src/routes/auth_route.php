<?php

use App\Controller\Auth_Controller;
require_once '/var/www/html/silver-micro/back/src/controller/Auth_Controller.php';

$router->map('POST', '/login', function () {
    $user = new Auth_Controller($_POST);
    return $user->login();
}, 'login_post');

$router->map('GET', '/logout', function () {
    unset($_SESSION['user']);
    session_destroy();
    header('Location: /silver-micro/');
    exit;
}, 'logout');

$router->map('POST', '/register', function () {
    $new_user = new Auth_Controller($_POST);
    return $new_user->register();
}, 'register_post');

