<?php
include "/functions.php";
isAuth();
$userId = $_SESSION['user'];
$name = $_POST['name'];
$description = $_POST['description'];
$fullText = $_POST['fulltext'];
if($_POST['draft']){
    $draft = 1;
}
else{
    $draft = 0;
}

//Проверка данных на пустоту
validEmpty($_POST);
// если была произведена отправка формы
$img = addImage($_FILES, 'create-form.php');
//подготовка и выполнение запроса к БД
$sql = 'INSERT INTO tasks (user_id, name, description, fulltxt, img, draft) VALUES (:userId, :name, :description, :fullText, :img, :draft)';
$params = array(':userId' => $userId,':name' => $name, ':description' => $description,':fullText' => $fullText, ':img' => $img, ':draft' => $draft);
$result = addElem($sql, $params, $pdo);
//Переадресация на страницу авторизации
redirect('index.php');