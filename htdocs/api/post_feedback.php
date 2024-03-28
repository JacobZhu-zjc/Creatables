<?php
require("config.php");

// For debugging:
//var_dump($_POST);
//die();

// Using if statements to decide input?
// Using dropdown for ratings, or just string?
function redirect_with_error($message) {
    header("Location: ../project_viewer.php?err=".urlencode($message));
    die();
}



session_start();
//rating, title, png, comment

if (!isset($_POST["commentType"]) || strlen($_POST["commentType"]) == 0) {
    redirect_with_error("Error");
}
if (!isset($_POST["title"]) || strlen($_POST["title"]) == 0) {
    redirect_with_error("You must enter valid title");
}
if (!isset($_POST["comment"]) || (($_POST["commentType"] == "stars") && strlen($_POST["rating"]) == 0)) { //Check if for comment type being right nah
    redirect_with_error("You must enter valid Comment");
}
if (!isset($_POST["imageData"]) || (($_POST["commentType"] == "png") && strlen($_POST["imageData"]) == 0)) {
    redirect_with_error("You must enter valid png");
}
if (!isset($_POST["rating"]) || strlen($_POST["rating"]) == 0) {
    redirect_with_error("You must enter valid rating");
}

$conn = new mysqli($db_address, $db_user, $db_pw, $db_name);
if ($conn->connect_error) {
    redirect_with_error("Server error"); // Don't tell the user too much...
}

$username = $_SESSION["username"];
$title = $_POST["title"];
$PID = $_POST["pidGrabber"];


if ($_POST["commentType"] == "text") {
    $comment = $_POST["title"];
    $stmt = $conn->prepare("INSERT INTO Feedback_LeavesFeedback (Title, Comment, Username, PID) VALUES (?,?,?,?)");
    $stmt->bind_param("sssi", $title, $comment, $username, $PID);
    $stmt->execute();
}
if ($_POST["commentType"] == "image") {
    $imageData = $_POST["imageData"];
    $stmt = $conn->prepare("INSERT INTO Feedback_LeavesFeedback (Title, ImageData, Username, PID) VALUES (?,?,?,?)");
    $decoded = b64_url_to_binary($imageData);
    $stmt->bind_param("sssi", $title, $decoded, $username, $PID);
    $stmt->execute();
}
if ($_POST["commentType"] == "stars") {
    $stars = $_POST["stars"];
    $stmt = $conn->prepare("INSERT INTO Feedback_LeavesFeedback (Title, Stars, Username, PID) VALUES (?,?,?,?)");
    $stmt->bind_param("sssi", $title, $stars, $username, $PID);
    $stmt->execute();
}

$conn->close();
?>

<script>
window.history.back();
</script>