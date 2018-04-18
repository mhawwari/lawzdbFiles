<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Hawwari
 * Date: 4/4/2018
 * Time: 11:58 PM
 */

require_once 'include/DB_User_Functions.php';
$db = new DB_User_Functions();

// json response array
$response = array("error" => FALSE);

if (isset($_POST['user_id'])) {

    // receiving the post params
    $id = $_POST["user_id"];

        // delete user
        if ($db->deleteUser($id))
        {
            // delete successful
            $response["error"] = FALSE;
            echo json_encode($response);
        } else {
            // user failed to delete
            $response["error"] = TRUE;
            $response["error_msg"] = "error: user not deleted!";
            echo json_encode($response);
        }

} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameter user id is missing!";
    echo json_encode($response);
}
