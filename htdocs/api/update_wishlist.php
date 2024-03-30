<?php
require("config.php");

// Helper functions
function redirect_to_error_page($message) {
    header("Location: ../error.php?err=".urlencode($message));
    die();
}
function redirect_with_error($message) {
    header("Location: ../wishlist_viewer.php?err=".urlencode($message)."&id=".$_POST["wishlistID"]);
    die();
}
function validate_username($conn, $newUsername) {
    $stmt = $conn->prepare("SELECT * FROM Users WHERE Username=?");
    $stmt->bind_param("s", $newUsername);
    $stmt->execute();
    if ($stmt->get_result()->num_rows == 0) {
        $conn->close();
        redirect_with_error("Specified user does not exist!");
    }
}

// Retrieving session data and data from form when DELETE is clicked
session_start();
if (!isset($_SESSION["username"])) {
    redirect_to_error_page("Authentication error");
}
if (!isset($_POST["wishlistID"]) || !filter_var($_POST["wishlistID"], FILTER_VALIDATE_INT) || $_POST["wishlistID"] < 1) {
    redirect_to_error_page("Internal error: wishlist ID invalid");
}
$username = $_SESSION["username"];
$wishlistID = $_POST["wishlistID"];

// Setting up variables to determine if one or both of the fields are to be updated
$conn = new mysqli($db_address, $db_user, $db_pw, $db_name);
if ($conn->connect_error) {
    die("Unable to connect to database");
}
$hasNewWishlistName = false;
$hasNewUsername = false;

if (isset($_POST["newWishlistName"]) && strlen($_POST["newWishlistName"]) > 0) {
    $hasNewWishlistName = true;
}
if (isset($_POST["newUsername"]) && strlen($_POST["newUsername"]) > 0) {
    validate_username($conn, $_POST["newUsername"]);
    $hasNewUsername = true;
}
if (!$hasNewWishlistName && !$hasNewUsername) {
    redirect_with_error("Specify a wishlist name or username before attempting to update!");
}

// Updating the wishlist tuple in the MySQL database
if (!$hasNewWishlistName) {
    $stmt = $conn->prepare("UPDATE ProjectWishlist_Creates SET Username=? WHERE Username=? AND WLID=?");
    $stmt->bind_param("ssi", $_POST["newUsername"], $username, $wishlistID);
    $stmt->execute();
} else if (!$hasNewUsername) {
    $stmt = $conn->prepare("UPDATE ProjectWishlist_Creates SET Name=? WHERE Username=? AND WLID=?");
    $stmt->bind_param("ssi", $_POST["newWishlistName"], $username, $wishlistID);
    $stmt->execute();
} else {
    $stmt = $conn->prepare("UPDATE ProjectWishlist_Creates SET Name=?, Username=? WHERE Username=? AND WLID=?");
    $stmt->bind_param("sssi", $_POST["newWishlistName"], $_POST["newUsername"], $username, $wishlistID);
    $stmt->execute();
}
$conn->close();

header("Location: ../wishlist_viewer.php?id=".urlencode($wishlistID));
