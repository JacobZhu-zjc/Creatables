<?php
require("config.php");

function redirect_to_error_page($message)
{
    header("Location: ../error.php?err=" . urlencode($message));
    die();
}

session_start();
if (!isset($_SESSION["username"]) || !isset($_GET["msid"])) {
    redirect_to_error_page("Authentication error");
}

// Delete message
$conn = new mysqli($db_address, $db_user, $db_pw, $db_name);
$stmt = $conn->prepare("DELETE FROM Message_Sends WHERE ReceiverUsername=? AND MSID=?");
$stmt->bind_param("si", $_SESSION["username"], $_GET["msid"]);
$stmt->execute();
$conn->close();

header("Location: ../inbox.php");
