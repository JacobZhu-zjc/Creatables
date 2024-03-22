<?php
require("config.php");

function redirect_with_error($message) {
    header("Location: ../login.php?err=".urlencode($message));
    die();
}

// Check POST params
if (!$_POST["username"]) {
    redirect_with_error("Please enter a username");
}
if (!$_POST["password"]) {
    redirect_with_error("Please enter a password");
}
$username = $_POST["username"];
$password = hash($password_hash, $_POST["password"]);

// Connect to database
$conn = new mysqli($db_address, $db_user, $db_pw, $db_name);
if ($conn->connect_error) {
    redirect_with_error("Server error"); // Don't tell the user too much...
}

// Prepare statement
$stmt = $conn->prepare("SELECT Username FROM Users WHERE Username=? AND PasswordHash=?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();

// Get results
$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
// Close connection
$conn->close();

if (count($result) == 0) {
    // Empty results, password doesn't match
    redirect_with_error("Incorrect password for user ".$username);
}
// Success! Create session, redirect to profile
session_start();
$_SESSION["username"] = $username;
header("Location: ../profile.php?u=".urlencode($username));
