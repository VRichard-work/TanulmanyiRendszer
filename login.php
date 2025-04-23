<?php
  if(session_status() == PHP_SESSION_NONE) {
    session_start();
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
