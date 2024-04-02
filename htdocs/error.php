<!DOCTYPE html>
<html lang="en">
<head>
    <title>Error 401</title>
    <style>
        body {
            text-align: center;
        }

        input, select {
            margin-bottom: 10px;
        }

        #error {
            color: red;
        }
    </style>
</head>
<body>
<h1>Error 401</h1>
<em id="error">
    <strong>
        <?php
        if (isset($_GET["err"]) && strlen($_GET["err"])) {
            echo(htmlspecialchars($_GET["err"]));
            echo("<br><br>");
        }
        header("HTTP/1.1 401 Unauthorized");
        ?>
    </strong>
</em>
<span>Already have an account?</span>
<br>
<br>
<a href="login.php">LOG IN</a>
<br>
<br>
<span>Do you need to register an account?</span>
<br>
<br>
<a href="register.php">REGISTER</a>
</body>
</html>