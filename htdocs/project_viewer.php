<!DOCTYPE html>
<html lang="en">
<head>
    <title>How to grow big beans</title>
    <style>
        body {
            margin: 5%;
        }
        div {
            width: 100%;
        }
        image {
            height: 100px;
            width: auto;
        }
        a {
            font-style: italic;
        }
        li {
            margin-bottom: 10px;
        }
        #delete_button {
            color: red;
            border: 1px solid red;
            float: right;
            min-width: 75px;
            min-height: 33px;
            margin: 5px;
        }
        #complete_button {
            float: right;
            min-width: 100px;
            min-height: 33px;
            margin: 5px;
        }
        #instruction_text {
            margin-top: 50px;
            height: 25%;
        }
        #review_content {
            border: 1px solid black;
        }
        #comment_type {
            margin-bottom: 10px;
        }
        #title_input {
            width: 100%;
            margin-bottom: 10px;
        }
        #comment_input {
            width: 100%;
            min-height: 150px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h1>How to grow big beans</h1>
    <h2><a href="">JSKONS</a></h2>
    Jan. 31, 2024
    <input type="submit" value="DELETE" id="delete_button">
    <input type="submit" value="I MADE THIS!" id="complete_button">
    <div id="instruction_text">
        <p>
            This is how everyone can grow massive beans at home! Simply start by soaking some beans in water, then wrapping in a damp paper towel and letting sit on your countertop for a couple of days! Then, wait for them to sprout. At this point, you can plant them in some dirt at a shallow level, and add water as required! In just a couple of weeks, you'll have some bean plants of your own, and in a month or two, you'll be sure to have some impossibly humongous, veiny beans!
        </p>
    </div>
    <div>
        <h3>Gallery:</h3>
        <img src="" alt="Some caption here!">
        <img src="" alt="Some caption here!">
        <img src="" alt="Some caption here!">
    </div>
    <div>
        <h3>Reviews:</h3>
        <div id="review_content">
            <ul>
                <li>
                    Loved these instructions! Had massive beans in no time!
                    <br>
                    <a href="">BOBTHEGROWER</a>
                </li>
                <li>
                    3/5
                    <br>
                    <a href="">Jack</a>
                </li>
                <li>
                    <img src="" alt="Some caption here!">
                    <br>
                    <a href="">MelonMan</a>
                </li>
            </ul>
        </div>
    </div>
    <div>
        <h3>Post a review:</h3>
        <select name="Comment" id="comment_type">
            <option value="text">Text</option>
            <option value="stars">Star rating</option>
            <option value="image">Upload image</option>
        </select>

        <form action="">
            <input type="text" placeholder="Add a title!" id="title_input">
            <br>
            <textarea name="comment" placeholder="Say something nice..." id="comment_input"></textarea>
            <br>
            <input type="submit" value="POST">
        </form>
    </div>
</body>
</html>