<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=task-manager', 'root','');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
function isAuth($type = true){
    if($type){
        if(empty($_SESSION['user']))
        {
            redirect('login-form.php');
        }
    }
    else{
        if(!empty($_SESSION['user']))
        {
            redirect('index.php');
        }
    }
}
function logout(){
    unset($_SESSION['user']);
    header('Location: login.php');
    exit;
}
function redirect($link){
    header('Location: '. $link);
    exit;
}
function showError(){
    if(!empty( $_SESSION['error'])){
        echo '<div class="container text-center mt-5"> <p class="text-error">'.$_SESSION['error'].'</p></div>';
    }
}
function includeError($elem,$type){
    if($elem) {
        $errorMessage = $type;
        include 'errors.php';
        exit;
    }

}
function validEmpty($post1, $show = false){
    foreach ($post1 as $post){
        if(empty($post)){

            if (!$show){
                $errorMessage = 'Заполните все поля.';
                includeError();
            }
            else{
                $_SESSION['error']='Заполните все поля';
                header('Location: /task/login-form.php');
                exit;
            }
        }
    }
}
function deleteSError(){
    if(!empty( $_SESSION['error'])){
        unset($_SESSION['error']);
    }
}
function getAllTasks($pdo){
    $sql = "SELECT  `id`, `name`, `img`, `description` FROM tasks WHERE user_id=:id";
    $statement = $pdo->prepare($sql);
    $statement->execute(array(':id' => $_SESSION['user']));
    return $statement->fetchAll();
}
function getTaskById($id,$pdo){
    $sql = 'SELECT * FROM tasks WHERE id=:id';
    $statement = $pdo->prepare($sql);
    $statement->execute(array(':id' => $id));
    return $statement->fetch();
}
function getElement($sql,$ex, $pdo){
    $statement = $pdo->prepare($sql);
    $statement->execute($ex);
    return $statement->fetchColumn();
}
function addElem($sql,$ex, $pdo){
    $statement = $pdo->prepare($sql);
    return $statement->execute($ex);
}
function addImage($file, $link){
    if(isset($file['image']) && !empty($file['image']['name'])) {
        // загружаем изображение на сервер
        $file_name = $file['image']['name'];
        $file_size = $file['image']['size'];
        $file_tmp = $file['image']['tmp_name'];
        $file_type = $file['image']['type'];
        $file_ext = strtolower(end(explode('.',$file['image']['name'])));
        $file_name = uniqid() .'.'.$file_ext;
        if($file_ext != 'jpg' and $file_ext != 'png'){
            $_SESSION['error']='Неверное расширение изображения';
            header('Location: ' . $link);
            exit;
        }
        $img ='upload/'.$file_name;
        move_uploaded_file($file_tmp, $img);
        if(!empty($_POST['img'])){
            unlink($_POST['img']);
        }
        return $img;
    }
    else{
        return $_POST['img'];
    }
}
function updateElem($sql, $param,$pdo){
        $statement = $pdo->prepare($sql);
        return $statement->execute(($param));
    }
function deleteTask($id, $pdo){
        $sql = "DELETE FROM tasks WHERE id =  :id";
        $statement = $pdo->prepare($sql);
        $params = array(':id' => $id);
        $statement->execute(($params));
    }