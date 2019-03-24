<?php
session_start();
/*echo  '<pre>';
var_dump($_POST);
echo  '</pre>';*/
$email = $_POST['email'];
$password = $_POST['password'];
$password = md5($password);
if(empty($email) || empty($password)){
    $_SESSION['error']='Заполните все поля ';
    header('Location: /task/login-form.php');
    exit;
}
//подготовка и выполнение запроса к БД
$pdo = new PDO('mysql:host=localhost;dbname=task-manager', 'root','');
$sql = 'SELECT id FROM users WHERE email=:email AND password =:password';

$statement = $pdo->prepare($sql);
//$statement->execute([':email' => $email]);
$statement->execute(array(':email' => $email,':password' => $password));

$user = $statement->fetchColumn();

if($user) {
    $_SESSION['user']=$user;
    header('Location: /task/index.php');
    exit;
}
else{
    $_SESSION['error']='Неверный email или пароль ';
    header('Location: /task/login-form.php');
}
