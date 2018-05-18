<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Hawwari
 * Date: 5/18/2018
 * Time: 3:38 PM
 */

require_once 'include/DB_Offer_Functions.php';
$db = new DB_Offer_Functions();

// json response array
$response = array("error" => FALSE);

if (isset($_POST['offer_id'])) {

    // receiving the offer params
    $id = $_POST["offer_id"];

    // delete offer
    if ($db->deleteOffer($id))
    {
        // delete successful
        $response["error"] = FALSE;
        echo json_encode($response);
    } else {
        // post failed to delete
        $response["error"] = TRUE;
        $response["error_msg"] = "error: offer not deleted!";
        echo json_encode($response);
    }

} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameter offer id is missing!";
    echo json_encode($response);
}