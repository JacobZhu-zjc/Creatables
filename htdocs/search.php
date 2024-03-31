<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>SEARCH</title>
    <script>
        let params;
        const searchParamHTML = `
        <select name="conns[]">
            <option value="AND" selected>AND</option>
            <option value="OR">OR</option>
        </select>
        <select name="attrs[]">
            <option value="Name" selected>Project Name (String)</option>
            <option value="PID">Project ID (Integer)</option>
            <option value="Username">Author Username (String)</option>
            <option value="Timestamp">Project Timestamp (Datetime)</option>
        </select>
        <select name="ops[]">
            <option value="eq" selected>=</option>
            <option value="gt">&gt;</option>
            <option value="lt">&lt;</option>
        </select>
        <input type="text" name="vals[]" placeholder="Value">`;

        function addSearchParameter() {
            const toAdd = document.createElement("div");
            toAdd.innerHTML = searchParamHTML;
            params.appendChild(toAdd);
        }

        function removeSearchParameter() {
            if (params.children.length > 0) {
                params.removeChild(params.lastChild);
            }
        }
    </script>
</head>
<body>
<h2><a href="index.php">HOME</a></h2>
<h1>SEARCH PROJECTS</h1>
<em>Reminder: AND is always evaluated before OR.</em>
<br><br>
<form action="api/search_results.php" target="searchFrame" method="get">
    <div id="firstSearchParameter">
        <select style="margin-left: 60px" name="attrs[]">
            <option value="Name" selected>Project Name (String)</option>
            <option value="PID">Project ID (Integer)</option>
            <option value="Username">Author Username (String)</option>
            <option value="Timestamp">Project Timestamp (Datetime)</option>
        </select>
        <select name="ops[]">
            <option value="eq" selected>=</option>
            <option value="gt">&gt;</option>
            <option value="lt">&lt;</option>
        </select>
        <input type="text" placeholder="Value" name="vals[]">
    </div>
    <div id="additionalSearchParameters">
    </div>
    <script>
        params = document.getElementById("additionalSearchParameters");
    </script>
    <br>
    <button onclick="addSearchParameter()" type="button">+</button>
    <button onclick="removeSearchParameter()" type="button">-</button>
    <br>
    <br>
    <input type="submit" value="SEARCH">
</form>
<br>
<iframe name="searchFrame" src="api/search_results.php" style="width:100%; height:300px; border: none"></iframe>
</body>
</html>
