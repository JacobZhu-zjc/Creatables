<!DOCTYPE html>
<html lang="en">
<head>

    <title>Extra Info</title>
    <style>
        body {
            text-align: center;
        }

        input, select, button {
            margin-bottom: 10px;
            margin-top: 10px;
        }

        #error {
            color: red;
        }

    </style>
</head>
<body>
<h1>Extra Info</h1>
<span></span>
<br>
<br>


<button id="ratedProjects">View Projects with a lot of feedback (>2)</button>
<div id="popularProjects"></div>
<br>
<button id="newUser">View Youngest Users</button>
<div id="UserInfo"></div>
<br>
<button id="allRated">Projects which have feedback left by everyone</button>
<div id="allRatedInfo"></div>


<script>
    async function highRateCount(file) {
        let json = await fetch(file);
        let information = await json.text();
        const info = JSON.parse(information);
        let out = [];
        for (let i = 0; i < info.length; i++) {
            out.push(" " + info[i].name)
        }
        document.getElementById("popularProjects").textContent = out;
    }

    document.getElementById("ratedProjects").addEventListener("click", function () {
        highRateCount("api/popular_projects.php");
    });

    async function newUser(file) {
        let json = await fetch(file);
        let information = await json.text();
        info = JSON.parse(information);
        out = [];
        for (i = 0; i < info.length; i++) {
            out.push(" " + info[i].Username)
        }
        document.getElementById("UserInfo").textContent = out;
    }

    document.getElementById("newUser").addEventListener("click", function () {
        newUser("api/new_user.php");
    });

    async function superRater(file) {
        let json = await fetch(file);
        let information = await json.text();
        info = JSON.parse(information);
        out = [];
        for (i = 0; i < info.length; i++) {
            out.push(" " + info[i].Name)
        }
        document.getElementById("allRatedInfo").textContent = out;

    }

    document.getElementById("allRated").addEventListener("click", function () {
        superRater("api/all_rated.php");
    });
</script>
<br>
<br>
<br>
<a href='index.php'>RETURN HOME</a>
</body>
</html>
