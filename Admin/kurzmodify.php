<?php
include '../functions.php';
Session();
Admin();
$conn = Connect();


if(isset($_POST['kurzusid']) && isset($_POST['knev']) && isset($_POST['kovetelmeny']) && isset($_POST['tipus']) && isset($_POST['kod'])){
    $kurzusid = $_POST['kurzusid'];
    $knev = $_POST['knev'];
    $kovetelmeny = $_POST['kovetelmeny'];
    $tipus = $_POST['tipus'];
    $kod = $_POST['kod'];
    $sql = "UPDATE KURZUSOK SET KNEV = :knev, KOVETELMENYTIPUS = :kovetelmeny, KURZUSTIPUS = :tipus, KURZUSKOD = :kod WHERE KURZUSID = :kurzusid";
    $result = oci_parse($conn, $sql);
    oci_bind_by_name($result, ':kurzusid', $kurzusid);
    oci_bind_by_name($result, ':knev', $knev);
    oci_bind_by_name($result, ':kovetelmeny', $kovetelmeny);
    oci_bind_by_name($result, ':tipus', $tipus);
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
    <title>Kurzus módosítás</title>
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
        <h1>Kurzus adatok módosítása</h1>
        <form action="kurzmodify.php" method="post">
            <?php
            if(isset($_GET['updatekurzus'])){
                $updatekurzus = $_GET['updatekurzus'];
                $sql = "SELECT * FROM KURZUSOK WHERE KURZUSID=$updatekurzus";
                $result = oci_parse($conn, $sql);
                oci_execute($result);
                while($row = oci_fetch_assoc($result)){
                ?>
                <label for="kurzusid">Kurzus azonosító</label>
                <input type="number" value="<?php echo $updatekurzus ?>" name="kurzusid" readonly>
                
                <label for="knev">Új Kurzusnév</label>
                <input type="text" value="<?php echo $row['KNEV'] ?>" name="knev">
                
                <label for="kovetelmeny">Követelménytipus</label>
                    <select id="kovetelmeny" name="kovetelmeny" required>
                        <?php
                        if($row['KOVETELMENYTIPUS'] == "KOLLOKVIUM"){
                            ?><option value="KOLLOKVIUM" <?php echo 'selected'; ?>>Kollokvium</option><?php
                            ?><option value="GYAKVIZSGA">Gyakorlati vizsga</option><?php
                            ?><option value="Nincs">Nincs</option><?php
                        } elseif($row['KOVETELMENYTIPUS'] == "GYAKVIZSGA"){
                            ?><option value="KOLLOKVIUM">Kollokvium</option><?php
                            ?><option value="GYAKVIZSGA" <?php echo 'selected'; ?>>Gyakorlati vizsga</option><?php
                            ?><option value="Nincs">Nincs</option><?php
                        }else{
                            ?><option value="KOLLOKVIUM">Kollokvium</option><?php
                            ?><option value="GYAKVIZSGA">Gyakorlati vizsga</option><?php
                            ?><option value="Nincs" <?php echo 'selected'; ?>>Nincs</option><?php
                        }
                            
                        ?>
                    </select>

                <label for="tipus">Kurzus tipusa</label>
                    <select id="tipus" name="tipus" required>
                        <?php
                        if($row['KURZUSTIPUS'] == "ELOADAS"){
                            ?><option value="ELOADAS" <?php echo 'selected'; ?>>Eloadas</option><?php
                            ?><option value="GYAKORLAT">Gyakorlati vizsga</option><?php
                            ?><option value="Nincs">Nincs</option><?php
                        } elseif($row['KURZUSTIPUS'] == "GYAKORLAT"){
                            ?><option value="ELOADAS">Eloadas</option><?php
                            ?><option value="GYAKORLAT" <?php echo 'selected'; ?>>Gyakorlati vizsga</option><?php
                            ?><option value="Nincs">Nincs</option><?php
                        }else{
                            ?><option value="ELOADAS">Eloadas</option><?php
                            ?><option value="GYAKORLAT">Gyakorlati vizsga</option><?php
                            ?><option value="Nincs" <?php echo 'selected'; ?>>Nincs</option><?php
                        }
                            
                        ?>
                    </select>

                <label for="kod">Új kurzus kód</label>
                <input type="text" value="<?php echo $row['KURZUSKOD'] ?>" name="kod">
                
                <?php }
                }
                ?>
                <button type="submit">Módosítás</button>
                <a href="apanel.php">Mégse</a>
    </form>
    </div>
    
</body>

</html>