<?php
include '../functions.php';
Session();
Stud();
$conn = Connect();


if (isset($_GET['kurzusValaszto']) && isset($_GET['datum'])) {
    $kurzid = $_GET['kurzusValaszto'];
    $datum = $_GET['datum'];
    $jegy = null;

    $sql = "SELECT MAX(FELVETELSZAM) FROM FELVETTKURZUSOK WHERE KURZUSID = :kurzus";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ':kurzus', $_GET['kurzusValaszto']);
    oci_execute($stmt);
    $szam = 0;
    $row = oci_fetch_array($stmt, OCI_NUM);
    if ($row && $row[0] !== null) {
        $szam = $row[0] + 1;
    } else {
        $szam = 1;
    }
    oci_free_statement($stmt);

    $sql = "INSERT INTO FELVETTKURZUSOK (HALLGATOID, KURZUSID, FELEVDATUM2, FELVETELSZAM, ERDEMJEGY) VALUES (:username, :kurzid, TO_DATE(:felev, 'YYYY-MM-DD'), :szam, :jegy)";
    $stmt = oci_parse($conn, $sql);
    if (!$stmt) {
        $error = oci_error($conn);
        echo "<script>alert('Hiba történt a jelentkezés során: " . $error['message'] . "');</script>";
    }
    oci_bind_by_name($stmt, ':username', $_SESSION['username']);
    oci_bind_by_name($stmt, ':kurzid', $kurzid);
    oci_bind_by_name($stmt, ':felev', $datum);
    oci_bind_by_name($stmt, ':szam', $szam);
    oci_bind_by_name($stmt, ':jegy', $jegy);
    if (!oci_execute($stmt)) {
        $error = oci_error($stmt);
        echo "<script>alert('Hiba történt a jelentkezés során: " . $error['message'] . "');</script>";

    } else {

        echo "<script>alert('Sikeres jelentkezés!');</script>";
    }
    oci_free_statement($stmt);
}
?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vizsgajelentkezés</title>
    <style>
        body {
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #023c66;
            color: white;
            padding: 1rem;
            text-align: center;
            font-size: 2.5rem;
        }

        .container {
            display: flex;
            justify-content: center;
            margin-top: 50px;
        }

        .panel {
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        h2 {
            text-align: center;
            color: #023c66;
        }

        select {
            width: 100%;
            padding: 0.7rem;
            margin: 1rem 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 1rem;
        }

        .vizsga-lista {
            margin-top: 1rem;
        }

        .vizsga {
            background-color: #e6f0ff;
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 8px;
        }

        .vizsga strong {
            display: block;
            color: #023c66;
        }

        .jelentkezes {
            background-color: #005796;
            color: white;
            padding: 0.8rem 1.2rem;
            width: 100%;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .jelentkezes:hover {
            background-color: #02132c;
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

    <header>Kurzusjelentkezés</header>

    <div class="container">
        <div class="panel">
            <h2>Kurzus kiválasztása</h2>
            <form method="GET" action="apply.php">
                <label for="datum">Félév:</label>
                <input type="date" id="datum" name="datum">

                <select name="kurzusValaszto" id="kurzusValaszto">
                    <?php
                    //kurzusok listázása
                    $sql = "SELECT KURZUSOK.KURZUSID, KURZUSOK.KNEV
                            FROM KURZUSOK
                            JOIN KTARTOZIK ON KURZUSOK.KURZUSID = KTARTOZIK.KURZUSID
                            JOIN HALLGATOK ON KTARTOZIK.SZAKID = HALLGATOK.SZAKID
                            WHERE HALLGATOK.HALLGATOID = :username";
                    $result = oci_parse($conn, $sql);
                    oci_bind_by_name($result, ':username', $_SESSION['username']);
                    oci_execute($result);
                    $isnul = false;
                    while ($row = oci_fetch_array($result, OCI_ASSOC + OCI_RETURN_NULLS)) {
                        if (!$isnul) {
                            ?>
                            <option value="<?php echo $row['KURZUSID']; ?>" hidden>Válassz kurzust</option>
                            <?php
                        }
                        $isnul = true;
                        ?>
                        <option value="<?php echo $row['KURZUSID']; ?>"><?php echo $row['KNEV']; ?></option>
                        <?php

                    }
                    oci_free_statement($result);
                    ?>
                </select>
                <button id="jelentkezes" name="jelentkezes">Kurzus jelentkezés</button>
            </form>

            <div class="vizsga-lista">
                <div class="vizsga">
                    <form method="POST" action="vizsga.php">
                        <?php
                        //órák listázása
                        /*
                        if (isset($_GET['kurzusokMegjelenitese']) && isset($_GET['kurzusValaszto'])) {
                            $kurzusid = $_GET['kurzusValaszto'];
                            $sql = "SELECT * FROM KURZUSOK WHERE KURZUSID = :kurzusid";
                            $result = oci_parse($conn, $sql);
                            oci_bind_by_name($result, ':kurzusid', $kurzusid);
                            oci_execute($result);
                            while ($row = oci_fetch_array($result, OCI_ASSOC + OCI_RETURN_NULLS)) {
                                $sql2 ="SELECT * FROM ORAK WHERE KURZUSID = :kurzusid2";
                                $result2 = oci_parse($conn, $sql2);
                                oci_bind_by_name($result2, ':kurzusid2', $kurzusid2);
                                oci_execute($result2);
                                ?>
                                <strong></strong>
                                <?php echo $row2['TEREMID']; ?><br>

                                <strong>Órák:</strong>
                                <?php
                                while ($row2 = oci_fetch_array($result2, OCI_ASSOC + OCI_RETURN_NULLS)) {
                                    ?>
                                    <strong>Időpont:</strong> <?php echo $row2['VKEZDET']; ?>
                                    <br>
                                    <?php echo $row2['VVEGE']; ?>
                                    <strong>Helyszín:</strong>
                                    <?php echo $row2['TEREMID']; ?><br>
                                <?php } ?>
                                <br><br>
                                <button class="jelentkezes" name="submit"
                                    value="<?php echo $row["KURZUSID"]; ?>">Jelentkezem</button>
                                <hr>
                                <?php
                            }
                        }
                            */
                        ?>
                        
                    </form>
                </div>
            </div>

            <a href="panel.php">Vissza a Panelre</a>
        </div>
    </div>

</body>

</html> 