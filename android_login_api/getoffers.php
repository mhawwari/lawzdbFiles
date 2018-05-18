<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Hawwari
 * Date: 5/18/2018
 * Time: 3:42 PM
 */

require_once 'include/DB_Offer_Functions.php';
$db = new DB_Offer_Functions();

// json response array
$jOffers = array();

// get all offers
$offers = $db->getOffers();
if ($offers) {
    foreach ($offers as $offer) {

        // offers found successfully
        $response["offer"]["offer_id"] = $offer["offer_id"];
        $response["offer"]["title"] = $offer["title"];
        $response["offer"]["description"] = $offer["description"];
        $response["offer"]["owner_id"] = $offer["owner_id"];
        $response["offer"]["first_name"] = $offer["first_name"];
        $response["offer"]["last_name"] = $offer["last_name"];
        $response["offer"]["image"] = $offer["image"];
        $response["offer"]["create_date"] = $offer["create_date"];
        array_push($jOffers, $response);}
    echo json_encode($jOffers);
    //}
} else {
    // no offers exist
    $response["error"] = TRUE;
    $response["error_msg"] = "no offers yet";
    echo json_encode($response);
}

