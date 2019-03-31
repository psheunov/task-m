<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=task-manager', 'root','');
$sql = 'SELECT * FROM tasks WHERE id=:id';

$statement = $pdo->prepare($sql);
$statement->execute(array(':id' => $_GET['id']));
$task  = $statement->fetchAll();
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">

    <title>Edit Task</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    
    <style>
      
    </style>
  </head>

  <body>
    <div class="form-wrapper text-center">
      <form class="form-signin" action="edit.php" method="post"  enctype="multipart/form-data">
        <img class="mb-4" src="assets/img/bootstrap-solid.svg" alt="" width="72" height="72">
          <?if(!empty( $_SESSION['error'])):?>
              <div class="container text-center mt-5">
                  <p class="text-error"><?=$_SESSION['error']?></p>
              </div>
          <?endif;?>
          <input type="hidden" name="id" value="<?=$_GET['id']?>">
          <input type="hidden" name="img" value="<?=$task[0]['img']?>">
        <h1 class="h3 mb-3 font-weight-normal">Добавить запись</h1>
        <label for="inputEmail" class="sr-only">Название</label>
        <input type="text" name="name" class="form-control" placeholder="Название" required value="<?=$task[0]['name']?>">
        <label for="inputEmail" class="sr-only">Описание</label>
        <textarea name="description" class="form-control" cols="30" rows="3" placeholder="Описание"><?=$task[0]['description']?></textarea>
          <label for="inputEmail" class="sr-only">Полный текст</label>
          <textarea name="fulltext" class="form-control" cols="30" rows="3" placeholder="Полный текст"><?=$task[0]['fulltxt']?></textarea>
          <label>
              <input name="draft" <?if($task[0]["draft"] == '1') echo 'checked';?>  type="checkbox">
              Черновик
          </label>
          <input name="image" type="file">
        <img src="<?=$task[0]['img']?>" alt="" width="300" class="mb-3">
        <button class="btn btn-lg btn-success btn-block" type="submit">Редактировать</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2018-2019</p>
      </form>
    </div>
  </body>
</html>