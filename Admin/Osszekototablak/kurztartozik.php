<?php
include '../../functions.php';
Session();
Admin();
$conn = Connect();

if(isset($_POST['szakid']) && isset($_POST['kurzid'])){
    $szakid = $_POST['szakid'];
    $kurzid = $_POST['kurzid'];
    $sql = "INSERT INTO KTARTOZIK (SZAKID, KURZUSID) VALUES (:szakid, :kurzid)";
    $result = oci_parse($conn, $sql);
    if (!$result){
        echo 'Nem olvasta be az adatot';
    }
    if (!$result) {
        $e = oci_error($conn);
        echo "Hiba a lekérdezés előkészítésekor: " . $e['message'];
    } else {
        oci_bind_by_name($result, ':szakid', $szakid);
        oci_bind_by_name($result, ':kurzid', $kurzid);

        if (!oci_execute($result)) {
            $e = oci_error($result);
            echo "Hiba a végrehajtás során: " . $e['message'];
        } else {
            oci_commit($conn);
            echo "Sikeres beszúrás!";
            header('Location: osszkotlista.php');
        }

        oci_free_statement($result);
    }
    
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kurzus feltételek</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }

        .container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 1200px;
            margin: 40px auto;
        }

        h1 {
            text-align: center;
            color: #3b3b3b;
            font-size: 2.4em;
            margin-bottom: 30px;
        }

        a {
            display: inline-block;
            margin: 10px 10px 20px 0;
            text-align: center;
            color: #005796;
            text-decoration: none;
            background-color: #75aafa;
            padding: 10px 16px;
            border-radius: 5px;
            font-weight: bold;
            font-size: 1.1em;
            transition: all 0.3s ease;
        }

        a:hover {
            background-color: #02132c;
            color: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
            background-color: #fdfdfd;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: center;
            font-size: 15px;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        .changes{
            background-color:rgb(0, 53, 110);
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #e0f0ff;
        }

        button {
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
            padding: 0.8rem 1.2rem;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        form button[type="submit"] {
        padding: 10px 20px;
        background-color: #e74c3c;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-left: 10px;
        font-size: 1.1em;
        transition: background-color 0.3s;
        }

        form button[type="submit"]:hover {
        background-color: #c0392b;
        }
    </style>

</head>
<body>
    <div class="container">
        <h1>Szakhoz tartozó kurzusok</h1>
        <form action="kurztartozik.php" method="post">
            
                <label for="szakid">Szak:</label>
                <select id="szakid" name="szakid" required>
                    <?php
                    //szakid választása a kurzusukhoz
                    if($sql = "SELECT SZAKID, SZNEV FROM SZAKOK"){
                        $result = oci_parse($conn, $sql);
                        $rowcount = oci_num_rows($result);
                        oci_define_by_name($result, 'SZAKID', $db_szakid);
                        oci_define_by_name($result, 'SZNEV', $db_szaknev);
                        oci_execute($result);
                        $isnul = false;
                        while($rowcount = oci_fetch_array($result)){
                            $isnul = true;
                            ?> 
                            <option value="<?php echo $db_szakid; ?>"><?php echo $db_szakid . ' - ' . $db_szaknev; ?></option>
                        <?php }
                        if(!$isnul){ ?>
                            <option value="0">Nem létezik Kurzus</option>
                        <?php }
                    }
                    ?>
                </select>

                <label for="kurzid">Új kurzus</label>
                <select name="kurzid" id="kurzid">
                    <?php
                    //kurzusid
                    if($sql = "SELECT KURZUSID, KNEV FROM KURZUSOK"){
                        $result = oci_parse($conn, $sql);
                        $rowcount = oci_num_rows($result);
                        oci_define_by_name($result, 'KURZUSID', $db_kurzusid);
                        oci_define_by_name($result, 'KNEV', $db_kurzusnev);
                        oci_execute($result);
                        $isnul = false;
                        while($rowcount = oci_fetch_array($result)){
                            $isnul = true;
                            ?> 
                            <option value="<?php echo $db_kurzusid;?>"><?php echo $db_kurzusid . ' - ' . $db_kurzusnev; ?></option>
                        <?php }
                        if(!$isnul){ ?>
                            <option value="0">Nem létezik Kurzus</option>
                        <?php }
                    }
                    ?>
                </select>
                <button type="submit">Regisztráció</button>
        </form>
        <a href="osszkotlista.php">Vissza az előző oldalra</a>

    </div>
</body>
</html>
