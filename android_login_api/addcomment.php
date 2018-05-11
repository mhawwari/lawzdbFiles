<?php
/**
 * add comment to a post.
 * User: Mohammad Hawwari
 * Date: 4/7/2018
 * Time: 2:57 PM
 */

require_once 'include/DB_Community_Functions.php';
$db = new DB_Community_Functions();

// json response array
$response = array("error" => FALSE);

if (isset($_GET['content']) && isset($_GET['post_id']) && isset($_GET['user_id'])) {

    // receiving the post params
    $content = $_GET["content"];
    $post_id = $_GET['post_id'];
    $user_id = $_GET['user_id'];

    // create a new comment
    if ($db->addComment( $content,$user_id, $post_id ))
    {
        // post stored successfully
        $response["error"] = FALSE;
        echo json_encode($response);
    } else {
        // post failed to store
        $response["error"] = TRUE;
        $response["error_msg"] = "unknown error: comment not stored!";
        echo json_encode($response);
    }

} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (content, user id or post id) are missing!";
    echo json_encode($response);
}
