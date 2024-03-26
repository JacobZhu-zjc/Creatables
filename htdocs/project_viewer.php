<?php
require("api/config.php");

if (!isset($_GET["id"]) || strlen($_GET["id"]) == 0) {
    echo("<h1>Please specify a project</h1>");
    die();
}

$pid = $_GET["id"];

$conn = new mysqli($db_address, $db_user, $db_pw, $db_name);
if ($conn->error) {
    echo("<h1>Error connecting to database</h1>");
    die();
}
$stmt = $conn->prepare("SELECT * FROM Projects_PostsProject WHERE PID=?");
$stmt->bind_param("i", $pid);
$stmt->execute();
$results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
if (count($results) != 1) {
    $conn->close();
    echo("<h1>Project not found</h1>");
    die();
}
// We will use this to generate HTML
$result = $results[0];

// Get images
$stmt = $conn->prepare("SELECT * FROM Images_ContainsImages WHERE PID=? ORDER BY GalleryIndex");
$stmt->bind_param("i", $pid);
$stmt->execute();
$images = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Get equipment
$stmt = $conn->prepare("SELECT b.Name, a.PurchaseLink ".
    "FROM Equipment_NeedsTools a, PurchaseLink_Name b, Projects_PostsProject c ".
    "WHERE a.PID = c.PID AND a.PurchaseLink = b.PurchaseLink AND c.PID=?");
$stmt->bind_param("i", $pid);
$stmt->execute();
$tools = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Get materials
$stmt = $conn->prepare("SELECT a.Name, Quantity, QuantityUnit ".
    "FROM Materials_MadeWith a, Projects_PostsProject b ".
    "WHERE a.PID = b.PID AND b.PID=?");
$stmt->bind_param("i", $pid);
$stmt->execute();
$materials = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Get feedback
$stmt = $conn->prepare("SELECT * FROM Feedback_LeavesFeedback WHERE PID=?");
$stmt->bind_param("i", $pid);
$stmt->execute();
$feedback = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

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
            width: 100%;
        }

        image {
            height: 100px;
            width: auto;
        }

        h2 a {
            font-style: italic;
        }

        li {
            margin-bottom: 10px;
        }

        .postButton { 
            margin-top: 23px;    
        }

        #delete_button {
            color: red;
            border: 1px solid red;
            float: right;
            min-width: 75px;
            min-height: 33px;
            margin: 5px;
        }

        #complete_button {
            float: right;
            min-width: 100px;
            min-height: 33px;
            margin: 5px;
        }

        .top-margin {
            margin-top: 30px;
        }

        #review_content {
            border: 1px solid black;
        }

        #comment_type {
            margin-bottom: 10px;
        }

        #title_input {
            width: 100%;
            margin-bottom: 10px;
        }

        #comment_input {
            width: 100%;
            min-height: 150px;
            margin-bottom: 10px;
        }


    </style>
</head>
<body>
<h1><?= $result["Name"] ?></h1>
<h2>By <a href="profile.php?u=<?= urlencode($result["Username"]) ?>"><?= $result["Username"] ?></a></h2>
<?php
echo($result["Timestamp"]);
if ($logged_in_as_creator) {
    echo('<form action="api/delete_project.php" method="post">');
    echo('<input type="submit" value="DELETE" id="delete_button">');
    echo('<input type="text" value="' . $pid . '" name="id" style="display:none">');
    echo("</form>");
}

if (count($tools) > 0) {
    echo('<div class="top-margin">');
    echo("<h3>Equipment:</h3>");
    echo("<ul>");
    foreach ($tools as $tool) {
        echo("<li>");
        echo('<a href="'.$tool["PurchaseLink"].'" target="_blank">'.$tool["Name"]."</a>");
        echo("</li>");
    }
    echo("</ul>");
    echo("</div>");
}
if (count($materials) > 0) {
    echo('<div class="top-margin">');
    echo("<h3>Materials:</h3>");
    echo("<ul>");
    foreach ($materials as $material) {
        echo("<li>");
        echo($material["Name"]." (".$material["Quantity"]." ".$material["QuantityUnit"].")");
        echo("</li>");
    }
    echo("</ul>");
    echo("</div>");
}
?>
<div class="top-margin">
    <h3>Instructions:</h3>
    <p>
        <?= $result["InstructionText"] ?>
    </p>
</div>
<?php
if (count($images) > 0) {
    echo('<div class="top-margin">');
    echo("<h3>Gallery:</h3>");
    foreach ($images as $image) {
        echo(get_image_tag_from_blob($image["ImageData"]));
        echo("<br>");
        echo("<p>" . $image["Caption"] . "</p>");
        echo("<hr>");
    }
    echo("</div>");
}
?>
<div>
    <h3>Reviews:</h3>
    <div id="review_content">
        <?php
        if (count($feedback) == 0) {
            echo("<br>");
            echo("&ensp;No projects added yet...<br><br>");
            return;
        }

        echo("<ul>");
        // No error handling for invalid reviews, where all three of Stars, Comment, and ImageData are NULL
        foreach ($feedback as $review) {
            echo("<li>".$review["Title"]."<br>");
            if (!is_null($review["Stars"])) {
                echo($review["Stars"].'/5<br>');
            } else if (!is_null($review["Comment"])) {
                echo($review["Comment"].'<br>');
            } else {
                echo(get_image_tag_from_blob($image["ImageData"]));
                echo("<br>");
                echo("<p>" . $image["Caption"] . "</p>");
            }
            echo('<a href="profile.php?u='.urlencode($review["Username"]).'">'.$review["Username"].'</a></li>');
        }
        echo("</ul>");
        ?>
    </div>
</div>
<div>
    <h3>Post a review:</h3>
    <select name="Comment" id="comment_type">
        <option value="text">Text</option>
        <option value="stars">Star rating</option>
        <option value="image">Upload image</option>
    </select>


    <form action="api/post_feedback.php" method="post" id ="text" style = "display: block;">
        <input type="text" placeholder="Add a title!" id="title_input" name = "title">
        <br>
        <textarea name="comment" placeholder="Say something nice..." id="comment_input"></textarea>
        <br>
        <input type="submit" value="POST" class = "postButton">
    </form>

    <form action="api/post_feedback.php" method="post" id ="image" style = "display: block;">
        <input type="text" placeholder="Add a title!" id="title_input" name = "title">
        <br>
        <input type="file" id="image" accept="image/*" name = "png">
        <br>
        <input type="submit" value="POST" class = "postButton">
    </form>

    <form action="api/post_feedback.php" method="post" id ="stars" style = "display: block;">
        <input type="text" placeholder="Add a title!" id="title_input">
        <br>
        <select name="Rating" id="user_rating">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        </select>
        <br>
        <input type="submit" value="POST" class = "postButton">
    </form>

    <script>
        var stars = document.getElementById("stars");
        var image = document.getElementById("image");
        var text = document.getElementById("text");
        var choices = document.getElementById("comment_type");
        changeDisplay();
        function changeDisplay() {

            stars.style.display="none"
            image.style.display="none"
            text.style.display="none"

            var choice = choices.value;

            if (choice == "text"){
                text.style.display = "block";
            } else if (choice == "stars"){
                stars.style.display = "block";
            } else if (choice == "image"){
                image.style.display = "block";
            }
        }
        choices.onchange = changeDisplay;

    </script>

</div>
</body>
</html>