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

<?php
  include_once ('Functions/Session_functions.php');
  session_start();
  $pdo = new PDO('sqlite:TASKS.db');

  $id = $_GET['id'];
  $uid = $_GET['uid'];
  if(!isset($_SESSION['id'])) {
    include_once('sessionError.php');
    die;
  }
  $userId = $_SESSION['id'];
  if(validSession($uid, $userId)) {
    $query = "DELETE FROM TODOS WHERE id=:id";
    $sql = $pdo->prepare($query);
    $sql->bindParam(':id', $id, PDO::PARAM_INT, 5);
    if($sql->execute()) {
    }
    else {
      print_r($sql->errorInfo()); // if any error is there it will be posted
      $msg=" Database problem, please contact site admin ";
    }
    $pdo = null;
    header('Location: dashBoard.php');
  } else {
    include_once('sessionError.php');
  }
?>
