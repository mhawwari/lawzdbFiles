<?php
/**
 * edit a post's content, title or topic
 * User: Mohammad Hawwari
 * Date: 4/7/2018
 * Time: 1:35 PM
 */

require_once 'include/DB_Community_Functions.php';
$db = new DB_Community_Functions();

// json response array
$response = array("error" => FALSE);

if (isset($_POST['content']) || isset($_POST['title']) && isset($_POST['topic'])) {

    // receiving the post params
    $id = $_POST["post_id"];
    $title = $_POST["title"];
    $content = $_POST['content'];
    $topic = $_POST["topic"];

        // edit post
        if ($db->editPost($id, $title, $content, $topic))
        {
            // edit successful
            $response["error"] = FALSE;
            echo json_encode($response);
        } else {
            // user failed to edit
            $response["error"] = TRUE;
            $response["error_msg"] = "error: failed to edit post!";
            echo json_encode($response);
        }
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (content, title or topic) are missing!";
    echo json_encode($response);
}
