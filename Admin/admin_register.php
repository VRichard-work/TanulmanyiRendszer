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
      <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        h1 {
            text-align: center;
            color: #3b3b3b;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 10px;
            font-weight: bold;
        }
        input, select, button {
            margin-top: 5px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        #department{
            margin-bottom: 50px;
        }

        button {
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
            padding: 0.8rem;
            margin-top: 20px;
        }
        button:hover {
            background-color: #0056b3;
        }

        a {
            display: block;
            margin-top: 1rem;
            text-align: center;
            color: #005796;
            text-decoration: none;
            background-color: #75aafa;
            padding: 0.8rem;
            border-radius: 5px;
        }
        a:hover {
            background-color: #02132c;
            color: white;
        }
    </style>
</head>
<body>
  <div class="container">
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
