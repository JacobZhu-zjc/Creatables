<?php
require("api/config.php");

$conn = new mysqli($db_address, $db_user, $db_pw, $db_name);
$stmt = $conn->prepare("SELECT * FROM Projects_PostsProject ORDER BY Timestamp DESC LIMIT $front_page_posts");
$stmt->execute();
$results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
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
        foreach ($results as $result) {
            echo("<tr>");
            echo('<td><a href="project_viewer.php?id='.$result["PID"].'">');
            echo($result["Name"]."</a></td>");
            echo("<td><br>".$result["Username"]);
            echo("</td></tr>");
        }
        ?>
        </tbody>
    </table>
</body>
</html>