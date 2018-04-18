<?php
/**
 * delete a comment by its id
 * User: Mohammad Hawwari
 * Date: 4/7/2018
 * Time: 2:10 PM
 */

require_once 'include/DB_Community_Functions.php';
$db = new DB_Community_Functions();

// json response array
$response = array("error" => FALSE);

if (isset($_POST['comment_id'])) {

    // receiving the post params
    $id = $_POST["comment_id"];

    // delete user
    if ($db->deleteComment($id))
    {
        // delete successful
        $response["error"] = FALSE;
        echo json_encode($response);
    } else {
        // comment failed to delete
        $response["error"] = TRUE;
        $response["error_msg"] = "error: comment not deleted!";
        echo json_encode($response);
    }

} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameter comment id is missing!";
    echo json_encode($response);
}
