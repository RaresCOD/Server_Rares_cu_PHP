<?php
  session_start();
  ob_start();
  include_once ('Functions/Sanitize_functions.php');
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="custom.css">
    <link hrepf="buttons.css" rel="stylesheet">
    <title>Hello, world!</title>
  </head>
  <body>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <div class="container">
      <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
        <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
          <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
        </a>

        <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
          <li><a href="#" class="nav-link px-2 link-secondary">Home</a></li>

        </ul>

        <div class="col-md-3 text-end">

          <?php
            if(isset($_SESSION['id'])) {
              ?><a href="login.php"><button type="button" class="btn btn-outline-primary me-2, d-none">Login</button></a>
              <a href="register.php"><button type="button" class="btn btn-primary, d-none">Sign-up</button></a>
              <a href="logout.php"><button type="button" class="btn btn-primary">Logout</button></a><?php
            } else {
              ?><a href="login.php"><button type="button" class="btn btn-outline-primary me-2">Login</button></a>
              <a href="register.php"><button type="button" class="btn btn-primary">Sign-up</button></a>
              <a href="logout.php"><button type="button" class="btn btn-primary, d-none">Logout</button></a><?php
            }
           ?>




        </div>
      </header>
    </div>
    <?php
    if(isset($_SESSION['id'])) {
      ?><form action="" method="post">

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
          <div class="col m-2"><button class="w-100 btn btn-lg btn-primary" name="add" type="submit">Add</button></div>
        </div>
      </form><?php
    } else {?>
      <div class='text-center'><h2>Please Login</h2>
      <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" class="bi bi-door-open-fill" viewBox="0 0 16 16">
      <path d="M1.5 15a.5.5 0 0 0 0 1h13a.5.5 0 0 0 0-1H13V2.5A1.5 1.5 0 0 0 11.5 1H11V.5a.5.5 0 0 0-.57-.495l-7 1A.5.5 0 0 0 3 1.5V15H1.5zM11 2h.5a.5.5 0 0 1 .5.5V15h-1V2zm-2.5 8c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1z"/>
      </svg></div><?php

    }




      try {
        $pdo = new PDO('sqlite:TASKS.db');
      } catch (PDOException $e) {
       echo $e->getMessage();
      }
      ?>
      <br>
      <?php
        if(isset($_SESSION['id'])) {
        $userid = $_SESSION["id"];
        if (gettype($userid) == "string") {
          $userid = intval($userid);
        }
        $email = $_SESSION['email'];

        if (isset($_POST['add'])) {
          $rawTask = $_POST['task'];
          $task = SQLite3::escapeString($rawTask);
          $importance = $_POST['importance'];
          $id = intval (uniqid (rand (),true));
          $pdo->exec("INSERT INTO TODOS(id,userid,task,importance,completed) VALUES('$id','$userid','$task','$importance','no');") or die(print_r($pdo->errorInfo(), true));
          unset($_POST['add']);
          header('Location: dashBoard.php');
          exit;
        }
        $result = $pdo->query("SELECT * FROM TODOS ORDER BY importance DESC");
       ?>

      <h2>List of tasks:<br></h2>
      <ul class="list-group list-group-flush">
        <?php foreach ($result as $row): ?>
          <form action="dashBoard.php" method="post">
            <div class="row g-2">
              <?php
              if ($row['userid'] == $userid) {
                if ($row['importance'] == '3' and $row['completed'] == 'no') {
                  ?><div class="col-8"><li class="list-group-item bg-danger" name="<?=$row['id']?>"><?= $row['task'] ?></li></div><?php
                } elseif ($row['importance'] == '2') {
                  ?><div class="col-8"><li class="list-group-item bg-warning" name="<?=$row['id']?>"><?= $row['task'] ?></li></div><?php
                } else {
                  ?><div class="col-8"><li class="list-group-item bg-succes" name="<?=$row['id']?>"><?= $row['task'] ?></li></div><?php
                }
                if ($row['completed'] == 'no') {
                  ?><div class="col m-2"><a href="delete_task.php?id=<?=$row['id']?>&uid=<?=$userid?>" class="w-100 btn btn-lg btn-primary" >Delete</a></div>
                  <div class="col m-2"><a href="edit_task.php?id=<?=$row['id']?>&uid=<?=$userid?>" class="w-100 btn btn-lg btn-primary" >Edit</a></div>
                  <div class="col m-2"><a href="complited_task.php?id=<?=$row['id']?>&uid=<?=$userid?>" class="w-100 btn btn-lg btn-primary" >Completed</a></div><?php
                } else {?>
                  <div class="col m-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                    <path d="M13.485 1.431a1.473 1.473 0 0 1 2.104 2.062l-7.84 9.801a1.473 1.473 0 0 1-2.12.04L.431 8.138a1.473 1.473 0 0 1 2.084-2.083l4.111 4.112 6.82-8.69a.486.486 0 0 1 .04-.045z"/>
                    </svg>
                  </div>
                  <?php
                }
              }
              ?>
            </div>
          </form>
          <?php endforeach;?>
          <?php
        }?>
      </ul>

  </body>
</html>
