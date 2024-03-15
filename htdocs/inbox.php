<!DOCTYPE html>
<html lang="en">
<head>
    <title>INBOX</title>
    <style>
        body {
            margin: 5%;
        }
        label {
            text-align: left;
        }
        input {
            margin-top: 5px;
            margin-bottom: 5px;
        }
        table {
            width: 100%;
            border: 1px solid black;
            margin-bottom: 10px;
        }
        iframe {
            width: 100%;
            height: 300px;
            border: 1px solid black;
            margin-bottom: 10px;
            overflow: auto;
        }
        .subject {
            width: 80%;
        }
    </style>
</head>
<body>
<h1>INBOX</h1>
<form action="#">
    <input type="submit" value="Compose a message">
    <br>
    <table>
        <tr>
            <td class="subject"><a href="">Message 1</a></td>
            <td><input type="submit" value="Delete"></td>
            <td>From: Jake</td>
        </tr>
        <tr>
            <td class="subject"><a href="">I enjoyed following your guide!</a></td>
            <td><input type="submit" value="Delete"></td>
            <td>From: hi</td>
        </tr>
        <tr>
            <td class="subject"><a href="">PLEASE FIX I CANNOT UNDERSTA...</a></td>
            <td><input type="submit" value="Delete"></td>
            <td>From: Zach</td>
        </tr>
        <tr>
            <td class="subject"><a href="">SHARE OR YOUR ARE CURSED...</a></td>
            <td><input type="submit" value="Delete"></td>
            <td>From: hi</td>
        </tr>
        <tr>
            <td class="subject"><a href="">I enjoyed following your project!</a></td>
            <td><input type="submit" value="Delete"></td>
            <td>From: BOB</td>
        </tr>
        <tr>
            <td class="subject"><a href="">I enjoyed following you home!</a></td>
            <td><input type="submit" value="Delete"></td>
            <td>From: creep</td>
        </tr>
    </table>

    <iframe src="message_viewer.php">
    </iframe>
</form>
</body>
</html>
