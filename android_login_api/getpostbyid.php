<?php
/**
 * Get a post by its id
 * User: Mohammad Hawwari
 * Date: 4/7/2018
 * Time: 1:32 PM
 */

require_once 'include/DB_Community_Functions.php';
$db = new DB_Community_Functions();

// json response array
$response = array("error" => FALSE);

    // receiving the post params
    $id = $_GET['id'];

        // get post
        $post = $db->getPostById($id);
        if ($post){
            // post found successfully
            $response["post"]["post_id"] = $post["post_id"];
            $response["post"]["title"] = $post["title"];
            $response["post"]["content"] = $post["content"];
            $response["post"]["user_id"] = $post["user_id"];
            $response["post"]["topic"] = $post["topic"];
            $response["post"]["first_name"] = $post["first_name"];
            $response["post"]["last_name"] = $post["last_name"];
            $response["post"]["create_date"] = $post["create_date"];
            $response["post"]["modify_date"] = $post["modify_date"];
            echo json_encode($response);
        } else {
            // post not found
            $response["error"] = TRUE;
            $response["error_msg"] = "post not found";
            echo json_encode($response);
        }

