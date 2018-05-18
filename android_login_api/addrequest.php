<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Hawwari
 * Date: 5/18/2018
 * Time: 3:31 PM
 */

require_once 'include/DB_Request_Functions.php';
$db = new DB_Request_Functions();
//connect to cloud server
$ftp_server = "ftp.gear.host";
$ftp_username = 'lawscloud\$lawscloud';
$ftp_password = "fio9bNvaDhtW7BHl92PXo6rRdXGfPmcag1xr4c24kWoPdjKyk8EMyeCjPiL4";
$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
$login = ftp_login($ftp_conn, $ftp_username, $ftp_password);
$destination_path = "site/repository/img/";

// json response array
$response = array("error" => FALSE);
define('UPLOAD_PATH', "http://lawscloud.gearhostpreview.com/img/");
if ( isset($_POST['details']) && isset($_POST['user_id']) && isset($_POST['offer_id'])) {
    // receiving the post params
    $details = $_POST['details'];
    $user_id = $_POST['user_id'];
    $offer_id = $_POST['offer_id'];
    $image ="";
    if (isset($_FILES['pic']['name'])) {
        try
        {
            $upload = ftp_put($ftp_conn, $destination_path.$_FILES['pic']['name'], $_FILES['pic']['tmp_name'], FTP_BINARY);
            $image = UPLOAD_PATH.$_FILES['pic']['name'];
        }
        catch (Exception $e){
            $response['error'] = true;
            $response['message'] = 'Could not upload file';
            echo json_encode($response);
        }
    }
    // create a new post
    if ($db->addRequest($details, $user_id, $offer_id ,$image))
    {
        // request stored successfully
        $response["error"] = FALSE;
        echo json_encode($response);
    } else {
        // post failed to store
        $response["error"] = TRUE;
        $response["error_msg"] = "unknown error: request not stored!";
        echo json_encode($response);
    }
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (details, user id, offer_id) are missing!";
    echo json_encode($response);
}