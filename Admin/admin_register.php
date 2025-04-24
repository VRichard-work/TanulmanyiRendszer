<?php
include '../functions.php';
Session();
Admin();
$conn = Connect();
if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['felhsz'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $felhsz = $_POST['felhsz'];
  $id = $_POST['id'];
  $szulet = $_POST['szulet'];
  if(isset($_POST['szakid'])) {
    $szakid = $_POST['szakid'];
  } else {
    $szakid = null;
  }
  // id ellenőrzése
  // SQL parancs előkészítése
  if($felhsz == 'oktato') {
      $sql = "SELECT * FROM OKTATOK WHERE OKTATOID = :id";
  } elseif ($felhsz == 'hallg') {
      $sql = "SELECT * FROM HALLGATOK WHERE HALLGATOID = :id";
  } else {
      echo "Invalid user type.";
      exit;
  }

  $stmt = oci_parse($conn, $sql);
  oci_bind_by_name($stmt, ':id', $id);
  oci_execute($stmt);
  if (oci_fetch($stmt)) {
      echo "A felhasználónév már létezik!";
  } else {
  // Felhasználó létrehozása
    oci_free_statement($stmt);
      if($felhsz == 'oktato') {
        $sql = "INSERT INTO OKTATOK (OKTATOID,ONEV,OJELSZO) VALUES (:id, :username, :password)";
    } elseif ($felhsz == 'hallg') {
        $sql = "INSERT INTO HALLGATOK (HALLGATOID,HNEV,HJELSZO,SZULETES) VALUES (:id, :username, :password, TO_DATE(:szulet, 'YYYY-MM-DD'), :szakid)";
    }
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ':id', $id);
    oci_bind_by_name($stmt, ':username', $username);
    oci_bind_by_name($stmt, ':password', $password);
    if($felhsz == 'hallg') {
        oci_bind_by_name($stmt, ':szulet', $szulet);
        oci_bind_by_name($stmt, ':szakid', $szakid);
    }

    if(oci_execute($stmt)) {
        echo "Sikeres regisztráció!";
    } else {
        echo "Hiba történt a regisztráció során.";
    }
    oci_free_statement($stmt);
  }
}




?>

<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="UTF-8">
  <title>Admin regisztráció</title>
</head>
<body>
  <div class="form-container">
    <h2>Admin regisztráció</h2>
    <form action="admin_register.php" method="POST">
      <label for="username">Név</label>
      <input type="text" id="username" name="username" required>
      <br>
      <label for="id">ID</label>
      <input type="text" id="id" name="id" required>
      <br>
      <label for="szulet"></label>
      <input type="date" id="szulet" name="szulet" required>
      <br>
      <label for="password">Jelszó</label>
      <input type="password" id="password" name="password" required>
      <br>
      <label for="confirm_password">Jelszó megerősítése</label>
      <input type="password" id="confirm_password" name="confirm_password" required>
      <br>
      <label for="felhsz">Felhasználói szerepkör</label>
      <select name="felhsz" id="felhsz">
        <option value="oktato">Oktato</option>
        <option value="hallg">Hallgató</option>
      </select>
      <br>
      <label for="szakid">Szak ID</label>
      <input type="text" id="szakid" name="szakid">
      <br>
      <input type="submit" value="Regisztráció">
    </form>
  </div>
</body>
</html>
