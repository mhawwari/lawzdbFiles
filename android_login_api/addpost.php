<?php
/**
 * Add a post with title, content, topic, user_id.
 * User: Toshiba
 * Date: 4/6/2018
 * Time: 10:29 PM
 */

require_once 'include/DB_Community_Functions.php';
$db = new DB_Community_Functions();

// json response array
$response = array("error" => FALSE);

if (isset($_POST['title']) && isset($_POST['content']) && isset($_POST['username']) && isset($_POST['topic'])) {

    // receiving the post params
    $title = $_POST["title"];
    $content = $_POST['content'];
    $user_id = $_POST['user_id'];
    $topic = $_POST["topic"];

        // create a new post
        if ($db->addPost($title, $content, $user_id, $topic))
        {
            // post stored successfully
            $response["error"] = FALSE;
            echo json_encode($response);
        } else {
            // post failed to store
            $response["error"] = TRUE;
            $response["error_msg"] = "unknown error: post not stored!";
            echo json_encode($response);
        }

} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (title, content, user id or topic) are missing!";
    echo json_encode($response);
}