<?php
require("config.php");

function redirect_to_error_page($message) {
    header("Location: ../error.php?err=".urlencode($message));
    die();
}

// Retrieving session data and data from form when DELETE is clicked
session_start();
if (!isset($_SESSION["username"])) {
    redirect_to_error_page("Authentication error");
}
$username = $_SESSION["username"];

if (!isset($_POST["wishlistID"]) || !filter_var($_POST["wishlistID"], FILTER_VALIDATE_INT) || $_POST["wishlistID"] < 1) {
    redirect_with_error("Internal error: wishlist ID invalid");
}
$wishlistID = $_POST["wishlistID"];

if (!isset($_POST["wishlistName"]) || strlen($_POST["wishlistName"]) == 0) {
    redirect_with_error("Internal error: wishlist ID invalid");
}
$newWishlistName = $_POST["wishlistName"];

// Update wishlist
$conn = new mysqli($db_address, $db_user, $db_pw, $db_name);
$stmt = $conn->prepare("DELETE ProjectWishlist_Creates SET Name=? WHERE Username=? AND WLID=?");
$stmt->bind_param("ssi", $newWishlistName, $username, $wishlistID);
$stmt->execute();
$conn->close();

header("Location: ../wishlist_viewer.php?id=".urlencode($wishlistID));
