<?php
  if(session_status() == PHP_SESSION_NONE) {
    session_start();
    $_SESSION['loggedin'] = false;
  }
  if($_SESSION['loggedin'] == true) {
    header("Location: index.php");
    exit;
  }
  if(isset($_POST['userType']) && isset($_POST['username']) && isset($_POST['password'])) {
    $userType = $_POST['userType'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $_SESSION['loggedin'] = true;
    header("Location: index.php");
  }
  // Connect to the database
  $conn = oci_connect("C##FK1C6Z", "C##FK1C6Z", "localhost:1521/orania2.inf.u-szeged.hu");
  if (!$conn) {
    $e = oci_error();
    echo "Connection failed: " . $e['message'];
    exit;
  }
  
?>


<!DOCTYPE html>
<html lang="hu">
  <head>
    <meta charset="UTF-8" />
    <title>Bejelentkezés</title>
  </head>
  <body>
    <div class="login-container">
      <h2>Bejelentkezés</h2>
      <form action="login.php" method="POST">
        <label for="userType">Felhasználó típusa</label>
        <select name="userType" id="userType" required>
          <option value="admin">Admin</option>
          <option value="prof">Tanár</option>
          <option value="stud">Tanuló</option>
        </select>
        <br />
        <label for="username">Felhasználónév</label>
        <input type="text" name="username" id="username" required />
        <br />
        <label for="password">Jelszó</label>
        <input type="password" name="password" id="password" required />
        <br />

        <input type="submit" value="Bejelentkezés" />
      </form>
    </div>
  </body>
</html>
