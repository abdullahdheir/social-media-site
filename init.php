<?php
ob_start();
session_start();

if(!isset($_SESSION['id'])){
    header('location:/social-media-site/login.php');
    exit();
}
$layouts = 'include/layouts/';
$app     = 'include/app/';
include 'conn.php';
include $app.'functions.php';
include $layouts.'head.php';
include $layouts.'aside.php';
include $layouts.'asideHidden.php';
include $layouts.'chat.php';
include $layouts.'nav.php';
