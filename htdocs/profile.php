<?php
$utc_offset = -8;
$prefix = $utc_offset >= 0 ? "+" : "";
$time = date_create("now", new DateTimeZone($prefix.$utc_offset));
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
<button class="offsetRight">Log out</button>
<h3>Vancouver, Canada (Local Time: <?php echo($time->format("h:i")); ?>)</h3>
<br>
<h2>Guides</h2><button class="offsetRight">Create New</button>
<div>
    <ul>
        <li><a href="#">Cool guide</a></li>
        <li><a href="#">My Second Project</a></li>
        <li><a href="#">How to make a 304 project</a></li>
        <li><a href="#">Foo bar baz biff zip zow character li…</a></li>
    </ul>
</div>
<br>
<h2>Wishlists</h2><button class="offsetRight">Create New</button>
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