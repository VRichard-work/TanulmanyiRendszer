<?php
include 'functions.php';
session_start();

if(!isset($_SESSION['userType'])) {
  header("Location: login.php");
} else{
  Admin();
  $conn = Connect();
}


/*
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
  */

//Megváltoztattam az admin regisztrációra, lehet én értem félre
//de nem hiszem h szükséges a diákoknak meg a tanároknak az összes
//kiírni
?>

<!DOCTYPE html>
<html lang="hu">
  <head>
    <meta charset="UTF-8" />
    <title>Bejelentkezés</title>
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <h1>Adminok kezelése</h1>
    <a href="Admin/admin_register.php">Új admin hozzáadása</a>
<?php
$sql = "SELECT * FROM ADMIN";
    $result = oci_parse($conn, $sql);
    oci_execute($result);
    $isnul = false;
    $first = oci_fetch_assoc($result);
    if($first){
        echo '<table border="1">';
        echo '<tr>
            <th>Admin azonosító</th>
            <th>Admin jelszó</th>
            <th>Adatok módosítása</th>
            <th>Terem törlése</th>
            </tr>';
        echo '<tr>';
            echo '<td>'.$first['ADMINID'].'</td>';
            echo '<td>'.$first['AJELSZO'].'</td>';
            echo '<td><a href="Admin/adminmodify.php?updateadmin='.$first['ADMINID'].'">Módosítás</a></td>';
            echo '<td><a href="torol.php">Törlés</a></td>'; //id + a sor id-ja a totol.php-n belul!!!
        echo '</tr>';
        $isnul = true;
        while($row = oci_fetch_assoc($result)){
            echo '<tr>';
                echo '<td>'.$row['ADMINID'].'</td>';
                echo '<td>'.$row['AJELSZO'].'</td>';
                echo '<td><a href="Admin/adminmodify.php?updateadmin='.$row['ADMINID'].'">Módosítás</a></td>';
                echo '<td><a href="torol.php">Törlés</a></td>'; //id + a sor id-ja a totol.php-n belul!!!
            echo '</tr>';
        }
        echo '</table>';
    } else{
        echo '<p>Még nincs megjeleníthető adat.</p>';
    }

?>
    <nav style="display:inline-box;">
    <a href="Admin/apanel.php">Admin panel</a>

    <form action="logout.php" method="POST">
        <input type="submit" value="Kilépés" />
    </form>
  </body>
</html>