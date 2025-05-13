<?php
include '../functions.php';
Session();
Admin();
$conn = Connect();
if(isset($_POST['password']) && isset($_POST['confirm_password'])){
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];
  // Ellenőrizzük, hogy a jelszavak megegyeznek-e
  if ($password !== $confirm_password) {
    echo "A jelszavak nem egyeznek meg.";
    exit;
  }
  $sql = "SELECT MAX(ADMINID) FROM ADMIN";
  $stmt = oci_parse($conn, $sql);
  oci_execute($stmt);
  $id = oci_fetch_row($stmt)[0][0];
  if($id == null) {
    $id = 1;
  } else {
    $id++;
  }
  oci_free_statement($stmt);

  $sql = "INSERT INTO ADMIN (ADMINID, AJELSZO) VALUES (:id, :password)";
  $stmt = oci_parse($conn, $sql);
  oci_bind_by_name($stmt, ':id', $id);
  oci_bind_by_name($stmt, ':password', $password);
  if(oci_execute($stmt)) {
    echo "Sikeres regisztráció!";
    header("Location: apanel.php");
  } else {
    echo "Hiba történt a regisztráció során.";
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
      <label for="password">Jelszó</label>
      <input type="password" id="password" name="password" required>
      <br>
      <label for="confirm_password">Jelszó megerősítése</label>
      <input type="password" id="confirm_password" name="confirm_password" required>
      <br>
      <input type="submit" value="Regisztráció">
    </form>
  </div>
</body>
</html>
