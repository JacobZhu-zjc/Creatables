<!DOCTYPE html>
<html lang="en">
<head>

    <title>Extra Info</title>
    <style>
        body {
            text-align: center;
        }
        input, select {
            margin-bottom: 10px;
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
    document.getElementById("popularProjects").textContent = information;
}
    document.getElementById("ratedProjects").addEventListener("click", function(){
        highRateCount("api/popular_projects.php");
    });
    async function newUser(file) {
    let json = await fetch(file);
    let information = await json.text();
    document.getElementById("UserInfo").textContent = information;
}
    document.getElementById("newUser").addEventListener("click", function(){
        newUser("api/new_user.php");
    });
    async function superRater(file) {
    let json = await fetch(file);
    let information = await json.text();
    document.getElementById("allRatedInfo").textContent = information;
}
    document.getElementById("allRated").addEventListener("click", function(){
        superRater("api/all_rated.php");
    });
</script>
<br>
<br>
<br>
<a href='index.php'>RETURN HOME</a>
</body>
</html>

<!-- // https://www.w3schools.com/js/js_api_fetch.asp-->