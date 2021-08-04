<html lang="en">

<?php
  include_once 'register_header.php';
  ob_start();
  session_start();
  //include_once 'users.db';
 ?>

<body class="text-center">

<main class="form-signin">
  <form action="" method="post">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <img class="mb-4" onerror="this.onerror=null" src="user-icon-trendy-flat-style-isolated-grey-background-user-symbol-user-icon-trendy-flat-style-isolated-grey-background-123663211.jpeg" alt="" width="72" height="72">
    <h1 class="h3 mb-3 fw-normal">Please Login</h1>

    <div class="form-floating">
      <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com">
      <label for="floatingInput">Email address</label>
    </div>
    <div class="form-floating">
      <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">Password</label>
    </div>

    <div class="checkbox mb-3">
      <label>
        <input type="checkbox" value="remember-me"> Remember me
      </label>
      <br>
      <a href="register.php">Don't have an account?</a>
    </div>
    <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>

  </form>
<?php

  try {
    $pdo = new PDO('sqlite:users.db');

    $pdo->exec("CREATE TABLE groups(id INTEGER PRIMARY KEY,firstName TEXT,lastName TEXT,email TEXT,password TEXT)");


    //$statement = $pdo->query("SELECT * FROM users");
    //rows = $statement->fetchAll(PDO::FETCH_ASSOC);
    //print_r($rows);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }


  function valid($email, $password, $pdo) {
    $validUser = false;
    $result = $pdo->query("SELECT * FROM groups");
    foreach ($result as $row) {
      if ($email == $row['email'] and $password == $row['password']) {
        $validUser = true;
      }
    }
    return $validUser;
  }

  function getId($email, $password, $pdo) {
    $id = null;
    $result = $pdo->query("SELECT * FROM groups");
    foreach ($result as $row) {
      if ($email == $row['email'] and $password == $row['password']) {
        $id = $row['id'];
        return $id;
      }
    }
    return $id;
  }


  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    if ($email == null || $password == null) {
      echo "All fileds must be complited";
    } else {
      if (!valid($email, $password, $pdo)) { //validam datele introduse de user
        echo "Incorrect email or password!";
      } else {
        echo "Login succesful";
        $_SESSION["id"] = getId($email, $password, $pdo);
        $_SESSION["email"] = $email;
        header('Location: dashBoard.php');
        ob_end_flush();
      }
    }
  }
 ?>

</main>





</body></html>
