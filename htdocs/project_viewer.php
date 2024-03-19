<?php
require("api/config.php");

if (!isset($_GET["id"]) || strlen($_GET["id"]) == 0) {
    echo("<h1>Please specify a project</h1>");
    die();
}

$conn = new mysqli($db_address, $db_user, $db_pw, $db_name);
$stmt = $conn->prepare("SELECT * FROM Projects_PostsProject WHERE PID=?");
$stmt->bind_param("i", $_GET["id"]);
$stmt->execute();
$results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
if (count($results) != 1) {
    $conn->close();
    echo("<h1>Project not found</h1>");
    die();
}
// We will use this to generate HTML
$result = $results[0];

$stmt = $conn->prepare("SELECT * FROM Images_ContainsImages WHERE PID=?");
$stmt->bind_param("i", $_GET["id"]);
$stmt->execute();
$results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$conn->close();

function index_sort($img1, $img2) {
    return $img1["GalleryIndex"] - $img2["GalleryIndex"];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= $result["Name"] ?></title>
    <style>
        body {
            margin: 5%;
        }
        div {
            width: 100%;
        }
        image {
            height: 100px;
            width: auto;
        }
        a {
            font-style: italic;
        }
        li {
            margin-bottom: 10px;
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
        #instruction_text {
            margin-top: 50px;
            height: 25%;
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
    <h2><a href="profile.php?u=<?= urlencode($result["Username"]) ?>"><?= $result["Username"] ?></a></h2>
    Jan. 31, 2024
<!--    <input type="submit" value="DELETE" id="delete_button">-->
    <input type="submit" value="I MADE THIS!" id="complete_button">
    <div id="instruction_text">
        <p>
            <?= $result["InstructionText"] ?>
        </p>
    </div>
    <div>
        <?php
        if (count($results) > 0) {
            echo("<h3>Gallery:</h3>");
            usort($results, "index_sort");
            foreach($results as $image) {
                echo(get_image_tag_from_blob($image["ImageData"]));
                echo("<br>");
                echo("<p>".$image["Caption"]."</p>");
                echo("<hr>");
            }
        }
        ?>
    </div>
    <div>
        <h3>Reviews:</h3>
        <div id="review_content">
            <ul>
                <li>
                    Loved these instructions! Had massive beans in no time!
                    <br>
                    <a href="">BOBTHEGROWER</a>
                </li>
                <li>
                    3/5
                    <br>
                    <a href="">Jack</a>
                </li>
                <li>
                    <img src="" alt="Some caption here!">
                    <br>
                    <a href="">MelonMan</a>
                </li>
            </ul>
        </div>
    </div>
    <div>
        <h3>Post a review:</h3>
        <select name="Comment" id="comment_type">
            <option value="text">Text</option>
            <option value="stars">Star rating</option>
            <option value="image">Upload image</option>
        </select>

        <form action="">
            <input type="text" placeholder="Add a title!" id="title_input">
            <br>
            <textarea name="comment" placeholder="Say something nice..." id="comment_input"></textarea>
            <br>
            <input type="submit" value="POST">
        </form>
    </div>
</body>
</html>