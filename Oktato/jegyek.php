<?php
include '../functions.php';
Session();
Prof();
$conn = Connect();

if (isset($_POST['hallgatoid'])) {
    $hallgatoid = $_POST['hallgatoid'];
    $kurzusid = $_POST['kurzusnev'];
    $jegy = $_POST['jegy'];

    //ellenőrzés
    if ($hallgatoid == 0) {
        echo "Nincs ilyen hallgató";
        $_POST['hallgatoid'] = null;
    }
    $sql = "SELECT * FROM FELVETTKURZUSOK 
    WHERE HALLGATOID = :hallgatoid AND KURZUSID = :kurzusid";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ':hallgatoid', $hallgatoid);
    oci_bind_by_name($stmt, ':kurzusid', $kurzusid);
    oci_execute($stmt);

    $felvetel = oci_fetch($stmt);
    $sql = "UPDATE FELVETTKURZUSOK SET ERDEMJEGY = :jegy  
    WHERE HALLGATOID = :hallgatoid AND KURZUSID = :kurzusid";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ':hallgatoid', $hallgatoid);
    oci_bind_by_name($stmt, ':kurzusid', $kurzusid);
    oci_bind_by_name($stmt, ':jegy', $jegy);



    //beszúrás

    if (oci_execute($stmt)) {
        echo "Sikeres jegy rögzítés!";
        header("Location: oktpanel.php");
    } else {
        echo "Hiba történt a jegy rögzítése során.";
    }

    oci_free_statement($stmt);
}



?>
<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jegy rögzítés</title>
    <style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f4f6f8;
    margin: 0;
    padding: 20px;
    color: #333;
}

form {
    background-color: #ffffff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    max-width: 500px;
    margin: 20px auto;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

label {
    font-weight: 600;
    margin-bottom: 5px;
    color: #444;
}

input[type="number"],
select {
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 16px;
    transition: border 0.3s ease;
}

input[type="number"]:focus,
select:focus {
    border-color: #007bff;
    outline: none;
}

button {
    padding: 12px;
    background-color: #007bff;
    border: none;
    border-radius: 8px;
    color: white;
    font-weight: bold;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.3s ease;
}

button:hover {
    background-color: #0056b3;
}

.success {
    color: green;
    font-weight: bold;
    text-align: center;
}

.error {
    color: red;
    font-weight: bold;
    text-align: center;
}


    </style>
</head>

<body>
    <form action="jegyek.php" method="POST">
        <label for="name">Kurzus azonosítója:</label>
        <select id="kurzusnev" name="kurzusnev">
            <?php
            //kurzusid választása a vizsgához
            $sql = "SELECT KURZUSOK.KNEV, KURZUSOK.KURZUSID FROM FELELOS
                     INNER JOIN KURZUSOK 
                     ON FELELOS.KURZUSID = KURZUSOK.KURZUSID 
                     WHERE FELELOS.OKTATOID = :username";
            $result = oci_parse($conn, $sql);
            oci_bind_by_name($result, ':username', $_SESSION['username']);
            oci_execute($result);
            $isnul = false;

            while ($row = oci_fetch_array($result)) {
                $isnul = true;
                ?>

                <option value="<?php echo $row['KURZUSID']; ?>"><?php echo $row['KNEV']; ?></option>
            <?php }
            if (!$isnul) { ?>
                <option value="0">Nem létezik Kurzus</option>
            <?php }
            oci_free_statement($result);
            ?>
        </select>
        <label for="button">Kiválaszt</label>
        <button type="submit">Kiválaszt</button>
    </form>
    <?php
    if (isset($_POST['kurzusnev'])) { ?>

        <form method="POST" action="jegyek.php">
            <label for="name">Hallgató azonosítója:</label>
            <select name="hallgatoid">
                <?php
                //hallgatóid választása a jegyhez
                $sql = "SELECT FELVETTKURZUSOK.HALLGATOID
                    FROM FELVETTKURZUSOK
                    INNER JOIN KURZUSOK ON FELVETTKURZUSOK.KURZUSID = KURZUSOK.KURZUSID
                    WHERE KURZUSOK.KURZUSID = :kurzusid";
                $kurzusid = $_POST['kurzusnev'];
                $result = oci_parse($conn, $sql);
                oci_bind_by_name($result, ':kurzusid', $kurzusid);
                oci_execute($result);
                $isnul = false;
                while ($row = oci_fetch_array($result)) {
                    $isnul = true; ?>
                    <option value="<?php echo $row['HALLGATOID']; ?>"><?php echo $row['HALLGATOID']; ?></option>
                <?php }
                if (!$isnul) { ?>
                    <option value="0">Nem létezik Hallgató</option>
                <?php }
                ?>
            </select>

            <label for="jegy">Jegy:</label>
            <input type="number" id="jegy" name="jegy" required>

            <label for="button">Kiválaszt</label>
            <button type="submit" name="kurzusnev" value="<?php echo $kurzusid; ?>">Kiválaszt</button>
        </form>
        <?php
        oci_free_statement($result);
    } ?>
</body>

</html>