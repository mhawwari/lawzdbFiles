<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Hawwari
 * Date: 5/18/2018
 * Time: 3:49 PM
 */

require_once 'include/DB_Request_Functions.php';
$db = new DB_Request_Functions();

// json response array
$response = array("error" => FALSE);

// receiving the request params
$id = $_POST['request_id'];

// get request
$request = $db->getRequestById($id);
if ($request){
    // request found successfully
    $response["request"]["request_id"] = $request["request_id"];
    $response["request"]["content"] = $request["details"];
    $response["request"]["user_id"] = $request["user_id"];
    $response["request"]["post_id"] = $request["offer_id"];
    $response["request"]["create_date"] = $request["create_date"];
    $response["request"]["first_name"] = $request["first_name"];
    $response["request"]["last_name"] = $request["last_name"];
    $response["request"]["image"] = $request["image"];
    echo json_encode($response);
} else {
    // request not found
    $response["error"] = TRUE;
    $response["error_msg"] = "request not found";
    echo json_encode($response);
}