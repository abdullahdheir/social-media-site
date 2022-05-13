<?php 

ob_start();

session_start();

$error = array();

include '../../conn.php';

$do = isset($_GET['do'])?$_GET['do']: 'manage';

if($do == 'login'){

if($_SERVER['REQUEST_METHOD']=='POST'){

$mail =  filter_var($_POST['login_email'],FILTER_SANITIZE_EMAIL);
$pass =  md5(filter_var($_POST['login_password'],FILTER_SANITIZE_STRING));

    $stmt = $conn->prepare('select * from users where email = ? AND password = ? LIMIT 1');
    $stmt->execute(array($mail,$pass));
    $row = $stmt->fetch();
    if($stmt->rowCount() > 0){
        $_SESSION['id'] = $row['id'];
        $_SESSION['name'] = $row['fname'].' '.$row['lname'];
        echo 'success';
    }else{
        echo 'Invalid login, please try again';
    }

}

//echo '<h1>Success</h1>';

}elseif($do == 'register'){
//echo '<h1>Fail</h1>';
if($_SERVER['REQUEST_METHOD']=='POST'){
$fname = filter_var($_POST['register_fname'],FILTER_SANITIZE_STRING);
$lname = filter_var($_POST['register_lname'],FILTER_SANITIZE_STRING);
$mail =  filter_var($_POST['register_email'],FILTER_SANITIZE_EMAIL);
$pass = filter_var($_POST['register_password'],FILTER_SANITIZE_STRING);
$passConm = filter_var($_POST['register_password_repeat'],FILTER_SANITIZE_STRING);

    $stmt = $conn->prepare('select * from users where email = ? LIMIT 1');
    $stmt->execute(array($mail));
    $row = $stmt->fetch();
    

if($pass === $passConm){
    $encPass = md5($pass);
        
function randCodeGen(){
    $rand = rand(0,1000000000);
    $str_rand = (string)$rand;
    if(strlen($str_rand) > 6):
        return substr($str_rand,0,6);
    else:
    randCodeGen();
    endif;
}
    $randCode = randCodeGen();
    
if($stmt->rowCount() == 0){
    $stmt1 = $conn->prepare('insert into users (fname , lname , email , password, vcode) values (:zfname ,:zlname , :zemail , :zpassword , :zcode)');
    $stmt1->execute(array(
        'zfname' => $fname,
        'zlname' => $lname,
        'zemail' => $mail,
        'zpassword' => $encPass,
        'zcode' => $randCode,
    ));
}else{
echo 'error Insert';
}
}

}else{
echo 'error';
}
}elseif($do == 'logout'){
    session_unset();
    session_destroy();
}

ob_end_flush();