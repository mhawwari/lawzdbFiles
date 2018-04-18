<?php
/**
 * edit existing comment content
 * User: Mohammad Hawwari
 * Date: 4/7/2018
 * Time: 2:07 PM
 */

require_once 'include/DB_Community_Functions.php';
$db = new DB_Community_Functions();

// json response array
$response = array("error" => FALSE);

if (isset($_POST['comment_id']) || isset($_POST['content'])) {

    // receiving the post params
    $id = $_POST["comment_id"];
    $content = $_POST["content"];

    // edit post
    if ($db->editComment( $id,  $content))
    {
        // edit successful
        $response["error"] = FALSE;
        echo json_encode($response);
    } else {
        // user failed to edit
        $response["error"] = TRUE;
        $response["error_msg"] = "error: failed to edit comment!";
        echo json_encode($response);
    }
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (comment id or content) are missing!";
    echo json_encode($response);
}
