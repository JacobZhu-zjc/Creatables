<?php
require("config.php");

function redirect_to_error_page($message)
{
    header("Location: ../error.php?err=" . urlencode($message));
    die();
}

session_start();
if (!isset($_SESSION["username"]) || !isset($_POST["id"])) {
    redirect_to_error_page("Authentication error");
}

// Delete project
$conn = new mysqli($db_address, $db_user, $db_pw, $db_name);
$stmt = $conn->prepare("DELETE FROM Projects_PostsProject WHERE Username=? AND PID=?");
$stmt->bind_param("si", $_SESSION["username"], $_POST["id"]);
$stmt->execute();
$conn->close();

?>
<script>
    location.href = "../index.php";
</script>
