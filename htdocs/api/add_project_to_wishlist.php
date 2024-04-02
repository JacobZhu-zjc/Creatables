<?php
require("config.php");

// Helper functions to redirect users if an error occurs
function redirect_to_error_page($message)
{
    header("Location: ../error.php?err=" . urlencode($message));
    die();
}

function redirect_with_error($message)
{
    header("Location: ../wishlist_viewer.php?err=" . urlencode($message) . '&id=' . $_POST["wishlistID"]);
    die();
}

// Retrieving session data and data from form when POST is clicked
session_start();

if (!isset($_SESSION["username"])) {
    redirect_to_error_page("You must be logged in to edit wishlists");
}
$username = $_SESSION["username"];

if (!isset($_POST["projectID"]) || !filter_var($_POST["projectID"], FILTER_VALIDATE_INT) || $_POST["projectID"] < 1) {
    redirect_with_error("You must enter an appropriate project ID to add to your wishlist");
}
$projectID = $_POST["projectID"];

if (!isset($_POST["wishlistID"]) || !filter_var($_POST["wishlistID"], FILTER_VALIDATE_INT) || $_POST["wishlistID"] < 1) {
    redirect_with_error("Internal error: wishlist ID invalid");
}
$wishlistID = $_POST["wishlistID"];

// Checking if the specified project ID exists
$conn = new mysqli($db_address, $db_user, $db_pw, $db_name);
if ($conn->connect_error) {
    die("Unable to connect to database"); // Don't tell the user too much...
}

$stmt = $conn->prepare("SELECT * FROM Projects_PostsProject WHERE PID=?");
$stmt->bind_param("i", $projectID);
$stmt->execute();
if ($stmt->get_result()->num_rows == 0) {
    $conn->close();
    redirect_with_error("Specified project does not exist");
    die();
}

// If project does exist, inserts tuple into database
$stmt = $conn->prepare("INSERT IGNORE INTO Contains (WLID, PID) VALUES (?,?)");
$stmt->bind_param("ii", $wishlistID, $projectID);
$stmt->execute();
$conn->close();

// Redirecting to wishlist viewer page
header("Location: ../wishlist_viewer.php?id=" . urlencode($wishlistID));
?>
