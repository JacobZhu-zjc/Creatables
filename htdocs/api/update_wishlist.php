<?php
require("config.php");

// Helper functions to redirect users if an error occurs
function redirect_to_error_page($message) {
    header("Location: ../error.php?err=".urlencode($message));
    die();
}

function redirect_with_error($message) {
    header("Location: ../wishlist_viewer.php?err=".urlencode($message));
    die();
}

// Retrieving session data and data from form when POST is clicked
session_start();

if (!isset($_SESSION["username"])) {
    redirect_to_error_page("You must be logged in to view wishlists");
}
$username = $_SESSION["username"];

if (!isset($_POST["title"]) || strlen($_POST["title"]) == 0) {
    redirect_with_error("You must enter a title for your wishlist");
}
$title = htmlspecialchars($_POST["title"]);

// Inserting wishlist into database
$conn = new mysqli($db_address, $db_user, $db_pw, $db_name);
if ($conn->connect_error) {
    die("Unable to connect to database"); // Don't tell the user too much...
}

$stmt = $conn->prepare("INSERT INTO ProjectWishlist_Creates (Name, Username) VALUES (?,?)");
$stmt->bind_param("ss", $title, $username);
$stmt->execute();
$wlid = $conn->insert_id;
$conn->close();

// Redirecting to wishlist viewer page
header("Location: ../wishlist_viewer.php?id=".$wlid);
?>
