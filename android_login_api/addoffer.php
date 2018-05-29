<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Hawwari
 * Date: 5/18/2018
 * Time: 3:20 PM
 */

require_once 'include/DB_Offer_Functions.php';
$db = new DB_Offer_Functions();
//connect to cloud server
$ftp_server = "ftp.gear.host";
$ftp_username = 'lawscloud\$lawscloud';
$ftp_password = "fio9bNvaDhtW7BHl92PXo6rRdXGfPmcag1xr4c24kWoPdjKyk8EMyeCjPiL4";
$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
$login = ftp_login($ftp_conn, $ftp_username, $ftp_password);
$destination_path = "/site/wwwroot/img/";

// json response array
$response = array("error" => FALSE);
define('UPLOAD_PATH', "http://lawscloud.gearhostpreview.com/img/");
if (isset($_POST['title']) && isset($_POST['description']) && isset($_POST['owner_id'])) {
    // receiving the offer params
    $title = $_POST["title"];
    $description = $_POST['description'];
    $owner_id = $_POST['owner_id'];
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
    if ($db->addOffer($title, $description, $owner_id, $image))
    {
        // offer stored successfully
        $response["error"] = FALSE;
        echo json_encode($response);
    } else {
        // post failed to store
        $response["error"] = TRUE;
        $response["error_msg"] = "unknown error: offer not stored!";
        echo json_encode($response);
    }
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (title, description, user id) are missing!";
    echo json_encode($response);
}
