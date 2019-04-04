<?php
include "/functions.php";
isAuth();
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Create Task</title>
    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    
    <style>
      
    </style>
  </head>
  <body>
    <div class="form-wrapper text-center">
      <form class="form-signin" action="create.php" method="post" enctype="multipart/form-data">
        <img class="mb-4" src="assets/img/bootstrap-solid.svg" alt="" width="72" height="72">
         <?
         showError();
         ?>
        <h1 class="h3 mb-3 font-weight-normal">Добавить запись</h1>
        <input type="text" name="name" class="form-control" placeholder="Название" required>
        <textarea name="description" class="form-control" cols="30" rows="3" placeholder="Описание"></textarea>
          <textarea name="fulltext" class="form-control" cols="30" rows="10" placeholder="Полный текст"></textarea>
        <input name="image" type="file">
          <label>
              <input name="draft"  type="checkbox">
             Черновик
          </label>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Отправить</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2018-2019</p>
      </form>
    </div>
  </body>
</html>



