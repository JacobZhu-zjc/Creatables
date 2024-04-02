<?php
// Establishing PHP variables that are used elsewhere in the HTML page
require("api/config.php");

// Finding the appropriate wishlist from the database and pulling the required info
if ((!isset($_GET["id"]) || strlen($_GET["id"]) == 0)) {
    echo("<h1>Please specify a wishlist</h1>");
    die();
}
$wlid = $_GET["id"];

$conn = new mysqli($db_address, $db_user, $db_pw, $db_name);
$stmt = $conn->prepare("SELECT * FROM ProjectWishlist_Creates WHERE WLID=?");
$stmt->bind_param("i", $wlid);
$stmt->execute();
$results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
if (count($results) != 1) {
    $conn->close();
    echo("<h1>Wishlist not found</h1>");
    die();
}

// We will use this to generate HTML
$result = $results[0];

// Get wishlist projects
$stmt = $conn->prepare("SELECT * FROM Projects_PostsProject WHERE PID IN (SELECT PID FROM Contains WHERE WLID=?)");
$stmt->bind_param("i", $wlid);
$stmt->execute();
$projects = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$conn->close();

$logged_in_as_creator = false;
session_start();
if (isset($_SESSION["username"])) {
    $logged_in_as_creator = $_SESSION["username"] == $result["Username"];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= $result["Name"] ?></title>
    <style>
        body {
            margin-left: 5%;
            margin-right: 5%;
        }
        div {
            border: 1px solid black;
        }
        ul {
            border-collapse: collapse;
            margin: 20px;
        }
        li {
            margin-top: 5px;
            margin-bottom: 10px;
        }
        form {
            margin-top: 10px;
            float: right;
        }
        input {
            margin-left: 5px;
        }
        em {
            color: red;
        }
        #nameTag {
            font-size: 30px;
            margin: 5px;
        }
        #deleteButton {
            color: red;
            border: 1px solid red;
            float: right;
            min-width: 75px;
            min-height: 33px;
            margin: 5px;
            color: "red";
        }
        .error {
            color: "red";
        }
    </style>
</head>
<body>
<!-- Displaying any error messages -->
<em>
    <strong>
        <?php
        if (isset($_GET["err"]) && strlen($_GET["err"])) {
            echo(htmlspecialchars($_GET["err"]));
            echo("<br><br>");
        }
        ?>
    </strong>
</em>

<h1><?= $result["Name"] ?></h1>
<a href="profile.php?u=<?= urlencode($result["Username"]) ?>" id="nameTag"><?= $result["Username"] ?></a>

<?php
    // Optionally displaying the button to delete the wishlist if current user is the creator
    if ($logged_in_as_creator) {
        echo('<form action="api/delete_wishlist.php" method="post">');
        echo('<input type="hidden" value="'.$wlid.'" name="wishlistID">');
        echo('<input id="deleteButton" type="submit" value="DELETE">');
        echo('</form>');
    }
?>

<h3>Projects:</h3>
<div>
    <?php
        if (count($projects) > 0) {
            echo("<ul>");
            foreach ($projects as $project) {
                // TODO: add individual delete buttons for each project
                echo('<li><a href="project_viewer.php?id='.urlencode($project["PID"]).'">');
                echo($project["Name"]);
                echo('</a></li>');
            }
            echo("</ul>");
        } else {
            echo("<br>");
            echo("&ensp;No projects added yet...<br><br>");
        }
    ?>
</div>

<?php
    if ($logged_in_as_creator) {
        // Optionally displaying the text field to add new projects if the current user is the creator
        echo('<form action="api/add_project_to_wishlist.php" method="post">');
        echo('<input type="text" placeholder="Project ID" name="projectID">');
        echo('<input type="hidden" value="'.$wlid.'" name="wishlistID">');
        echo('<input type="submit" value="ADD PROJECT">');
        echo('</form>');

        echo('<br><br>');

        // Optionally displaying the text field to rename the wishlist or to send the wishlist to someone else, if the current user is the creator
        echo('<form action="api/update_wishlist.php" method="post">');
        echo('<h3>Send your wishlist to someone else!</h3>');
        echo('<input type="text" placeholder="New wishlist name" name="newWishlistName">');
        echo('<input type="text" placeholder="Username of new wishlist owner" name="newUsername">');
        echo('<input type="hidden" value="'.$wlid.'" name="wishlistID">');
        echo('<input type="submit" value="UPDATE WISHLIST">');
        echo('</form>');
    }
?>
</body>
</html>