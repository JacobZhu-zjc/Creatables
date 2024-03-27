<?php
require("api/config.php");

if (!isset($_GET["u"]) || strlen($_GET["u"]) == 0) {
    echo("<h1>Please specify a username</h1>");
    die();
}
$username = $_GET["u"];

$conn = new mysqli($db_address, $db_user, $db_pw, $db_name);
if ($conn->error) {
    echo("<h1>Error connecting to database</h1>");
    die();
}
// Verify user exists
$stmt = $conn->prepare("SELECT * FROM Users NATURAL JOIN City_Timezones WHERE Username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
if (count($results) != 1) {
    echo("<h1>User does not exist</h1>");
    die();
}
// Get city, timezone
$city = $results[0]["City"];
$utc_offset = $results[0]["Timezone"];
$prefix = $utc_offset >= 0 ? "+" : "";
$time = date_create("now", new DateTimeZone($prefix.$utc_offset));

$stmt = $conn->prepare("SELECT * FROM Projects_PostsProject WHERE Username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$guides = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$stmt = $conn->prepare("SELECT * FROM ProjectWishlist_Creates WHERE Username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$wishlists = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$conn->close();

session_start();
$logged_in = isset($_SESSION["username"]);
$logged_in_as_author = $logged_in && $_SESSION["username"] == $username;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= $username ?></title>
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
<h2><a href="index.php">HOME</a></h2>
<h1><?= $username ?></h1>
<?php
if ($logged_in_as_author) {
    echo('<button class="offsetRight" onclick="location.href=\'api/logout.php\'">Log out</button>');
    echo('<button class="offsetRight" onclick="location.href=\'inbox.php\'">Inbox</button>');
}
?>

<h3><?= $city ?> (Local Time: <?= $time->format("h:i") ?>)</h3>
<br>
<h2>Guides</h2>
<?php
if ($logged_in_as_author) {
    echo('<button class="offsetRight" onclick="location.href=\'post_project.php\'">Create new</button>');
}
?>
<div>
    <ul>
        <?php
            foreach($guides as $guide) {
                echo('<li><a target="_blank" href="project_viewer.php?id='.$guide["PID"].'">'.$guide["Name"].'</a></li>');
            }
        ?>
    </ul>
</div>
<br>
<h2>Wishlists</h2>
<?php
if ($logged_in_as_author) {
    echo('<button class="offsetRight" onclick="location.href=\'./create_wishlist.php\'">Create New</button>');
}
?>

<div>
    <ul>
        <?php
        foreach($wishlists as $wishlist) {
            echo('<li><a target="_blank" href="wishlist_viewer.php?id='.$wishlist["WLID"].'">'.$wishlist["Name"].'</a></li>');
        }
        ?>
    </ul>
</div>
</body>
</html>