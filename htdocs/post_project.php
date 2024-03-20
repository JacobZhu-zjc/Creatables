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
            let table = document.getElementById("toolTable");
            table.removeChild(table.lastElementChild);
        }

        function removeLastMaterial() {
            let table = document.getElementById("materialTable");
            table.removeChild(table.lastElementChild);
        }

        function getMaterialCount() {
            return document.getElementById("materialTable").children.length;
        }

        function getToolCount() {
            return document.getElementById("toolTable").children.length;
        }

        function addMaterial() {
            let row = document.createElement("tr");

            let name = document.createElement("td");
            let nameInput = document.createElement("input");
            nameInput.setAttribute("type", "text");
            nameInput.setAttribute("placeholder", "Name");
            nameInput.setAttribute("name", "name" + getMaterialCount());
            name.appendChild(nameInput);

            let quantity = document.createElement("td");
            let quantityInput = document.createElement("input");
            quantityInput.setAttribute("type", "text");
            quantityInput.setAttribute("placeholder", "Quantity");
            quantityInput.setAttribute("quantity", "quantity" + getMaterialCount());
            quantity.appendChild(quantityInput);

            let unit = document.createElement("td");
            let unitInput = document.createElement("input");
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
            let row = document.createElement("tr");

            let name = document.createElement("td");
            let nameInput = document.createElement("input");
            nameInput.setAttribute("type", "text");
            nameInput.setAttribute("placeholder", "Name");
            nameInput.setAttribute("name", "name" + getToolCount());
            name.appendChild(nameInput);

            let purchaseLink = document.createElement("td");
            let purchaseLinkInput = document.createElement("input");
            purchaseLinkInput.setAttribute("type", "text");
            purchaseLinkInput.setAttribute("placeholder", "Purchase Link");
            purchaseLinkInput.setAttribute("name", "purchaseLink" + getToolCount());
            purchaseLink.appendChild(purchaseLinkInput);

            let brandName = document.createElement("td");
            let brandNameInput = document.createElement("input");
            brandNameInput.setAttribute("type", "text");
            brandNameInput.setAttribute("placeholder", "Brand Name");
            brandNameInput.setAttribute("name", "brandName" + getToolCount());
            brandName.appendChild(brandNameInput);

            row.appendChild(name);
            row.appendChild(purchaseLink);
            row.appendChild(brandName);

            document.getElementById("toolTable").appendChild(row);
        }

        function postForm() {
            let form = document.getElementById("form");
            let files = document.getElementById("imagePicker").files;
            if (files.length == 0) {
                form.submit();
            }
            let addedImages = 0;
            for (let file of files) {
                let reader = new FileReader();
                reader.onload = () => {
                    let input = document.createElement("input");
                    input.setAttribute("value", reader.result);
                    input.setAttribute("name", "imageData" + addedImages);
                    input.setAttribute("type", "text");
                    input.setAttribute("style", "display:none");
                    let name = document.createElement("input");
                    name.setAttribute("value", file.name);
                    name.setAttribute("name", "imageName" + addedImages);
                    name.setAttribute("type", "text");
                    name.setAttribute("style", "display:none");
                    form.appendChild(name);
                    form.appendChild(input);
                    addedImages++;
                    if (addedImages == files.length) {
                        form.submit();
                    }
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
</head>
<body>
<h1>POST PROJECT</h1>
<form action="api/post_project.php" method="post" id="form">
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
    <input multiple type="file" accept="image/png" id="imagePicker"></button>
    <br>
    <br>
    <input type="button" onclick="postForm()" value="POST PROJECT">
</form>
</body>
</html>