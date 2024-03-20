<!DOCTYPE html>
<html lang="en">
<head>
    <title>POST PROJECT</title>
    <style>
        .bottomSpace {
            margin-bottom: 15px;
        }
        textarea {
            width: 100%;
            height: 200px;
        }
        body {
            margin-left: 5%;
            margin-right: 5%;
        }
        button {
            margin-right: 5px;
        }
    </style>
    <script>
        function removeLastTool() {
            var table = document.getElementById("toolTable");
            table.removeChild(table.lastElementChild);
        }

        function removeLastMaterial() {
            var table = document.getElementById("materialTable");
            table.removeChild(table.lastElementChild);
        }

        //see elem count to identify
        function getMaterialCount() {
            return document.getElementById("materialTable").children.length;
        }

        function getToolCount() {
            return document.getElementById("toolTable").children.length;
        }

        function addMaterial() {
            var row = document.createElement("tr");

            var name = document.createElement("td");
            var nameInput = document.createElement("input");
            nameInput.setAttribute("type", "text");
            nameInput.setAttribute("placeholder", "Name");
            nameInput.setAttribute("name", "name" + getMaterialCount());
            name.appendChild(nameInput);

            var quantity = document.createElement("td");
            var quantityInput = document.createElement("input");
            quantityInput.setAttribute("type", "text");
            quantityInput.setAttribute("placeholder", "Quantity");
            quantityInput.setAttribute("quantity", "quantity" + getMaterialCount());
            quantity.appendChild(quantityInput);


            var quantity = document.createElement("td");
            var quantityInput = document.createElement("input");
            quantityInput.setAttribute("type", "text");
            quantityInput.setAttribute("placeholder", "Quantity");
            quantityInput.setAttribute("quantity", "quantity" + getMaterialCount());
            quantity.appendChild(quantityInput);

            var unit = document.createElement("td");
            var unitInput = document.createElement("input");
            unitInput.setAttribute("type", "text");
            unitInput.setAttribute("placeholder", "Unit");
            unitInput.setAttribute("unit", "unit" + getMaterialCount());
            unit.appendChild(unitInput);

            row.appendChild(name);
            row.appendChild(quantity);
            row.appendChild(unit);

            document.getElementById("materialTable").appendChild(row);
        }

        function addTool() {
            var row = document.createElement("tr");

            var name = document.createElement("td");
            var nameInput = document.createElement("input");
            nameInput.setAttribute("type", "text");
            nameInput.setAttribute("placeholder", "Name");
            nameInput.setAttribute("name", "name" + getToolCount());
            name.appendChild(nameInput);

            var purchaseLink = document.createElement("td");
            var purchaseLinkInput = document.createElement("input");
            purchaseLinkInput.setAttribute("type", "text");
            purchaseLinkInput.setAttribute("placeholder", "Purchase Link");
            purchaseLinkInput.setAttribute("name", "purchaseLink" + getToolCount());
            purchaseLink.appendChild(purchaseLinkInput);

            var brandName = document.createElement("td");
            var brandNameInput = document.createElement("input");
            brandNameInput.setAttribute("type", "text");
            brandNameInput.setAttribute("placeholder", "Brand Name");
            brandNameInput.setAttribute("name", "brandName" + getToolCount());
            brandName.appendChild(brandNameInput);

            row.appendChild(name);
            row.appendChild(purchaseLink);
            row.appendChild(brandNames);

            document.getElementById("toolTable").appendChild(row);
        }

        
    </script>
</head>
<body>
<h1>POST PROJECT</h1>
<form action="api/post_project.php" method="post">
    <label for="title">Title:</label>
    <input id="title" name="title">
    <br>
    <label>Tools:</label>
    <table id="toolTable">
    <tbody>
        <tr>
            <td><input type="text" placeholder="Name" name="name0"></td>
            <td><input type="text" placeholder="Purchase Link" name="link0"></td>
            <td><input type="text" placeholder="Brand Name" name="brand0"></td>
        </tr>
    </tbody>
    </table>
    <button class="bottomSpace" type="button" onclick="addTool()">+</button>
    <button class="bottomSpace" type="button" onclick="removeLastTool()">-</button>
    <br>
    <label>Materials:</label>
    <table>
    <tbody id="materialTable">
        <tr>
            <td><input type="text" placeholder="Name" name="name0"></td>
            <td><input type="text" placeholder="Quantity" name="qty0"></td>
            <td><input type="text" placeholder="Unit" name="unit0"></td>
        </tr>
    </tbody>
    </table>
    <button class="bottomSpace" type="button" onclick="addMaterial()">+</button>
    <button class="bottomSpace" type="button" onclick="removeLastMaterial()">-</button>
    <br>
    <label for="instructions">Instructions:</label>
    <br>
    <textarea id="instructions" name="instructions" class="bottomSpace"></textarea>
    <br>
    <label>Add images:</label>
    <br>
    <input multiple type="file" accept="image/png" name="image" onchange="console.log('asdasdas')"></button>
    <br>
    <input type="submit" value="POST PROJECT">
</form>
</body>
</html>