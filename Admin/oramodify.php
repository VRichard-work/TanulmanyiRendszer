<?php
include '../functions.php';
Session();
Admin();
$conn = Connect();


if(isset($_POST['oraid']) && isset($_POST['kezdet']) && isset($_POST['veg']) && isset($_POST['terem']) && isset($_POST['kod'])){
    $oraid = $_POST['oraid'];
    $kezdet = $_POST['kezdet'];
    $veg = $_POST['veg'];
    $terem = $_POST['terem'];
    $kod = $_POST['kod'];
    $sql = "UPDATE ORAK SET OKEZDET = TO_TIMESTAMP(:kezdet, 'YYYY-MM-DD HH24:MI:SS'), OVEGE = TO_TIMESTAMP(:veg, 'YYYY-MM-DD HH24:MI:SS'), TEREMID = :terem, KURZUSID = :kod WHERE ORAID = :oraid";
    $result = oci_parse($conn, $sql);
    oci_bind_by_name($result, ':oraid', $oraid);
    oci_bind_by_name($result, ':kezdet', $kezdet);
    oci_bind_by_name($result, ':veg', $veg);
    oci_bind_by_name($result, ':terem', $terem);
    oci_bind_by_name($result, ':kod', $kod);
    oci_execute($result);

    if($result){
        //header('Location: apanel.php');
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
    <title>Óra módosítás</title>
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
        <h1>Óra adatok módosítása</h1>
        <form action="oramodify.php" method="post">
            <?php
            if(isset($_GET['updateora'])){
                $updateora = $_GET['updateora'];
                $sql = "SELECT * FROM ORAK WHERE ORAID=$updateora";
                $result = oci_parse($conn, $sql);
                oci_execute($result);
                while($row = oci_fetch_assoc($result)){
                ?>
                <label for="oraid">Óra azonosító</label>
                <input type="number" value="<?php echo $updateora ?>" name="oraid" readonly>
                
                <label for="kezdet">Új kezdő időpont</label>
                <input type="time" value="<?php echo $row['OKEZDET'] ?>" name="kezdet">

                <label for="veg">Új vég időpont</label>
                <input type="time" value="<?php echo $row['OVEGE'] ?>" name="veg">
                
                <label for="terem">Új terem</label>
                <select name="terem" id="terem">
                    <?php
                    //teremid választása az órákhoz
                    if($sql = "SELECT TEREMID FROM TERMEK"){
                        $result = oci_parse($conn, $sql);
                        $rowcount = oci_num_rows($result);
                        oci_define_by_name($result, 'TEREMID', $teremid);
                        oci_execute($result);
                        $isnul = false;
                        while($rowcount = oci_fetch_array($result)){
                            $isnul = true;
                            ?> 
                            <option value="<?php echo $rowcount['TEREMID'];?>" <?php if($rowcount['TEREMID'] == $row['TEREMID']){echo ' selected';}?>><?php echo $rowcount['TEREMID']; ?></option>
                        <?php }
                        if(!$isnul){ ?>
                            <option value="0">Nem létezik ez a terem</option>
                        <?php }
                    }
                    ?>
                </select>

                <label for="kod">Új kurzus</label>
                <select name="kod" id="kod">
                    <?php
                    //kurzusid választása az órákhoz
                    if($sql = "SELECT KURZUSID, KNEV FROM KURZUSOK"){
                        $result = oci_parse($conn, $sql);
                        $rowcount = oci_num_rows($result);
                        oci_define_by_name($result, 'KURZUSID', $kurzusid);
                        oci_define_by_name($result, 'KNEV', $kurzusnev);
                        oci_execute($result);
                        $isnul = false;
                        while($rowcount = oci_fetch_array($result)){
                            $isnul = true;
                            ?> 
                            <option value="<?php echo $rowcount['KURZUSID'];?>" <?php if($rowcount['KURZUSID'] == $row['KURZUSID']){echo ' selected';}?>><?php echo $rowcount['KURZUSID'] . ' - ' . $rowcount['KNEV']; ?></option>
                        <?php }
                        if(!$isnul){ ?>
                            <option value="0">Nem létezik Kurzus</option>
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