<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Hawwari
 * Date: 5/18/2018
 * Time: 2:20 PM
 */

class DB_Offer_Functions
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

    /** Add a new offer
     * @param $title
     * @param $description
     * @param $owner_id
     * @param $image
     * @return bool true when success
     */
    public function addOffer($title, $description, $owner_id, $image) {
        $stmt = $this->conn->prepare("INSERT INTO offer(title, description, owner_id, image, create_date) VALUES(?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssss", $title, $description, $owner_id, $image);
        $result = $stmt->execute();
        $stmt->close();

        // check for successful store
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * delete an offer by it's id
     * @param $id
     * @return bool true when success
     */
    public function deleteOffer($id) {
        $stmt = $this->conn->prepare("DELETE FROM offer WHERE offer_id = ?");
        $stmt->bind_param("s",$id);
        $result = $stmt->execute();
        $stmt->close();

        // check for successful store
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * return all offers
     * @return array|null
     */
    public function getOffers() {
        $offers = array();
        $stmt = $this->conn->prepare("SELECT offer.*, user.first_name, user.last_name FROM offer INNER JOIN user ON offer.owner_id = user.user_id");

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            while ($r = mysqli_fetch_assoc($result)){
                $offers[] = $r;
            }
            $stmt->close();
            return $offers;
        }
        else {
            return NULL;
        }
    }

    /**
     * return offer by the id from db
     * @param $id
     * @return array|null
     */
    public function getOfferById($id) {

        $stmt = $this->conn->prepare("SELECT offer.*, user.first_name, user.last_name FROM offer INNER JOIN user ON offer.owner_id = user.user_id WHERE offer_id = ?");
        $stmt->bind_param("s", $id);

        if ($stmt->execute()) {
            $offer = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $offer;
        } else {
            return NULL;
        }
    }

    /**
     * return offer by their user
     * @param $owner_id
     * @return array|null
     */
    public function getOffersByOwner($owner_id) {
        $offers = array();
        $stmt = $this->conn->prepare("SELECT offer.*, user.first_name, user.last_name FROM offer INNER JOIN user ON offer.owner_id = user.user_id WHERE owner_id = ?");
        $stmt->bind_param("s", $owner_id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            while ($r = mysqli_fetch_assoc($result)){
                $offers[] = $r;
            }
            $stmt->close();
            return $offers;
        }
        else {
            return NULL;
        }
    }

    /**
     * return all offers by keyword
     * @param $search_text
     * @return array|null
     */
    public function SearchOffers($search_text) {
        $offers = array();
        $stmt = $this->conn->prepare("SELECT * FROM offer WHERE description like ? or title like ?");
        $stmt->bind_param("ss", $search_text, $search_text);

        if ($stmt->execute()) {
            while ($r = $stmt->get_result()->fetch_assoc()){
                $offers[] = $r;
            }
            $stmt->close();
            return $offers;
        }
        else {
            return NULL;
        }
    }
}