<?php
include '../../functions.php';
Session();
Admin();
$conn = Connect();
 

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
        <h1>Kurzusfeltételek</h1>
        <h2>Szakokhoz tartozó kurzusok</h2>
        <a href="kurztartozik.php">Hozzáadás</a>
        <table>
            <?php

                $sql = "SELECT * FROM KTARTOZIK";
                $result = oci_parse($conn, $sql);
                oci_execute($result);
                $isnul = false;
                $first = oci_fetch_assoc($result);
                if($first){
                    echo '<table border="1">';
                    echo '<tr>
                        <th>Szak</th>
                        <th>Kurzus</th>
                        <th>Törlés</th>
                        </tr>';
                    echo '<tr>';
                        echo '<td>'.$first['SZAKID'].'</td>';
                        echo '<td>'.$first['KURZUSID'].'</td>';
                        echo "<td>
                                <form method='post' action='./torol1.php' onsubmit='return confirm(\"Biztosan törlöd ezt a kapcsolatot?\");'>
                                    <input type='hidden' name='szakid' value='" . $first['SZAKID'] . "'>
                                    <input type='hidden' name='kurzusid' value='" . $first['KURZUSID'] . "'>
                                    <button type='submit'>Törlés</button>
                                </form>
                            </td>";
                    echo '</tr>';
                    $isnul = true;
                    while($row = oci_fetch_assoc($result)){
                        echo '<tr>';
                            echo '<td>'.$row['SZAKID'].'</td>';
                            echo '<td>'.$row['KURZUSID'].'</td>';
                            echo "<td>
                                <form method='post' action='./torol1.php' onsubmit='return confirm(\"Biztosan törlöd ezt a kapcsolatot?\");'>
                                    <input type='hidden' name='szakid' value='" . $row['SZAKID'] . "'>
                                    <input type='hidden' name='kurzusid' value='" . $row['KURZUSID'] . "'>
                                    <button type='submit'>Törlés</button>
                                </form>
                            </td>";
                        echo '</tr>';
                    }
                    echo '</table>';
                } else{
                    echo '<p>Még nincs megjeleníthető adat.</p>';
                }

            ?>
        </table>
            <hr>
        <h2>Kurzusfelelősök</h2>
        <a href="oratart.php">Hozzáadás</a>
        <table>
            <?php

                $sql = "SELECT * FROM FELELOS";
                $result = oci_parse($conn, $sql);
                oci_execute($result);
                $isnul = false;
                $first = oci_fetch_assoc($result);
                if($first){
                    echo '<table border="1">';
                    echo '<tr>
                        <th>Kurzus</th>
                        <th>Tanár</th>
                        <th>Törlés</th>
                        </tr>';
                    echo '<tr>';
                        echo '<td>'.$first['KURZUSID'].'</td>';
                        echo '<td>'.$first['OKTATOID'].'</td>';
                        echo "<td>
                                <form method='post' action='./torol2.php' onsubmit='return confirm(\"Biztosan törlöd ezt a kapcsolatot?\");'>
                                    <input type='hidden' name='szakid' value='" . $first['KURZUSID'] . "'>
                                    <input type='hidden' name='kurzusid' value='" . $first['OKTATOID'] . "'>
                                    <button type='submit'>Törlés</button>
                                </form>
                            </td>";                        
                    echo '</tr>';
                    $isnul = true;
                    while($row = oci_fetch_assoc($result)){
                        echo '<tr>';
                            echo '<td>'.$row['KURZUSID'].'</td>';
                            echo '<td>'.$row['OKTATOID'].'</td>';
                            echo "<td>
                                <form method='post' action='./torol2.php' onsubmit='return confirm(\"Biztosan törlöd ezt a kapcsolatot?\");'>
                                    <input type='hidden' name='szakid' value='" . $row['KURZUSID'] . "'>
                                    <input type='hidden' name='kurzusid' value='" . $row['OKTATOID'] . "'>
                                    <button type='submit'>Törlés</button>
                                </form>
                            </td>"; 
                        echo '</tr>';
                    }
                    echo '</table>';
                } else{
                    echo '<p>Még nincs megjeleníthető adat.</p>';
                }

            ?>
        </table>
            <hr>
        <h2>Óratartók</h2>
        <a href="orafelelos.php">Hozzáadás</a>
        <table>
            <?php

                $sql = "SELECT * FROM TARTJA";
                $result = oci_parse($conn, $sql);
                oci_execute($result);
                $isnul = false;
                $first = oci_fetch_assoc($result);
                if($first){
                    echo '<table border="1">';
                    echo '<tr>
                        <th>Tanár</th>
                        <th>Kurzus</th>
                        <th>Töröl</th>
                        </tr>';
                    echo '<tr>';
                        echo '<td>'.$first['OKTATOID'].'</td>';
                        echo '<td>'.$first['ORAID'].'</td>';
                        echo "<td>
                                <form method='post' action='./torol3.php' onsubmit='return confirm(\"Biztosan törlöd ezt a kapcsolatot?\");'>
                                    <input type='hidden' name='szakid' value='" . $first['OKTATOID'] . "'>
                                    <input type='hidden' name='kurzusid' value='" . $first['ORAID'] . "'>
                                    <button type='submit'>Törlés</button>
                                </form>
                            </td>"; 
                    echo '</tr>';
                    $isnul = true;
                    while($row = oci_fetch_assoc($result)){
                        echo '<tr>';
                            echo '<td>'.$row['OKTATOID'].'</td>';
                            echo '<td>'.$row['ORAID'].'</td>';echo "<td>
                                <form method='post' action='./torol3.php' onsubmit='return confirm(\"Biztosan törlöd ezt a kapcsolatot?\");'>
                                    <input type='hidden' name='szakid' value='" . $row['OKTATOID'] . "'>
                                    <input type='hidden' name='kurzusid' value='" . $row['ORAID'] . "'>
                                    <button type='submit'>Törlés</button>
                                </form>
                            </td>"; 
                        echo '</tr>';
                    }
                    echo '</table>';
                } else{
                    echo '<p>Még nincs megjeleníthető adat.</p>';
                }

            ?>
        </table>
            <hr>
        <h2>Kurzusfeltételek</h2>
        <a href="kurzfeltetel.php">Hozzáadás</a>
        <table>
            <?php

                $sql = "SELECT * FROM FELTETELEK";
                $result = oci_parse($conn, $sql);
                oci_execute($result);
                $isnul = false;
                $first = oci_fetch_assoc($result);
                if($first){
                    echo '<table border="1">';
                    echo '<tr>
                        <th>Kurzus</th>
                        <th>Feltétel</th>
                        <th>Töröl</th>
                        </tr>';
                    echo '<tr>';
                        echo '<td>'.$first['KURZUSID'].'</td>';
                        echo '<td>'.$first['FELTETELKURZUSID'].'</td>';
                        echo "<td>
                                <form method='post' action='./torol4.php' onsubmit='return confirm(\"Biztosan törlöd ezt a kapcsolatot?\");'>
                                    <input type='hidden' name='szakid' value='" . $first['KURZUSID'] . "'>
                                    <input type='hidden' name='kurzusid' value='" . $first['FELTETELKURZUSID'] . "'>
                                    <button type='submit'>Törlés</button>
                                </form>
                            </td>"; 
                    echo '</tr>';
                    $isnul = true;
                    while($row = oci_fetch_assoc($result)){
                        echo '<tr>';
                            echo '<td>'.$row['KURZUSID'].'</td>';
                            echo '<td>'.$row['FELTETELKURZUSID'].'</td>';
                            echo "<td>
                                <form method='post' action='./torol4.php' onsubmit='return confirm(\"Biztosan törlöd ezt a kapcsolatot?\");'>
                                    <input type='hidden' name='szakid' value='" . $row['KURZUSID'] . "'>
                                    <input type='hidden' name='kurzusid' value='" . $row['FELTETELKURZUSID'] . "'>
                                    <button type='submit'>Törlés</button>
                                </form>
                            </td>"; 
                        echo '</tr>';
                    }
                    echo '</table>';
                } else{
                    echo '<p>Még nincs megjeleníthető adat.</p>';
                }

            ?>
        </table>
                <hr>
        <a href="../apanel.php">Vissza az admin panelra</a>

    </div>
</body>
</html>
