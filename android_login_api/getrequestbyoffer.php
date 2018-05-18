<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Hawwari
 * Date: 5/18/2018
 * Time: 3:56 PM
 */

require_once 'include/DB_Request_Functions.php';
$db = new DB_Request_Functions();

// receiving the request params
$offer_id = $_POST['offer_id'];
// json response array
$jRequests = array();

// get all comments of a user
$requests = $db->getRequestByOffer($post_id);
if ($requests) {
    $response["error"] = FALSE;
    foreach ($requests as $request) {

        // requests found successfully
        $response["request"]["request_id"] = $request["request_id"];
        $response["request"]["details"] = $request["details"];
        $response["request"]["user_id"] = $request["user_id"];
        $response["request"]["offer_id"] = $request["offer_id"];
        $response["request"]["create_date"] = $request["create_date"];
        $response["request"]["first_name"] = $request["first_name"];
        $response["request"]["last_name"] = $request["last_name"];
        $response["request"]["image"] = $request["image"];
        array_push($jRequests, $response);
    }
    echo json_encode($jRequests);
} else {
    // no requests exist
    $response["error"] = TRUE;
    $response["error_msg"] = "no requests exist";
    echo json_encode($response);
}