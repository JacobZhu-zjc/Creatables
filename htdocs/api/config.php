<?php
// Disable error reporting (Enable in "production")
error_reporting(0);

// Database connection params
$db_address = "localhost";
$db_user = "creatables";
$db_pw = "1234";
$db_name = "creatables";
// User registration requirements
$password_hash = "md5";
$min_username_length = 5;
$min_password_length = 5;
// Misc
$front_page_posts = 5;

// Begin shared functions
function get_image_tag_from_b64($b64)
{
    return '<img src="' . $b64 . '">';
}

function echo_table($fields, $rows)
{
    echo("<table>");
    echo("<tr>");
    foreach ($fields as $field) {
        echo("<th>" . $field->name . "</th>");
    }
    echo("</tr>");
    foreach ($rows as $row) {
        echo("<tr>");
        foreach ($row as $col) {
            echo("<td>$col</td>");
        }
        echo("</tr>");
    }
    echo("</tbody></table>");
}
