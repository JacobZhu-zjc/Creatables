<?php
require("api/config.php");

// Check login, params
session_start();
if (!isset($_SESSION["username"]) || !isset($_GET["msid"])) {
    die(); // Fail silently
}

// Fetch message
$conn = new mysqli($db_address, $db_user, $db_pw, $db_name);
$stmt = $conn->prepare("SELECT Timestamp, Text, SenderUsername FROM Message_Sends WHERE ReceiverUsername=? AND MSID=?");
$stmt->bind_param("si", $_SESSION["username"], $_GET["msid"]);
$stmt->execute();
$results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$conn->close();

if (count($results) == 0) {
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>MESSAGE VIEWER</title>
    <style>
        body {
            margin: 4%;
        }
    </style>
</head>
<body>
<em><?= $results[0]["Timestamp"] ?></em>
<br>
<strong>From: <?= $results[0]["SenderUsername"] ?></strong>
<br>
<hr>
<?= $results[0]["Text"] ?>
</body>
</html>
