<?php
include '../functions.php';
Session();
Admin();
$conn = Connect();

if(isset($_POST['ferohely']) && isset($_POST['id'])){
    $id=$_POST['id'];
    $ferohely=$_POST['ferohely'];
    //hogyan ellenőrizzük h egyedi e az id?

    $sql = "INSERT INTO TERMEK (TEREMID,FEROHELY) VALUES (:id, :ferohely)";
    
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ':id', $id);
    oci_bind_by_name($stmt, ':ferohely', $ferohely);
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
    <title>Terem Regisztráció</title>
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

        <h1>Oktató Regisztráció</h1>
        <form action="teremregist.php" method="POST">
            <label for="id">Terem ID:</label>
            <input type="text" id="id" name="id" placeholder="Terem ID" required>

            <label for="name">Férőhely:</label>
            <input type="text" id="name" name="ferohely" placeholder="Férőhely" required>

            <button type="submit">Regisztráció</button>
            <a href="apanel.php" class="back-link">Vissza a főpanelre</a>
        </form>
    </div>
</body>
</html>