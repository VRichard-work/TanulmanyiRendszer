<?php
include '../functions.php';
Session();
Prof();
$conn = Connect();
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kurzus Órák Felvitele</title>
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
        <h1>A kurzusok</h1>

        <form action="kurzusview.php" method="POST">
            <label for="kurzusnev">Válasszon félévet</label>
            <select id="kurzusnev" name="kurzusnev" required>
                <?php
                //kurzus választása az órák listázásához
                    $sql = "SELECT KURZUSOK.KNEV FROM KURZUSOK INNER JOIN FELELOS ON KURZUSOK.KURZUSID = FELELOS.KURZUSID WHERE FELELOS.OKTATOID = :username";
                    $result = oci_parse($conn, $sql);
                    oci_bind_by_name($result, ':username',$_SESSION['username']);
                    oci_execute($result);
                    $rowcount = oci_num_rows($result);
                    if($rowcount > 0){
                        while($row = oci_fetch_array($result)){?>
                            <option value="<?$row["KNEV"]?>"><?$row['KNEV']?></option>
                        <?php }
                    } else{ ?>
                        <option value="0">Nem létezik Kurzus</option>
                    <?php
                    }
                    oci_free_statement($result);
                ?>
            </select>
        </form>

        <?php
        //kurzusok listázása
                $sql="SELECT KURZUSOK.KNEV FROM KURZUSOK INNER JOIN FELELOS ON KURZUSOK.KURZUSID = FELELOS.KURZUSID WHERE FELELOS.OKTATOID = :username";
                $result = oci_parse($conn, $sql);
                oci_bind_by_name($result, ':username', $_SESSION['username']);
                oci_execute($result);
                $rowcount = oci_num_rows($result);
                if($rowcount > 0){
                    echo '<table border="1">';
                        echo '<tr>
                            <th>Kurzus ID</th>
                            <th>Kurzus név</th>
                            <th>Követelménytípus</th>
                            <th>Kurzustípus</th>
                            <th>Kurzus Kód</th>
                            </tr>';

                    while($row = oci_fetch_assoc($result)){
                        echo '<tr>';
                            echo '<td>'.$sql['KURZUSID'].'</td>';
                            echo '<td>'.$sql['KNEV'].'</td>';
                            echo '<td>'.$sql['KOVETELMENYTIPUS'].'</td>';
                            echo '<td>'.$sql['KURZUSTIPUS'].'</td>';
                            echo '<td>'.$sql['KURZUSKOD'].'</td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                } else{
                    echo '<p>Még nincs megjeleníthető adat.</p>';
                }

            ?>
            <br><br><br>
            <?php
            //órák listázása kurzusok szerint
            if(isset($_POST['kurzusnev'])){
                $kurzusnev = $_POST['kurzusnev'];
                if($sql = 'SELECT * FROM ORAK INNER JOIN TARTJA WHERE OKTATOID = :username AND ORAK.KURZUSNEV = :kurzusnev'){
                    $result = oci_parse($conn, $sql);
                    oci_bind_by_name($result, ':username', $_SESSION['username']);
                    oci_bind_by_name($result, ':kurzusnev', $kurzusnev);
                    oci_execute($result);
                    $rowcount = oci_num_rows($result);
                    if($rowcount > 0){
                        echo '<table border="1">';
                            echo '<tr>
                                <th>Óra ID</th>
                                <th>Óra időpontja</th>
                                <th>Terem</th>
                                </tr>';

                        while($row = oci_fetch_assoc($result)){
                            echo '<tr>';
                                echo '<td>'.$sql['ORAID'].'</td>';
                                echo '<td>'.$sql['OKEZDET'].' - '.$sql['OVEGE'].'</td>';
                                echo '<td>'.$sql['TEREMID'].'</td>';
                            echo '</tr>';
                        }
                        echo '</table>';
                    } else{
                        echo '<p>Még nincs megjeleníthető adat.</p>';
                    }
                }
            }

        ?>
        <a href="oktpanel.php" class="back-link">Vissza a főpanelre</a>
    </div>
</body>
</html>