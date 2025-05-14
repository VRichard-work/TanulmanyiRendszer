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
  <style>

body {
  font-family: Arial, sans-serif;
  background-color: #f4f4f4;
  color: #333;
  margin: 0;
  padding: 20px;
}

h1 {
  text-align: center;
  color: #2c3e50;
}

a {
  display: inline-block;
  margin: 5px;
  text-align: center;
  font-size: 1em;
  font-weight: bold;
  padding: 10px 15px;
  background-color: #75aafa;
  color: #005796;
  text-decoration: none;
  border-radius: 5px;
  transition: background-color 0.3s;
}

a:hover {
  background-color: #2980b9;
}

table {
  width: 80%;
  margin: 20px auto;
  border-collapse: collapse;
  box-shadow: 0 0 10px rgba(0,0,0,0.1);
  background-color: white;
}

th, td {
  padding: 12px 15px;
  text-align: center;
  border: 1px solid #ccc;
}

th {
  background-color: #007BFF;
  color: white;
}

.changes{
  background-color:rgb(0, 53, 110);
  color: white;
}

nav {
  margin-top: 30px;
  text-align: center;
}

form input[type="submit"] {
  padding: 10px 20px;
  background-color: #e74c3c;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  margin-left: 10px;
  font-size: 1.1em;
  transition: background-color 0.3s;
}

form input[type="submit"]:hover {
  background-color: #c0392b;
}

</style>

  </head>
  <body>
    <h1>Adminok kezelése</h1>
   
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
            <th class="changes">Adatok módosítása</th>
            <th class="changes">Terem törlése</th>
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
    <a href="Admin/admin_register.php">Admin hozzáadása</a>
    <a href="Admin/apanel.php">Admin panel</a>

    <form action="logout.php" method="POST">
        <input type="submit" value="Kilépés" />
    </form>
  </body>
</html>