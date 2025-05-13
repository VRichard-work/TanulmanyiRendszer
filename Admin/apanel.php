<?php
/*include '../functions.php';
Session();
Admin();
$conn = Connect();
*/
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        h1 {
            text-align: center;
            color: #3b3b3b;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 10px;
            font-weight: bold;
        }
        input, select, button {
            margin-top: 5px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        #department{
            margin-bottom: 50px;
        }

        button {
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
            padding: 0.8rem;
            margin-top: 20px;
        }
        button:hover {
            background-color: #0056b3;
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

<div class="container">
    <h1>Admin Panel</h1>
    <div class="panel">
        <a href="studreg.php">👨‍🎓 Diákok felvitele</a>
        <a href="oktregis.php">👩‍🏫 Tanárok felvitele</a>
        <a href="kurzregist.php">📚 Kurzusok felvitele</a>
        <a href="teremregist.php">💼 Terem felvitele</a>
        <a href="oraregist.php">📖 Óra felvitele</a>
        </form>
        <form action="../logout.php" method="POST">
            <button type="submit">Kijelentkezés</button>
        </form>
    </div>
</div>

</body>
</html>
