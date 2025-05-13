<?php
include 'functions.php';
session_start();

if(!isset($_SESSION['userType'])) {
  header("Location: login.php");
}



// Csatlakozás
$conn = Connect();

// SQL parancs előkészítése
// A felhasználó típusa alapján állítjuk be a lekérdezést
if($_SESSION['userType'] == 'admin') {
  $stmt = oci_parse($conn, "SELECT * FROM ADMIN");
} elseif ($_SESSION['userType'] == 'prof') {
  $stmt = oci_parse($conn, "SELECT * FROM OKTATOK");
} elseif ($_SESSION['userType'] == 'stud') {
  $stmt = oci_parse($conn, "SELECT * FROM HALLGATOK");
} else {
  echo "Invalid user type.";
  exit;
}

// SQL parancs végrehajtása
if (!$stmt) {
  $e = oci_error($conn);
  echo "SQL error: " . $e['message'];
  exit;
}

oci_execute($stmt);
if($_SESSION['userType'] == 'admin') {
  while ($row = oci_fetch_array($stmt)) {
    echo "<br>";
    echo "<br>";
    echo $row['ADMINID'];
    echo "<br>";
    echo $row['AJELSZO'];
    echo "<br>";
  }
}
else if($_SESSION['userType'] == 'prof') {
  while ($row = oci_fetch_array($stmt)) {
    echo "<br>";
    echo "<br>";
    echo $row['OKTATOID'];
    echo "<br>";
    echo $row['OJELSZO'];
    echo "<br>";
  }
}
else if($_SESSION['userType'] == 'stud') {
  while ($row = oci_fetch_array($stmt)) {
    echo "<br>";
    echo "<br>";
    echo $row['HALLGATOID'];
    echo "<br>";
    echo $row['HJELSZO'];
    echo "<br>";
  }
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
        <li><a href="Admin/admin_register.php">Admin regisztráció</a></li>
        <li><a href="login.php">Bejelentkezés</a></li>
      </ul>

    <button onclick="location.href='login.php'">Bejelentkezés</button>
    <form action="logout.php" method="POST">
        <input type="submit" value="Kilépés" />
    </form>
  </body>
</html>