<?php
include '../functions.php';
Session();
Admin();
$conn = Connect();


if(isset($_POST['teremid']) && isset($_POST['fer'])){
    $teremid = $_POST['teremid'];
    $fer = $_POST['fer'];
    $sql = "UPDATE TERMEK SET FEROHELY = :fer WHERE TEREMID = :teremid";
    $result = oci_parse($conn, $sql);
    oci_bind_by_name($result, ':teremid', $teremid);
    oci_bind_by_name($result, ':fer', $fer);
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
    <title>Terem módosítás</title>
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
        <h1>Terem adatok módosítása</h1>
        <form action="teremmodify.php" method="post">
            <?php
            if(isset($_GET['updateterem'])){
                $updateterem = $_GET['updateterem'];
                $sql = "SELECT * FROM TERMEK WHERE TEREMID=$updateterem";
                $result = oci_parse($conn, $sql);
                oci_execute($result);
                while($row = oci_fetch_assoc($result)){
                ?>
                <label for="teremid">Új terem azonosító</label>
                <input type="number" value="<?php echo $updateterem ?>" name="teremid" readonly>

                <label for="fer">Új teremató jelszó</label>
                <input type="number" value="<?php echo $row['FEROHELY'] ?>" name="fer">
                
                <?php }
                }
                ?>
                <button type="submit">Módosítás</button>
                <a href="apanel.php">Mégse</a>
    </form>
    </div>
    
</body>

</html>