<?php
include '../functions.php';
Session();
Admin();
$conn = Connect();

$sql = "SELECT KURZUSOK.Knev, COUNT(FELVETTKURZUSOK.HallgatoID) AS HallgatoSzam
FROM KURZUSOK
LEFT JOIN FELVETTKURZUSOK ON KURZUSOK.KurzusID = FELVETTKURZUSOK.KurzusID
GROUP BY KURZUSOK.Knev
ORDER BY HallgatoSzam DESC";
$result =oci_parse($conn, $sql);
oci_execute($result);
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
            align-items: flex-start;
            min-height: 100vh;
        }

        .container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 1200px;
            margin: 40px auto;
        }

        h1 {
            text-align: center;
            color: #3b3b3b;
            font-size: 2.4em;
            margin-bottom: 30px;
        }

        a {
            display: inline-block;
            margin: 10px 10px 20px 0;
            text-align: center;
            color: #005796;
            text-decoration: none;
            background-color: #75aafa;
            padding: 10px 16px;
            border-radius: 5px;
            font-weight: bold;
            font-size: 1.1em;
            transition: all 0.3s ease;
        }

        a:hover {
            background-color: #02132c;
            color: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
            background-color: #fdfdfd;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: center;
            font-size: 15px;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        .changes{
            background-color:rgb(0, 53, 110);
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #e0f0ff;
        }

        button {
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
            padding: 0.8rem 1.2rem;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        form button[type="submit"] {
        padding: 10px 20px;
        background-color: #e74c3c;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-left: 10px;
        font-size: 1.1em;
        transition: background-color 0.3s;
        }

        form button[type="submit"]:hover {
        background-color: #c0392b;
        }
    </style>

</head>
<body>
    <div class="container">
        <h1>Szak adatok</h1>
        <table>
            <tr>
                <th>Szak neve</th>
                <th>Hallgatók száma</th>
            </tr>
            <?php
                while (($row = oci_fetch_assoc($result)) !== false) {
                    echo "<tr>";
                    echo "<td>{$row['KNEV']}</td>";
                    echo "<td>{$row['HALLGATOSZAM']}</td>";
                    echo "</tr>";
                }
            ?>
        </table>
        <?php
        oci_free_statement($result);
        oci_close($conn);
        ?>

    </div>
</body>
</html>
