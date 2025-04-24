<?php
include '../functions.php';
Session();
Prof();
$conn = Connect();

if(isset($_POST['id']) && isset($_POST['name']) && isset($_POST['kezdet']) && isset($_POST['veg']) && isset($_POST['kod']) && isset($_POST['terem']) && isset($_POST['felev'])){
    $id=$_POST['id'];
    $name=$_POST['name'];
    $kezdet=$_POST['kezdet'];
    $veg=$_POST['veg'];
    $felev=$_POST['felev'];
    $kod=$_POST['kod'];
    $terem=$_POST['terem'];
    $tanar=$_SESSION['OKTATOID']; // remelem jol írtam
    //egyedi id ellenőrzése?

    $sql = "INSERT INTO VIZSGAK (VIZSGAID,VKEZDET,VVEGE,FELEVDATUM1,KURZUSID,TEREMID, OKTATOID) VALUES (:id, :name, :kezdet, :veg, :felev, :kod, :terem, :tanar)";
    
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ':id', $id);
    oci_bind_by_name($stmt, ':name', $name);
    oci_bind_by_name($stmt, ':kezdet', $kezdet);
    oci_bind_by_name($stmt, ':veg', $veg);
    oci_bind_by_name($stmt, ':kod', $felev);
    oci_bind_by_name($stmt, ':kod', $kod);
    oci_bind_by_name($stmt, ':kod', $terem);
    oci_bind_by_name($stmt, ':kod', $tanar);
    if(oci_execute($stmt)) {
        echo "Sikeres regisztráció!";
        header("Location: apanel.php");
    } else {
        echo "Hiba történt a regisztráció során.";
    }
    oci_free_statement($stmt);
}
?>
<DOCTYPE html>
<html lang="hu">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vizsgahirdetés</title>
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
            <h1>Vizsgahirdetés</h1>
            <form action="vizsgahir.php" method="POST">
            <label for="id">Vizsga azonosítója:</label>
            <input type="text" name="id" id="id" placeholder="Vizsga ID" required>

            <label for="name">Óra név:</label>
            <input type="text" id="name" name="name" placeholder="Add meg az óra nevét" required>

            <label for="kezdet">Vizsga kezdete:</label>
            <input type="time" id="kezdet" name="kezdet" required>

            <label for="veg">Vizsga vége:</label>
            <input type="time" id="veg" name="veg" required>

            <label for="felev">Félév:</label>
            <input type="text" id="felev" name="felev" required> <!--nem milyen formátumban adjuk meg so marad a szebadkézi beírás egyelőre-->

            <label for="kod">Kurzushoz tartozik(kurzus kód):</label>
            <select name="kod" id="kod">
                <?php
                //kurzusid választása a vizsgához
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

            <label for="terem">Terem:</label>
            <select name="terem" id="terem">
                <?php
                //teremid választása a vizsgához
                if($sql = "SELECT TEREMID FROM TERMEK"){
                    $result = oci_parse($conn, $sql);
                    $rowcount = oci_num_rows($result);
                    if($rowcount > 0){
                        while($row = oci_fetch_assoc($result)){
                            echo '<option value="'.$result.'">'.$result.'</option>';
                        }
                    } else{
                        echo '<option value="">Még nincs terem regisztrálva!</option>';
                    }
                }
                ?>
                <option value=""></option>
            </select>

            <button type="submit">Kihirdetés</button>
            <a href="oktpanel.php" class="back-link">Vissza a főpanelre</a>
        </form>

        </div>
    </body>
</html>
