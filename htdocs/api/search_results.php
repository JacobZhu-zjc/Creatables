<?php
require("config.php");
if (count($_GET) == 0) {
    die();
}
$connectives = [];
if (isset($_GET["conns"])) {
    // Verify that all connectives are valid
    foreach ($_GET["conns"] as $dirtyConnective) {
        if ($dirtyConnective != "AND" && $dirtyConnective != "OR") {
            die("Invalid input");
        }
    }
    $connectives = $_GET["conns"];
}

// TODO validate/map operators, attributes (no need to sanitize values because PS)

$query = "SELECT PID, Name, Timestamp, Username FROM Projects_PostsProject WHERE ";
// TODO build query
echo("<pre>");
print_r($_GET);
echo("</pre>");
?>
<!DOCTYPE html>