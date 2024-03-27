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

if (!isset($_POST["Comment"]) || strlen($_POST["Comment"]) == 0) {
    redirect_with_error("You must enter valid Comment");
}

if (!isset($_POST["instructions"]) || strlen($_POST["instructions"]) == 0) {
    redirect_with_error("You must enter valid instructions");
}

if (!isset($_POST["instructions"]) || strlen($_POST["instructions"]) == 0) {
    redirect_with_error("You must enter valid instructions");
}

$comment = $_SESSION["Comment"];

$title = $_SESSION["Title"];

$pid = $_GET["id"]; //How to specify from which table?

$username = $_SESSION["username"];

$conn = new mysqli($db_address, $db_user, $db_pw, $db_name);
if ($conn->connect_error) {
    redirect_with_error("Server error"); // Don't tell the user too much...
}
$conn->close();

$stmt = $conn->prepare("INSERT INTO Feedback_LeavesFeedback (Title, Comment, Username, PID) VALUES (?,?,?,?)");
$stmt->bind_param("sssi", $title, $comment, $username, $pid);
$stmt->execute();

?>