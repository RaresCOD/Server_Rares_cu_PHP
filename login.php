<html lang="en">

<?php
  include_once 'register_header.php';
  include_once 'Functions/Sanitize_functions.php';
  ob_start();
  session_start();
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

        <br>
        <a href="register.php">Don't have an account?</a>
      </div>
      <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>

    </form>
    <?php

      try {
        $pdo = new PDO('sqlite:users.db');
      } catch (PDOException $e) {
        echo $e->getMessage();
      }

      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"];
        $password = $_POST["password"];
        if ($email == null || $password == null) {
          echo "All fileds must be complited";
        } else {
          if (!validLoginInput($email, $password, $pdo)) { //validam datele introduse de user
            echo "Incorrect email or password!";
            header("Location: login.php");
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
  </body>
</html>
