<?php
require("config.php");
$valid_connectives = ["AND", "OR"];
$valid_operators = ["eq" => "=", "gt" => ">", "lt" => "<"];
$valid_attribute_types = ["Name" => "s", "PID" => "i", "Username" => "s", "Timestamp" => "s"];

if (count($_GET) == 0) {
    die();
}
$connectives = [];
if (isset($_GET["conns"])) {
    // Verify that all connectives are valid
    foreach ($_GET["conns"] as $dirty_connective) {
        if (!in_array($dirty_connective, $valid_connectives, true)) {
            die("Invalid input");
        }
    }
    $connectives = $_GET["conns"];
}

$operators = [];
foreach ($_GET["ops"] as $op) {
    if (!in_array($op, array_keys($valid_operators), true)) {
        die("Invalid input");
    }
    $operators[] = $valid_operators[$op];
}

$attributes = $_GET["attrs"];
foreach ($attributes as $attr) {
    if (!in_array($attr, array_keys($valid_attribute_types), true)) {
        die("Invalid input");
    }
}
$rows = $_GET["vals"];
if (count($rows) != count($attributes) ||
    count($attributes) != count($operators) ||
    count($connectives) != (count($rows) - 1)) {
    die("Invalid input");
}

// Set up query
$query = "SELECT PID, Name, Timestamp, Username FROM Projects_PostsProject WHERE ";
$query .= $attributes[0] . " " . $operators[0] . " ?";
for ($i = 1; $i < count($attributes); $i++) {
    $query .= " " . $connectives[$i - 1] . " " . $attributes[$i] . " " . $operators[$i] . " ?";
}

// Connect to database
$conn = new mysqli($db_address, $db_user, $db_pw, $db_name);
if ($conn->error) {
    die("MySQL error");
}
$stmt = $conn->prepare($query);
$type_string = implode(array_map(function ($attr) use ($valid_attribute_types) {
    return $valid_attribute_types[$attr];
    }, $attributes));
$stmt->bind_param($type_string, ...$rows);
$stmt->execute();
$result = $stmt->get_result();
$rows = $result->fetch_all();
$fields = $result->fetch_fields();
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
    <?php
    /**
     * @param array $fields
     * @param array $rows
     * @return void
     */
    if (count($rows) > 0) {
        echo("<h3>" . count($rows) . " results:</h3>");
        echo_table($fields, $rows);
    } else {
        echo("<h3>No matching results.</h3>");
    }
    ?>
</body>
</html>