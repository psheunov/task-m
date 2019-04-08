<?php
include "/functions.php";
isAuth();
$task  = getTaskById($_GET['id'],$pdo);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Show</title>
    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
    </style>
  </head>
  <body>
    <div class="form-wrapper text-center">
      <img src="<?=$task['img']?>" alt="" width="400">
      <h2><?=$task['name']?></h2>
      <p>
          <?=$task['fulltxt']?>
      </p>
    </div>
  </body>
</html>
