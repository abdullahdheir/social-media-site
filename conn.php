<?php
ob_start();
session_start();
$dsn  = 'mysql:host=localhost;dbname=social_media_site';
$user = 'root';
$pass = '';

try {
    $conn = new PDO($dsn, $user, $pass);
    //    echo 'You Are Connect';
    global $conn;
} catch (PDOException $e) {
    echo 'Faild Connect -> [ ' . $e->getMessage() . ' ]';
}

$route = '/social-media-site/';
