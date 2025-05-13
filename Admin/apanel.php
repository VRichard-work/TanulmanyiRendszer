<?php
include '../functions.php';
Session();
Admin();
$conn = Connect();
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
<!--
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
            margin: 20px;
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
            max-width: 300px;
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
            max-width: 300px;
        }
        a:hover {
            background-color: #02132c;
            color: white;
        }
    </style>
-->
</head>
<body>

<div class="container">
    <h1>Admin Panel</h1>
    <div class="panel">
        <a href="studreg.php">👨‍🎓 Diákok felvitele</a>
        <br>
        <?php
            $sql = "SELECT * FROM HALLGATOK";
                $result = oci_parse($conn, $sql);
                oci_execute($result);
                $isnul = false;
                $first = oci_fetch_assoc($result);
                if($first){
                    echo '<table border="1">';
                    echo '<tr>
                        <th>Hallgató azonosító</th>
                        <th>Hallgató név</th>
                        <th>Hallgató jelszó</th>
                        <th>Hallgató születési dátuma</th>
                        <th>Hallgató szak (szakid)</th>
                        <th>Adatok módosítása</th>
                        <th>Hallgató törlése</th>
                        </tr>';
                    echo '<tr>';
                        echo '<td>'.$first['HALLGATOID'].'</td>';
                        echo '<td>'.$first['HNEV'].'</td>';
                        echo '<td>'.$first['HJELSZO'].'</td>';
                        echo '<td>'.$first['SZULETES'].'</td>';
                        echo '<td>'.$first['SZAKID'].'</td>';
                        echo '<td><a href="studmodify.php">Módosítás</a></td>';
                        echo '<td><a href="torol.php">Törlés</a></td>'; //id + a sor id-ja a totol.php-n belul!!!
                    echo '</tr>';
                    $isnul = true;
                    while($row = oci_fetch_assoc($result)){
                        echo '<tr>';
                            echo '<td>'.$row['HALLGATOID'].'</td>';
                            echo '<td>'.$row['HNEV'].'</td>';
                            echo '<td>'.$row['HJELSZO'].'</td>';
                            echo '<td>'.$row['SZULETES'].'</td>';
                            echo '<td>'.$row['SZAKID'].'</td>';
                            echo '<td><a href="studmodify.php">Módosítás</a></td>';
                            echo '<td><a href="torol.php">Törlés</a></td>'; //id + a sor id-ja a totol.php-n belul!!!
                        echo '</tr>';
                    }
                    echo '</table>';
                } else{
                    echo '<p>Még nincs megjeleníthető adat.</p>';
                }
            ?>
            <br>
            <a href="oktregis.php">👩‍🏫 Tanárok felvitele</a>
            <br>
            <?php
            $sql = "SELECT * FROM OKTATOK";
                $result = oci_parse($conn, $sql);
                oci_execute($result);
                $isnul = false;
                $first = oci_fetch_assoc($result);
                if($first){
                    echo '<table border="1">';
                    echo '<tr>
                        <th>Oktato azonosító</th>
                        <th>Oktató név</th>
                        <th>Oktató jelszó</th>
                        <th>Adatok módosítása</th>
                        <th>Oktató törlése</th>
                        </tr>';
                    echo '<tr>';
                        echo '<td>'.$first['OKTATOID'].'</td>';
                        echo '<td>'.$first['ONEV'].'</td>';
                        echo '<td>'.$first['OJELSZO'].'</td>';
                        echo '<td><a href="studmodify.php">Módosítás</a></td>';
                        echo '<td><a href="torol.php">Törlés</a></td>'; //id + a sor id-ja a totol.php-n belul!!!
                    echo '</tr>';
                    $isnul = true;
                    while($row = oci_fetch_assoc($result)){
                        echo '<tr>';
                            echo '<td>'.$row['OKTATOID'].'</td>';
                            echo '<td>'.$row['ONEV'].'</td>';
                            echo '<td>'.$row['OJELSZO'].'</td>';
                            echo '<td><a href="studmodify.php">Módosítás</a></td>';
                            echo '<td><a href="torol.php">Törlés</a></td>'; //id + a sor id-ja a totol.php-n belul!!!
                        echo '</tr>';
                    }
                    echo '</table>';
                } else{
                    echo '<p>Még nincs megjeleníthető adat.</p>';
                }
            ?>
            <br>
            <a href="kurzregist.php">📚 Kurzusok felvitele</a>
            <br>
            <?php
            $sql = "SELECT * FROM KURZUSOK";
                $result = oci_parse($conn, $sql);
                oci_execute($result);
                $isnul = false;
                $first = oci_fetch_assoc($result);
                if($first){
                    echo '<table border="1">';
                    echo '<tr>
                        <th>Kurzus azonosító</th>
                        <th>Kurzus név</th>
                        <th>Követelménytípus</th>
                        <th>Kurzus típusa</th>
                        <th>Kurzuskód</th>
                        <th>Adatok módosítása</th>
                        <th>Kurzus törlése</th>
                        </tr>';
                    echo '<tr>';
                        echo '<td>'.$first['KURZUSID'].'</td>';
                        echo '<td>'.$first['KNEV'].'</td>';
                        echo '<td>'.$first['KOVETELMENYTIPUS'].'</td>';
                        echo '<td>'.$first['KURZUSTIPUS'].'</td>';
                        echo '<td>'.$first['KURZUSKOD'].'</td>';
                        echo '<td><a href="studmodify.php">Módosítás</a></td>';
                        echo '<td><a href="torol.php">Törlés</a></td>'; //id + a sor id-ja a totol.php-n belul!!!
                    echo '</tr>';
                    $isnul = true;
                    while($row = oci_fetch_assoc($result)){
                        echo '<tr>';
                            echo '<td>'.$row['KURZUSID'].'</td>';
                            echo '<td>'.$row['KNEV'].'</td>';
                            echo '<td>'.$row['KOVETELMENYTIPUS'].'</td>';
                            echo '<td>'.$row['KURZUSTIPUS'].'</td>';
                            echo '<td>'.$row['KURZUSKOD'].'</td>';
                            echo '<td><a href="studmodify.php">Módosítás</a></td>';
                            echo '<td><a href="torol.php">Törlés</a></td>'; //id + a sor id-ja a totol.php-n belul!!!
                        echo '</tr>';
                    }
                    echo '</table>';
                } else{
                    echo '<p>Még nincs megjeleníthető adat.</p>';
                }
            ?>
            <br>
            <a href="teremregist.php">💼 Terem felvitele</a>
            <br>
            <?php
            $sql = "SELECT * FROM TERMEK";
                $result = oci_parse($conn, $sql);
                oci_execute($result);
                $isnul = false;
                $first = oci_fetch_assoc($result);
                if($first){
                    echo '<table border="1">';
                    echo '<tr>
                        <th>Terem azonosító</th>
                        <th>Férőhely</th>
                        <th>Adatok módosítása</th>
                        <th>Terem törlése</th>
                        </tr>';
                    echo '<tr>';
                        echo '<td>'.$first['TEREMID'].'</td>';
                        echo '<td>'.$first['FEROHELY'].'</td>';
                        echo '<td><a href="studmodify.php">Módosítás</a></td>';
                        echo '<td><a href="torol.php">Törlés</a></td>'; //id + a sor id-ja a totol.php-n belul!!!
                    echo '</tr>';
                    $isnul = true;
                    while($row = oci_fetch_assoc($result)){
                        echo '<tr>';
                            echo '<td>'.$row['TEREMID'].'</td>';
                            echo '<td>'.$row['FEROHELY'].'</td>';
                            echo '<td><a href="studmodify.php">Módosítás</a></td>';
                            echo '<td><a href="torol.php">Törlés</a></td>'; //id + a sor id-ja a totol.php-n belul!!!
                        echo '</tr>';
                    }
                    echo '</table>';
                } else{
                    echo '<p>Még nincs megjeleníthető adat.</p>';
                }
            ?>
            <br>
            <a href="oraregist.php">📖 Óra felvitele</a>
            <br>
            <?php
            $sql = "SELECT * FROM ORAK";
                $result = oci_parse($conn, $sql);
                oci_execute($result);
                $isnul = false;
                $first = oci_fetch_assoc($result);
                if($first){
                    echo '<table border="1">';
                    echo '<tr>
                        <th>Óra azonosító</th>
                        <th>Óra Időtartama</th>
                        <th>Terem azonosító/th>
                        <th>Kurzus azonosító</th>
                        <th>Adatok módosítása</th>
                        <th>Óra törlése</th>
                        </tr>';
                    echo '<tr>';
                        echo '<td>'.$first['ORAID'].'</td>';
                        echo '<td>'.$first['OKEZDET']. ' - '.$first['OVEGE'].'</td>';
                        echo '<td>'.$first['TEREMID'].'</td>';
                        echo '<td>'.$first['KURZUSID'].'</td>';
                        echo '<td><a href="studmodify.php">Módosítás</a></td>';
                        echo '<td><a href="torol.php">Törlés</a></td>'; //id + a sor id-ja a totol.php-n belul!!!
                    echo '</tr>';
                    $isnul = true;
                    while($row = oci_fetch_assoc($result)){
                        echo '<tr>';
                            echo '<td>'.$row['ORAID'].'</td>';
                            echo '<td>'.$row['OKEZDET']. ' - '.$first['OVEGE'].'</td>';
                            echo '<td>'.$row['TEREMID'].'</td>';
                            echo '<td>'.$row['KURZUSID'].'</td>';
                            echo '<td><a href="studmodify.php">Módosítás</a></td>';
                            echo '<td><a href="torol.php">Törlés</a></td>'; //id + a sor id-ja a totol.php-n belul!!!
                        echo '</tr>';
                    }
                    echo '</table>';
                } else{
                    echo '<p>Még nincs megjeleníthető adat.</p>';
                }
            ?>
            <br>
        <form action="../logout.php" method="POST">
            <button type="submit">Kijelentkezés</button>
        </form>
    </div>
</div>

</body>
</html>
