<?
include "/functions.php";
isAuth();
//подготовка и выполнение запроса к БД
$pdo = new PDO('mysql:host=localhost;dbname=task-manager', 'root','');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'SELECT img FROM tasks WHERE id=:id';
$statement = $pdo->prepare($sql);
$statement->execute(array(':id' => $_GET['id']));
$task  = $statement->fetch();
$img = $task['img'];
if(file_exists($img))
    unlink($img);

$sql = "DELETE FROM tasks WHERE id =  :id";
$statement = $pdo->prepare($sql);
$params = array(':id' => $_GET['id']);
$statement->execute(($params));
//Переадресация на страницу авторизации
redirect('index.php');
