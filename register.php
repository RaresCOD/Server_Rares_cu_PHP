<html lang="en">

<?php
  include_once 'register_header.php';
  ob_start();
  session_start();
  //session_destroy();
  //include_once 'users.db';
 ?>
 <div class="container">
   <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
     <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
       <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
     </a>

     <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
       <li><a href="dashBoard.php" class="nav-link px-2 link-secondary">Home</a></li>

     </ul>

     <div class="col-md-3 text-end">
     </div>
   </header>
 </div>
<body class="text-center">

<main class="form-signin">
  <form action="" method="post">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <img class="mb-4" onerror="this.onerror=null" src="user-icon-trendy-flat-style-isolated-grey-background-user-symbol-user-icon-trendy-flat-style-isolated-grey-background-123663211.jpeg" alt="" width="72" height="72">
    <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

    <div class="form-floating">
      <input type="text" name="first_name" class="form-control" id="floatingInput1" placeholder="Rares" value="<?php echo isset($_POST['first_name']) ? $_POST['first_name'] : '' ?>">
      <label for="floatingInput">First name</label>
    </div>

    <div class="form-floating">
      <input type="text" name="last_name" class="form-control" id="floatingInput2" placeholder="Codreanu" value="<?php echo isset($_POST['last_name']) ? $_POST['last_name'] : '' ?>">
      <label for="floatingInput">Last name</label>
    </div>

    <div class="form-floating">
      <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>">
      <label for="floatingInput">Email address</label>
    </div>
    <div class="form-floating">
      <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" value="<?php echo isset($_POST['password']) ? $_POST['password'] : '' ?>">
      <label for="floatingPassword">Password</label>
    </div>

    <div class="checkbox mb-3">
    </div>
    <a href="login.php">Login</a>
    <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>

  </form><?php

  try {
    $pdo = new PDO('sqlite:users.db');

    $pdo->exec("CREATE TABLE groups(id INTEGER PRIMARY KEY,firstName TEXT,lastName TEXT,email TEXT,password TEXT)");


    //$statement = $pdo->query("SELECT * FROM users");
    //rows = $statement->fetchAll(PDO::FETCH_ASSOC);
    //print_r($rows);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }


  function valid($first_name, $last_name, $email, $password, $pdo) {
    $error = "";
    if (preg_match('/^[a-zA-Z]*$/', $first_name) == 0) $error .= "First name invalid, must contain only letters!";
    if (preg_match('/^[a-zA-Z]*$/', $last_name) == 0) $error .= "Last name invalid, must contain only letters!";
    $result = $pdo->query("SELECT * FROM groups");
    foreach ($result as $row) {
      if ($email == $row['email']) {
        $error .= "Email already used!";
      }
    }
    return $error;
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST["first_name"];
    $lastName = $_POST["last_name"];
    $rowEmail = $_POST["email"];
    $email = filter_var($rowEmail, FILTER_SANITIZE_EMAIL);
    $password = $_POST["password"];
    if ($firstName == null || $lastName == null || $email == null || $password == null) {
      echo "All fileds must be complited";
    } else {
      $error = valid($firstName, $lastName, $email, $password, $pdo); //validam datele introduse de user
      if (strlen($error) != 0) {
        echo $error;
        if ($error == "Email already used!") {
          ?><br><a href="login.php">Want to login?</a><?php
        }
      } else {
        echo "Sign in succesful";
        $id = intval (uniqid (rand (),true));
        $pdo->exec("INSERT INTO groups(id,firstName,lastName,email,password) VALUES('$id','$firstName','$lastName','$email','$password');");
        //redirect la DashBoard
        //header('Location: dashBoard.php');
        $_SESSION["id"] = $id;
        $_SESSION["email"] = $email;
        //exit();
        //session_start();
        //$_SESSION['id'] = $id;
        //$_SESSION['email'] = $email;
        header('Location: dashBoard.php');
        ob_end_flush();
      }
    }
  }
 ?>

</main>





</body></html>
