<?php
include '../functions.php';
Session();
Admin();
$conn = Connect();

//admin torles
if(isset($_GET['deleteadmin'])){
    $deleteadmin = $_GET['deleteadmin'];
    $sql = "DELETE FROM ADMIN WHERE ADMINID=$deleteadmin";
    $result = oci_parse($conn, $sql);
    oci_execute($result);
    if($result){
        header("Location: ../index.php");
    }
    else{
        echo 'Nem sikerült a törlés';
    }
}

//hallgato torles
if(isset($_GET['deletestud'])){
    $deletestud = $_GET['deletestud'];
    $sql = "DELETE FROM HALLGATOK WHERE HALLGATOID=$deletestud";
    $result = oci_parse($conn, $sql);
    oci_execute($result);
    if($result){
        header("Location: apanel.php");
    }
    else{
        echo 'Nem sikerült a törlés';
    }
}

//oktató törlés
if(isset($_GET['deleteokt'])){
    $deleteokt = $_GET['deleteokt'];
    $sql = "DELETE FROM OKTATOK WHERE OKTATOID=$deleteokt";
    $result = oci_parse($conn, $sql);
    oci_execute($result);
    if($result){
        header("Location: apanel.php");
    }
    else{
        echo 'Nem sikerült a törlés';
    }
}

//kurzus törlés
if(isset($_GET['deletekurz'])){
    $deletekurz = $_GET['deletekurz'];
    $sql = "DELETE FROM KURZUSOK WHERE KURZUSID=$deletekurz";
    $result = oci_parse($conn, $sql);
    oci_execute($result);
    if($result){
        header("Location: apanel.php");
    }
    else{
        echo 'Nem sikerült a törlés';
    }
}

//terem törlése
if(isset($_GET['deleteterem'])){
    $deleteterem = $_GET['deleteterem'];
    $sql = "DELETE FROM TERMEK WHERE TEREMID=$deleteterem";
    $result = oci_parse($conn, $sql);
    oci_execute($result);
    if($result){
        header("Location: apanel.php");
    }
    else{
        echo 'Nem sikerült a törlés';
    }
}

//ora törlése
if(isset($_GET['deleteora'])){
    $deleteora = $_GET['deleteora'];
    $sql = "DELETE FROM ORAK WHERE ORAID=$deleteora";
    $result = oci_parse($conn, $sql);
    oci_execute($result);
    if($result){
        header("Location: apanel.php");
    }
    else{
        echo 'Nem sikerült a törlés';
    }
}

//szak törlése
if(isset($_GET['deleteszak'])){
    $deleteszak = $_GET['deleteszak'];
    $sql = "DELETE FROM SZAKOK WHERE SZAKID=$deleteszak";
    $result = oci_parse($conn, $sql);
    oci_execute($result);
    if($result){
        header("Location: apanel.php");
    }
    else{
        echo 'Nem sikerült a törlés';
    }
}
?>