<?php

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
        $query = 'SELECT id, firstname, lastname, username, balance, account_id FROM vw_users';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
 
        return $stmt;
    }

}