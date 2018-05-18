<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Hawwari
 * Date: 5/18/2018
 * Time: 3:09 PM
 */

class DB_Request_Functions
{
    private $conn;

    // constructor
    function __construct() {
        require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $this->conn = $db->connect();
    }

    // destructor
    function __destruct() {

    }

    /** Add a new Request
     * @param $details
     * @param $user_id
     * @param $offer_id
     * @param $image
     * @return bool , true when success
     */
    public function addRequest($details, $user_id, $offer_id, $image) {
        $stmt = $this->conn->prepare("INSERT INTO request(details, user_id, offer_id, image, create_date) VALUES(?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssss", $details, $user_id, $offer_id, $image);
        $result = $stmt->execute();
        $stmt->close();

        // check for successful store
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /** delete a request by id
     * @param $id
     * @return bool, true when success
     */
    public function deleteRequest($id) {
        $stmt = $this->conn->prepare("DELETE FROM request WHERE request_id = ?");
        $stmt->bind_param("s",$id);
        $result = $stmt->execute();
        $stmt->close();

        // check for successful deletion
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /** return list of offers to a post
     * @param $offer_id
     * @return array|null
     */
    public function getRequestByOffer($offer_id) {
        $requests = array();
        $stmt = $this->conn->prepare("SELECT request.*, user.first_name, user.last_name, user.image FROM request INNER JOIN user ON request.user_id = user.user_id WHERE offer_id = ?");
        $stmt->bind_param("s", $offer_id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            while ($r = mysqli_fetch_assoc($result)){
                $requests[] = $r;
            }
            $stmt->close();
            return $requests;
        }
        else {
            return NULL;
        }
    }

    /** get a request by its id
     * @param $id
     * @return array|null
     */
    public function getRequestById($id) {
        $stmt = $this->conn->prepare("SELECT request.*, user.first_name, user.last_name FROM request INNER JOIN user ON request.user_id = user.user_id WHERE request_id = ?");
        $stmt->bind_param("s", $id);

        if ($stmt->execute()) {
            $request = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $request;
        } else {
            return NULL;
        }
    }
}