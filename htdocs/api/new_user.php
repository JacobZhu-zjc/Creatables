<?php
require("config.php");
session_start();
header("Content-Type: application/json; charset=UTF-8");
$conn = new mysqli($db_address, $db_user, $db_pw, $db_name);
if ($conn->error) {
    die("Error connecting to database");
}

$stmt = $conn->prepare("SELECT p.Username, p.JoinDate FROM Users p GROUP BY p.Username, p.JoinDate HAVING p.JoinDate = (SELECT MAX(JoinDate) FROM Users)");

$stmt->execute();
$result = $stmt->get_result();
echo(json_encode($result->fetch_all(MYSQLI_ASSOC)));
$conn->close();
