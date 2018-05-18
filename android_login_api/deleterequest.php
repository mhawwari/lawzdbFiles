<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Hawwari
 * Date: 5/18/2018
 * Time: 3:40 PM
 */

require_once 'include/DB_Request_Functions.php';
$db = new DB_Request_Functions();

// json response array
$response = array("error" => FALSE);

if (isset($_POST['request_id'])) {

    // receiving the post params
    $id = $_POST["request_id"];

    // delete user
    if ($db->deleteRequest($id))
    {
        // delete successful
        $response["error"] = FALSE;
        echo json_encode($response);
    } else {
        // comment failed to delete
        $response["error"] = TRUE;
        $response["error_msg"] = "error: request not deleted!";
        echo json_encode($response);
    }

} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameter request id is missing!";
    echo json_encode($response);
}