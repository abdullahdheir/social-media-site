<?php

include 'conn.php';
if (!isset($_SESSION['v_email'])) {
    header('location:' . $route . 'login');
    exit();
}
require 'include/app/mailer.php';


$email = filter_var($_SESSION['v_email'], FILTER_SANITIZE_EMAIL);
function randCodeGen()
{
    $rand = rand(0, 1000000000);
    $str_rand = (string)$rand;
    if (strlen($str_rand) > 4) {
        return substr($str_rand, 0, 4);
    } else {
        randCodeGen();
    }
}
$v_code = randCodeGen();

$stmt = $conn->prepare('UPDATE users SET v_code = ? WHERE email = ? ');
$stmt->execute([$v_code, $email]);

if ($stmt->rowCount() > 0) {
    try {
        $mail->setFrom('awfulm577@gmail.com', 'no-reply');
        $mail->addAddress("$email");
        $mail->isHTML(true);
        $mail->Subject = 'Verification Code';
        $mail->Body    = 'Your Code Is <strong>' . $v_code . '</strong>';
        $mail->CharSet = 'UTF-8';
        $mail->send();
        echo 'success';
    } catch (Exception $err) {
        echo 'Fail';
    }
}












ob_end_flush();
