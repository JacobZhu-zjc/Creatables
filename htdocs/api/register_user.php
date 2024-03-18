<?php
require("config.php");

function redirect_with_error($message) {
    header("Location: ../register.php?err=".urlencode($message));
    die();
}

// Check POST params
if (!$_POST["username"]) {
    redirect_with_error("Please enter a username");
}
if (!$_POST["password"]) {
    redirect_with_error("Please enter a password");
}
if (!$_POST["password_confirm"]) {
    redirect_with_error("Please confirm your password");
}
if (!$_POST["city"]) {
    redirect_with_error("Please choose a city");
}
$username = $_POST["username"];
$password = $_POST["password"];
$password_confirm = $_POST["password_confirm"];
$city = $_POST["city"];

// More validation
if ($password != $password_confirm) {
    redirect_with_error("Passwords must match");
}
$city_name;
switch ($city) {
    case "vancouver":
        $city_name = "Vancouver";
        break;
    case "victoria":
        $city_name = "Victoria";
        break;
    case "toronto":
        $city_name = "Toronto";
        break;
    case "qc":
        $city_name = "Quebec City";
        break;
    default:
        redirect_with_error("Invalid city ".$city);
}
if (strlen($username) < $min_username_length) {
    redirect_with_error("Username must be at least ".$min_username_length." characters long.");
}
if (strlen($username) > 40) {
    redirect_with_error("Username must not be longer than 40 characters long.");
}
if (strlen($password) < $min_password_length) {
    redirect_with_error("Password must be at least ".$min_password_length." characters long.");
}

// Check if username is available
// Connect to database
$conn = new mysqli($db_address, $db_user, $db_pw, $db_name);
if ($conn->connect_error) {
    redirect_with_error("Server error"); // Don't tell the user too much...
}
// Prepare statement
$stmt = $conn->prepare("SELECT Username FROM Users WHERE Username=?");
$stmt->bind_param("s", $username);
$stmt->execute();

// Get results
$result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
if (count($result) != 0) {
    // Username is taken
    $conn->close();
    redirect_with_error("Username is already in use: ".$username);
}

// Success! Create account
// The City_Timezone association should already have been set up in the database script
$stmt = $conn->prepare("INSERT INTO Users (Username, PasswordHash, City) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, hash($password_hash, $password), $city_name);
$stmt->execute();
$conn->close();

// Redirect to login page
$message = "Registration successful, log in to continue";
header("Location: ../login.php?err=".urlencode($message));