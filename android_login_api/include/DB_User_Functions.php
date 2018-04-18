<?php
/**
 * php functions for user interactions
 * User: Mohammad Hawwari
 * Date: 4/4/2018
 * Time: 6:29 PM
 */

class DB_User_Functions {

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

    /**
     * @param $fname
     * @param $lname
     * @param $email
     * @param $password
     * @param $username
     * @param $phone
     * @param $longitude
     * @param $latitude
     * @return bool
     */
    public function addUser($email, $password, $username) {
       // $uuid = uniqid('', true);
        $hash = $this->hashSSHA($password);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"]; // salt

        $stmt = $this->conn->prepare("INSERT INTO user(username, password, salt, email, register_date) VALUES(?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssss", $username, $encrypted_password, $salt, $email);
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
     * edit user data. doesn't have email/username verification
     * @param $id
     * @param $username
     * @param $fname
     * @param $lname
     * @param $email
     * @param $phone
     * @param $age
     * @param $image
     * @param $password
     * @param $longitude
     * @param $latitude
     * @return bool
     */
    public function editUser($id, $username, $fname, $lname, $email, $phone, $age, $image, $password, $longitude, $latitude) {
        // $uuid = uniqid('', true);
        $hash = $this->hashSSHA($password);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"]; // salt

        $stmt = $this->conn->prepare("UPDATE user SET username = ?, first_name = ?, last_name = ?, password = ?, salt = ?, email = ?, phone = ?, age = ?, image = ?, longitude = ?, latitude = ? WHERE user_id = ?");
        $stmt->bind_param("sssssssssddi", $username, $fname, $lname, $encrypted_password, $salt, $email, $phone, $age, $image, $longitude, $latitude, $id);
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
     * @param $id
     * @return bool
     */
    public function deleteUser($id) {
        $stmt = $this->conn->prepare("DELETE FROM user WHERE user_id = ?");
        $stmt->bind_param("i",$id);
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
     * Get user by email and password
     * returns null when email/password incorrect
     */
    public function getUserByEmailAndPassword($email, $password) {

        $stmt = $this->conn->prepare("SELECT * FROM user WHERE email = ?");

        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            // verifying user password
            $salt = $user['salt'];
            $encrypted_password = $user['encrypted_password'];
            $hash = $this->checkhashSSHA($salt, $password);
            // check for password equality
            if ($encrypted_password == $hash) {
                // user authentication details are correct
                return $user;
            }
        } else {
            return NULL;
        }
    }

    /**
     * get user by their email
     * @param $email
     * @return array|null
     */
    public function getUserByEmail($email, $password) {

        $stmt = $this->conn->prepare("SELECT * FROM user WHERE email = ?");

        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
                return $user;
            }
        else {
            return NULL;
        }
    }

    /**
     * @param $id
     * @return array|null
     */
    public function getUserById($id) {

        $stmt = $this->conn->prepare("SELECT * FROM user WHERE user_id = ?");

        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user;
        } else {
            return NULL;
        }
    }

    /**
     * Check user is existed or not
     */
    public function isUserExisted($email) {
        $stmt = $this->conn->prepare("SELECT email from user WHERE email = ?");

        $stmt->bind_param("s", $email);

        $stmt->execute();

        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // user existed
            $stmt->close();
            return true;
        } else {
            // user not existed
            $stmt->close();
            return false;
        }
    }

    /**
     * Encrypting password
     * @param password
     * returns salt and encrypted password
     * @return array
     */
    public function hashSSHA($password) {

        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }

    /**
     * Decrypting password
     * @param salt, password
     * @return hash string
     */
    public function checkhashSSHA($salt, $password) {

        $hash = base64_encode(sha1($password . $salt, true) . $salt);

        return $hash;
    }

}
