<?php
include "/functions.php";
isAuth(false);
$username = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

//Проверка данных на пустоту
validEmpty($_POST);
//подготовка и выполнение запроса к БД
$sql = 'SELECT id FROM users WHERE email=:email';
$execute = array(':email' => $email);
$user = getElement($sql, $execute, $pdo);
includeError($user,'Пользователь ы таким email уже существует');
$password= md5($password);
$sql = 'INSERT INTO users (username, email, password) VALUES (:username, :email, :password)';
$execute = array(':username' => $username,':email' => $email,':password' => $password);
$result = addElem($sql, $execute, $pdo);
includeError(!$result,'Ошибка регистрации.');
//Переадресация на страницу авторизации
redirect('login-form.php');
