<!DOCTYPE html>
<html lang="en">
<head>
    <title>REGISTER</title>
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
<h1>REGISTER</h1>
<em id="error">
    <strong>
        <?php
        if (isset($_GET["err"]) && strlen($_GET["err"])) {
            echo("Error: ");
            echo(htmlentities($_GET["err"]));
            echo("<br><br>");
        }
        ?>
    </strong>
</em>
<form action="api/register_user.php">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username">
    <br>
    <label for="password">Password:</label>
    <input type="password" name="password" id="password">
    <br>
    <label for="password_confirm">Confirm password:</label>
    <input type="password" name="password_confirm" id="password_confirm">
    <br>
    <label for="city">City:</label>
    <select name="city" id="city">
        <option value="vancouver">Vancouver</option>
        <option value="toronto">Toronto</option>
        <option value="victoria">Victoria</option>
        <option value="qc">Quebec City</option>
    </select>
    <br>
    <input type="submit" value="Create account">
</form>
<span>Already have an account?</span>
<br>
<a href="login.php">LOG IN</a>
</body>
</html>