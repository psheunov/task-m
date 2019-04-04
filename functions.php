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
function getTaskById($id,$pdo){
    $sql = 'SELECT * FROM tasks WHERE id=:id';
    $statement = $pdo->prepare($sql);
    $statement->execute(array(':id' => $id));
    return $statement->fetch();
}
function getAllTasks($pdo){
    $sql = "SELECT  `id`, `name`, `img`, `description` FROM tasks WHERE user_id=:id";
    $statement = $pdo->prepare($sql);
    $statement->execute(array(':id' => $_SESSION['user']));
    return $statement->fetchAll();
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
function includeError(){
    include 'errors.php';
    exit;
}