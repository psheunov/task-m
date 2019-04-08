<?
include "/functions.php";
isAuth();
$userId = $_SESSION['user'];
$name = $_POST['name'];
$description = $_POST['description'];
$fullText = $_POST['fulltext'];
$taskId = $_POST['id'];
if($_POST['draft']){
    $draft = 1;
}
else{
    $draft = 0;
}
//Проверка данных на пустоту

validEmpty($_POST, true);
// если была произведена отправка формы
$img = addImage($_FILES, 'edit-form.php?id='. $taskId);
deleteSError();
//подготовка и выполнение запроса к БД
$sql = 'UPDATE tasks SET  name=?, description=?, fulltxt=?, img=?, draft=? WHERE id = ?';
$params = array($name, $description, $fullText,  $img ,$draft, $taskId);
$result = updateElem($sql, $params, $pdo);
//Переадресация на страницу авторизации
redirect('index.php');
