<?php
/**
 * Add a post with title, content, topic, user_id.
 * User: Toshiba
 * Date: 4/6/2018
 * Time: 10:29 PM
 */

require_once 'include/DB_Community_Functions.php';
$db = new DB_Community_Functions();
//connect to cloud server
$ftp_server = "ftp.gear.host";
$ftp_username = 'lawscloud\$lawscloud';
$ftp_userpass = "fio9bNvaDhtW7BHl92PXo6rRdXGfPmcag1xr4c24kWoPdjKyk8EMyeCjPiL4";
$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
$login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);
$destination_path = "site/repository/img/"; 


// json response array
$response = array("error" => FALSE);
define('UPLOAD_PATH', "http://lawscloud.gearhostpreview.com/img/");

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
            $upload = ftp_put($ftp_conn, $destination_path.$_FILES['pic']['name'], $_FILES['pic']['tmp_name'], FTP_BINARY);
            //move_uploaded_file($_FILES['pic']['name'], UPLOAD_PATH . $_FILES['pic']['name']);
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
