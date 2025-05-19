<?php
include '../../functions.php';
Session();
Admin();
$conn = Connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['kurzusid']) && isset($_POST['szakid'])) {
        $kurzusid = $_POST['kurzusid'];
        $szakid = $_POST['szakid'];

        $sql = "DELETE FROM TARTJA WHERE OKTATOID = :szakid AND ORAID = :kurzusid";
        $stmt = oci_parse($conn, $sql);

        oci_bind_by_name($stmt, ':kurzusid', $kurzusid);
        oci_bind_by_name($stmt, ':szakid', $szakid);

        if (!oci_execute($stmt)) {
            $e = oci_error($stmt);
            echo "Hiba a törlés során: " . $e['message'];
        } else {
            oci_commit($conn);
            header("Location: osszkotlista.php");
            exit();
        }
        oci_free_statement($stmt);
    }
    oci_close($conn);
} else {
    echo "Érvénytelen kérés.";
}
?>
