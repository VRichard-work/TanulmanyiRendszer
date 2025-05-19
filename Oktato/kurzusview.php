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

        input,
        select,
        button {
            margin-top: 5px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        #department {
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
            <label for="kurzusnev">Kurzus választása</label>

            <?php
            //kurzus választása az órák listázásához
            $sql = "BEGIN :kurzus_lista := OKTATO_KURZUSAI(:username); END;";
            $result = oci_parse($conn, $sql);
            oci_bind_by_name($result, ':username', $_SESSION['username']);
            oci_bind_by_name($result, ':kurzus_lista', $kurzus_lista, 4000);
            oci_execute($result);
            $isnul = false;
            echo '<select name="kurzusnev" id="kurzusok">';
            $kurzusok = explode(", ", $kurzus_lista);
            foreach ($kurzusok as $kurzus) {
                echo '<option value="' . $kurzus . '">' . $kurzus . '</option>';
            }

            echo '</select>';
            oci_free_statement($result);

            ?>

            <button type="submit">Kurzusok megjelenítése</button>
        </form>

        <?php
        //kurzusok listázása
        if (isset($_POST['kurzusnev'])) { ?>
            <h1>Óráid</h1>
            <?php
            $sql = "SELECT * FROM ORAK
                     INNER JOIN KURZUSOK
                     ON ORAK.KURZUSID = KURZUSOK.KURZUSID
                     WHERE KURZUSOK.KNEV = :NEV";
            $result = oci_parse($conn, $sql);
            oci_bind_by_name($result, ':NEV', $_POST['kurzusnev']);
            oci_execute($result);
            $isnul = false;
            $first = oci_fetch_assoc($result);
            if ($first) {
                echo '<table border="1">';
                echo '<tr>
                                <th>Kurzus ID</th>
                                <th>Kurzus név</th>
                                <th>Kurzustípus</th>
                                <th>Kurzus Kód</th>
                                <th>Óra kezdete</th>
                                <th>Óra vége</th>
                                <th>Terem</th>
                                </tr>';
                echo '<tr>';
                echo '<td>' . $first['ORAID'] . '</td>';
                echo '<td>' . $first['KNEV'] . '</td>';
                echo '<td>' . $first['KURZUSTIPUS'] . '</td>';
                echo '<td>' . $first['KURZUSKOD'] . '</td>';
                echo '<td>' . $first['OKEZDET'] . '</td>';
                echo '<td>' . $first['OVEGE'] . '</td>';
                echo '<td>' . $first['TEREMID'] . '</td>';
                echo '</tr>';
                $isnul = true;
                while ($row = oci_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td>' . $row['ORAID'] . '</td>';
                    echo '<td>' . $row['KNEV'] . '</td>';
                    echo '<td>' . $row['KURZUSTIPUS'] . '</td>';
                    echo '<td>' . $row['KURZUSKOD'] . '</td>';
                    echo '<td>' . $row['OKEZDET'] . '</td>';
                    echo '<td>' . $row['OVEGE'] . '</td>';
                    echo '<td>' . $row['TEREMID'] . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo '<p>Még nincs megjeleníthető adat.</p>';
            }
        }
        ?>
        <br><br><br>
        <?php
        //órák listázása kurzusok szerint
        
        ?>
        <a href="oktpanel.php" class="back-link">Vissza a főpanelre</a>
    </div>
</body>

</html>