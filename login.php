<?php
include "/functions.php";
isAuth(false);
$email = $_POST['email'];
$password = $_POST['password'];
$password = md5($password);
if(empty($email) || empty($password)){
    $_SESSION['error']='Заполните все поля ';
    header('Location: /task/login-form.php');
    exit;
}
$sql = 'SELECT id FROM users WHERE email=:email AND password =:password';
$statement = $pdo->prepare($sql);
$statement->execute(array(':email' => $email,':password' => $password));
$user = $statement->fetchColumn();

if($user) {
    $_SESSION['user']=$user;
    redirect('index.php');
}
else{
    $_SESSION['error']='Неверный email или пароль ';
    redirect('login-form.php');
}
