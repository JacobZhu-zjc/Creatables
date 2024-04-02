<?php
function post_message()
{
    require_once("config.php");
    session_start();

    if (!isset($_SESSION["username"])) {
        return "You must be logged in to send messages";
    }
    if (!isset($_POST["recipient"]) || !isset($_POST["message"]) ||
        strlen($_POST["recipient"]) == 0 || strlen($_POST["message"]) == 0) {
        return "Please enter a recipient and a message";
    }
    $message = htmlspecialchars($_POST["message"]);
    $recipient = $_POST["recipient"];
    if (strlen($message) > 1000) {
        return "Message is too long";
    }

    // Ensure recipient exists
    $conn = new mysqli($db_address, $db_user, $db_pw, $db_name);
    if ($conn->connect_error) {
        return "Error connecting to database";
    }
    $stmt = $conn->prepare("SELECT * FROM Users WHERE Username=?");
    $stmt->bind_param("s", $recipient);
    $stmt->execute();
    if ($stmt->get_result()->num_rows == 0) {
        $conn->close();
        return "Recipient does not exist";
    }

    // Post message
    $stmt = $conn->prepare("INSERT INTO Message_Sends(Text, SenderUsername, ReceiverUsername)" .
        "VALUES (?,?,?)");
    $stmt->bind_param("sss", $message, $_SESSION["username"], $recipient);
    $stmt->execute();
    $conn->close();
    return "Message sent!";
}

?>
<!DOCTYPE html>
<html lang="en">
<body>
<em><?= post_message() ?></em>
<br>
<br>
<a href="../compose_message.php">Send another message</a>
<br>
<a href="../inbox.php">Return to inbox</a>
</body>
</html>
