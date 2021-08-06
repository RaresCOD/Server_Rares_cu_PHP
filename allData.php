<?php
  $pdo = new PDO('sqlite:users.db');
  $result = $pdo->query('SELECT * FROM users');
  print "<table border=1>";
  print "<tr><td>id</td><td>firstname</td><td>lastname</td><td>email</td><td>password</td></tr>";
  foreach($result as $row)
  {
    print "<tr><td>".$row['id']."</td>";
    print "<td>".$row['firstName']."</td>";
    print "<td>".$row['lastName']."</td>";
    print "<td>".$row['email']."</td>";
    print "<td>".$row['password']."</td>";
  }
  print "</table>";
