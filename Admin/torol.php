<?php
include '../functions.php';
Session();
Admin();
$conn = Connect();

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
?>