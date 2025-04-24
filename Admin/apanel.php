<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
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
            width: 350px;
        }

        a {
            display: block;
            text-decoration: none;
            color: #005796;
            background-color: #75aafa;
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 5px;
            text-align: center;
            transition: 0.3s ease;
            font-weight: bold;
        }

        a:hover {
            background-color: #02132c;
            color: white;
        }

        .back-link {
            margin-top: 2rem;
            background-color: #ddd;
        }
    </style>
</head>
<body>

<header>Admin Panel</header>

<div class="container">
    <div class="panel">
        <a href="studreg.html">👨‍🎓 Diákok felvitele</a>
        <a href="oktregis.html">👩‍🏫 Tanárok felvitele</a>
        <a href="kurzregist.html">📚 Kurzusok felvitele</a>
    </div>
</div>

</body>
</html>
