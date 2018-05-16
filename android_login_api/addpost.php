<?php
/**
 * Add a post with title, content, topic, user_id.
 * User: Toshiba
 * Date: 4/6/2018
 * Time: 10:29 PM
 */

require_once 'include/DB_Community_Functions.php';
$db = new DB_Community_Functions();

// json response array
$response = array("error" => FALSE);
define('UPLOAD_PATH', 'http:\/\/lawscloud.gearhostpreview.com\/img\/');

if (isset($_POST['title']) && isset($_POST['content']) && isset($_POST['user_id']) && isset($_POST['topic'])) {

    // receiving the post params
    $title = $_POST["title"];
    $content = $_POST['content'];
    $user_id = $_POST['user_id'];
    $topic = $_POST["topic"];
    $image ="";
    if (isset($_FILES['pic']['name'])) {
        try
        {
            move_uploaded_file($_FILES['pic']['tmp_name'], UPLOAD_PATH . $_FILES['pic']['name']);
            $image = UPLOAD_PATH.$_FILES['pic']['name'];
        }
        catch (Exception $e){
            $response['error'] = true;
            $response['message'] = 'Could not upload file';
            echo json_encode($response);
        }
    }
        // create a new post
        if ($db->addPost($title, $content, $user_id, $topic, $image))
        {
            // post stored successfully
            $response["error"] = FALSE;
            echo json_encode($response);
        } else {
            // post failed to store
            $response["error"] = TRUE;
            $response["error_msg"] = "unknown error: post not stored!";
            echo json_encode($response);
        }

} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (title, content, user id or topic) are missing!";
    echo json_encode($response);
}
