<!DOCTYPE html>
<html lang="en">
<head>
    <title>CREATE WISHLIST</title>
    <style>
        body {
            text-align: center;
        }

        table {
            border: 1px solid black;
            border-collapse: collapse;
            margin-top: 20px;
        }

        button {
            margin-top: 20px;
        }

        .center {
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>
<em>
    <strong>
        <?php
        if (isset($_GET["err"]) && strlen($_GET["err"])) {
            echo(htmlspecialchars($_GET["err"]));
            echo("<br><br>");
        }
        ?>
    </strong>
</em>
<h1>CREATE WISHLIST</h1>
<form action="api/create_wishlist.php" method="post">
    <label for="title">Wishlist Title:</label>
    <input type="text" name="title"><br><br>
    <input type="submit" value="POST">
</form>
</body>
</html>