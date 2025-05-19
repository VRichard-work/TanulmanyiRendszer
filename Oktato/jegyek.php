<?php
include '../functions.php';
Session();
Prof();
$conn = Connect();

if (isset($_POST['hallgatoid'])) {
    $hallgatoid = $_POST['hallgatoid'];
    $kurzusid = $_POST['kurzusnev'];
    $jegy = $_POST['jegy'];
    $felev = $_POST['felev'];


    //ellenőrzés
    if ($hallgatoid == 0) {
        echo "Nincs ilyen hallgató";
        $_POST['hallgatoid'] = null;
    }

    $sql = "UPDATE FELVETTKURZUSOK SET ERDEMJEGY = :jegy  
    WHERE HALLGATOID = :hallgatoid AND KURZUSID = :kurzusid AND FELEVDATUM2 = TO_DATE(:felev, 'YYYY-MM-DD')";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ':hallgatoid', $hallgatoid);
    oci_bind_by_name($stmt, ':kurzusid', $kurzusid);
    oci_bind_by_name($stmt, ':jegy', $jegy);
    oci_bind_by_name($stmt, ':felev', $felev);



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

            <label for="felev">Félév:</label>
            <input type="date" id="felev" name="felev" required>

            <label for="button">Kiválaszt</label>
            <button type="submit" name="kurzusnev" value="<?php echo $kurzusid; ?>">Kiválaszt</button>
        </form>
        <?php
        oci_free_statement($result);
    } ?>
</body>

</html>