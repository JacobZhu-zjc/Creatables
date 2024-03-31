<?php
require("api/config.php");

$conn = new mysqli($db_address, $db_user, $db_pw, $db_name);
if ($conn->error) {
    die("Error connecting to database");
}
$query = "SELECT * FROM Projects_PostsProject ORDER BY Timestamp DESC LIMIT $front_page_posts";
$projects = $conn->query($query)->fetch_all(MYSQLI_ASSOC);

$query = "SELECT COUNT(*) FROM Projects_PostsProject";
$count = $conn->query($query)->fetch_all()[0][0];


$query = "SELECT max(avgStars) FROM (SELECT PID, avg(Stars) as avgStars FROM Feedback_LeavesFeedback GROUP BY PID) as Avgs";
$max_avg = $conn->query($query)->fetch_all()[0][0];

if (!is_null($max_avg)) {
    $stmt = $conn->prepare("SELECT * FROM Projects_PostsProject WHERE PID IN (SELECT PID FROM Feedback_LeavesFeedback GROUP BY PID HAVING avg(Stars)=?)");
    $stmt->bind_param("d", $max_avg);
    $stmt->execute();
    $best_projects = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

$conn->close();

session_start();
$logged_in = isset($_SESSION["username"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>CREATABLES</title>
    <style>
        body {
            text-align: center;
        }
        table {
            border: 1px solid black;
            border-collapse: collapse;
            margin-top: 20px;
        }
        td {
            border-top: 1px solid black;
            border-bottom: 1px solid black;
            border-collapse: collapse;
        }
        .center {
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>
    <h1>CREATABLES</h1>
    <?php
    if (!$logged_in) {
        echo("<h3>Not logged in.</h3>");
        echo('<a href="login.php">LOG IN</a>');
    } else {
        echo('<h3>Logged in as <a href="profile.php?u='.urlencode($_SESSION["username"]).'">'.$_SESSION["username"]
            .'</a></h3>');
        echo('<a href="api/logout.php">LOG OUT</a>');
    }
    ?>
    <h3>Recent projects:</h3>
    <table class="center">
        <tbody>
        <?php
        foreach ($projects as $project) {
            echo("<tr>");
            echo('<td><a href="project_viewer.php?id='.$project["PID"].'">');
            echo($project["Name"]."</a></td>");
            echo('<td><br><a href="profile.php?u='.urlencode($project["Username"]).'">'.$project["Username"]);
            echo("</a></td></tr>");
        }
        ?>
        </tbody>
    </table>
    <br>
    <a href="search.php">SEARCH</a>
    <br>
    <br>
    <a href="projection.php">COLUMN PROJECTION</a>
    <br>
    <br>
    <a href="extra_info.php">INTERESTING STATS</a>
    <?php
        if (!is_null($max_avg)) {
            echo("<h3>Best project(s):</h3>");
            foreach ($best_projects as $best_project) {
                echo('<a href="project_viewer.php?id='.$best_project["PID"].'">'.$best_project["Name"].'</a>');
                echo('&emsp; Rating: '.number_format((float)$max_avg, 2, '.', '').'<br><br>');
            }
        }
    ?>
<h3>Total projects: <?= $count ?></h3>
</body>
</html>



