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
foreach ($_POST as $post){
    if(empty($post)){
        $_SESSION['error']='Заполните все поля.';
        header('Location: /edit-form.php?id='.$taskId);
        exit;
    }
}
// если была произведена отправка формы
if(isset($_FILES['image']) && !empty($_FILES['image']['name'])) {

    // загружаем изображение на сервер
    $file_name = $_FILES['image']['name'];
    $file_size = $_FILES['image']['size'];
    $file_tmp = $_FILES['image']['tmp_name'];
    $file_type = $_FILES['image']['type'];
    $file_ext = strtolower(end(explode('.',$_FILES['image']['name'])));
    $file_name = uniqid() .'.'.$file_ext;
    if($file_ext != 'jpg' and $file_ext != 'png'){
        $_SESSION['error']='Неверное расширение изображения';
        header('Location: /edit-form.php?id='.$taskId);
        exit;
    }

    $img ='upload/'.$file_name;
    move_uploaded_file($file_tmp, $img);
}
else{
    $img = $_POST['img'];
}
if(!empty( $_SESSION['error'])){
    unset($_SESSION['error']);
}
//подготовка и выполнение запроса к БД
$sql = 'UPDATE tasks SET  name=?, description=?, fulltxt=?, img=?, draft=? WHERE id = ?';
$statement = $pdo->prepare($sql);
$params = array($name, $description, $fullText,  $img ,$draft, $taskId);
$result = $statement->execute(($params));

//Переадресация на страницу авторизации
redirect('index.php');
