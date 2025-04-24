<?php
include 'functions.php';
session_start();


if(isset($_SESSION['userType'])) {
  header("Location: index.php");
}

  // Csatlakozás
  $conn = Connect();
  // Login form feldolgozása
  if(isset($_POST['userType']) && isset($_POST['username']) && isset($_POST['password'])) {
    $userType = $_POST['userType'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // SQL parancs előkészítése
    // A felhasználó típusa alapján állítjuk be a lekérdezést
    if ($userType == 'admin') {
      $sql = "SELECT * FROM ADMIN WHERE ADMINID = :username AND AJELSZO = :password";
    } elseif ($userType == 'prof') {
      $sql = "SELECT * FROM OKTATOK WHERE OKTATOID = :username AND OJELSZO = :password";
    } elseif ($userType == 'stud') {
      $sql = "SELECT * FROM HALLGATOK WHERE HALLGATOID = :username AND HJELSZO = :password";
    } else {
      echo "Invalid user type.";
      exit;
    }

    // SQL parancs végrehajtása
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ':username', $username);
    oci_bind_by_name($stmt, ':password', $password);
    oci_execute($stmt);
    

    
    // Beloginoltatás
    if (oci_fetch($stmt)) {
      $_SESSION['userType'] = $userType;
      $_SESSION['username'] = $username;
      header("Location: index.php");
      exit;
    } else {
      echo "Invalid username or password.";
    }
  }
  oci_close($conn);
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
      <form action="logout.php" method="POST">
        <input type="submit" value="Kilépés" />
      </form>
    </div>
  </body>
</html>
