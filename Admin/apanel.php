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
    <h1>Admin Panel</h1>
    <!--adminok hozzáadása-->
    <br><br>
    <a href="../index.php">Adminok kezelése</a>
    <br><br><br><br>
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
                        <th class="changes">Adatok módosítása</th>
                        <th class="changes">Hallgató törlése</th>
                        </tr>';
                    echo '<tr>';
                        echo '<td>'.$first['HALLGATOID'].'</td>';
                        echo '<td>'.$first['HNEV'].'</td>';
                        echo '<td>'.$first['HJELSZO'].'</td>';
                        echo '<td>'.$first['SZULETES'].'</td>';
                        echo '<td>'.$first['SZAKID'].'</td>';
                        echo '<td><a href="studmodify.php">Módosítás</a></td>';
                        echo '<td><a href="torol.php?deletestud='.$first['HALLGATOID'].'">Törlés</a></td>'; //id + a sor id-ja a totol.php-n belul!!!
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
                            echo '<td><a href="torol.php?deletestud='.$row['HALLGATOID'].'">Törlés</a></td>'; //id + a sor id-ja a totol.php-n belul!!!
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
                        <th class="changes">Adatok módosítása</th>
                        <th class="changes">Oktató törlése</th>
                        </tr>';
                    echo '<tr>';
                        echo '<td>'.$first['OKTATOID'].'</td>';
                        echo '<td>'.$first['ONEV'].'</td>';
                        echo '<td>'.$first['OJELSZO'].'</td>';
                        echo '<td><a href="studmodify.php">Módosítás</a></td>';
                        echo '<td><a href="torol.php?deleteokt='.$first['OKTATOID'].'">Törlés</a></td>'; //id + a sor id-ja a totol.php-n belul!!!
                    echo '</tr>';
                    $isnul = true;
                    while($row = oci_fetch_assoc($result)){
                        echo '<tr>';
                            echo '<td>'.$row['OKTATOID'].'</td>';
                            echo '<td>'.$row['ONEV'].'</td>';
                            echo '<td>'.$row['OJELSZO'].'</td>';
                            echo '<td><a href="studmodify.php">Módosítás</a></td>';
                            echo '<td><a href="torol.php?deleteokt='.$row['OKTATOID'].'">Törlés</a></td>'; //id + a sor id-ja a totol.php-n belul!!!
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
                        <th class="changes">Adatok módosítása</th>
                        <th class="changes">Kurzus törlése</th>
                        </tr>';
                    echo '<tr>';
                        echo '<td>'.$first['KURZUSID'].'</td>';
                        echo '<td>'.$first['KNEV'].'</td>';
                        echo '<td>'.$first['KOVETELMENYTIPUS'].'</td>';
                        echo '<td>'.$first['KURZUSTIPUS'].'</td>';
                        echo '<td>'.$first['KURZUSKOD'].'</td>';
                        echo '<td><a href="studmodify.php">Módosítás</a></td>';
                        echo '<td><a href="torol.php?deletekurz='.$first['KURZUSID'].'">Törlés</a></td>'; //id + a sor id-ja a totol.php-n belul!!!
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
                            echo '<td><a href="torol.php?deletekurz='.$row['KURZUSID'].'">Törlés</a></td>'; //id + a sor id-ja a totol.php-n belul!!!
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
                        <th class="changes">Adatok módosítása</th>
                        <th class="changes">Terem törlése</th>
                        </tr>';
                    echo '<tr>';
                        echo '<td>'.$first['TEREMID'].'</td>';
                        echo '<td>'.$first['FEROHELY'].'</td>';
                        echo '<td><a href="studmodify.php">Módosítás</a></td>';
                        echo '<td><a href="torol.php?deleteterem='.$first['TEREMID'].'">Törlés</a></td>'; //id + a sor id-ja a totol.php-n belul!!!
                    echo '</tr>';
                    $isnul = true;
                    while($row = oci_fetch_assoc($result)){
                        echo '<tr>';
                            echo '<td>'.$row['TEREMID'].'</td>';
                            echo '<td>'.$row['FEROHELY'].'</td>';
                            echo '<td><a href="studmodify.php">Módosítás</a></td>';
                            echo '<td><a href="torol.php?deleteterem='.$row['TEREMID'].'">Törlés</a></td>'; //id + a sor id-ja a totol.php-n belul!!!
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
                        <th class="changes">Adatok módosítása</th>
                        <th class="changes">Óra törlése</th>
                        </tr>';
                    echo '<tr>';
                        echo '<td>'.$first['ORAID'].'</td>';
                        echo '<td>'.$first['OKEZDET']. ' - '.$first['OVEGE'].'</td>';
                        echo '<td>'.$first['TEREMID'].'</td>';
                        echo '<td>'.$first['KURZUSID'].'</td>';
                        echo '<td><a href="studmodify.php">Módosítás</a></td>';
                        echo '<td><a href="torol.php?deleteora='.$first['ORAID'].'">Törlés</a></td>'; //id + a sor id-ja a totol.php-n belul!!!
                    echo '</tr>';
                    $isnul = true;
                    while($row = oci_fetch_assoc($result)){
                        echo '<tr>';
                            echo '<td>'.$row['ORAID'].'</td>';
                            echo '<td>'.$row['OKEZDET']. ' - '.$first['OVEGE'].'</td>';
                            echo '<td>'.$row['TEREMID'].'</td>';
                            echo '<td>'.$row['KURZUSID'].'</td>';
                            echo '<td><a href="studmodify.php">Módosítás</a></td>';
                            echo '<td><a href="torol.php?deleteora='.$row['ORAID'].'">Törlés</a></td>'; //id + a sor id-ja a totol.php-n belul!!!
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
