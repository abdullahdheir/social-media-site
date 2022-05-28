<?php

require 'include/app/mailer.php';
try {
    $mail->setFrom('awfulm577@gmail.com', 'no-reply');
    $mail->addAddress("tareqm577@gmail.com");
    $mail->isHTML(true);
    $mail->Subject = 'Verification Code';
    $mail->Body    = 'Your Code Is <strong>5555</strong>';
    $mail->CharSet = 'UTF-8';
    $mail->send();
    echo 'Done';
} catch (Exception $err) {
    echo 'Fail';
}
