<?php
/**
 * return comments in of a user
 * User: Mohammad Hawwari
 * Date: 4/7/2018
 * Time: 2:23 PM
 */


require_once 'include/DB_Community_Functions.php';
$db = new DB_Community_Functions();

// receiving the post params
$user_id = $_POST['user_id'];
// json response array
$response = array("error" => FALSE);

// get all comments of a user
$comments = $db->getCommentByUser($user_id);
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
    }
    echo json_encode($response);
} else {
    // no posts exist
    $response["error"] = TRUE;
    $response["error_msg"] = "no comments exist";
    echo json_encode($response);
}

