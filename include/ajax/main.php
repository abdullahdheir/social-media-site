<?php


$error = array();

include '../../conn.php';
require __DIR__ . '/../app/mailer.php';
require __DIR__ . '/../app/functions.php';

$do = isset($_GET['do']) ? $_GET['do'] : 'manage';

if ($do == 'login') {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $mail =  filter_var($_POST['login_email'], FILTER_SANITIZE_EMAIL);
        $pass =  md5(filter_var($_POST['login_password'], FILTER_SANITIZE_STRING));

        $stmt = $conn->prepare('select * from users where email = ? AND password = ? AND is_active = 1 LIMIT 1');
        $stmt->execute(array($mail, $pass));
        $row = $stmt->fetch();
        if ($stmt->rowCount() > 0) {
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['name'] = $row['fname'];
            echo 'success';
        } else {
            echo 'Invalid login, please try again';
        }
    }
} elseif ($do == 'register') {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $fname = filter_var($_POST['register_fname'], FILTER_SANITIZE_STRING);
        $lname = filter_var($_POST['register_lname'], FILTER_SANITIZE_STRING);
        $username = strtolower($fname . '-' . $lname);
        $email =  filter_var($_POST['register_email'], FILTER_SANITIZE_EMAIL);
        $pass = filter_var($_POST['register_password'], FILTER_SANITIZE_STRING);
        $passConm = filter_var($_POST['register_password_repeat'], FILTER_SANITIZE_STRING);

        $stmt = $conn->prepare('select * from users where email = ? LIMIT 1');
        $stmt->execute(array($email));
        $row = $stmt->fetch();

        // Error Empty 

        if (empty($fname)) {
            $error[] = 'Can\' Be This Feild Emtpy !!';
        }
        if (empty($lname)) {
            $error[] = 'Can\' Be This Feild Emtpy !!';
        }
        if (empty($email) || !filter_var($_POST['register_email'], FILTER_VALIDATE_EMAIL)) {
            $error[] = 'This Invalid Email Format !!';
        }

        if ($pass === $passConm) {
            $encPass = md5($pass);
        } else {
            $error[] = 'Passwords Not Match !!';
        }
        function randCodeGen()
        {
            $rand = rand(0, 1000000000);
            $str_rand = (string)$rand;
            if (strlen($str_rand) > 4) :
                return substr($str_rand, 0, 4);
            else :
                randCodeGen();
            endif;
        }
        $randCode = randCodeGen();

        if ($stmt->rowCount() > 0) {
            $error[] = 'This Email Already Exists !!';
        }
        if (empty($error)) {
            try {
                $mail->setFrom('awfulm577@gmail.com', 'no-reply');
                $mail->addAddress("$email");
                $mail->isHTML(true);
                $mail->Subject = 'Verification Code';
                $mail->Body    = 'Your Code Is <strong>' . $randCode . '</strong>';
                $mail->CharSet = 'UTF-8';
                $mail->send();
                $stmt1 = $conn->prepare('insert into users (username,fname , lname , email , password, v_code) values (:zusername,:zfname ,:zlname , :zemail , :zpassword , :zcode)');
                $stmt1->execute(array(
                    'zusername' => $username,
                    'zfname' => $fname,
                    'zlname' => $lname,
                    'zemail' => $email,
                    'zpassword' => $encPass,
                    'zcode' => $randCode,
                ));
                $_SESSION['v_email'] = $email;
                echo 'success';
            } catch (Exception $err) {
                echo 'Fail';
            }
        }
    }
} elseif ($do == 'logout') {

    session_unset();
    session_destroy();
} elseif ($do == 'forget-password') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = filter_var($_POST['forget_email'], FILTER_SANITIZE_EMAIL);
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $stmt = $conn->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
            $stmt->execute([$email]);
            $row = $stmt->fetch();
            if ($stmt->rowCount() > 0) {
                try {
                    $_SESSION['pass_id'] = $row['id'];
                    $code = md5(get_rand_alphanumeric(20));
                    $stmt1 = $conn->prepare('INSERT INTO password_reset (old_password , code_password , user_id) VALUES (:zold_pass ,:zcode_pass,:zuser_id)');
                    $stmt1->execute([
                        "zold_pass" => $row['password'],
                        "zcode_pass" => $code,
                        "zuser_id" => $row['id'],
                    ]);
                    if ($stmt1->rowCount() > 0) {
                        $mail->setFrom('awfulm577@gmail.com', 'no-reply');
                        $mail->addAddress("$email");
                        $mail->isHTML(true);
                        $mail->Subject = 'Restore Password';
                        $mail->Body    = '<!doctype html>
                        <html lang="en-US">
                            <head>
                                <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
                                <title>Reset Password Email Template</title>
                                <meta name="description" content="Reset Password Email Template.">
                                <style type="text/css">
                                    a:hover {text-decoration: underline !important;}
                                </style>
                            </head>
                            <body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #f2f3f8;" leftmargin="0">
                                <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8"
                                    style="@import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700); font-family: "Open Sans", sans-serif;">
                                    <tr>
                                        <td>
                                            <table style="background-color: #f2f3f8; max-width:670px;  margin:0 auto;" width="100%" border="0"
                                                align="center" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td style="height:80px;">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align:center;">
                                                    <a href="https://rakeshmandal.com" title="logo" target="_blank">
                                                        <img width="60" src="https://i.ibb.co/hL4XZp2/android-chrome-192x192.png" title="logo" alt="logo">
                                                    </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="height:20px;">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0"
                                                            style="max-width:670px;background:#fff; border-radius:3px; text-align:center;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);">
                                                            <tr>
                                                                <td style="height:40px;">&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding:0 35px;">
                                                                    <h1 style="color:#1e1e2d; font-weight:500; margin:0;font-size:32px;font-family:"Rubik",sans-serif;">You have
                                                                        requested to reset your password</h1>
                                                                    <span
                                                                        style="display:inline-block; vertical-align:middle; margin:29px 0 26px; border-bottom:1px solid #cecece; width:100px;"></span>
                                                                    <p style="color:#455056; font-size:15px;line-height:24px; margin:0;">
                                                                        We cannot simply send you your old password. A unique link to reset your
                                                                        password has been generated for you. To reset your password, click the
                                                                        following link and follow the instructions.
                                                                    </p>
                                                                    <a href="' . $_SERVER['SERVER_NAME'] . $route . 'forget-password/' . $code . '"
                                                                        style="background:#20e277;text-decoration:none !important; font-weight:500; margin-top:35px; color:#fff;text-transform:uppercase; font-size:14px;padding:10px 24px;display:inline-block;border-radius:50px;">Reset
                                                                        Password</a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="height:40px;">&nbsp;</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                <tr>
                                                    <td style="height:20px;">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td style="text-align:center;">
                                                        <p style="font-size:14px; color:rgba(69, 80, 86, 0.7411764705882353); line-height:18px; margin:0 0 0;">&copy; <strong>' . $_SERVER['SERVER_NAME'] . '</strong></p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="height:80px;">&nbsp;</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </body>

                        </html>';
                        $mail->CharSet = 'UTF-8';
                        $mail->send();
                        echo 'success';
                    }
                } catch (Exception $err) {
                    echo 'Fail';
                }
            } else {
                echo "This Email Not Register ";
            }
        } else {
            echo 'Invaild Email Format !!';
        }
    }
}

ob_end_flush();
