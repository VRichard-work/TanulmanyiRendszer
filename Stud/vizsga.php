<?php
include '../functions.php';
Session();
Stud();
$conn = Connect();


if (isset($_POST['submit'])) {
    $vizsgaid = $_POST['submit'];
    $sql = "INSERT INTO VIZSGAZO (HALLGATOID, VIZSGAID) VALUES (:username, :vizsgaid)";
    $stmt = oci_parse($conn, $sql);
    if (!$stmt) {
        $error = oci_error($conn);
        echo "<script>alert('Hiba történt a jelentkezés során: " . $error['message'] . "');</script>";
    }
    oci_bind_by_name($stmt, ':username', $_SESSION['username']);
    oci_bind_by_name($stmt, ':vizsgaid', $vizsgaid);
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

    <header>Vizsgajelentkezés</header>

    <div class="container">
        <div class="panel">
            <h2>Kurzus kiválasztása</h2>
            <form method="GET">
                <select name="kurzusValaszto" id="kurzusValaszto">
                    <?php
                    //kurzusok kiírása
                    $sql = "SELECT KURZUSOK.KNEV, KURZUSOK.KURZUSID FROM FELVETTKURZUSOK
                INNER JOIN KURZUSOK
                ON KURZUSOK.KURZUSID = FELVETTKURZUSOK.KURZUSID 
                WHERE HALLGATOID = :username";
                    $result = oci_parse($conn, $sql);
                    oci_bind_by_name($result, ':username', $_SESSION['username']);
                    oci_execute($result);
                    $isnul = false;
                    while ($row = oci_fetch_array($result, OCI_ASSOC + OCI_RETURN_NULLS)) {
                        if (!$isnul) {
                            ?>
                            <option value="" disabled selected hidden>Válassz kurzust</option>
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
                <button id="vizsgakMegjelenitese" name="vizsgakMegjelenitese">Vizsgák megjelenítése</button>
            </form>

            <div class="vizsga-lista">
                <div class="vizsga">
                    <form method="POST" action="vizsga.php">
                        <?php
                        //vizsgák kiírása
                        if (isset($_GET['vizsgakMegjelenitese']) && isset($_GET['kurzusValaszto'])) {
                            $kurzusid = $_GET['kurzusValaszto'];
                            $sql = "SELECT VIZSGAK.VIZSGAID,VIZSGAK.VKEZDET, VIZSGAK.VVEGE, TERMEK.TEREMID, TERMEK.FEROHELY
                            FROM VIZSGAK
                            INNER JOIN TERMEK ON VIZSGAK.TEREMID = TERMEK.TEREMID
                            WHERE KURZUSID = :kurzusid";
                            $result = oci_parse($conn, $sql);
                            oci_bind_by_name($result, ':kurzusid', $kurzusid);
                            oci_execute($result);
                            while ($row = oci_fetch_array($result, OCI_ASSOC + OCI_RETURN_NULLS)) {
                                ?>
                                <strong>Időpont:</strong> <?php echo $row['VKEZDET']; ?>
                                <br>
                                <?php echo $row['VVEGE']; ?>
                                <strong>Helyszín:</strong>
                                <?php echo $row['TEREMID']; ?><br>
                                <strong>Férőhely:</strong> <?php echo $row['FEROHELY']; ?><br>
                                <button class="jelentkezes" name="submit"
                                    value="<?php echo $row["VIZSGAID"]; ?>">Jelentkezem</button>
                                <hr>
                                <?php
                            }
                        }
                        ?>
                    </form>
                </div>
            </div>

            <a href="panel.php">Vissza a Panelre</a>
        </div>
    </div>

</body>

</html>