<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Hawwari
 * Date: 4/4/2018
 * Time: 6:27 PM
 */

class DB_Connect {
    private $conn;

    // Connecting to database
    public function connect() {
        require_once 'include/Config.php';

        // Connecting to mysql database
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

        // return database handler
        return $this->conn;
    }
}

