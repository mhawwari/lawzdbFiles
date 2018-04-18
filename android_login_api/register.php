<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Hawwari
 * Date: 4/4/2018
 * Time: 8:38 PM
 */

require_once 'include/DB_User_Functions.php';
$db = new DB_User_Functions();

// json response array
$response = array("error" => FALSE);

if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {

    // receiving the post params
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // check if user is already existed with the same email
    if ($db->isUserExisted($email)) {
        // user already existed
        $response["error"] = TRUE;
        $response["error_msg"] = "User already existed with " . $email;
        echo json_encode($response);
    } else {
        // create a new user
        if ($db->addUser($email, $password, $username))
        {
            // user stored successfully
            $response["error"] = FALSE;
            echo json_encode($response);
        } else {
            // user failed to store
            $response["error"] = TRUE;
            $response["error_msg"] = "Unknown error occurred in registration!";
            echo json_encode($response);
        }
    }
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (name, email or password) is missing!";
    echo json_encode($response);
}
