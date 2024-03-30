<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>SEARCH</title>
    <script>
        let params;
        const searchParamHTML = `
        <select>
            <option value="AND" selected>AND</option>
            <option value="OR">OR</option>
        </select>
        <select>
            <option value="Name" selected>Project Name (String)</option>
            <option value="PID">Project ID (Integer)</option>
            <option value="Username">Author Username (String)</option>
            <option value="Timestamp">Project Timestamp (Datetime)</option>
        </select>
        <select>
            <option value="eq" selected>=</option>
            <option value="gt">&gt;</option>
            <option value="lt">&lt;</option>
        </select>
        <input type="text" placeholder="Value">`;

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

        function sendSearchRequest() {
            document.getElementById("searchFrame").src = "api/search_results.php?" + firstParameter() + otherParameters();
        }

        function firstParameter() {
            const fields = document.getElementById("firstSearchParameter").children;
            const attribute = encodeURIComponent(fields[0].value);
            const operator = encodeURIComponent(fields[1].value);
            const value = encodeURIComponent(fields[2].value);
            return "attrs[]=" + attribute + "&ops[]=" + operator + "&vals[]=" + value;
        }

        function otherParameters() {
            let queryString = "";
            const additionalParameters = params.children;
            for (const param of additionalParameters) {
                const fields = param.children;
                const connective = encodeURIComponent(fields[0].value);
                const attribute = encodeURIComponent(fields[1].value);
                const operator = encodeURIComponent(fields[2].value);
                const value = encodeURIComponent(fields[3].value);
                queryString = queryString.concat(
                    "&attrs[]=", attribute,
                    "&ops[]=", operator,
                    "&vals[]=", value,
                    "&conns[]=", connective);
            }
            return queryString;
        }
    </script>
</head>
<body>
<h2><a href="index.php">HOME</a></h2>
<h1>SEARCH PROJECTS</h1>
<em>Reminder: AND is always evaluated before OR.</em>
<br><br>
<div id="firstSearchParameter">
    <select style="margin-left: 60px">
        <option value="Name" selected>Project Name (String)</option>
        <option value="PID">Project ID (Integer)</option>
        <option value="Username">Author Username (String)</option>
        <option value="Timestamp">Project Timestamp (Datetime)</option>
    </select>
    <select>
        <option value="eq" selected>=</option>
        <option value="gt">&gt;</option>
        <option value="lt">&lt;</option>
    </select>
    <input type="text" placeholder="Value">
</div>
<div id="additionalSearchParameters">
</div>
<script>
    params = document.getElementById("additionalSearchParameters");
</script>
<br>
<button onclick="addSearchParameter()">+</button>
<button onclick="removeSearchParameter()">-</button>
<br>
<br>
<button onclick="sendSearchRequest()">SEARCH</button>
<br><br>
<iframe id="searchFrame" src="api/search_results.php" style="width:100%; height:300px; border: none"></iframe>
</body>
</html>
