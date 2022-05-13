<?php

$dsn  = 'mysql:host=localhost;dbname=social_media_site';
$user = 'root';
$pass = '';

try{
    $conn = new PDO($dsn,$user,$pass);
//    echo 'You Are Connect';
    global $conn;
}catch(PDOException $e){
    echo 'Faild Connect -> [ '.$e->getMessage().' ]';
}