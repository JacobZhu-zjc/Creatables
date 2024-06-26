<?php
require("config.php");
session_start();
header("Content-Type: application/json; charset=UTF-8");
$conn = new mysqli($db_address, $db_user, $db_pw, $db_name);
if ($conn->error) {
    die("Error connecting to database");
}
$stmt = $conn->prepare("SELECT Name FROM Projects_PostsProject p1 WHERE NOT EXISTS ((SELECT Username FROM Users) EXCEPT (SELECT f.Username FROM Feedback_LeavesFeedback f WHERE f.PID = p1.PID))");
$stmt->execute();
$result = $stmt->get_result();
echo(json_encode($result->fetch_all(MYSQLI_ASSOC)));
$conn->close();

