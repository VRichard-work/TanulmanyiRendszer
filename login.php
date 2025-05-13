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

      if($userType == 'admin') {
        header("Location: Admin/apanel.php");
      } elseif ($userType == 'prof') {
        header("Location: Oktato/oktpanel.php");
      } elseif ($userType == 'stud') {
        header("Location: Stud/panel.php");
      } else {
        echo "Invalid user type.";
      }
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

        <button type="submit" class="back-link">Bejelentkezés</button>
        
      </form>
    </div>
  </body>
</html>
