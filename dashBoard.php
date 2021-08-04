<?php
  session_start();
  ob_start();
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
        <div class="col m-2"><button class="w-100 btn btn-lg btn-primary" name="add" type="submit">Add</button></div>
      </div>
    </form>
    <?php


      //try {
        $pdo = new PDO('sqlite:TASKS.db');

        $pdo->exec("CREATE TABLE TODOS(id INTEGER PRIMARY KEY,userid INTEGER,task TEXT, importance INTEGER);");
      //} catch (PDOException $e) {
      //  echo $e->getMessage();
    //  }

      // function deleteTask($taskId) {
      //   $sql = 'DELETE FROM TODOS '.'WHERE id = :id';
      //   $stmt = $pdo->exec($sql);
      //   $stmt->bindValue(':id', $taskId);
      //   $stmt->execute();
      //   return $stmt->rowcount();
      // }
      ?>
      <br>

      <?php
        $userid = $_SESSION["id"];
        if (gettype($userid) == "string") {
          $userid = intval($userid);
        }
        $email = $_SESSION['email'];

        if (isset($_POST['add'])) {
          $task = $_POST['task'];
          $importance = $_POST['importance'];
          $id = intval (uniqid (rand (),true));
          echo $id. " = ". gettype($id) . "<br>" . $userid. " = " . gettype($userid). "<br>" . $task. " = " . gettype($task). " " . $importance. " = ". gettype($importance)."<br>";
          //$output = ob_get_contents();
          //echo "<br>".$output;
          echo "da";
          $pdo->exec("INSERT INTO TODOS(id,userid,task,importance) VALUES('$id','$userid','$task','$importance');");
          $string = ("INSERT INTO TODOS(id,userid,task,importance) VALUES('$id','$userid','$task','$importance');");
          echo $string;
          //die();
          //echo $da;
          //$pdo->exec("INSERT INTO TODOS(id,userid,task,importance) VALUES('$id','$userid','dada','mportancae');");
          unset($_POST['add']);
        }
        //session_destroy();\
        $result = $pdo->query("SELECT * FROM TODOS");
       ?>

      <h2>List of tasks:<br></h2>
      <ul class="list-group list-group-flush">
        <?php foreach ($result as $row): ?>
          <form action="" method="post">
            <div class="row g-2">
              <?php
              if ($row['id'] === $id) {
                if ($row['importance'] == '3') {
                  ?><div class="col-8"><li class="list-group-item bg-danger"><?= $row['task'] ?></li></div><?php
                } elseif ($row['importance'] == '2') {
                  ?><div class="col-8"><li class="list-group-item bg-warning"><?= $row['task'] ?></li></div><?php
                } else {
                  ?><div class="col-8"><li class="list-group-item bg-succes"><?= $row['task'] ?></li></div><?php
                }
              }

              ?>

              <?php


                if(isset($_REQUEST['del'])) {
                  //deleteTask($row['id']);
                  unset($_REQUEST['del']);
                }
                if(isset($_REQUEST['edit'])) {
                  echo "Edit";
                  unset($_REQUEST['edit']);
                }
                if(isset($_REQUEST['com'])) {
                  echo "Complited";
                  unset($_REQUEST['com']);
                }
              ?>

                <div class="col m-2"><input type="submit" name="del" class="w-100 btn btn-lg btn-primary" value="Delete"></div>
                <div class="col m-2"><input type="submit" name="edit" class="w-100 btn btn-lg btn-primary" value="Edit"></div>
                <div class="col m-2"><input type="submit" name="com" class="w-100 btn btn-lg btn-primary" value="Complited"></div>
                <br>

            </div>
          </form>
        <?php endforeach; ?>
      </ul>

  </body>
</html>
