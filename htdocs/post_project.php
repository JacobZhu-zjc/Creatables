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
</head>
<body>
<h1>POST PROJECT</h1>
<form action="#">
    <label for="title">Title:</label>
    <input id="title" name="title">
    <br>
    <label>Tools:</label>
    <table>
        <tr>
            <td><input type="text" placeholder="Name" name="name0"></td>
            <td><input type="text" placeholder="Purchase Link" name="link0"></td>
            <td><input type="text" placeholder="Brand Name" name="brand0"></td>
        </tr>
        <tr>
            <td><input type="text" placeholder="Name" name="name1"></td>
            <td><input type="text" placeholder="Purchase Link" name="link1"></td>
            <td><input type="text" placeholder="Brand Name" name="brand1"></td>
        </tr>
    </table>
    <button class="bottomSpace">+</button><button class="bottomSpace">-</button>
    <br>
    <label>Materials:</label>
    <table>
        <tr>
            <td><input type="text" placeholder="Name" name="name0"></td>
            <td><input type="text" placeholder="Quantity" name="qty0"></td>
            <td><input type="text" placeholder="Unit" name="unit0"></td>
        </tr>
    </table>
    <button class="bottomSpace">+</button><button class="bottomSpace">-</button>
    <br>
    <label for="instructions">Instructions:</label>
    <br>
    <textarea id="instructions" name="instructions" class="bottomSpace"></textarea>
    <br>
    <label>Add images:</label>
    <br>
    <button>Upload image</button><button>Remove last</button>
    <ol>
        <li>Image1.png</li>
        <li>Dog.jpg</li>
    </ol>
    <input type="submit" value="POST PROJECT">
</form>
</body>
</html>