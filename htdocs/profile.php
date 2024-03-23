<?php

require("api/config.php");
$utc_offset = -8;
$prefix = $utc_offset >= 0 ? "+" : "";
$time = date_create("now", new DateTimeZone($prefix.$utc_offset));



$conn = new mysqli($db_address, $db_user, $db_pw, $db_name);
$stmt = $conn->prepare("SELECT * FROM Projects_PostsProject ORDER BY Timestamp DESC LIMIT $front_page_posts");
$stmt->execute();
$results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>JSKONS</title>
    <style>
        h2 {
            display: inline;
        }
        .offsetRight {
            float: right;
            margin-left: 5px;
        }
        div {
            border: 1px solid black;
        }
        body {
            margin-left: 5%;
            margin-right: 5%;
        }
    </style>
</head>
<body>
<h1>JSKONS</h1>
<h2>Jacob Skons</h2>
<button class="offsetRight">Log out</button><button class="offsetRight">Inbox</button>
<h3>Vancouver, Canada (Local Time: <?php echo($time->format("h:i")); ?>)</h3>
<br>
<h2>Guides</h2><button class="offsetRight" onclick="location.href='https://google.ca'">Create New</button>
<div>
    <ul>
        <li><a href="#">Cool guide</a></li>
        <li><a href="#">My Second Project</a></li>
        <li><a href="#">How to make a 304 project</a></li>
        <li><a href="#">Foo bar baz biff zip zow character li…</a></li>
    </ul>
</div>
<br>
<h2>Wishlists</h2><button class="offsetRight" onclick="href='create_wishlist.php'">Create New</button>
<div>
    <ul>
        <li><a href="#">Epic list</a></li>
        <li><a href="#">Projects I want to make</a></li>
        <li><a href="#">Expensive projects</a></li>
    </ul>
</div>
<br>
<h2>Finished projects</h2>
<div>
    <ul>
        <li><a href="#">How to grow big beans</a></li>
    </ul>
</div>
</body>
</html>