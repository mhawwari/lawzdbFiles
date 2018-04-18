<?php
/**
 * Get a comment by its id
 * User: Mohammad Hawwari
 * Date: 4/7/2018
 * Time: 2:13 PM
 */

require_once 'include/DB_Community_Functions.php';
$db = new DB_Community_Functions();

// json response array
$response = array("error" => FALSE);

    // receiving the post params
    $id = $_POST['comment_id'];

        // get post
        $comment = $db->getCommentById($id);
        if ($comment){
            // comment found successfully
            $response["comment"]["comment_id"] = $comment["comment_id"];
            $response["comment"]["content"] = $comment["content"];
            $response["comment"]["user_id"] = $comment["user_id"];
            $response["comment"]["post_id"] = $comment["post_id"];
            $response["comment"]["create_date"] = $comment["create_date"];
            $response["comment"]["modify_date"] = $comment["modify_date"];
            echo json_encode($response);
        } else {
            // post not found
            $response["error"] = TRUE;
            $response["error_msg"] = "post not found";
            echo json_encode($response);
        }

