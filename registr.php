<?php
include "/functions.php";
isAuth(false);
$username = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

//Проверка данных на пустоту
foreach ($_POST as $post){
    if(empty($post)){
        $errorMessage = 'Заполните все поля.';
        includeError();
    }
}

//подготовка и выполнение запроса к БД
$sql = 'SELECT id FROM users WHERE email=:email';
$statement = $pdo->prepare($sql);
$statement->execute(array(':email' => $email));
$user = $statement->fetchColumn();
if($user) {
    $errorMessage = 'Пользователь ы таким email уже существует';
    includeError();
}

$sql = 'INSERT INTO users (username, email, password) VALUES (:username, :email, :password)';
$statement = $pdo->prepare($sql);
$password= md5($password);
//echo  $password;
//$result = $statement->execute($_POST);
$result = $statement->execute((array(':username' => $username,':email' => $email,':password' => $password)));

if(!$result){
    $errorMessage = 'Ошибка регистрации.';
    includeError();
}
//Переадресация на страницу авторизации
redirect('login-form.php');
