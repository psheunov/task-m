<?php
include "/functions.php";
isAuth(false);
$email = $_POST['email'];
$password = $_POST['password'];
$password = md5($password);
validEmpty($_POST, true);

$sql = 'SELECT id FROM users WHERE email=:email AND password =:password';
$execute =array(':email' => $email,':password' => $password);
$user = getElement($sql, $execute, $pdo);
if($user) {
    $_SESSION['user']=$user;
    redirect('index.php');
}
else{
    $_SESSION['error']='Неверный email или пароль ';
    redirect('login-form.php');
}
