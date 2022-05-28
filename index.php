<?php

$page =  $_SERVER['REQUEST_URI'];
$ep = explode('/', $page);
$get = end($ep);
/*
    case ($route . ''):
        $title = 'Newsfeed';
        include 'include/app/functions.php';
        include 'include/layouts/head.php';
        include 'view/';
        break;
*/

include 'conn.php';
switch ($page) {
    case ($route):
        $title = 'Newsfeed';
        include 'include/app/functions.php';
        include 'include/layouts/head.php';
        include 'view/newsfeed.php';
        break;
    case ($route . 'login'):
        $title = 'Login';
        $loader = '';
        include 'include/app/functions.php';
        include 'view/login/login.php';
        break;
    case ($route . 'verification'):
        $title = 'Verification';
        $loader = '';
        include 'view/login/verification.php';
        break;
    case ($route . 'forget-password'):
        $title = 'Forget Password';
        include 'include/app/functions.php';
        include 'view/login/forget-pass.php';
        break;
    case ($route . 'forget-password/' . $get):
        $title = 'Forget Password';
        include 'include/app/functions.php';
        include 'view/login/restore-pass.php';
        break;
    default:
        http_response_code(404);
        include '404.php';
        break;
}

include 'include/layouts/footer.php';
