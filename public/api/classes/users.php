<?php

// include_once 'db.php';

class User {

    private $conn;

    public $id;
    public $firstname;
    public $lastname;
    public $username;
    public $account_id;
    public $balance;

    public function __construct($db) {
        $this->conn = $db;
    }

    // read users
    public function read(){
 
        // select all query
        $query = 'SELECT id, firstname, lastname, username, balance, account_id FROM vw_users';

        // prepare query statement
        $stmt = $this->conn->prepare($query);
 
        // execute query
        $stmt->execute();
 
        return $stmt;
    }

}