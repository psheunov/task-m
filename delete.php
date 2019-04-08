<?
include "/functions.php";
isAuth();
//подготовка и выполнение запроса к БД
$task = getTaskById($_GET['id'], $pdo);
$img = $task['img'];
if(file_exists($img))
    unlink($img);
deleteTask($_GET['id'] ,$pdo);
//Переадресация на страницу авторизации
redirect('index.php');
