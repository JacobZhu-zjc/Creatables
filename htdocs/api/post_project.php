<?php
require("config.php");

function redirect_to_error_page($message) {
    header("Location: ../error.php?err=".urlencode($message));
    die();
}

function redirect_with_error($message) {
    header("Location: ../post_project.php?err=".urlencode($message));
    die();
}

session_start();

if (!isset($_POST["instructions"]) || strlen($_POST["instructions"]) == 0) {
    redirect_with_error("You must enter valid instructions");
}

if (!isset($_SESSION["username"])) {
    redirect_to_error_page("You must be logged in to view projects");
}
$username = $_SESSION["username"];



if (!isset($_POST["title"]) || strlen($_POST["title"]) == 0) {
    redirect_with_error("You must enter a title");
}
$title = htmlspecialchars($_POST["title"]);


$instructions = htmlspecialchars($_POST["instructions"]);

// Parse materials
$materials = [];
if (isset($_POST["materialName"]) && isset($_POST["quantity"]) && isset($_POST["unit"]) 
        && count($_POST["materialName"]) == count($_POST["quantity"])
        && count($_POST["quantity"]) == count($_POST["unit"])) {
    for ($i = 0; $i < count($_POST["materialName"]); $i++) {
        $newMaterial["name"] = htmlspecialchars($_POST["materialName"][$i]);
        $newMaterial["quantity"] = $_POST["quantity"][$i];
        $newMaterial["unit"] = htmlspecialchars($_POST["unit"][$i]);
        $materials[] = $newMaterial;
    }
}

// Parse tools 
$tools = [];
if (isset($_POST["toolName"]) && isset($_POST["link"])
        && count($_POST["toolName"]) == count($_POST["link"])) {
    for ($i = 0; $i < count($_POST["toolName"]); $i++) {
        $newTool["name"] = htmlspecialchars($_POST["toolName"][$i]);
        $newTool["purchaseLink"] = htmlspecialchars($_POST["link"][$i]);
        $tools[] = $newTool;
    }
}

$images = [];
if (isset($_POST["imageName"]) && isset($_POST["imageData"]) 
        && count($_POST["imageName"]) == count($_POST["imageData"])) {
    for ($i = 0; $i < count($_POST["imageName"]); $i++) {
        $newImage["name"] = htmlspecialchars($_POST["imageName"][$i]);
        $newImage["data"] = b64_url_to_binary($_POST["imageData"][$i]);
        $images[] = $newImage;
    }
}
$conn = new mysqli($db_address, $db_user, $db_pw, $db_name);
if ($conn->connect_error) {
    die("To do 3"); // Don't tell the user too much...
}

$stmt = $conn->prepare("INSERT INTO Projects_PostsProject (Name, InstructionText, Username) VALUES (?,?,?)");
$stmt->bind_param("sss", $title, $instructions, $username);
$stmt->execute();

$pid = $conn->insert_id;

$stmt = $conn->prepare("INSERT INTO Materials_MadeWith (Name, Quantity, QuantityUnit, PID) VALUES (?,?,?,?)");
foreach ($materials as $material) {
    $stmt->bind_param("sdsi", $material["name"], $material["quantity"], $material["unit"], $pid);
    $stmt->execute();
}

$stmt = $conn->prepare("INSERT INTO Images_ContainsImages VALUES (?,?,?,?)");
for ($i = 0; $i < count($images); $i++) {
    $oneIndex = $i + 1;
    $stmt->bind_param("issi", $oneIndex, $images[$i]["data"], $images[$i]["name"], $pid);
    $stmt->execute();
}

$stmt = $conn->prepare("INSERT IGNORE INTO PurchaseLink_Name VALUES (?,?)");
$stmt2 = $conn->prepare("INSERT INTO Equipment_NeedsTools (PurchaseLink, PID) VALUES (?,?)");
foreach ($tools as $tool) {
    $stmt->bind_param("ss", $tool["purchaseLink"], $tool["name"]);
    $stmt->execute();
    $stmt2->bind_param("si", $tool["purchaseLink"], $pid);
    $stmt2->execute();
}
$conn->close();
header("Location: ../project_viewer.php?id=".$pid);
?>
