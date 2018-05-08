<?php
/**
 * return comments of a post
 * User: Mohammad Hawwari
 * Date: 4/7/2018
 * Time: 2:23 PM
 */


require_once 'include/DB_Community_Functions.php';
$db = new DB_Community_Functions();

// receiving the post params
$post_id = $_POST['post_id'];
// json response array
$jcomments = array();

// get all comments of a user
$comments = $db->getCommentByPost($post_id);
if ($comments) {
    $response["error"] = FALSE;
    foreach ($comments as $comment) {//code might not work due to json formatting of multiple objects

        // comment found successfully
        $response["comment"]["comment_id"] = $comment["comment_id"];
        $response["comment"]["content"] = $comment["content"];
        $response["comment"]["user_id"] = $comment["user_id"];
        $response["comment"]["post_id"] = $comment["post_id"];
        $response["comment"]["create_date"] = $comment["create_date"];
        $response["comment"]["modify_date"] = $comment["modify_date"];
        $response["comment"]["first_name"] = $comment["first_name"];
        $response["comment"]["last_name"] = $comment["last_name"];
        array_push($jcomments, $response);
    }
    echo json_encode($jcomments);
} else {
    // no posts exist
    $response["error"] = TRUE;
    $response["error_msg"] = "no comments exist";
    echo json_encode($response);
}

