<?php
require("api/config.php");

// Check login
session_start();
if (!isset($_SESSION["username"])) {
    $message = "You must be logged in to view messages projects";
    header("Location: error.php?err=".$message);
    die();
}

// Fetch all messages where the current user is a recipient
$conn = new mysqli($db_address, $db_user, $db_pw, $db_name);
$stmt = $conn->prepare("SELECT Text, MSID, SenderUsername FROM Message_Sends WHERE ReceiverUsername=?");
$stmt->bind_param("s", $_SESSION["username"]);
$stmt->execute();
$results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>INBOX</title>
    <style>
        body {
            margin: 5%;
        }
        label {
            text-align: left;
        }
        input {
            margin-top: 5px;
            margin-bottom: 5px;
        }
        table {
            width: 100%;
            border: 1px solid black;
            margin-bottom: 10px;
        }
        iframe {
            width: 100%;
            height: 300px;
            border: 1px solid black;
            margin-bottom: 10px;
            overflow: auto;
        }
        .subject {
            width: 80%;
        }
    </style>
    <script>
        function deleteMessage(msid) {
            location.href = "api/delete_message.php?msid=" + msid;
        }

        function showMessage(msid) {
            document.getElementById("viewerFrame").src = "message_viewer.php?msid=" + msid;
        }
    </script>
</head>
<body>
<h1>INBOX</h1>
<h3><a href="profile.php?u=<?= urlencode($_SESSION["username"]) ?>">Return to profile</a></h3>
<input type="submit" value="Compose a message" onclick="location.href = 'compose_message.php'">
<br>
<table>
    <tbody>
    <?php
    foreach ($results as $message) {
        echo('<tr><td class="subject">');
        echo('<a href="#" onclick="showMessage('.$message["MSID"].')">');
        echo(mb_strimwidth($message["Text"], 0, 25, '...'));
        echo("</a></td><td>");
        echo('<input type="submit" value="Delete" onclick="deleteMessage('.$message["MSID"].')">');
        echo("</td><td>From: ".$message["SenderUsername"]."</td></tr>");
    }
    ?>
    </tbody>
</table>

<iframe src="about:blank" id="viewerFrame">
</iframe>
</body>
</html>
