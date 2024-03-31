<?php
require("api/config.php");

// Get all tables, and their columns
$conn = new mysqli($db_address, $db_user, $db_pw, $db_name);
if ($conn->error) {
    die("Error connecting to database");
}
$results = $conn->query("SHOW TABLES")->fetch_all();
$tables = array_column($results, 0);
$table_attributes = [];
foreach($tables as $table) {
    $results = $conn->query("DESCRIBE " . $table)->fetch_all();
    $table_attributes[$table] = array_column($results, 0);
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>PROJECT COLUMNS</title>
    <script>
        const tables = <?= json_encode($table_attributes) ?>;
        function changeTable(picker) {
            const table = picker.value;
            const checkboxes = document.getElementById("checkboxes");
            while (checkboxes.childNodes.length > 0) {
                checkboxes.removeChild(checkboxes.lastChild);
            }
            if (table !== "") {
                const columns = tables[table];
                for (const columnName of columns) {
                    const checkbox = document.createElement("input");
                    checkbox.id = columnName;
                    checkbox.name = "attrs[]";
                    checkbox.value = columnName;
                    checkbox.type = "checkbox";
                    const label = document.createElement("label");
                    label.setAttribute("for", columnName);
                    label.innerHTML = columnName;
                    const spacer = document.createElement("br");
                    checkboxes.appendChild(label);
                    checkboxes.appendChild(checkbox);
                    checkboxes.appendChild(spacer);
                }
            }
        }
    </script>
</head>
<body>
<h2><a href="index.php">HOME</a></h2>
<h1>COLUMN PROJECTION</h1>
<form action="api/projection_results.php" target="searchFrame" method="get">
    <label for="table">Table: </label><select id="table" name="table" onchange="changeTable(this)">
        <option value="" selected>Choose a table</option>
    </select>
    <br>
    Columns:
    <div id="checkboxes">
    </div>
    <br>
    <input type="submit">
</form>
<iframe name="searchFrame" src="about:blank" style="width:100%; height:300px; border: none"></iframe>
<script>
    const tablePicker = document.getElementById("table");
    for (const table in tables) {
        const option = document.createElement("option");
        option.setAttribute("value", table);
        option.innerText = table;
        tablePicker.appendChild(option);
    }
</script>
</body>
</html>
