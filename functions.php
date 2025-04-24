<?php 
function Session() {
    session_start();

    if(!isset($_SESSION['userType'])) {
      header("Location: ../login.php");
    }
}
// Csatlakozás az adatbázishoz
function Connect() {

    $conn = oci_connect("C##CHCGUK", "C##CHCGUK", "localhost:1521/orania2.inf.u-szeged.hu");
    if (!$conn) {
        $e = oci_error();
        echo "Connection failed: " . $e['message'];
        exit;
    }
    return $conn;
}
//Kapcsolat bontása
function Disconnect($conn) {
    oci_close($conn);
}
function Admin() {
    if($_SESSION['userType'] != 'admin') {
        header("Location: ../index.php");
        exit;
    }
}
function Prof() {
    if($_SESSION['userType'] != 'prof') {
        header("Location: ../index.php");
        exit;
    }
}
function Stud() {
    if($_SESSION['userType'] != 'stud') {
        header("Location: ../index.php");
        exit;
    }
}