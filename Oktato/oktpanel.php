<?php
include 'functions.php';
Session();
Prof();
$conn = Connect();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diák Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
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
            width: 300px;
        }
        .panel h2 {
            margin-bottom: 1rem;
            text-align: center;
        }
        .panel a {
            display: block;
            text-decoration: none;
            color: #005796;
            background-color: #75aafa;
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 5px;
            text-align: center;
            transition: 0.3s ease;
        }
        .panel a:hover {
            background-color: #02132c;
        }
    </style>

</head>
<body>
    <header>
        Oktató Panel
    </header>
    <div class="container">
        <div class="panel">
            <a href="kurzupd.html">kurzusok, órák felvitele</a>
            <a href="spect.html">vizsgák hirdetése</a>
            <a href="vizsga.html">jegyek beírása</a>
        </div>
    </div>
</body>
</html>