<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Hawwari
 * Date: 4/4/2018
 * Time: 11:48 PM
 */

require_once 'include/DB_User_Functions.php';
$db = new DB_User_Functions();

// json response array
$response = array("error" => FALSE);

if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {

    // receiving the post params
    $id = $_POST["user_id"];
    $username = $_POST["username"];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $fname = $_POST["first_name"];
    $lname = $_POST["last_name"];
    $phone = $_POST["phone"];
    $age = $_POST["age"];
    $image = $_POST["image"];
    $longitude = $_POST["longitude"];
    $latitude = $_POST["latitude"];

    // check if a user already exists with the same email
    if ($db->isUserExisted($email)) {
        // user already existed
        $response["error"] = TRUE;
        $response["error_msg"] = "Email already occupied" . $email;
        echo json_encode($response);
    } else {
        // edit user
        if ($db->editUser($id, $username, $fname, $lname, $email, $phone, $age, $image, $password, $longitude, $latitude))
        {
            // edit successful
            $response["error"] = FALSE;
            echo json_encode($response);
        } else {
            // user failed to edit
            $response["error"] = TRUE;
            $response["error_msg"] = "error: failed to edit user!";
            echo json_encode($response);
        }
    }
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (name, email or password) are missing!";
    echo json_encode($response);
}
