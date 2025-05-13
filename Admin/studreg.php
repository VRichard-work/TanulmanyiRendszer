<?php
include '../functions.php';
Session();
Admin();
$conn = Connect();
if(isset($_POST['username']) && isset($_POST['password']) && $_POST['username'] != null && $_POST['password'] != null && $_POST['szulet'] != null) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $szulet = $_POST['szulet'];
    $szakid = $_POST['szakid'] ?? null; // Ha nem küldtek szakid-t, akkor null-ra állítjuk
    $id = 0;
    while(true){
        $sql = "SELECT * FROM HALLGATOK WHERE HALLGATOID = :id";
        $id = rand(1, 999);
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':id', $id);
        oci_execute($stmt);
        if (!oci_fetch($stmt)) {
            break;
        }
    }
    
    oci_free_statement($stmt);
    $sql = "INSERT INTO HALLGATOK (HALLGATOID,HNEV,HJELSZO,SZULETES, SZAKID) VALUES (:id, :username, :password, TO_DATE(:szulet, 'YYYY-MM-DD'), :szakid)";
    
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ':id', $id);
    oci_bind_by_name($stmt, ':username', $username);
    oci_bind_by_name($stmt, ':password', $password);
    oci_bind_by_name($stmt, ':szulet', $szulet);
    oci_bind_by_name($stmt, ':szakid', $szakid);
    if(oci_execute($stmt)) {
        echo "Sikeres regisztráció!";
        header("Location: apanel.php");
    } else {
        echo "Hiba történt a regisztráció során.";
    }
    oci_free_statement($stmt);
    
}

?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diák Regisztráció</title>
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


        <h1>Diák Regisztráció</h1>
        <form action="studreg.php" method="POST">
            <label for="username">Teljes név:</label>
            <input type="text" id="name" name="username" placeholder="Add meg a neved" required>

            <label for="password">Jelszó:</label>
            <input type="password" id="password" name="password" placeholder="Add meg a jelszavad" required>

            <label for="szulet">Születési dátum:</label>
            <input type="date" id="date_id" name="szulet" required>

            <label for="szakid">Szak:</label>
            <select id="department" name="szakid" required>
                <option value="0">Válassz szakot</option>
                <option value="1">SZAKOK:SZNEV</option>
            </select>
            
            <button type="submit">Regisztráció</button>
            <a href="apanel.php">Vissza a főpanelre</a>
        </form>
    </div>
</body>
</html>