<?php

if(session_status() == PHP_SESSION_NONE) {
  session_start();
  header("login.php");
}
// Connect to the database
$conn = oci_connect("C##CHCGUK", "C##CHCGUK", "localhost:1521/orania2.inf.u-szeged.hu");
if (!$conn) {
  $e = oci_error();
  echo "Connection failed: " . $e['message'];
  exit;
}
$test = oci_parse($conn, "SELECT * FROM ADMIN");

// Check if the connection was successful
if (!$test) {
  $e = oci_error($conn);
  echo "SQL error: " . $e['message'];
  exit;
}

oci_execute($test);
while ($row = oci_fetch_array($test, OCI_ASSOC + OCI_RETURN_NULLS)) {
  echo "<br>";
  echo "<br>";
  echo $row['ADMINID'];
  echo "<br>";
  echo $row['AJELSZO'];
  echo "<br>";
  
}
?>

<!DOCTYPE html>
<html lang="hu">
  <head>
    <meta charset="UTF-8" />
    <title>Bejelentkezés</title>
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <nav style="display:inline-box;">
      <ul>
        <li><a href="index.php">Főoldal</a></li>
        <li><a href="admin_register.php">Admin regisztráció</a></li>
        <li><a href="login.php">Bejelentkezés</a></li>
      </ul>

    <button onclick="location.href='login.php'">Bejelentkezés</button>
  </body>
</html>