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
$conn->close();
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
    <a href="login.php">LOG IN</a>
    <h3>Recent projects:</h3>
    <table class="center">
        <tbody>
        <?php
        foreach ($projects as $project) {
            echo("<tr>");
            echo('<td><a href="project_viewer.php?id='.$project["PID"].'">');
            echo($project["Name"]."</a></td>");
            echo("<td><br>".$project["Username"]);
            echo("</td></tr>");
        }
        ?>
        </tbody>
    </table>
<h3>Total projects: <?= $count ?></h3>
</body>
</html>