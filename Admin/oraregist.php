<?php
include '../functions.php';
Session();
Admin();
$conn = Connect();

if(isset($_POST['id']) && isset($_POST['name']) && isset($_POST['kezdet']) && isset($_POST['veg']) && isset($_POST['kod'])){
    $id=$_POST['id'];
    $name=$_POST['name'];
    $kovtipus=$_POST['kezdet'];
    $kurtipus=$_POST['veg'];
    $kod=$_POST['kod'];
    //egyedi id ellenőrzése?

    $sql = "INSERT INTO ORAK (ORAID,ONEV,OKEZDET,OVEGE,KURZUSID) VALUES (:id, :name, :kovtipus, :kutipus, :kod)";
    
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ':id', $id);
    oci_bind_by_name($stmt, ':name', $name);
    oci_bind_by_name($stmt, ':kezdet', $kovtipus);
    oci_bind_by_name($stmt, ':veg', $kurtipus);
    oci_bind_by_name($stmt, ':kod', $kod);
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
    <title>Óra felvitele</title>
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


        <h1>Óra felvitele</h1>
        <form action="oraregist.php" method="POST">
            <label for="id">Óra azonosítója:</label>
            <input type="text" name="id" id="id" placeholder="Óra ID" required>

            <label for="name">Óra név:</label>
            <input type="text" id="name" name="name" placeholder="Add meg az óra nevét" required>

            <label for="kezdet">Óra kezdete:</label>
            <input type="time" id="kezdet" name="kezdet" required>

            <label for="veg">Óra vége:</label>
            <input type="time" id="veg" name="veg" required>

            <label for="kod">Kurzushoz tartozik(kurzus kód):</label>
            <select name="kod" id="kod">
                <?php
                //kurzusid választása az órákhoz
                if($sql = "SELECT KURZUSID FROM KURZUSOK"){
                    $result = oci_parse($conn, $sql);
                    $rowcount = oci_num_rows($result);
                    if($rowcount > 0){
                        while($row = oci_fetch_assoc($result)){
                            echo '<option value="'.$result.'">'.$result.'</option>';
                        }
                    } else{
                        echo '<option value="">Még nincs kurzus regisztrálva!</option>';
                    }
                }
                ?>
                <option value=""></option>
            </select>

            <button type="submit">Regisztráció</button>
            <a href="apanel.php" class="back-link">Vissza a főpanelre</a>
        </form>
    </div>
</body>
</html>