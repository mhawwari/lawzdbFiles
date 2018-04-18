<?php
/**
 * To POST all posts for a user in database
 * User: Mohammad Hawwari
 * Date: 4/6/2018
 * Time: 10:08 PM
 */

require_once 'include/DB_Community_Functions.php';
$db = new DB_Community_Functions();

// receiving the post params
$user_id = $_POST['user_id'];
// json response array
$response = array("error" => FALSE);

// get all posts
$posts = $db->getPostByUser($user_id);
if ($posts) {
    $response["error"] = FALSE;
    foreach ($posts as $post) {//code might not work due to json formatting of multiple objects

        // posts found successfully
        $response["post"]["post_id"] = $post["post_id"];
        $response["post"]["title"] = $post["title"];
        $response["post"]["content"] = $post["content"];
        $response["post"]["user_id"] = $post["user_id"];
        $response["post"]["topic"] = $post["topic"];
        $response["post"]["create_date"] = $post["create_date"];
        $response["post"]["modify_date"] = $post["modify_date"];
    }
    echo json_encode($response);
} else {
    // no posts exist
    $response["error"] = TRUE;
    $response["error_msg"] = "no posts yet";
    echo json_encode($response);
}

