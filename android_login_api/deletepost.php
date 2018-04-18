<?php
/**
 * Delete a post by id
 * User: Mohammad Hawwari
 * Date: 4/7/2018
 * Time: 1:51 PM
 */

require_once 'include/DB_Community_Functions.php';
$db = new DB_Community_Functions();

// json response array
$response = array("error" => FALSE);

if (isset($_POST['post_id'])) {

    // receiving the post params
    $id = $_POST["post_id"];

    // delete user
    if ($db->deletePost($id))
    {
        // delete successful
        $response["error"] = FALSE;
        echo json_encode($response);
    } else {
        // post failed to delete
        $response["error"] = TRUE;
        $response["error_msg"] = "error: post not deleted!";
        echo json_encode($response);
    }

} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameter post id is missing!";
    echo json_encode($response);
}
