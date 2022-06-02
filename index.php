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

$route_login = $route . 'login';
$route_verification = $route . 'verification';
$route_forgetPassword = $route . 'forget-password';
$route_myProfile = $route . 'my-profile';


switch ($page) {
    case ($route):
        $title = 'Newsfeed';
        include 'include/app/functions.php';
        include 'include/layouts/head.php';
        include 'view/newsfeed.php';
        break;
    case ($route_login):
        $title = 'Login';
        $loader = '';
        include 'include/app/functions.php';
        include 'view/login/login.php';
        break;
    case ($route_verification):
        $title = 'Verification';
        $loader = '';
        include 'view/login/verification.php';
        break;
    case ($route_forgetPassword):
        $title = 'Forget Password';
        include 'include/app/functions.php';
        include 'view/login/forget-pass.php';
        break;
    case ($route_forgetPassword . '/' . $get):
        $title = 'Forget Password';
        include 'include/app/functions.php';
        include 'view/login/restore-pass.php';
        break;
    case ($route_myProfile):
        $title = 'My Profile';
        $loader = '';
        include 'include/app/functions.php';
        include 'include/layouts/head.php';
        include 'view/init.php';
        include 'view/profile/hub-profile-info.php';
        break;
    default:
        http_response_code(404);
        include '404.php';
        break;
}

include 'include/layouts/footer.php';
