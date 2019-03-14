<?php
/**
 * Created by PhpStorm.
 * Date: 27.02.2019
 * Time: 21:01
 */
//Получение данных из формы регистрации
$username = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

//Проверка данных на пустоту
foreach ($_POST as $post){
    if(empty($post)){
        $errorMessage = 'Заполните все поля.';
        include 'errors.php';
        exit;
    }
}

//подготовка и выполнение запроса к БД
$pdo = new PDO('mysql:host=localhost;dbname=task-manager', 'root','');
$sql = 'SELECT id FROM users WHERE email=:email';



$statement = $pdo->prepare($sql);
//$statement->execute([':email' => $email]);
$statement->execute(array(':email' => $email));

$user = $statement->fetchColumn();
if($user) {
    $errorMessage = 'Пользователь ы таким email уже существует';
    include 'errors.php';
    exit;
}

$sql = 'INSERT INTO users (username, email, password) VALUES (:username, :email, :password)';
$statement = $pdo->prepare($sql);
$password= md5($password);
//echo  $password;
//$result = $statement->execute($_POST);
$result = $statement->execute((array(':username' => $username,':email' => $email,':password' => $password)));

if(!$result){
    $errorMessage = 'Ошибка регистрации.';
    include 'errors.php';
    exit;
}
//Переадресация на страницу авторизации
header('Location: /task/login-form.php');
exit;
