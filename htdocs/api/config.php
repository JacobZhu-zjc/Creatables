<?php
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
$front_page_posts = 10;

// Begin shared functions
function get_image_tag_from_blob($blob) {
    $b64 = base64_encode($blob);
    return '<img src="data:image/png;base64,'.$b64.'">';
}
?>