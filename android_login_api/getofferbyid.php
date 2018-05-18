<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Hawwari
 * Date: 5/18/2018
 * Time: 4:01 PM
 */

require_once 'include/DB_Offer_Functions.php';
$db = new DB_Offer_Functions();

// json response array
$response = array("error" => FALSE);

// receiving the offer params
$id = $_POST['id'];

// get offer
$offer = $db->getOfferById($id);
if ($offer){
    // offer found successfully
    $response["offer"]["offer_id"] = $offer["offer_id"];
    $response["offer"]["title"] = $offer["title"];
    $response["offer"]["description"] = $offer["description"];
    $response["offer"]["owner_id"] = $offer["owner_id"];
    $response["offer"]["first_name"] = $offer["first_name"];
    $response["offer"]["last_name"] = $offer["last_name"];
    $response["offer"]["image"] = $offer["image"];
    $response["offer"]["create_date"] = $offer["create_date"];
    echo json_encode($response);
} else {
    // offer not found
    $response["error"] = TRUE;
    $response["error_msg"] = "offer not found";
    echo json_encode($response);
}

