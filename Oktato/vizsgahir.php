<?php
include '../functions.php';
Session();
Prof();
$conn = Connect();
if(isset($_POST['kurzusid']) && $_POST['kurzusid'] == 0){
        echo "Nincs ilyen kurzus";
        $_POST['kurzusid'] = null;
    }
    if(isset($_POST['terem']) && $_POST['terem'] == 0){
        echo "Nincs ilyen terem";
        $_POST['terem'] = null;
    }
    if(isset($_POST['kezdet']) && isset($_POST['veg'])  && $_POST['kezdet'] > $_POST['veg']){
        echo "A vizsga kezdete nem lehet később mint a vége";
        $_POST['kezdet'] = null;
        $_POST['veg'] = null;
    }

if(isset($_POST['kurzusid']) && 
isset($_POST['kezdet']) &&
isset($_POST['veg']) &&
isset($_POST['terem']) && 
isset($_POST['felev'])){
    
    //az űrlap adatai
    $id=$_POST['kurzusid'];
    $kezdet=$_POST['kezdet'];
    $veg=$_POST['veg'];
    $date=$_POST['datum'];
    $kezdet = $date. ' ' . $kezdet . ':00';
    $veg = $date . ' ' . $veg . ':00';
    $felev=$_POST['felev'];
    $terem=$_POST['terem'];
    $tanar=$_SESSION['username'];
    $sql = "SELECT MAX(VIZSGAID) FROM VIZSGAK";
    $stmt = oci_parse($conn, $sql);
    oci_execute($stmt);
    $id = oci_fetch_row($stmt)[0][0];
    if($id == null) {
      $id = 1;
    } else {
      $id++;
    }
    oci_free_statement($stmt);



    $sql = "INSERT INTO VIZSGAK (VIZSGAID,VKEZDET,VVEGE,FELEVDATUM1,KURZUSID,TEREMID, OKTATOID) 
    VALUES (:id, 
    TO_TIMESTAMP(:kezdet, 'YYYY-MM-DD HH24:MI:SS'), 
    TO_TIMESTAMP(:veg, 'YYYY-MM-DD HH24:MI:SS'), 
    TO_DATE(:felev, 'YYYY-MM-DD'), 
    :kurzusid, :terem, :tanar)";
    
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ':id', $id);
    oci_bind_by_name($stmt, ':kezdet', $kezdet);
    oci_bind_by_name($stmt, ':veg', $veg);
    oci_bind_by_name($stmt, ':felev', $felev);
    oci_bind_by_name($stmt, ':kurzusid', $kurzusid);
    oci_bind_by_name($stmt, ':terem', $terem);
    oci_bind_by_name($stmt, ':tanar', $tanar);
    if(oci_execute($stmt)) {
        header("Location: oktpanel.php");
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

            <label for="name">Kurzus azonosítója:</label>
            <select name="kurzusid">
                <?php
                //kurzusid választása a vizsgához
                 $sql = "SELECT KURZUSOK.KNEV FROM FELELOS
                     INNER JOIN KURZUSOK 
                     ON FELELOS.KURZUSID = KURZUSOK.KURZUSID 
                     WHERE FELELOS.OKTATOID = :username";
                    $result = oci_parse($conn, $sql);
                    oci_bind_by_name($result, ':username',$_SESSION['username']);
                    oci_execute($result);
                    $isnul = false;
                    while($row = oci_fetch_array($result)){
                        $isnul = true;
                        ?>
                        
                        <option value="<?php echo $row['KNEV']; ?>"><?php echo $row['KNEV']; ?></option>
                    <?php }
                    if(!$isnul){ ?>
                        <option value="0">Nem létezik Kurzus</option>
                    <?php }
                    oci_free_statement($result);
                ?>
            </select>
            <label for="datum">Vizsga dátuma:</label>
            <input type="date" id="datum" name="datum" required>

            <label for="kezdet">Vizsga kezdete:</label>
            <input type="time" id="kezdet" name="kezdet" required>

            <label for="veg">Vizsga vége:</label>
            <input type="time" id="veg" name="veg" required>

            <label for="felev">Félév:</label>
            <input type="date" id="felev" name="felev" required> <!--nem milyen formátumban adjuk meg so marad a szebadkézi beírás egyelőre-->

            <label for="terem">Terem:</label>
            <select name="terem" id="terem">
                <?php
                //teremid választása a vizsgához
                if($sql = "SELECT TEREMID FROM TERMEK"){
                    $result = oci_parse($conn, $sql);
                    $isnul = false;
                    oci_execute($result);
                    while($row = oci_fetch_array($result)){
                        $isnul = true;?>
                        <option value="<?php echo $row['TEREMID']; ?>"><?php echo $row['TEREMID']; ?></option>
                    <?php }
                    if(!$isnul){ ?>
                        <option value="0">Nem létezik terem</option>
                    <?php }
                }
                ?>
            </select>

            <button type="submit">Kihirdetés</button>
            <a href="oktpanel.php" class="back-link">Vissza a főpanelre</a>
        </form>

        </div>
    </body>
</html>
