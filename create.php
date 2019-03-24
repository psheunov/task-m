<?
session_start();
$userId = $_SESSION['user'];
$name = $_POST['name'];
$description = $_POST['description'];
$fullText = 'text';
if($_POST['draft']){
    $draft = 1;
}
else{
    $draft = 0;
}

//Проверка данных на пустоту
foreach ($_POST as $post){
    if(empty($post)){
        $errorMessage = 'Заполните все поля.';
        include 'errors.php';
        exit;
    }
    // если была произведена отправка формы
    if(isset($_FILES['image'])) {
        // загружаем изображение на сервер
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];
        $file_ext = strtolower(end(explode('.',$_FILES['image']['name'])));
        $file_name = uniqid() .'.'.$file_ext;
        if($file_ext != 'jpg' and $file_ext != 'png'){
            $_SESSION['error']='Неверное расширение изображения';
            header('Location: /task/create-form.php');
            exit;
        }
        $img ='upload/'.$file_name;
        move_uploaded_file($file_tmp, $img);
    }
}

//подготовка и выполнение запроса к БД
$pdo = new PDO('mysql:host=localhost;dbname=task-manager', 'root','');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = 'INSERT INTO tasks (user_id, name, description, fulltxt, img, draft) VALUES (:userId, :name, :description, :fullText, :img, :draft)';
$statement = $pdo->prepare($sql);
$params = array(':userId' => $userId,':name' => $name, ':description' => $description,':fullText' => $fullText, ':img' => $img, ':draft' => $draft);
$result = $statement->execute(($params));

//Переадресация на страницу авторизации
header('Location: /task/index.php');
exit;
