<?php
include '../functions.php';
Session();
Stud();
$conn = Connect();
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Felvett kurzusok / órák</title>
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
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 400px;
        }
        h2 {
            text-align: center;
            color: #023c66;
        }
        .kurzus-lista {
            margin-top: 1rem;
        }
        .kurzus {
            background-color: #e6f0ff;
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 8px;
        }
        .kurzus strong {
            display: block;
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

<header>Felvett kurzusok / órák</header>

<div class="container">
    <div class="panel">
        <div class="kurzus-lista">
            <div class="kurzus">
                <strong>Kurzus neve:</strong> KURZUS:KNEV
                <strong>Óra:</strong> ORAK:OKEZDETE - OVEGE  
                <strong>Helyszín:</strong> TERMEK:TEREMID
            </div>
            <div class="kurzus">
                <strong>Kurzus neve:</strong> KURZUS:KNEV
                <strong>Óra:</strong> ORAK:OKEZDETE - OVEGE 
                <strong>Helyszín:</strong> TERMEK:TEREMID
            </div>
        </div>

        <a href="panel.php">Vissza a Panelre</a>
    </div>
</div>

</body>
</html>
