<?php
require("config.php"); //is it legql to copy pasta documentation w3schools?
session_start();
header("Content-Type: application/json; charset=UTF-8");
$conn = new mysqli($db_address, $db_user, $db_pw, $db_name);
if ($conn->error) {
    die("Error connecting to database");
}

$stmt = $conn->prepare("SELECT p.Username, p.JoinDate FROM Users p GROUP BY p.Username, p.JoinDate HAVING p.JoinDate = (SELECT MAX(JoinDate) FROM Users)");

$stmt->execute();
$result = $stmt->get_result();
$outp = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($outp);
$conn->close();
// https://www.w3schools.com/js/js_json_php.asp
?>
