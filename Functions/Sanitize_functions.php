<?php

function validRegisterInput($first_name, $last_name, $email, $password, $pdo) {
  $error = "";
  if (preg_match('/^[a-zA-Z]*$/', $first_name) == 0) $error .= "First name invalid, must contain only letters! ";
  if (preg_match('/^[a-zA-Z]*$/', $last_name) == 0) $error .= "Last name invalid, must contain only letters! ";
  $result = $pdo->query("SELECT * FROM users");
  foreach ($result as $row) {
    if ($email == $row['email']) {
      $error .= "Email already used! ";
    }
  }
  return $error;
}

function validLoginInput($email, $password, $pdo) {
  $validUser = false;
  $result = $pdo->query("SELECT * FROM users");
  foreach ($result as $row) {
    if ($email == $row['email'] and $password == $row['password']) {
      $validUser = true;
    }
  }
  return $validUser;
}

function getId($email, $password, $pdo) {
  $id = null;
  $result = $pdo->query("SELECT * FROM users");
  foreach ($result as $row) {
    if ($email == $row['email'] and $password == $row['password']) {
      $id = $row['id'];
      return $id;
    }
  }
  return $id;
}

function addSlashesRares($input) {
  $output = "";
  for($i=0;$i<strlen($input);$i++) {
    if(strpos(".,/\'\";!@#$%^&*()",$input[$i])) {
      $output .= "\\";
    }
    $output .= $input[$i];
  }
  echo $output;
  return $output;
}
