<!DOCTYPE html>
<html lang="en">
<head>
    <title>COMPOSE MESSAGE</title>
    <style>
        body {
            text-align: center;
        }
        label {
            text-align: left;
        }
        input {
            margin-bottom: 10px;
            min-width: 300px;
        }
        textarea {
            margin-bottom: 10px;
            min-width: 300px;
            min-height: 300px;
        }
    </style>
</head>
<body>
<h1>COMPOSE MESSAGE</h1>
<form action="api/post_message.php" method="post">
    <label for="recipient">Recipent:</label>
    <br>
    <input type="text" name="recipient" id="recipient" placeholder="Username" maxlength="40">
    <br>
    <label for="message">Message:</label>
    <br>
    <textarea name="message" id="message" placeholder="Say something nice..."></textarea>
    <br>
    <input type="submit" value="SEND">
</form>
</body>
</html>
