<!DOCTYPE html>
<html lang="en">
<head>
    <title>LOGIN</title>
    <style>
        body {
            text-align: center;
        }
        input {
            margin-bottom: 10px;
        }
        #error {
            color: red;
        }
    </style>
</head>
<body>
<h1>LOGIN</h1>
<em id="error">
    <strong>
    <?php
    if (isset($_GET["err"]) && $_GET["err"]) {
        echo(htmlentities($_GET["err"]));
        echo("<br><br>");
    }
    ?>
    </strong>
</em>
<form action="api/validate_login.php" method="post">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username">
    <br>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password">
    <br>
    <input type="submit" value="Log in">
</form>
<span>Don't have an account yet?</span>
<br>
<a href="register.php">REGISTER</a>
</body>
</html>
