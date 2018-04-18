<?php
/**
 * Get user info by id
 * User: Toshiba
 * Date: 4/7/2018
 * Time: 3:02 PM
 */


require_once 'include/DB_User_Functions.php';
$db = new DB_User_Functions();

// json response array
$response = array("error" => FALSE);

if (isset($_POST['user_id'])) {

    // receiving the post params
    $user_id = $_POST['user_id'];
    // get the user by email and password
    $user = $db->getUserById( $user_id);

    if ($user != false) {
        // use is found
        $response["error"] = FALSE;
        $response["user"]["user_id"] = $user["user_id"];
        $response["user"]["username"] = $user["username"];
        $response["user"]["first_name"] = $user["first_name"];
        $response["user"]["last_name"] = $user["last_name"];
        $response["user"]["email"] = $user["email"];
        $response["user"]["phone"] = $user["phone"];
        $response["user"]["age"] = $user["age"];
        $response["user"]["register_date"] = $user["register_date"];
        $response["user"]["longitude"] = $user["longitude"];
        $response["user"]["latitude"] = $user["latitude"];
        $response["user"]["image"] = $user["image"];
        echo json_encode($response);
    } else {
        // user is not found with the credentials
        $response["error"] = TRUE;
        $response["error_msg"] = "user not found. Please try again!";
        echo json_encode($response);
    }
} else {
    // required post params is missing
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters user id is missing!";
    echo json_encode($response);
}
