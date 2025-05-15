<?php
include '../functions.php';
Session();
Admin();
$conn = Connect();


if(isset($_POST['studid']) && isset($_POST['hnev']) && isset($_POST['jelszo']) && isset($_POST['szulet']) && isset($_POST['kod'])){
    $studid = $_POST['studid'];
    $hnev = $_POST['hnev'];
    $jelszo = $_POST['jelszo'];
    $szulet = $_POST['szulet'];
    $kod = $_POST['kod'];
    $sql = "UPDATE HALLGATOK SET HNEV = :hnev, HJELSZO = :jelszo, SZULETES = TO_DATE(:szulet, 'YYYY-MM-DD'), SZAKID = :kod WHERE HALLGATOID = :studid";
    $result = oci_parse($conn, $sql);
    oci_bind_by_name($result, ':studid', $studid);
    oci_bind_by_name($result, ':hnev', $hnev);
    oci_bind_by_name($result, ':jelszo', $jelszo);
    oci_bind_by_name($result, ':szulet', $szulet);
    oci_bind_by_name($result, ':kod', $kod);
    oci_execute($result);

    if($result){
        header('Location: apanel.php');
    }else{
        echo 'Nem sikerült a módosítás';
    }

}

?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hallgatók módosítás</title>
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
        <h1>Hallgatói adatok módosítása</h1>
        <form action="studmodify.php" method="post">
            <?php
            if(isset($_GET['updatestud'])){
                $updatestud = $_GET['updatestud'];
                $sql = "SELECT * FROM HALLGATOK WHERE HALLGATOID=$updatestud";
                $result = oci_parse($conn, $sql);
                oci_execute($result);
                while($row = oci_fetch_assoc($result)){
                ?>
                <label for="studid">Hallgatoi azonosító</label>
                <input type="number" value="<?php echo $updatestud ?>" name="studid" readonly>
                
                <label for="hnev">Új hallgató név</label>
                <input type="text" value="<?php echo $row['HNEV'] ?>" name="hnev" required>

                <label for="jelszo">Új hallgató jelszó</label>
                <input type="text" value="<?php echo $row['HJELSZO'] ?>" name="jelszo" required>
                
                <label for="szulet">Új születési dátum</label>
                <input type="date" id="szulet" name="szulet" required>

                <label for="kod">Új kurzus azonosító</label>
                <select name="kod" id="kod">
                    <?php
                    //Szak id választása a diákokhoz
                    if($sql = "SELECT SZAKID, SZNEV FROM SZAKOK"){
                        $result = oci_parse($conn, $sql);
                        $rowcount = oci_num_rows($result);
                        oci_define_by_name($result, 'SZAKID', $szakid);
                        oci_define_by_name($result, 'SZNEV', $szaknev);
                        oci_execute($result);
                        $isnul = false;
                        while($rowcount = oci_fetch_array($result)){
                            $isnul = true;
                            ?> 
                            <option value="<?php echo $rowcount['SZAKID'];?>" <?php if($rowcount['SZAKID'] == $row['SZAKID']){echo ' selected';}?>><?php echo $rowcount['SZAKID'] . ' - ' . $rowcount['SZNEV']; ?></option>
                        <?php }
                        if(!$isnul){ ?>
                            <option value="0">Nem létezik ilyen szak</option>
                        <?php }
                    }
                    ?>
                </select>

                <?php }
                }
                ?>
                <button type="submit">Módosítás</button>
                <a href="apanel.php">Mégse</a>
    </form>
    </div>
    
</body>

</html>