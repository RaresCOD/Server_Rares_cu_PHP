<?php
  include_once 'Functions/Session_functions.php';
  session_start();
  if(empty($_GET)) {
    ?>
    <h1>Unexpected entry!</h1>
    <?php
    die;
  }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="custom.css">
    <link hrepf="buttons.css" rel="stylesheet">
    <title>Hello, world!</title>
  </head>
  <body>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <form action="" method="post">
      <div class="row g-2">
        <div class="col-5">
          <div class="form-floating">
            <input type="text" name="task" class="form-control" id="floatingInputGrid" placeholder="Mers la magazin">
            <label for="floatingInputGrid">Task</label>
          </div>
        </div>
        <div class="col-5">
          <div class="form-floating">
            <select class="form-select" name="importance" id="floatingSelectGrid" aria-label="Floating label select example">
              <option selected>Open this select menu</option>
              <option value="1">Low</option>
              <option value="2">Medium</option>
              <option value="3">High</option>
            </select>
            <label for="floatingSelectGrid">Importance</label>
          </div>
        </div>
        <div class="col m-2"><button class="w-100 btn btn-lg btn-primary" name="go" type="submit">Go
        </button></div>
      </div>
    </form>
    <?php

    $pdo = new PDO('sqlite:TASKS.db');

    $id = $_GET['id'];
    $uid = $_GET['uid'];
    if(!isset($_SESSION['id'])) {
      include_once('sessionError.php');
      die;
    }
    $userId = $_SESSION['id'];
    if(validSession($uid, $userId)) {
      if (isset($_POST['go'])) {
        $rawtaskUpdate = $_POST['task'];
        $taskUpdate = SQLite3::escapeString($rawtaskUpdate);
        $query = "UPDATE TODOS SET task=:task,importance=:importance WHERE id=:id";
        $sql = $pdo->prepare($query);
        $sql->bindParam(':task', $taskUpdate,PDO::PARAM_STR, 25);
        $sql->bindParam(':importance', $taskImportance,PDO::PARAM_STR, 25);
        $sql->bindParam(':id', $id,PDO::PARAM_INT, 5);
        $sql->execute();
        header("Location: dashBoard.php");
        exit;
      }
    } else {
      include_once('sessionError.php');
    }
    ?>
  </body>
