<?php
require("config.php");

if (!isset($_GET["table"]) || strlen($_GET["table"]) == 0) {
    die("Please choose a table to project from");
}
$table = $_GET["table"];

if (!isset($_GET["attrs"]) || count($_GET["attrs"]) == 0) {
    die("Please choose attributes to project");
}
$attributes = $_GET["attrs"];

// Validate that table exists
$conn = new mysqli($db_address, $db_user, $db_pw, $db_name);
if ($conn->error) {
    die("Error connecting to database");
}

$results = $conn->query("SHOW TABLES")->fetch_all();
$tables = array_column($results, 0);
if (!in_array($table, $tables, true)) {
    $conn->close();
    die("Invalid table");
}

// Validate that attributes exist on table
$results = $conn->query("DESCRIBE " . $table)->fetch_all();
$valid_attributes = array_column($results, 0);
foreach ($attributes as $attribute) {
    if (!in_array($attribute, $valid_attributes, true)) {
        $conn->close();
        die("Invalid attribute");
    }
}

// All is good. Get results
$query = "SELECT " . implode(", ", $attributes) . " FROM $table";
$results = $conn->query($query);
$fields = $results->fetch_fields();
$rows = $results->fetch_all();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        table, th, td {
            padding: 5px;
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
<?php echo_table($fields, $rows); ?>
</body>
</html>
